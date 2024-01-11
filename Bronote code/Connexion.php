<?php
require 'header.php';



$message = [
    'type' => "warning",
    'contenu' => ""
];




if (isset($_POST['ID']) && isset($_POST['MDP'])) {
    $users = $bdd->prepare("SELECT * FROM inscrit WHERE Identifiant=? AND Mdp=?");
    $users->execute([$_POST['ID'], $_POST['MDP']]);

    $user = $users->fetch();

    if ($user) {
        $_SESSION["Id_inscrit"] = $user["Id_inscrit"];
        $_SESSION["Nom"] = $user["Nom"];
        $_SESSION["Prenom"] = $user["Prenom"];
        $_SESSION["Statut"] = $user["Statut"];
        $_SESSION["Mdp"] = $user["Mdp"];
        $_SESSION["Identifiant"] = $user["Identifiant"];
        header('Location:Tbord.php');
    } else {
        $message = [
            'type' => "warning",
            'contenu' => "Erreur! Veuillez verifier votre identifiant et ou mot de passe"
        ];

    }

}



?>

<div class="form">
    <h1>Connexion</h1>
    <?php
    if ($message['contenu'] !== "") {
        ?>
        <div role="alert">
            <?= $message['contenu'] ?>
        </div>
        <?php
    }
    ?>
    <form method="post">
        <div>
            <label for='id'>Identifiant</label>
            <br>
            <input id='id' type="text" name="ID" required>
        </div>
        <div>
            <label for='MDP'>Mot de passe</label>
            <br>
            <input id='MDP' type="password" name="MDP" required>
        </div>
        <br>
        <input type="submit" value="Connexion">
    </form>
    <br>
    <div>
        <a href="Inscription.php">Vous n'avez pas de compte ? Inscrivez-vous !</a>
    </div>
</div>



</main>
</body>