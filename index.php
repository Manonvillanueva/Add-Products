<!-- Pour chaque champ du formulaire, il faut ajouter un attribut name afin que PHP puisse identifier les données envoyées. -->
<?php
if($_POST["add-btn"]) {
  $con = mysqli_connect("db","root","example","products_db");
  if (!$con) {
    echo "connexion XX" ;
  } else {
    // Utilisation  de $_POST qui va récupérer la valeur du champ product-name ou product-description ici . On met le NAME de l'input et non l'ID ou la class
    // $_POST est une superglobale en PHP. Cela veut dire que c'est une variable spéciale qui permet de récupérer toutes les informations envoyées via le formulaire.
    if(empty($_POST['product-name']) || empty($_POST['product-description'])) {
      echo "Veuillez remplir tous les champs" ;
    } else {
      $productName = $_POST['product-name'];
      $productDescription = $_POST['product-description'];

      if(isset($_FILES["product-image"])) {
        $temporaryName = $_FILES['product-image']['tmp_name'];
        $name = $_FILES['product-image']['name'];
        $imageMoved = move_uploaded_file($temporaryName,"./upload".$name);

        if($imageMoved) {
         $query = "INSERT INTO product (name, description, image) VALUES ('$productName', '$productDescription', '$name')";
         $result = mysqli_query($con, $query);
         if($result) {
          echo "y";
         } else {
          echo "x";
         }
      } 
    }
  }}
  
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
        <!-- Utilisation de la méthode POST pour envoyer les données au serveur via le formulaire -->
        <form class="form-add-products" method="POST" enctype="multipart/form-data">
            <!-- NAME PRODUCT  -->
            <label for="product-name">Nom du produit</label>
            <input type="text" id="product-name" name="product-name" required />
            <!-- DESCRIPTION PRODUCT  -->
            <label for="product-description">Description du produit</label>
            <textarea id="product-description" name="product-description" required></textarea>
            <!-- IMG PRODUCT  -->
            <!-- enctype="multipart/form-data"> Cela permet d’envoyer des fichiers via le formulaire. -->
            <label for="add-img">Ajouter une image</label>
            <input type="file" name="product-image" id="add-img" />
            <!-- SUBMIT BTN  -->
            <input type="submit" value="Ajouter" name="add-btn" />
            <a class="nav-products-list" href="./liste.php">Liste des produits</a>
        </form>
    </div>
</body>

</html>