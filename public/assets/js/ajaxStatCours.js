function getStats() {
  $(document).ready(function() {
    let selectedLessons = $("#idLesson").val();
    $("#info").empty();
    $("#info").show();

    let promises = selectedLessons.map(function(id) {
      return $.ajax({
        url: "/lesson/get/" + id,
        method: "GET"
      });
    });

    Promise.all(promises).then(function(responses) {
      let datasets = [];

      responses.forEach(function(data, index) {
        let nbrAbs = 0;
        let nbrJust = 0;
        let nbrPresent = 0;

        for (let i = 0; i < data.length; i++) {
          if (data[i].absent.status === 0) {
            nbrAbs += 1;
          } else if (data[i].absent.status === 1) {
            nbrJust += 1;
          } else if (data[i].absent.status === 2) {
            nbrPresent += 1;
          }
        }

        datasets.push({
          label: "lesson " + selectedLessons[index],
          data: [nbrPresent, nbrJust, nbrAbs],
          backgroundColor: ["#4e73df", "#1cc88a", "#e74a3b"],
          hoverBackgroundColor: ["#2e59d9", "#17a673", "#b91111"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        });
      });

      let canvas = document.createElement("canvas");
      let canvasId = "barStatsLesson";
      canvas.setAttribute("id", canvasId);
      $("#info").append(canvas);

      var ctx = document.getElementById(canvasId).getContext("2d");
      var myChart = new Chart(ctx, {
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
          legend: {
            display: true,
            position: "bottom",
            labels: {
              fontSize: 20
            }
          },
          cutoutPercentage: 80
        }
      });
    });
  });
}