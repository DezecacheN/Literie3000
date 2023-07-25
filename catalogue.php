<?php
include("templates/header.php")
?>

<section class="page">

<div class="container">
        <div class="movies flex-container">
            <?php
            foreach ($matelas as $matela) {

                // rappel : faire les images (plus tard)!
            ?>
                <div class="movie">

                    <div class="movie-details">
                        <h3>
                            <?= $matela["name"] ?>
                        </h3>
                            <?php

                            
                            foreach ($matelas_marques as $mm) {
                                if ($mm["matela_id"] == $matela["id"]) {
                                    foreach ($marques as $marque) {
                                        if ($marque["id"] == $mm["marque_id"]) {
                                            $newmarque = $marque["name"];
                                        }
                                    }

                                    ?>
                                    <p class="movie-genre"><?= $newmarque ?></p>
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
                                    <p class="movie-genre"><?= $newdimension ?></p>
                                    <?php
                                }
                            }







                            ?>
                    </div>
                </div>


                        <?php
                            if ($matela["reduction"] > 0) {
                                $priceDef = number_format($matela["price"] * ((100 - $matela["reduction"])/100),2);
                                ?>
                                <p>Pas <?= number_format($matela["price"], 2) ?>€ </p>
                                <p> <?= $priceDef ?>€ </p>
                                <?php
                            } else {
                                ?>
                                <p> <?= number_format($matela["price"], 2) ?>€ </p>
                                <?php
                            }
                        ?>
                        

            <?php
            }
            ?>
        </div>
    </div>

</section>

<?php
include("templates/footer.php")
?>