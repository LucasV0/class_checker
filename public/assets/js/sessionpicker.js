
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
                        '<tr id="'+lesson[i].id+'">')
                    if (lesson[i].label.length > 20){
                        $("#lesson").append(
                            '<td class="ps-2 toolTip" style="max-width: 10em; max-height: 5em;">'+lesson[i].label.substring(0,20) + '... ' +
                            '<span class="toolTiptext" style="background-color: #f3f4f4;">'+ lesson[i].label+'</span>' +
                            '</td>')
                    }else {
                        $("#lesson").append(
                            '<td class="ps-2" style="max-width: 10em; max-height: 5em;">'+lesson[i].label +
                            '</td>')
                    }
                    $("#lesson").append(
                        '<td class="ps-2">' +lesson[i].prof_name +' '+ lesson[i].prof_surname + '</td>' +
                        '<td class="ps-2">' +lesson[i].student + '</td>' +
                        '<td class="ps-2">' +lesson[i].max_student + '</td>' +
                        '<td class="ps-2"> du' +lesson[i].period_start+' au ' +lesson[i].period_end + '</td>' +
                        '<td class="ps-2"> le' +lesson[i].day+' de ' +lesson[i].hour_start + 'à'+lesson[i].hour_end + '</td>' +
                        '<td class="ps-2" style="width:10em ">' +
                        '<a class="btn btn-sm btn-outline-info me-1" style="border: 1px solid #36b9cc; padding: 0.25rem 0.5rem;" href="/lesson/modif/'+lesson[i].id +'"> Modifier</a>' +
                        '<a class="btn btn-sm btn-outline-danger" style="border: 1px solid #e74a3b; padding: 0.25rem 0.5rem;" onclick="delLesson('+ lesson[i].id +' )"> Supprimer</a> '+
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

