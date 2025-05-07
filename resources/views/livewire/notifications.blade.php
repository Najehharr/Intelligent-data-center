<body>
    <div class="container-fluid py-4">
      <div class="row">
        <!-- CO2 Chart -->
        <div class="col-md-10 col-lg-10">
          <div class="card mt-4">
            <div class="card-body">
              <h6 class="mb-0">Gas Sensor Readings</h6>
              <div id="gas-sensor-chart" style="width: 100%; height: 350px;"></div>
              <div id="gas-alert" class="alert alert-danger mt-3 d-none" role="alert">
                ⚠️ Alerte : Niveau de gaz élevé détecté !
              </div>
            </div>
          </div>
        </div>

        <!-- Humidity Chart -->
        <div class="col-md-10 col-lg-10">
          <div class="card mt-4">
            <div class="card-body">
              <h6 class="mb-0">Humidity Levels</h6>
              <div id="humidity-chart" style="width: 100%; height: 350px;"></div>
              <div id="humidity-alert" class="alert alert-warning mt-3 d-none" role="alert">
                ⚠️ Alerte : Humidité en dehors des seuils !
              </div>
            </div>
          </div>
        </div>

        <!-- Temperature Chart -->
        <div class="col-md-10 col-lg-10">
          <div class="card mt-4">
            <div class="card-body">
              <h6 class="mb-0">Température Moyenne Haute et Basse</h6>
              <div id="temperature-chart" style="width: 100%; height: 350px;"></div>
              <div id="temperature-alert" class="alert alert-primary mt-3 d-none" role="alert">
                ⚠️ Alerte : Température hors des seuils !
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script>
      const client = mqtt.connect('wss://test.mosquitto.org:8081/mqtt');

      const chartOptions = (title) => ({
        chart: { type: 'line', height: 350 },
        series: [{ name: title, data: [] }],
        xaxis: { type: 'datetime' }
      });

      const maxPoints = 20;

      const temperatureChart = new ApexCharts(document.querySelector("#temperature-chart"), chartOptions("Temperature"));
      const humidityChart = new ApexCharts(document.querySelector("#humidity-chart"), chartOptions("Humidity"));
      const co2Chart = new ApexCharts(document.querySelector("#gas-sensor-chart"), chartOptions("CO2 Level"));

      temperatureChart.render();
      humidityChart.render();
      co2Chart.render();

      const charts = {
        "esp32/temperature": temperatureChart,
        "esp32/humidity": humidityChart,
        "esp32/co2_level": co2Chart
      };

      // Thresholds
      const thresholds = {
        "esp32/temperature": { min: 10, max: 35, alertId: "temperature-alert" },
        "esp32/humidity": { min: 30, max: 70, alertId: "humidity-alert" },
        "esp32/co2_level": { max: 800, alertId: "gas-alert" }
      };

      function checkThresholds(topic, value) {
        const th = thresholds[topic];
        if (!th) return;

        const alertEl = document.getElementById(th.alertId);
        let show = false;

        if (topic === "esp32/co2_level") {
          show = value > th.max;
        } else {
          show = value < th.min || value > th.max;
        }

        alertEl.classList.toggle("d-none", !show);
      }

      client.on('connect', () => {
        console.log("✅ Connected to MQTT broker");
        Object.keys(charts).forEach(topic => client.subscribe(topic));
      });

      client.on('message', (topic, message) => {
        const value = parseFloat(message.toString());
        const timestamp = new Date().getTime();

        const chart = charts[topic];
        if (chart && chart.w && chart.w.globals && chart.w.globals.series[0]) {
          let data = chart.w.globals.series[0].data || [];
          data.push([timestamp, value]);
          if (data.length > maxPoints) data.shift();
          chart.updateSeries([{ data }]);
        }

        // Check for alerts
        checkThresholds(topic, value);
      });
    </script>
  </body>
