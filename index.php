<?php
include("templates/header.php");


if (!empty($_POST)) {
    $name = trim(strip_tags($_POST["name"]));


    $errors = [];

    // Valider que le champ name est bien renseigné
    if (empty($name)) {
        $errors["name"] = "Le nom du matelas est obligatoire";
    }

    
    if (empty($errors)) {



        $query = $db->prepare("DELETE FROM matelas WHERE name = :name");
        $query->bindParam(":name", $name);

        if ($query->execute()) {
            header("Location: index.php");
        }
    }
}


?>




<section class="homeSection1 background" id="voir">

<div>
    <div class="homeBTN">
        <h2>
            <a href="catalogue.php"> Voir notre catalogue </a>
        </h2>
    </div>
</div>

</section>




<section class="homeSection2">
    <h1 class="titre">Gérer le catalogue :</h1>

<section class="homeSection2Display">

    <div class="homeBTN">
        <h2>
            <a href="add_catalogue.php"> Ajouter au catalogue </a>
        </h2>
    </div>

    <div class="homeBTN">
            
            <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="inputName">Supprimer du catalogue :</label>
                <input type="text" id="inputName" name="name" value="<?= isset($name) ? $name : "" ?>">
                <?php
                if (isset($errors["name"])) {
                ?>
                    <span class="info-error"><?= $errors["name"] ?></span>
                <?php
                }
                ?>
            </div>

            <input type="submit" value="Supprimer le matelas" >

            </form>

</section>


<?php
include("templates/footer.php")
?>