<?php
session_start();
?>

<?php
$serveur = "localhost"; // Remplacez par le nom de votre serveur
$utilisateur = "root"; // Remplacez par votre nom d'utilisateur
$mot_de_passe = ""; // Remplacez par votre mot de passe
$base_de_donnees = "projetphp";

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}


if (isset($_POST['deconnexion'])) {
    // Détruire toutes les données de session
    session_destroy();
    header("Location: connexion.php");
}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bronote</title>
</head>

<body>
    <div class="">
        <h2>Bronote </h2>
    </div>
    <main>

        <footer>
            <form method="post">
                <input type="submit" name="deconnexion" value="Déconnexion">
            </form>
        </footer>