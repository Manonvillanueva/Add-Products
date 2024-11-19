<!-- Pour chaque champ du formulaire, il faut ajouter un attribut name afin que PHP puisse identifier les données envoyées. -->

<?php
// Vérifie si le formulaire a été soumis en appuyant sur le bouton "add-btn"
if ($_POST["add-btn"]) {

  // Connexion à la base de donnée 
  $con = mysqli_connect("db", "root", "example", "products_db");

  // Récupération des données du formulaire (name and description)
  // Utilisation de $_POST qui va récupérer la valeur du champ product-name ou product-description ici. On met le NAME de l'input et non l'ID ou la class
  // $_POST est une superglobale en PHP. Cela veut dire que c'est une variable spéciale qui permet de récupérer toutes les informations envoyées via le formulaire.
  $productName = $_POST['product-name'];
  $productDescription = $_POST['product-description'];

  if (!$con) {
    echo "Erreur de connexion à la base de données : " . mysqli_connect_error();;
  } else {
    if (!empty($productName) && !empty($productDescription)) {
      // Vérifie si le produit existe déjà dans la base de donnée 
      // La fonction mysqli_query exécute une requête SQL sur la base de données associée à la connexion $con.
      $req1 = mysqli_query($con, "SELECT name, description FROM product WHERE name='$productName' OR description='$productDescription'");

      // mysqli_num_row est un outil pour compter le nombre de résultats retournés par une requête de type SELECT ici, donc ici on vérifie simplement s'il y a des résultats avec > 0
      if (mysqli_num_rows($req1) > 0) {
        $message = '<p style="color:red">Le produit existe déjà</p>';
      } else {
        // Si une image a été téléchargée 
        if (!empty($_FILES["product-image"]["name"])) {
          // On récupère le nom de l'image
          $name = $_FILES['product-image']['name'];
          // Nous lui donnons un nom temporaire 
          $temporaryName = $_FILES['product-image']['tmp_name'];
          // On déplace l'image dans le dossier upload 
          $imageMoved = move_uploaded_file($temporaryName, "./upload/" . $name);

          // Si l'image a été déplacée 
          if ($imageMoved) {
            // On insère toutes les données du produit dans la base de données 
            $query = "INSERT INTO product (name, description, image) VALUES ('$productName', '$productDescription', '$name')";
            $result = mysqli_query($con, $query);

            // Si les données ont bien été envoyées à la base de donnée 
            if ($result) {
              $message = '<p style="color:green">Produit ajouté avec succès</p>';
              $productName = '';
              $productDescription = '';
            } else {
              $message = '<p style="color:red">Votre produit n\'a pas été ajouté</p>';
            }
          }
        } else {
          $message = '<p style="color:red">Veuillez rajouter une image</p>';
        }
      }
    }
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
    <!-- Utilisation de la méthode POST pour envoyer les données au serveur via le formulaire -->
    <form class="form-add-products" method="POST" enctype="multipart/form-data">
      <div class="message">
        <?php
        if (isset($message)) {
          echo $message;
        }
        ?>
      </div>
      <!-- NAME PRODUCT  -->
      <label for="product-name">Nom du produit</label>
      <input type="text" id="product-name" name="product-name" value="<?php echo ($productName ?? ''); ?>" required />
      <!-- DESCRIPTION PRODUCT  -->
      <label for="product-description">Description du produit</label>
      <textarea id="product-description" name="product-description" required><?php echo ($productDescription ?? ''); ?></textarea>
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