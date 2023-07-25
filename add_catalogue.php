<?php
include("templates/header.php");



if (!empty($_POST)) {
    // Le formulaire est envoyé !
    // Uilisation de la fonction strip_tags pour supprimer d'éventuelles balises HTML qui ce seraient glissées dans le champ input et palier à la faille XSS
    // Utilisation de la fonction trim pour supprimer d'éventuels espaces en début et fin de chaine
    $name = trim(strip_tags($_POST["name"]));
    $marque = trim(strip_tags($_POST["marque"]));
    $dimension = trim(strip_tags($_POST["dimension"]));
    $price = trim(strip_tags($_POST["price"]));
    $reduction = trim(strip_tags($_POST["reduction"]));

    $errors = [];

    // Valider que le champ name est bien renseigné
    if (empty($name)) {
        $errors["name"] = "Le nom du matelas est obligatoire";
    }

    // Gestion de l'upload de la photo de notre recette
    if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] === UPLOAD_ERR_OK) {
        // Le fichier avec l'attribut name qui vaut picture existe et il n'y a pas eu d'erreur pendant l'upload
        $fileTmpPath = $_FILES["picture"]["tmp_name"];
        $fileName = $_FILES["picture"]["name"];
        $fileType = $_FILES["picture"]["type"];

        // On génère un nouveau nom de fichier pour ne pas se préoccuper des espaces, caractères accentués mais aussi si des personnes upload plusieurs images ayant le même nom
        $fileNameArray = explode(".", $fileName);
        // La fonction end est très pratique pour récupérer le dernier élément d'un tableau
        $fileExtension = end($fileNameArray);
        // L'ajout de time() permet d'être sur d'avoir un hash unique
        // La fonction md5 permet de générer un hash à partir d'une chaine donnée
        $newFileName = md5($fileName . time()) . "." . $fileExtension;

        // Attention à vérifier que le dossier de destination est bien créé au préalable
        $fileDestPath = "./img/recipes/{$newFileName}";

        $allowedTypes = array("image/jpeg", "image/png", "image/webp");
        if (in_array($fileType, $allowedTypes)) {
            // Le type de fichier est bien valide on peut donc ajouter le fichier à notre serveur
            move_uploaded_file($fileTmpPath, $fileDestPath);
        } else {
            // Le type de fichier est incorrect
            $errors["picture"] = "Le type de fichier est incorrect (.jpg, .png ou .webp requis)";
        }
    }

    if (empty($errors)) {



        $query = $db->prepare("INSERT INTO matelas (name, price, reduction) VALUES (:name, :price, :reduction)");
        $query->bindParam(":name", $name);
        $query->bindParam(":price", $price);
        $query->bindParam(":reduction", $reduction);


        $id = 0;
        if ($query->execute()) {

            foreach ($matelas as $matela) {
                if ($matela["id"] > $id) {
                    $id = $matela["id"];
                }
            }
            $id += 1;
            echo $id;

            echo $marque;




            $query2 = $db->prepare("INSERT INTO matelas_marques (matela_id, marque_id) VALUES (:matela_id, :marque_id)");
            $query2->bindParam(":matela_id", $id);
            $query2->bindParam(":marque_id", $marque);
        }

        if ($query2->execute()) {

            $query3 = $db->prepare("INSERT INTO matelas_dimensions (matela_id, dimension_id) VALUES (:matela_id, :dimension_id)");
            $query3->bindParam(":matela_id", $id);
            $query3->bindParam(":dimension_id", $dimension);        }

        if ($query3->execute()) {
            header("Location: index.php");
        }
    }
}

?>
<h1>Ajouter un matelas</h1>
<!-- Lorsque l'attribut action est vide les données du formulaire sont envoyées à la même page -->
<form action="" method="post" enctype="multipart/form-data">
    
<div class="form-group">
        <label for="inputName">Nom du matelas :</label>
        <input type="text" id="inputName" name="name" value="<?= isset($name) ? $name : "" ?>">
        <?php
        if (isset($errors["name"])) {
        ?>
            <span class="info-error"><?= $errors["name"] ?></span>
        <?php
        }
        ?>
    </div>

<!-- !!!!!!!!!!!!!!!!!!! -->
<!-- faire la photo, voir dans le marmitton -->



    <div class="form-group">
        <label for="selectMarque">Marque :</label>
        <select name="marque" id="selectMarque">
            <?php
                foreach ($marques as $marque) {
                    ?>
                        <option value="<?= $marque["id"] ?>" <?= isset($marque) && $marque === "" ? "selected" : "" ?>> <?= $marque["name"] ?></option>
                    <?php
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="selectDimension">Dimensions :</label>
        <select name="dimension" id="selectDimension">
            <?php
                foreach ($dimensions as $dimension) {
                    ?>
                        <option value="<?= $dimension["id"] ?>" <?= isset($dimension) && $dimension === "" ? "selected" : "" ?>> <?= $dimension["dimension"] ?></option>
                    <?php
                }
            ?>
        </select>
    </div>


    <div class="form-group">
        <label for="inputPrice">Prix :</label>
        <input type="number" name="price" id="inputPrice" value="<?= isset($price) ? $price : 0 ?>">
    </div>


    <div class="form-group">
        <label for="inputReduction">Réduction (en pourcentage) :</label>
        <input type="number" name="reduction" id="inputReduction" value="<?= isset($reduction) ? $reduction : 0 ?>">
    </div>



    <input type="submit" value="Ajouter le matelas" class="btn-marmiton">
</form>

<?php
include("templates/footer.php");
?>