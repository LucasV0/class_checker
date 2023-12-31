//CALL AJAX TO GET SESSION (ex : 2022/2023)
//@author: Caron Baptiste
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
                $("#labelPeriod").empty();
                $("#labelPeriod").append(data.session);
                let lesson = data.lesson;
                for (let i = 0; i < lesson.length; i++) {
                    if (lesson[i].label.length > 20){
                       $("#lesson").append(
                         '<tr id="'+lesson[i].id+'">'+
                        '<td class="ps-2 toolTip" style="max-width: 10em; max-height: 5em;"><a href="/lesson/'+lesson[i].id+'/sessions">' +
                           +lesson[i].label.substring(0,20) + '... ' +'</a>'+
                        '<span class="toolTiptext" style="background-color: #f3f4f4;">'+ lesson[i].label+'</span>' +
                        '</td>'+
                            '<td class="ps-2">' +lesson[i].prof_name +' '+ lesson[i].prof_surname + '</td>' +
                            '<td class="ps-2">' +lesson[i].student + '</td>' +
                            '<td class="ps-2">' +lesson[i].max_student + '</td>' +
                            '<td class="ps-2"> du ' +lesson[i].period_start+' au ' +lesson[i].period_end + '</td>' +
                            '<td class="ps-2"> le ' +lesson[i].day+' de ' +lesson[i].hour_start + ' à '+lesson[i].hour_end + '</td>' +
                            '<td class="ps-2" style="width:10em ">' +
                           '<a class="btn btn-sm btn-outline-warning me-1" style="border: 1px solid ; padding: 0.25rem 0.5rem;" href="/lesson/modif/'+lesson[i].id +'">' +
                           '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">'+
                               '<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>'+
                               '<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>'+
                           '</svg>' +
                           ' </a>' +
                           '<a class="btn btn-sm btn-outline-danger" style="border: 1px solid ; padding: 0.25rem 0.5rem;" onclick="delLesson('+ lesson[i].id +' )">' +
                           '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">' +
                           '<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>' +
                           '</svg>'+
                           '</a> '+
                           '<a type="button" class="btn btn-sm btn-outline-primary" href="/tohave/'+lesson[i].id +'">'+
                           '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">'+
                               '<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>'+
                               '<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>'+
                           '</svg>'+
                           '</a>'+
                            '</td></tr>'
                        )
                    }else {
                        $("#lesson").append(
                            '<tr id="'+lesson[i].id+'">'+
                            '<td class="ps-2 toolTip" style="max-width: 10em; max-height: 5em;">+<a href="/lesson/'+lesson[i].id+'/sessions">'
                            +lesson[i].label.substring(0,20) +  '... ' +'</a>'+
                            '<span class="toolTiptext" style="background-color: #f3f4f4;">'+ lesson[i].label+'</span>' +
                            '</td>'+
                        '<td class="ps-2">' +lesson[i].prof_name +' '+ lesson[i].prof_surname + '</td>' +
                        '<td class="ps-2">' +lesson[i].student + '</td>' +
                        '<td class="ps-2">' +lesson[i].max_student + '</td>' +
                        '<td class="ps-2"> du ' +lesson[i].period_start+' au ' +lesson[i].period_end + '</td>' +
                        '<td class="ps-2"> le ' +lesson[i].day+' de ' +lesson[i].hour_start + ' à '+lesson[i].hour_end + '</td>' +
                        '<td class="ps-2" style="width:10em ">' +
                        '<a class="btn btn-sm btn-outline-warning me-1" style="border: 1px solid ; padding: 0.25rem 0.5rem;" href="/lesson/modif/'+lesson[i].id +'">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">'+
                                '<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>'+
                                '<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>'+
                           ' </svg>' +
                            ' </a>' +
                        '<a class="btn btn-sm btn-outline-danger" style="border: 1px solid ; padding: 0.25rem 0.5rem;" onclick="delLesson('+ lesson[i].id +' )">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">' +
                            '<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>' +
                            '</svg>'+
                            '</a> '+
                            '<a type="button" class="btn btn-sm btn-outline-primary" href="/tohave/'+lesson[i].id +'">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">'+
                                    '<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>'+
                                    '<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>'+
                                '</svg>'+
                            '</a>'+
                        '</td></tr>'
                    );
                    }




                }
            },

            error:function(response = 'ko'){
                console.log('error');
                alert("error");

            }

        });
    });
}

