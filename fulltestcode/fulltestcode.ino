#include <WiFi.h>
#include <AsyncMqttClient.h>
#include <DHT.h>
#include <MFRC522v2.h>
#include <MFRC522DriverSPI.h>
#include <MFRC522DriverPinSimple.h>

// WiFi credentials
const char* ssid = "TOPNET_30D8";
const char* password = "2s5nif470a";

// MQTT broker address and WebSocket port
const char* mqtt_server = "broker.emqx.io";
const uint16_t mqtt_port = 8083;  // WebSocket port

// Create an AsyncMqttClient instance
AsyncMqttClient mqttClient;
TimerHandle_t mqttReconnectTimer;

// DHT sensor setup
#define DHTPIN 4
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// MQ2 sensor (CO2 gas)
#define MQ2_PIN 34
#define CO2_THRESHOLD 60
#define CO2_LED_PIN 32

int previousCO2State = -1;

// RFID setup
MFRC522DriverPinSimple ss_pin(5);
MFRC522DriverSPI rfid_driver{ss_pin};
MFRC522 mfrc522{rfid_driver};

// --- Forward declarations ---
void connectToMqtt();
void onMqttConnect(bool sessionPresent);
void onMqttDisconnect(AsyncMqttClientDisconnectReason reason);
void onMqttSubscribe(uint16_t packetId, uint8_t qos);
void onMqttUnsubscribe(uint16_t packetId);
void onMqttMessage(char* topic, char* payload, AsyncMqttClientMessageProperties properties,
                   size_t len, size_t index, size_t total);
void onMqttPublish(uint16_t packetId);
void publishTemperatureHumidity();
void measureCO2();
void checkRFID();

void setup() {
  Serial.begin(115200);
  delay(1000);
  Serial.println("Starting setup...");

  // --- WiFi Setup ---
  Serial.println("Connecting to WiFi...");
  WiFi.begin(ssid, password);
  
  // Use WiFi event for connection
  WiFi.onEvent([](WiFiEvent_t event, WiFiEventInfo_t info) {
    if (event == IP_EVENT_STA_GOT_IP) {
      Serial.println("✅ WiFi connected!");
      Serial.print("IP Address: ");
      Serial.println(WiFi.localIP());
      connectToMqtt();  // Connect to MQTT only after WiFi is connected
    }
  });

  // Wait until WiFi is connected
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  // --- MQTT Setup ---
  mqttClient.onConnect(onMqttConnect);
  mqttClient.onDisconnect(onMqttDisconnect);
  mqttClient.onSubscribe(onMqttSubscribe);
  mqttClient.onUnsubscribe(onMqttUnsubscribe);
  mqttClient.onMessage(onMqttMessage);
  mqttClient.onPublish(onMqttPublish);
  mqttClient.setServer(mqtt_server, mqtt_port);

  mqttReconnectTimer = xTimerCreate("mqttTimer", pdMS_TO_TICKS(2000), pdFALSE, (void*)0, 
    [](TimerHandle_t xTimer){
      connectToMqtt();
    }
  );
  // Do not call connectToMqtt() here anymore; it will be triggered by WiFi event.

  // --- Sensor Initialization ---
  dht.begin();
  pinMode(CO2_LED_PIN, OUTPUT);

  // --- RFID Initialization ---
  mfrc522.PCD_Init();
  Serial.println("System Initialized. Waiting for RFID...");
}

void loop() {
  static unsigned long lastMsg = 0;
  unsigned long now = millis();

  if (now - lastMsg > 5000) {
    lastMsg = now;
    publishTemperatureHumidity();
    measureCO2();
  }

  checkRFID(); // Constantly check for RFID input
}

// --- MQTT Callback Functions ---
void connectToMqtt() {
  Serial.println("Connecting to MQTT broker...");
  mqttClient.connect();
}

void onMqttConnect(bool sessionPresent) {
  Serial.println("✅ Connected to MQTT broker over WebSocket!");
  mqttClient.subscribe("esp32/control", 0);
}

void onMqttDisconnect(AsyncMqttClientDisconnectReason reason) {
  Serial.print("⚠️ Disconnected from MQTT. Reason: ");
  Serial.println(static_cast<uint8_t>(reason));
  xTimerStart(mqttReconnectTimer, 0);  // Retry connection after disconnect
}

void onMqttSubscribe(uint16_t packetId, uint8_t qos) {
  Serial.print("Subscribed; packetId=");
  Serial.print(packetId);
  Serial.print(", qos=");
  Serial.println(qos);
}

void onMqttUnsubscribe(uint16_t packetId) {
  Serial.print("Unsubscribed; packetId=");
  Serial.println(packetId);
}

void onMqttMessage(char* topic, char* payload, AsyncMqttClientMessageProperties properties,
                   size_t len, size_t index, size_t total) {
  Serial.print("Incoming message on topic: ");
  Serial.print(topic);
  Serial.print(". Payload: ");
  for (size_t i = 0; i < len; i++) {
    Serial.print(payload[i]);
  }
  Serial.println();
}

void onMqttPublish(uint16_t packetId) {
  Serial.print("Published packetId: ");
  Serial.println(packetId);
}

// --- Sensor Functions ---
void publishTemperatureHumidity() {
  float humidity = dht.readHumidity();
  float temperature = dht.readTemperature();

  if (isnan(humidity) || isnan(temperature)) {
    Serial.println("DHT sensor error.");
    return;
  }

  char tempString[8];
  char humString[8];
  dtostrf(temperature, 1, 2, tempString);
  dtostrf(humidity, 1, 2, humString);

  mqttClient.publish("esp32/temperature", 0, false, tempString);
  mqttClient.publish("esp32/humidity", 0, false, humString);

  Serial.print("Temperature: ");
  Serial.println(tempString);
  Serial.print("Humidity: ");
  Serial.println(humString);
}

void measureCO2() {
  int co2Level = analogRead(MQ2_PIN);
  co2Level = map(co2Level, 0, 4095, 0, 1000);

  char co2String[8];
  dtostrf(co2Level, 1, 2, co2String);
  mqttClient.publish("esp32/co2_level", 0, false, co2String);

  Serial.print("CO2 Level: ");
  Serial.print(co2Level);
  Serial.println(" ppm");

  if (co2Level >= CO2_THRESHOLD) {
    if (previousCO2State != 1) {
      Serial.println("⚠️ High CO2 Alert!");
      mqttClient.publish("esp32/co2_alert", 0, false, "High CO2 Alert!");
      previousCO2State = 1;
    }
    digitalWrite(CO2_LED_PIN, HIGH);
  } else {
    if (previousCO2State != 0) {
      Serial.println("✅ CO2 Normal");
      mqttClient.publish("esp32/co2_alert", 0, false, "CO2 Normal");
      previousCO2State = 0;
    }
    digitalWrite(CO2_LED_PIN, LOW);
  }
}

void checkRFID() {
  if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  unsigned long timestamp = millis();
  Serial.print("RFID Access - Time(ms): ");
  Serial.print(timestamp);
  Serial.print(" | UID: ");

  String uidString = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    if (mfrc522.uid.uidByte[i] < 0x10) Serial.print("0");
    Serial.print(mfrc522.uid.uidByte[i], HEX);
    if (i > 0) uidString += ":";
    uidString += String(mfrc522.uid.uidByte[i], HEX);
  }
  Serial.println();

  String payload = "Time(ms): " + String(timestamp) + " | UID: " + uidString;
  mqttClient.publish("esp32/rfid_access", 0, false, payload.c_str());

  mfrc522.PICC_HaltA();
  mfrc522.PCD_StopCrypto1();
  delay(1000);
}
