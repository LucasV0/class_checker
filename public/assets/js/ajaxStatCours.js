function getStats(){
    $(document).ready(function () {
      let selectedLessons = $("#idLesson").val(); 
      $("#info").empty(); 
      $("#info").show(); 
  

      selectedLessons.forEach(function(id) {
        $.ajax({
          url: '/lesson/get/'+id,
          method: 'GET',
          success: function (data) {
            let nbrAbs = 0;
            let nbrJust = 0;
            let nbrPresent = 0;
            for (let i = 0; i < data.length; i++) {
              if (data[i].absent.status === 0){
                nbrAbs += 1;
              } else if (data[i].absent.status === 1){
                nbrJust += 1;
              } else if (data[i].absent.status === 2){
                nbrPresent += 1;
              }
            }
            let canvasId = "bar" + id;
            $("#info").append('<canvas id="'+canvasId+'"></canvas>'); 
            bar(nbrPresent, nbrJust, nbrAbs, canvasId); 
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        });
      });
    });
  }
  