
function getSession(session){
    $(document).ready(function(){

        $.ajax({
            url:'/api/lesson',
            type:'GET',
            data:{
                session: session
            } ,
            dataType: 'json', //text

            success:function(data){
                $("#lesson").empty();
                for (let i = 0; i < data.length; i++) {
                    $("#lesson").append(
                        '<tr >' +
                        '<td class="ps-2">' +data[i].lesson.label + '</td>' +
                        '<td class="ps-2">' +data[i].lesson.prof_name +' '+ data[i].lesson.prof_surname + '</td>' +
                        '<td class="ps-2">' +data[i].lesson.student + '</td>' +
                        '<td class="ps-2">' +data[i].lesson.max_student + '</td>' +
                        '<td class="ps-2"> du' +data[i].lesson.period_start+' au ' +data[i].lesson.period_end + '</td>' +
                        '<td class="ps-2"> le' +data[i].lesson.day+' de ' +data[i].lesson.hour_start + 'à'+data[i].lesson.hour_end + '</td>' +
                        '<td class="ps-2" style="width:10em ">' +
                        '<a class="btn btn-outline-info btn-sm me-1" href="/lesson/modif/'+data[i].lesson.id +'"> Modifier</a>' +
                        '<a class="btn btn-outline-danger btn-sm" href="/lesson/delete/'+data[i].lesson.id +'" onclick="return confirm(\'Voulez vous vraiment supprimer le cour ?\')"> Supprimer</a> '+
                        '</td></tr>'
                    );
                }
            },

            error:function(response = 'ko'){
                console.log('error');
                alert("error");

            }

        });
    });
}

