//@author: Caron baptiste
//Call AJAX to delete one lesson

function delLesson(id){
    $(document).ready(function(){

    if(confirm("Voulez vous vraiment supprimer le cours ?")){
            $.ajax({
                url:'/lesson/delete/'+id,
                method:'DELETE',
                success:function(data){
                   if(data.response === 'ok'){
                       $("#alert").append(
                           '<div class="flash" data-state=success>' +
                           '<strong id="response">Le cours a bien été supprimé.</strong>' +
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
    }
    });
}
