<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./style.css" />
  <title>Listing Produits</title>
</head>

<body>
  <div class="container-products">

    <a href="./index.php">Ajouter un produit</a>
    <h2>LISTE DES PRODUITS</h2>

    <!-- Liste des produits  -->
    <ul class="products-list">
      <?php
      // Connexion à la base de donnée 
      $con = mysqli_connect("db", "root", "example", "products_db");

      if (!$con) {
        echo '<div>Pas de connexion à la base de données</div>';
      } else {
        // Récupération des données de la bases de données
        $req3 = mysqli_query($con, "SELECT * FROM product");

        // Si aucune ligne n'a été retournée par la requête SQL.
        if (mysqli_num_rows($req3) == 0) {
          echo '<div>Aucun produits trouvés ...</div>';
          // Si une ligne a été retrouvée dans la base de données 
        } else {
          // La fonction mysqli_fetch_assoc($req3) extrait une ligne de la table product sous forme de tableau
          // Chaque colonne de la table devient une clé dans ce tableau, et les valeurs correspondantes dans la base de données deviennent les valeurs associées.
          // while => tant que 
          while ($row = mysqli_fetch_assoc($req3)) {
            echo '<li class="product">
                   <div class="img-list-product">
                     <img src="upload/' . $row['image'] . '" alt="" />
                   </div>
                   <div class="text">
                     <p class="name-list-products">' . $row['name'] . '</p>
                     <p class="description-list-products">' . $row['description'] . '</p>
                   </div>
                  </li>';
          }
        }
      }
      ?>
    </ul>
  </div>
</body>

</html>