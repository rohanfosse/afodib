	<!DOCTYPE html>
<html>
<title>Café Michel - AFoDIB</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />
<style>
body {font-family: "Times New Roman", Georgia, Serif;}
h1,h2,h3,h4,h5,h6 {
    font-family: "Playfair Display";
    letter-spacing: 5px;
}

    a.fancybox img {
        border: none;
        box-shadow: 0 1px 7px rgba(0,0,0,0.6);
        -o-transform: scale(1,1); -ms-transform: scale(1,1); -moz-transform: scale(1,1); -webkit-transform: scale(1,1); transform: scale(1,1); -o-transition: all 0.2s ease-in-out; -ms-transition: all 0.2s ease-in-out; -moz-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;
    } 
    a.fancybox:hover img {
        position: relative; z-index: 999; -o-transform: scale(1.03,1.03); -ms-transform: scale(1.03,1.03); -moz-transform: scale(1.03,1.03); -webkit-transform: scale(1.03,1.03); transform: scale(1.03,1.03);
        .zoom {
height:400px;
margin:auto;
}
.zoom p {
text-align:center;
}
.zoom img {
width:300px;
height:225px;
}
.zoom img:hover {
width:400px;
height:300px;
}
</style>

<script type="text/javascript">
    $(function($){
        var addToAll = false;
        var gallery = true;
        var titlePosition = 'inside';
        $(addToAll ? 'img' : 'img.fancybox').each(function(){
            var $this = $(this);
            var title = $this.attr('title');
            var src = $this.attr('data-big') || $this.attr('src');
            var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
            $this.wrap(a);
        });
        if (gallery)
            $('a.fancybox').attr('rel', 'fancyboxgallery');
        $('a.fancybox').fancybox({
            titlePosition: titlePosition
        });
    });
    $.noConflict();
</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
      <script type="text/javascript" src="panier.js"></script>
      <script>
$(document).ready(function(){
    $("button").click(function(){
$.ajax({
	  type: "GET",  
	  url: "tarifs.csv",
	  dataType: "text",       
	  success: function(response)  
	  {
		data = $.csv.toArrays(response);
		var ref = parseInt(document.getElementById("id").value);
		data_line = find_line(data,ref);
		ajouter(data_line);
	  }   
	});
    });
});			function find_line(data_in,val){
				len = data_in.length;
				for (i = 0; i < len; i++) {
					if(data_in[i][0] == val){
						return data[i];					
					}
				}
			}

            function ajouter(data_in)
            {
                var code = parseInt(data_in[0]);
                var name = data_in[1];
                var qte = parseInt(document.getElementById("qte").value);
                var prix = parseFloat(data_in[2]);
                var monPanier = new Panier();
                monPanier.ajouterArticle(code,name, qte, prix);
                var tableau = document.getElementById("tableau");
                var longueurTab = parseInt(document.getElementById("nbreLignes").innerHTML);
                if (longueurTab > 0)
                {
                    for(var i = longueurTab ; i > 0  ; i--)
                    {
                        monPanier.ajouterArticle(parseInt(tableau.rows[i].cells[0].innerHTML), tableau.rows[i].cells[1].innerHTML,parseInt(tableau.rows[i].cells[2].innerHTML), parseInt(tableau.rows[i].cells[3].innerHTML));
                        tableau.deleteRow(i);
                    }
                }
                var longueur = monPanier.liste.length;
                for(var i = 0 ; i < longueur ; i++)
                {
                    var ligne = monPanier.liste[i];
                    console.log(ligne);
                    var ligneTableau = tableau.insertRow(-1);
                    var colonne1 = ligneTableau.insertCell(0);
                    colonne1.innerHTML += ligne.getCode();
                    var colonne2 = ligneTableau.insertCell(1);
                    colonne2.innerHTML += ligne.getName();
                    var colonne3 = ligneTableau.insertCell(2);
                    colonne3.innerHTML += ligne.qteArticle;
                    var colonne4 = ligneTableau.insertCell(3);
                    colonne4.innerHTML += ligne.getPrixLigne();
                    var colonne5 = ligneTableau.insertCell(4);
                    colonne5.innerHTML += "<button class=\"btn btn-danger\" type=\"submit\" onclick=\"supprimer(this.parentNode.parentNode.cells[0].innerHTML)\"><span class=\"glyphicon glyphicon-remove\"></span> Remove</button>";
                
                    }
                                    document.getElementById("prixTotal").innerHTML = monPanier.getPrixPanier();
                document.getElementById("nbreLignes").innerHTML = longueur;
            }
            
            function supprimer(code)
            {
                var monPanier = new Panier();
                var tableau = document.getElementById("tableau");
                var longueurTab = parseInt(document.getElementById("nbreLignes").innerHTML);
                if (longueurTab > 0)
                {
                    for(var i = longueurTab ; i > 0  ; i--)
                    {
                        monPanier.ajouterArticle(parseInt(tableau.rows[i].cells[0].innerHTML), parseInt(tableau.rows[i].cells[1].innerHTML), parseInt(tableau.rows[i].cells[2].innerHTML));
                        tableau.deleteRow(i);
                    }
                }
                monPanier.supprimerArticle(code);
                var longueur = monPanier.liste.length;
                for(var i = 0 ; i < longueur ; i++)
                {
                    var ligne = monPanier.liste[i];
                    var ligneTableau = tableau.insertRow(-1);
                    var colonne1 = ligneTableau.insertCell(0);
                    colonne1.innerHTML += ligne.getCode();
                    var colonne2 = ligneTableau.insertCell(1);
                    colonne2.innerHTML += ligne.qteArticle;
                    var colonne3 = ligneTableau.insertCell(2);
                    colonne3.innerHTML += ligne.prixArticle;
                    var colonne4 = ligneTableau.insertCell(3);
                    colonne4.innerHTML += ligne.getPrixLigne();
                    var colonne5 = ligneTableau.insertCell(4);
                    colonne5.innerHTML += "<button class=\"btn btn-danger\" type=\"submit\" onclick=\"supprimer(this.parentNode.parentNode.cells[0].innerHTML)\"><span class=\"glyphicon glyphicon-remove\"></span> Remove</button>";
                }
                document.getElementById("prixTotal").innerHTML = monPanier.getPrixPanier();
                document.getElementById("nbreLignes").innerHTML = longueur;
            }
        </script>
        
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-padding w3-card" style="letter-spacing:4px;">
    <a href="#home" class="w3-bar-item w3-button">AFoDIB</a>
    <!-- Right-sided navbar links. Hide them on small screens -->
    <div class="w3-right w3-hide-small">
      <a href="#about" class="w3-bar-item w3-button">About</a>
      <a href="#Commander" class="w3-bar-item w3-button">Orders</a>
      <a href="#contact" class="w3-bar-item w3-button">Contact</a>
    </div>
  </div>
</div>

<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1880px;min-width:500px" id="home">
  <img class="w3-image" src="https://i1.wp.com/www.todaysvictory.com/hp_wordpress/wp-content/uploads/2016/11/Coffee-Shop-Ministry-Church-Website-Banner-.jpg" alt="Hamburger Catering" width="1880" height="800">
  <div class="w3-display-bottomleft w3-padding-large w3-opacity">
    <h1 class="w3-xxlarge">Café Michel</h1>
  </div>
</header>

<!-- Page content -->
<div class="w3-content" style="max-width:1100px">
	<h1 class="w3-center w3-xxxlarge">Café Michel</h1>
  <!-- About Section -->
  <div class="w3-row w3-padding-64" id="about">


      <h1 class="w3-center">Les tarifs</h1>
	<div class="w3-center zoom l4 w3-padding-large">
<img src="tarif-CM-2018-1.jpg" class="w3-round w3-image w3-opacity-min fancybox" alt="Menu" style="width:100%">
<img src="tarif-CM-2018-2.jpg" class="w3-round w3-image w3-opacity-min fancybox" alt="Menu" style="width:100%">

</div>
      <h5 class="w3-center"><a href="https://simondasilva.fr/afodib-cafe/tarif-CM-2018.pdf">Download references and prices</a></h5>

  <hr>
  
  <!-- Menu Section -->
  

  <!-- Menu Section -->
  <div class="w3-row w3-padding-64" id="menu">
        <h1 class="w3-center">Orders</h1><br>
  <div class="w3-col l6 orders">
		<h3 class="w3-center">Add an article</h3><br>
    <section  class="container">
            <article class="well form-inline pull-left col-lg-5">
                
                <p><label>Reference</label> <input class="w3-input w3-padding-16" type="text" id = "id" ></p>
      <p><label>Quantity</label><input class="w3-input w3-padding-16" type="number" id = "qte" required name="Quantité"></p>
      <button class="w3-button w3-section btn btn-primary" id="Add" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span> <b>Add</b></button>
            </article>
        </section>
        <p id="demo"></p>


    </div>
    <div class="w3-col l6">
    <h3 class="w3-center">Shopping cart</h3><br><br>
             <section class="container">
            <article class="well form-inline pull-left col-lg-5">
                <table id="tableau" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                <br><label>Total price</label> : <label id = "prixTotal"></label><br>
                <label id = "nbreLignes" hidden>0</label>
                <button class=" pull-right btn btn-primary disabled" id="buy" type="button"><span class="glyphicon glyphicon-shopping-cart"></span> <b>Buy</b></button>
            </article>
        </section>
  
    </div>
  </div>

  <hr>

    <div class="w3-row w3-padding-64" id="Contact">
    <h1 class="w3-center">AFODIB Description</h1><br>

  </div>
<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-center w3-light-grey w3-padding-32"> 
Copyright AFoDIB 2018
</footer>

</body>
</html>
