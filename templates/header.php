<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Literie 3000</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/main.css" />
</head>

<body>
    <header>
        <img src="logo/logo.png" />
        <nav>
            <ul>
                <a href="./index.php" class="nav-link">Accueil</a>
                <a href="./catalogue.php" class="nav-link">Voir Catalogue</a>
            </ul>
        </nav>

    </header>





<!-- récupération bases de données -->
<?php

$dsn = "mysql:host=localhost;dbname=literie3000";
$db = new PDO($dsn, "root", "");


// récupérer les recettes de la table matelas
$query = $db->query("select * from matelas");
$matelas = $query->fetchAll(PDO::FETCH_ASSOC);
// récupérer les recettes de la table marques
$query = $db->query("select * from marques");
$marques = $query->fetchAll(PDO::FETCH_ASSOC);
// récupérer les recettes de la table matelas_marques
$query = $db->query("select * from matelas_marques");
$matelas_marques = $query->fetchAll(PDO::FETCH_ASSOC);
// récupérer les recettes de la table dimensions
$query = $db->query("select * from dimensions");
$dimensions = $query->fetchAll(PDO::FETCH_ASSOC);
// récupérer les recettes de la table matelas_dimensions
$query = $db->query("select * from matelas_dimensions");
$matelas_dimensions = $query->fetchAll(PDO::FETCH_ASSOC);
