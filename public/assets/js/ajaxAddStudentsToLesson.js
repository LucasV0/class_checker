function addStudent(id){

    $(document).onclick(function(){
        $.ajax({
            url:'/tohave'+id,
            method:'PUT',
            success:function(data){
                if(data.response === 'ok'){
                    $("#alert").append(
                        '<div class="flash" data-state=success>' +
                        '<strong id="response">L\'élèves a bien été ajouté au cours.</strong>' +
                        '</div>'
                    );
                }
                $('#'+id).remove();
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
    })
}