<?php
require 'header.php';

if (isset($_GET['id']) && $_GET['id'] != "" && $_SESSION != 'ELEVE') {
    $query = 'SELECT inscrit.Id_inscrit, inscrit.Nom, inscrit.Prenom, inscrit.Statut, Mdp, Identifiant, infoeleve.Classe, infoprof.Enseigne  
        FROM  inscrit 
        LEFT JOIN infoeleve ON inscrit.Id_inscrit = infoeleve.Id_eleve 
        LEFT JOIN infoprof ON inscrit.Id_inscrit = infoprof.Id_prof 
        WHERE Id_inscrit = ? ';

    $req = $bdd->prepare($query);
    $req->execute(array($_GET['id']));
    $infos = $req->fetch();

    // Variables
    $infos['Prenom'];
    $infos['Nom'];
    $infos['Mdp'];
    $infos['Identifiant'];

    $infos['Statut'];
    $infos['Classe'];
    $infos['Enseigne'];

    if (isset($_POST['boutton']) && $_POST['boutton'] == "Valider") {
        $Iquery = 'UPDATE inscrit SET Prenom = ?, Nom = ?, Mdp = ?, Identifiant = ? WHERE Id_inscrit = ?';
        $reqI = $bdd->prepare($Iquery);
        $reqI->execute(array($_POST['prenom'], $_POST['nom'], $_POST['MDP'], $_POST['identifiant'], $_GET['id']));

        if ($infos['Statut'] == "ELEVE") {
            $reqIE = $bdd->prepare('UPDATE infoeleve SET Classe = ? WHERE Id_eleve = ?');
            $reqIE->execute(array($_POST["Classe"], $_GET['id']));
        } elseif ($infos['Statut'] == "PROF") {
            $reqIP = $bdd->prepare('UPDATE infoprof SET Enseigne = ? WHERE Id_prof = ?');
            $reqIP->execute(array($_POST["Matière"], $_GET['id']));
        }

        echo "Information modifier";
    }
} else {
    header('Location:index.php');
    die;
}
?>
<form action="Tbord.php">
    <button>retour</button>
</form>

<h2>Modification des données de
    <?= $infos['Prenom'] . " " . $infos['Nom'] ?>
</h2>
<form action="Modif_profil.php?id=<?= $_GET['id'] ?>" method="POST">
    <label for="prenom">Prenom</label><br>
    <input id="prenom" type="text" name="prenom" value="<?= $infos['Prenom'] ?>"><br>

    <label for="nom">Nom</label><br>
    <input id="nom" type="text" name="nom" value="<?= $infos['Nom']; ?>"><br>

    <label for="identifiant">Son identifiant</label><br>
    <input id="identifiant" type="text" name="identifiant" value="<?= $infos['Identifiant']; ?>"><br>

    <label for="mdp">Son mot de passe</label><br>
    <input id="mdp" type="text" name="MDP" value="<?= $infos['Mdp'] ?>"><br>

    <?php if ($infos['Statut'] == 'ELEVE') { ?>
        <label for="select">Sa classe:</label><br>
        <select name="Classe" id="select">
            <option value="<?= $infos['Classe'] ?>">
                <?= $infos['Classe'] ?>
            </option>
            <option value="6a">6a</option>
            <option value="6b">6b</option>
            <option value="6c">6c</option>
            <option value="5a">5a</option>
            <option value="5b">5b</option>
            <option value="5c">5c</option>
            <option value="4a">4a</option>
            <option value="4b">4b</option>
            <option value="4c">4c</option>
            <option value="3a">3a</option>
            <option value="3b">3b</option>
            <option value="3c">3c</option>
        </select><br>
    <?php } ?>
    <br>
    <?php
    ?>
    <?php
    if ($infos['Statut'] == 'PROF') { ?>
        <label for="select">Sa matière:</label>
        <br>
        <select name="Matière" id="select">
            <option value="<?= $infos['Enseigne'] ?>">
                <?= $infos['Enseigne'] ?>
            </option>
            <option value="Anglais">Anglais</option>
            <option value="Mathématiques">Mathématiques</option>
            <option value="Français">Français</option>
            <option value="SVT">SVT</option>
            <option value="Sport">Sport</option>
            <option value="Physique-Chimie">Physique-Chimie</option>
            <option value="Histoire-géographie">Histoire-géographie</option>
        </select>
        <br>

        <?php
    }
    ?>
    <input name="boutton" type="submit" value="Valider">

    <?php

    ?>
</form>