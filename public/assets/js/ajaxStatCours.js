function showStat(id){
    $(document).ready(function () {
            $.ajax({
                url: '/lesson/get/'+id,
                method: 'GET',
                success: function (data) {
                    $("#info").empty();
                    let nbrAbs = 0;
                    let nbrJust = 0;
                    let nbrPresent = 0;
                    let label;
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].absent.status === 0){
                            nbrAbs += 1;
                        }if (data[i].absent.status === 1){
                            nbrJust += 1;
                        }if (data[i].absent.status === 2){
                            nbrPresent += 1;
                        }
                        label = data[i].absent.label;
                    }
                    $("#info").append(
                        '<h3> Nom du cours :' + label + '</h3>' +
                        '<p> Absent :' + nbrAbs + 'Justifié :' + nbrJust + 'Présent :' + nbrPresent + '</p>'
                    );
                    $("#info").show();

                }
            });
    });
}