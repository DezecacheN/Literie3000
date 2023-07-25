<?php
include("templates/header.php");


// --------------------------------------------------------------------------------------------

if (!empty($_POST)) {
    $name = trim(strip_tags($_POST["name"]));
    $marque = trim(strip_tags($_POST["marque"]));
    $dimension = trim(strip_tags($_POST["dimension"]));
    $price = trim(strip_tags($_POST["price"]));
    $reduction = trim(strip_tags($_POST["reduction"]));




    $errors = [];

    if (empty($name)) {
        $errors["name"] = "Le nom du matelas est obligatoire";
    }

    if (empty($price)) {
        $errors["price"] = "Veuillez renseigner un prix";
    }




// --------------------------------------------------------------------------------------------
// Gestion de l'image
    if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES["picture"]["tmp_name"];
        $fileName = $_FILES["picture"]["name"];
        $fileType = $_FILES["picture"]["type"];

        $fileNameArray = explode(".", $fileName);
        $fileExtension = end($fileNameArray);
        $newFileName = md5($fileName . time()) . "." . $fileExtension;

        $fileDestPath = "./img/matelas/{$newFileName}";

        $allowedTypes = array("image/jpeg", "image/png", "image/webp");
        if (in_array($fileType, $allowedTypes)) {
            move_uploaded_file($fileTmpPath, $fileDestPath);
        } else {
            $errors["picture"] = "Le type de fichier est incorrect (.jpg, .png ou .webp requis)";
        }
    }


// --------------------------------------------------------------------------------------------
// Envoi du formulaire

    if (empty($errors)) {



        $query = $db->prepare("INSERT INTO matelas (name, price, reduction, picture) VALUES (:name, :price, :reduction, :picture)");
        $query->bindParam(":name", $name);
        $query->bindParam(":price", $price);
        $query->bindParam(":reduction", $reduction);
        $query->bindParam(":picture", $newFileName);



        $id = 0;
        if ($query->execute()) {

            foreach ($matelas as $matela) {
                if ($matela["id"] > $id) {
                    $id = $matela["id"];
                }
            }
            $id += 1;





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


// --------------------------------------------------------------------------------------------
// La page :

?>
<h1 class="titre">Ajouter un matelas</h1>


<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="inputName">Nom du matelas* :</label>
        <input type="text" id="inputName" name="name" value="<?= isset($name) ? $name : "" ?>">
        <?php
        if (isset($errors["name"])) {
        ?>
            <span class="info-error"><?= $errors["name"] ?></span>
        <?php
        }
        ?>
    </div>

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
        <label for="inputPicture">Photo :</label>
        <input type="file" id="inputPicture" name="picture">
        <?php
        if (isset($errors["picture"])) {
        ?>
            <span class="info-error"><?= $errors["picture"] ?></span>
        <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label for="inputPrice">Prix* :</label>
        <input type="number" name="price" id="inputPrice" value="<?= isset($price) ? $price : 0 ?>">
        <?php
        if (isset($errors["price"])) {
        ?>
            <span class="info-error"><?= $errors["price"] ?></span>
        <?php
        }
        ?>
    </div>


    <div class="form-group">
        <label for="inputReduction">Réduction (en pourcentage) :</label>
        <input type="number" name="reduction" id="inputReduction" value="<?= isset($reduction) ? $reduction : 0 ?>">
    </div>


        <p class="legende">* Champs Obligatoires</p>
    <input type="submit" value="Ajouter le matelas" class="btn">
</form>
</div>

<?php
include("templates/footer.php");
?>