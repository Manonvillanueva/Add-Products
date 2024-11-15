<!-- Pour chaque champ du formulaire, il faut ajouter un attribut name afin que PHP puisse identifier les données envoyées. -->
<?php
if(isset($_POST["add-btn"])) {
  $con = mysqli_connect("db","root","example","products_db");
  if(!$con) {
    echo "échoué";
  } else {
    echo "yes";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css" />
    <title>PRODUITS</title>
  </head>
  <body>
    
    <div class="add-products-container">
    <!-- enctype="multipart/form-data"> Cela permet d’envoyer des fichiers via le formulaire (comme une image). -->
      <form class="form-add-products" method="POST" enctype="multipart/form-data">
        <label for="product-name">Nom du produit</label>
        <input type="text" id="product-name" name="product-name"/>
        <label for="product-description">Description du produit</label>
        <textarea id="product-description" name="product-description"></textarea>
        <label for="add-img">Ajouter une image</label>
        <input type="file" name="product-image" id="add-img" />
        <input type="submit" value="Ajouter" name="add-btn"/>
        <a class="nav-products-list" href="./liste.php">Liste des produits</a>
      </form>
    </div>
  </body>
</html>
