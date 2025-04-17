#include <WiFi.h>
#include <PubSubClient.h>
#include <DHT.h>
#include <SPI.h>
#include <MFRC522.h>

// Wi-Fi credentials
const char* ssid = "TOPNET_30D8";
const char* password = "2s5nif470a";

// MQTT broker
const char* mqtt_server = "test.mosquitto.org";
const int mqtt_port = 1883;  // ✅ Changed from 9001 to 1883 (standard TCP)

// Pins
#define DHTPIN 4
#define DHTTYPE DHT11
#define MQ2_PIN 34
#define CO2_LED_PIN 32
#define RST_PIN 5
#define SS_PIN 21

WiFiClient espClient;
PubSubClient mqttClient(espClient);
DHT dht(DHTPIN, DHTTYPE);
MFRC522 mfrc522(SS_PIN, RST_PIN);

unsigned long lastPublishTime = 0;
const long interval = 5000; // 5 seconds

int CO2_THRESHOLD = 400;
int previousCO2State = -1;

void setup_wifi() {
  delay(100);
  Serial.print("📶 Connecting to WiFi: ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\n✅ WiFi connected");
  Serial.print("💻 IP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  while (!mqttClient.connected()) {
    Serial.print("🔌 Attempting MQTT connection...");
    
    String clientId = "ESP32Client-" + String(WiFi.macAddress());
    if (mqttClient.connect(clientId.c_str())) {
      Serial.println(" connected!");
      mqttClient.subscribe("esp32/status");
    } else {
      Serial.print(" failed, rc=");
      Serial.print(mqttClient.state());
      Serial.println(" trying again in 5 seconds");
      delay(5000);
    }
  }
}

void setup() {
  Serial.begin(115200);
  pinMode(CO2_LED_PIN, OUTPUT);
  dht.begin();
  SPI.begin();
  mfrc522.PCD_Init();

  setup_wifi();
  mqttClient.setServer(mqtt_server, mqtt_port);
}

void loop() {
  if (!mqttClient.connected()) {
    reconnect();
  }
  mqttClient.loop();

  unsigned long currentMillis = millis();
  if (currentMillis - lastPublishTime >= interval) {
    lastPublishTime = currentMillis;
    publishStatus();
  }

  checkRFID();
}

void publishStatus() {
  float humidity = dht.readHumidity();
  float temperature = dht.readTemperature();
  int co2Level = analogRead(MQ2_PIN);
  co2Level = map(co2Level, 0, 4095, 0, 1000);

  if (isnan(humidity) || isnan(temperature)) {
    Serial.println("❌ DHT sensor error.");
    return;
  }

  String co2Status = co2Level >= CO2_THRESHOLD ? "High" : "Normal";
  digitalWrite(CO2_LED_PIN, co2Level >= CO2_THRESHOLD ? HIGH : LOW);

  mqttClient.publish("esp32/temperature", String(temperature, 2).c_str());
  mqttClient.publish("esp32/humidity", String(humidity, 2).c_str());
  mqttClient.publish("esp32/co2_level", String(co2Level).c_str());
  mqttClient.publish("esp32/co2_status", co2Status.c_str());

  Serial.println("📡 Published temperature, humidity, CO2 level & status");
}


void checkRFID() {
  if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) return;

  String uidString = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    if (i > 0) uidString += ":";
    uidString += String(mfrc522.uid.uidByte[i], HEX);
  }

  mqttClient.publish("esp32/rfid", uidString.c_str());
  Serial.println("📡 Published RFID: " + uidString);

  mfrc522.PICC_HaltA();
  mfrc522.PCD_StopCrypto1();
  delay(1000);
}

