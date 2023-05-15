function bar(datasets, id) {
  Chart.defaults.global.defaultFontFamily =
    "'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif";
  Chart.defaults.global.defaultFontColor = "#858796";
  var ctx = document.getElementById(id);
  var myBar = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Présent", "Justifiée", "Non-justifiée"],
      datasets: datasets
    },
    options: {
      scales: {
        xAxes: [
          {
            ticks: {
              fontSize: 30
            }
          }
        ],
        yAxes: [
          {
            ticks: {
              fontSize: 20,
              stepSize: 1,
              min: 0,
              max: 15
            }
          }
        ]
      },
      // legend: {
      //   display: false
      // },
    }
  });
}