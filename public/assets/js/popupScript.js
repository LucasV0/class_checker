function flash() {

  setTimeout(function(){
   $(".flash").remove();  
    $(".flash").fadeOut();
  }, 2000);
  
   
  
  
  
};
setTimeout("flash()", 3000);
flash();