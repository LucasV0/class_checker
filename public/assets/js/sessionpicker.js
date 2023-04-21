
function getSession(path, session){
    $(document).ready(function(){

        $.ajax({
            url:path,
            type:'POST',
            data:{
                session: session
            } ,
            dataType: 'json', //text

            success:function(data){

                console.log(data);

            },

            error:function(response = 'ko'){
                console.log('error');
                alert("error");

            }

        });
    });
}

