
function delSesson(id){
    $(document).ready(function(){

    if(confirm("Voulez vous vraiment supprimer la session ?")){
            $.ajax({
                url:'/session/delete/'+id,
                method:'DELETE',
                success:function(data){
                   if(data.response === 'ok'){
                       $("#alert").append(
                           '<div class="flash" data-state=success>' +
                           '<strong id="response">La session a bien été supprimée.</strong>' +
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
