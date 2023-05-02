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
                           '<div class="alert alert-dismissible alert-success" id="succes">' +
                           '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                           '<strong id="response">Le cours a bien été supprimé.</strong>' +
                           '</div>'
                       );
                   }
                    $('#'+id).remove();

                },
                error:function(response = 'ko'){
                    $("#alert").append(
                        '<div class="alert alert-dismissible alert-danger" id="error">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '<strong id="resp">Il y a eu une erreur</strong>' +
                        '</div>'
                    );
                }

            });
    }
    });
}
