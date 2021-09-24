function noteFilm(score){
  var titre = document.getElementById("caption").innerHTML;
  mesNotes(score);
  $.ajax({
    type: "POST",
    url: '../backEnd/note.php?score='+score+'&titre='+titre,
    data: $(this).serialize()
    }).then(
    // resolve/success callback
    function(response)
    {
     
     $("#noteClient").css("display","none");
     
        
    },
    // reject/failure callback
    function()
    {
        alert('There was some error!');
    }
);
}

/*On affecte les notes quand le client donne sa note*/
function mesNotes(noteClient){
  
  $("#affichageRating").css("display","block");
        /*Le film n'a pas de note*/
          if(note==0){

            for(var i=0;i<noteClient;i++){
            j = i+1;
            /*alert(j);*/
            document.getElementById("note"+j).style.display = "inline-block";
         }
          }
          else{
            /*On enleve les notes et on affiche ensuite les bonnes*/
            for(var i=0;i<5;i++){
            j = i+1;
            document.getElementById("note"+j).style.display = "none";
            }
            /*alert(note);
            alert(noteClient);*/
            noteAVG = (noteClient + note)/2;
            noteAVG = Math.floor(noteAVG);
            /*alert(noteAVG)*/;
          for(var i=0;i<noteAVG;i++){
            j = i+1;
            document.getElementById("note"+j).style.display = "inline-block";
         }
       }
}

