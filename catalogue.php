<?php
include("templates/header.php")
?>

<section class="page">


            <?php
            foreach ($matelas as $matela) {

            ?>

                    <!-- <div class="flex-container"> -->
                    <div class="encart">
                        
                    
                    
                        <div class="matelas-image">
                            <img class="catalogueIMG" src="./img/matelas/<?= $matela["picture"] ?>" alt="">
                        </div>

                    
                        <div class="matelasDetails">
                        <h1 class="titre">
                            <?= $matela["name"] ?>
                        </h1>
                            <?php

                            
                            foreach ($matelas_marques as $mm) {
                                if ($mm["matela_id"] == $matela["id"]) {
                                    foreach ($marques as $marque) {
                                        if ($marque["id"] == $mm["marque_id"]) {
                                            $newmarque = $marque["name"];
                                        }
                                    }

                                    ?>
                                    <h2><?= $newmarque ?></h2>
                                    <?php
                                }
                            }

                            foreach ($matelas_dimensions as $md) {
                                if ($md["matela_id"] == $matela["id"]) {
                                    foreach ($dimensions as $dimension) {
                                        if ($dimension["id"] == $md["dimension_id"]) {
                                            $newdimension = $dimension["dimension"];
                                        }
                                    }

                                    ?>
                                    <p><?= $newdimension ?></p>
                                    <?php
                                }
                            }







                            ?>


                            <div class="prix">
                        <?php
                            if ($matela["reduction"] > 0) {
                                $priceDef = number_format($matela["price"] * ((100 - $matela["reduction"])/100),2);
                                ?>
                                <p class="no"><?= number_format($matela["price"], 2) ?>€ </p>
                                <p class="yes"> <?= $priceDef ?>€ </p>
                                <?php
                            } else {
                                ?>
                                <p class="yes"> <?= number_format($matela["price"], 2) ?>€ </p>
                                <?php
                            }
                        ?>
                    </div>


                    </div>

                </div>
            <?php
            }
            ?>




</section>

<?php
include("templates/footer.php")
?>