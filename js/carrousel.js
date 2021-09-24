var imageIndex=1;
var note=0;
function carrousel(incrementation){
  //alert(imageIndex);
  /*On avance dans le carousel*/
  imageIndex+=incrementation;
  if (imageIndex<1) {
    imageIndex=1;
  }
	if(imageIndex==4){
		imageIndex=1;
	}
  var nbAleatoire=Math.floor(Math.random() * Math.floor(20));
  showImageURL(imageIndex,nbAleatoire+1);
}

function showImageURL(imageIndex,alea) {
  // alert(alea);
  $.ajax({
    type: "POST",
    url: '../backEnd/film.php?imageVal='+alea,
    data: $(this).serialize()
    }).then(
    // resolve/success callback
    function(response)
    {
        var jsonData = JSON.parse(response);
        //var myString = JSON.stringify(jsonData);
        var urlPhoto=jsonData.photo;
        var title=jsonData.titre
        document.getElementById("image"+imageIndex).src = urlPhoto;
      /*  document.getElementById("captionImage"+imageIndex).innerHTML=title;*/
        // user is logged in successfully in the back-end
        // let's redirect
        
    },
    // reject/failure callback
    function()
    {
        alert('There was some error!');
    }
);
      
  }
/*Affichage de la galerie*/
function galerie(cat){
var url;
  if(typeof cat!="undefined"){
    url1 = '../backEnd/galerie.php?cat='+cat;
  }else{
     url1 = '../backEnd/galerie.php';
  }
  $.ajax({
    type: "POST",
    url:url1,
    data: $(this).serialize(),
    }).then(
    // resolve/success callback
    function(response)
    {

        var jsonData = JSON.parse(response);
        console.table(jsonData);
        //alert(jsonData[5]['titre']);
        //console.table(test);

        var myMovies = new Array();
        var photo = new Array();


        if(typeof cat !="undefined"){
          var tailleMoovies = Object.keys(jsonData['photo']).length;
          /*On enlève les images*/
          for(i=1;i<10;i++){
                document.getElementById("galerie"+i).style.display="none";
          }

          // alert(tailleMoovies);
          for(var j =1;j<tailleMoovies+1;j++){
            var photo=jsonData['photo'][j-1];
            document.getElementById("galerie"+j).style.display="block";
            document.getElementById("galerie"+j).alt=jsonData['id'][j-1];
            document.getElementById("galerie"+j).src = photo;
          }
        }
        else{
        var tailleGalerie = 9;
        /*jsonData.length + 1*/
        var n = jsonData['value'].length + 1;
        var nbIndex=[];
        /*Tableau des index d'images*/
        for(var i=1;i<n;i++){
          nbIndex.push(i);
          myMovies[i-1] = jsonData['value'][i-1];
          photo[i-1] = jsonData['photo'][i-1];
        }
        var listeautocomplete = JSON.parse(JSON.stringify(myMovies));
        console.table(listeautocomplete);


         var j=1;
        //Remplissage de la galerie
        while(j!=tailleGalerie+1){
          //Nombre aléatoire
          var nbAleatoire=Math.floor(Math.random() * Math.floor(n));
              /*On test le nombre pour ne pas prendre deux fois le même film*/
              if(nbIndex.includes(nbAleatoire)){
                //index du tableau
                  var test=nbIndex.indexOf(nbAleatoire);
                //On supprime le nombre choisis
                  nbIndex.splice(test,1);
                  var photo= jsonData['photo'][nbAleatoire-1];
                  document.getElementById("galerie"+j).style.display="block";
                  document.getElementById("galerie"+j).alt=jsonData['id'][nbAleatoire-1];
                  document.getElementById("galerie"+j).src =photo;
                  j++;
              }

        }
      }
        
        
    },
    // reject/failure callback
    function()
    {
        alert('There was some error!');
    }
);

}
function afficherCommentaire(photo){
  $.ajax({
    type: "POST",
    url: '../backEnd/film.php?url='+photo,
    data: $(this).serialize()
    }).then(
    // resolve/success callback
    function(response)
    {
        var jsonData = JSON.parse(response);
        var commentaire = jsonData.com;

        var commentaireInfo = document.getElementById("commentaireContenue");

      
        commentaireInfo.innerHTML = commentaire;
    },
    // reject/failure callback
    function()
    {
        alert('There was some error!');
    }
);   
}


function popupImage(id){
    var url1 = '../backEnd/articles.php?id='+id;
  $.ajax({
    type: "POST",
    url: url1,
    data: $(this).serialize()
    }).then(
    // resolve/success callback
    function(response)
    {
      /*Les variables*/
        var jsonData = JSON.parse(response);
        console.log(jsonData);
              var cat = jsonData['categorie'][0];
              var prix = jsonData['prix'][0];
              var photo = jsonData['photo'][0];
              var modal = document.getElementById("myModal");
              var modalImg = document.getElementById("img01");
              var prixModal = document.getElementById("prix");
              var catego = document.getElementById("categorie");
           


              prixModal.innerHTML = prix.toString().concat(" €");
              catego.innerHTML = cat;
              modal.style.display = "block";
              modalImg.src = photo;
              $("#description").text(jsonData['desc']);


              var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
          modal.style.display = "none";
        }
      }
);
}
function reloadGalerie(){
  galerie();
}   
