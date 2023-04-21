$(document).ready(function(){
 
    $("#editProfil").submit(function(e){
        e.preventDefault();
 
            $.ajax({
            url:$(this).attr('action'),
            type:'POST',
            data: $(this).serialize(),
			dataType: 'json', //text
            
            success:function(response = 'ok'){		
				console.log(response);
                location.reload();  


            },
			error:function(response = 'ko'){
                console.log('error');
				alert("error");

            }
			
        });
    });
});