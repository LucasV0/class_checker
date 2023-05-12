function addStudent(idStudent, idLesson){

        $.ajax({
            url:'/tohave/add',
            method:'POST',
            data: {
                idStudent : idStudent,
                idLesson : idLesson
            },
            success:function(response = 'ok'){
                    $("#alert").append(
                        '<div class="flash" data-state=success>' +
                        '<strong id="response">L\'élèves a bien été ajouté au cours.</strong>' +
                        '</div>'
                    );
                $('#'+idStudent).attr('onclick', 'delStudent('+idStudent +','+ idLesson +')')
                flash();

            },
            error:function(response = 'ko'){
                $("#alert").append(
                    '<div class="flash" data-state=error>' +
                    '<strong id="resp">Il y a eu une erreur</strong>' +
                    '</div>'
                );
                flash();
            }

        });

}

function delStudent(idStudent, idLesson){

        $.ajax({
            url:'/tohave/del',
            method:'DELETE',
            data:{
              idStudent:idStudent,
              idLesson: idLesson
            },
            success:function(response = 'ok'){
                    $("#alert").append(
                        '<div class="flash" data-state=success>' +
                        '<strong id="response">L\'élèves a bien été enlevé du cours.</strong>' +
                        '</div>'
                    );
                    $('#'+idStudent).attr('onclick', 'addStudent('+idStudent +','+ idLesson +')')
                flash();

            },
            error:function(response = 'ko'){
                $("#alert").append(
                    '<div class="flash" data-state=error>' +
                    '<strong id="resp">Il y a eu une erreur</strong>' +
                    '</div>'
                );
                flash();
            }

        });
}