<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sensor Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
</head>
<body>
  <div class="container-fluid py-4">
    <div class="row">
      <!-- CO2 Chart -->
      <div class="col-md-10 col-lg-10">
        <div class="card mt-4">
          <div class="card-body">
            <h6 class="mb-0">Gas Sensor Readings</h6>
            <div id="gas-sensor-chart" style="width: 100%; height: 350px;"></div>
          </div>
        </div>
      </div>

      <!-- Humidity Chart -->
      <div class="col-md-10 col-lg-10">
        <div class="card mt-4">
          <div class="card-body">
            <h6 class="mb-0">Humidity Levels</h6>
            <div id="humidity-chart" style="width: 100%; height: 350px;"></div>
          </div>
        </div>
      </div>

      <!-- Temperature Chart -->
      <div class="col-md-10 col-lg-10">
        <div class="card mt-4">
          <div class="card-body">
            <h6 class="mb-0">Température Moyenne Haute et Basse</h6>
            <div id="temperature-chart" style="width: 100%; height: 350px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

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
  } else {
    console.warn("Chart or data series not ready for topic:", topic);
  }
});

  </script>
</body>
</html>
