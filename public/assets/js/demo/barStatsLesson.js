function bar(present, justifiee, non_justifiee, id) {
    Chart.defaults.global.defaultFontFamily =
      "Nunito', '-apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif";
    Chart.defaults.global.defaultFontColor = "#858796";
    var ctx = document.getElementById(id);
    var myBar = new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Présent", "Justifiée", "Non-justifiée"],
        datasets: [
          {
            axis: "y",
            data: [present, justifiee, non_justifiee],
            fill: false,
            backgroundColor: ["#4e73df", "#1cc88a", "#e74a3b"],
            hoverBackgroundColor: ["#2e59d9", "#17a673", "#b91111"],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          },
        ],
      },
      options: {
        scales: {
          xAxes: [
            {
              ticks: {
                fontSize: 30,
              },
            },
          ],
          yAxes: [
            {
              ticks: {
                fontSize: 20,
                stepSize: 1,
                min: 0,
                max: 15,
              },
            },
          ],
        },
        legend: {
          display: false,
        },
        cutoutPercentage: 80,
      },
    });
  }
  