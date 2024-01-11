<?php
require 'header.php';


if (isset($_GET['id']) && $_GET['id'] != "") {
    if ($_SESSION['Statut'] == 'ELEVE' && $_SESSION['Id_inscrit'] != $_GET['id']) {
        header('location:Tbord.php');
    }

    $query = 'SELECT inscrit.Id_inscrit,inscrit.Nom,inscrit.Prenom,inscrit.Statut, infoeleve.Classe,infoprof.Enseigne  
    FROM  inscrit 
    LEFT JOIN infoeleve ON inscrit.Id_inscrit = infoeleve.Id_eleve 
    LEFT JOIN infoprof ON inscrit.Id_inscrit = infoprof.Id_prof 
    WHERE Id_inscrit = ? ';

    $req = $bdd->prepare($query);
    $req->execute(array($_GET['id']));

    $info = $req->fetch();


    $reqELE = $bdd->prepare('SELECT Statut FROM inscrit WHERE Id_inscrit= ?');
    $reqELE->execute(array($_GET['id']));

    $Rele = $reqELE->fetch();

} else {
    header("Location:Tbord.php");
    die;
}
?>


<form action=Tbord.php>
    <input type="submit" value="retour" name="retour">
</form>


<div>
    <h3>Nom:
        <?= $info["Nom"] ?>
    </h3>
    <h3>Prenom:
        <?= $info["Prenom"] ?>
    </h3>
    <h3>Statut:
        <?= $info["Statut"] ?>
    </h3>
    <?php
    switch ($info["Statut"]) {
        case 'ELEVE':
            echo '<h3>Classe: ' . $info["Classe"] . '</h3>';
            break;
        case 'PROF':
            echo "<h3>Matière d'enseignement: </h3>";

            echo " -  " . $info["Enseigne"] . "<br>";


            break;
        default:
            break;
    }
    ?>
</div>
<br>
<div>
    <?php
    if ($Rele['Statut'] == 'ELEVE') { ?>
        <a href='Notes.php?id=<?= $_GET['id'] ?>'>Notes</a>
        <?php
    }

    ?>


</div>
<div>
    <?php
    if ($_SESSION['Statut'] == 'ADMIN') {
        ?>
        <a href="Modif_profil.php?id=<?= $_GET['id'] ?>">Modifier</a>
        <form action='Profil.php?id=<?= $_GET['id'] ?>' method='POST'>
            <input type="hidden" name="supprimer" value="true">
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
        <?php

        if (isset($_POST['supprimer']) && $_POST['supprimer'] === 'true') {


            $DIquery = $bdd->prepare('DELETE FROM inscrit WHERE Id_inscrit = ?');
            $DEquery = $bdd->prepare('DELETE FROM infoeleve WHERE Id_eleve = ?');
            $DPquery = $bdd->prepare('DELETE FROM infoprof WHERE Id_prof = ?');

            $id = $_GET['id'];
            if ($info['Statut'] === 'ELEVE') {
                $DIquery->execute(array($id));
                $DEquery->execute(array($id));
                header('Location: recherche.php');
                exit();
            } elseif ($info['Statut'] === 'PROF') {
                $DPquery->execute(array($id));
                $DIquery->execute(array($id));

                header('Location: recherche.php');
                exit();

            } elseif ($info['Statut'] === 'ADMIN' && $id == $_SESSION['Id_inscrit']) {

                echo " vous ne pouvez pas supprimer votre propre compte";
            } elseif ($info['Statut'] === 'ADMIN') {
                $DIquery->execute(array($id));
                header('Location: recherche.php');

            }

        }
    }

    ?>


</div>