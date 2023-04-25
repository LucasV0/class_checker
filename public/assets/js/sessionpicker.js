
function getSession(session){
    $(document).ready(function(){
        let content = session;
        $.ajax({
            url:'/api/lesson',
            type:'GET',
            data:{
                session: content
            } ,
            dataType: 'json', //text

            success:function(data){
                $("#lesson").empty();
                $("#period").empty();
                $("#period").append('Période : ' + data.session);
                let lesson = data.lesson;
                for (let i = 0; i < lesson.length; i++) {
                    $("#lesson").append(
                        '<tr >' +
                        '<td class="ps-2">' +lesson[i].label + '</td>' +
                        '<td class="ps-2">' +lesson[i].prof_name +' '+ lesson[i].prof_surname + '</td>' +
                        '<td class="ps-2">' +lesson[i].student + '</td>' +
                        '<td class="ps-2">' +lesson[i].max_student + '</td>' +
                        '<td class="ps-2"> du' +lesson[i].period_start+' au ' +lesson[i].period_end + '</td>' +
                        '<td class="ps-2"> le' +lesson[i].day+' de ' +lesson[i].hour_start + 'à'+lesson[i].hour_end + '</td>' +
                        '<td class="ps-2" style="width:10em ">' +
                        '<a class="btn btn-outline-info btn-sm me-1" href="/lesson/modif/'+lesson[i].id +'"> Modifier</a>' +
                        '<a class="btn btn-outline-danger btn-sm" href="/lesson/delete/'+lesson[i].id +'" onclick="return confirm(\'Voulez vous vraiment supprimer le cour ?\')"> Supprimer</a> '+
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

