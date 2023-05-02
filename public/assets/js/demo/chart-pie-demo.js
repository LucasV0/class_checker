//@author baptiste Caron
// Graphique Donuts permettant d'afficher les données Global de l'application

// Set new default font family and font color to mimic Bootstrap's default styling
function Donuts(present, justifiee, non_justifiee) {
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';
  // Pie Chart Example
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Présent", "Justifiée", "Non-Justifiée"],
      datasets: [{
        data: [present, justifiee, non_justifiee],
        backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#b91111'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });
}


