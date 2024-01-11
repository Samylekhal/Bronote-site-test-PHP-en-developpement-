<?php
require 'header.php';

$mdpCheck = "";
$idCheck = "";

$idquery = $bdd->query('SELECT Identifiant FROM inscrit');
$listes = $idquery->fetchAll();

$KEYquery = $bdd->prepare('SELECT * FROM cles');
$KEYquery->execute();
$cles = $KEYquery->fetchAll();

$keycheck = "";




?>

<script>
    function toggleFields() {
        var statut = document.getElementById('statut').value;
        var eleveFields = document.getElementById('eleveFields');
        var profFields = document.getElementById('profFields');
        var adminFields = document.getElementById('adminFields');

        if (statut === 'ELEVE') {
            eleveFields.style.display = 'block';
            profFields.style.display = 'none';
            adminFields.style.display = 'none';
        } else if (statut === 'PROF') {
            eleveFields.style.display = 'none';
            profFields.style.display = 'block';
            adminFields.style.display = 'none';
        } else if (statut === 'ADMIN') {
            eleveFields.style.display = 'none';
            profFields.style.display = 'none';
            adminFields.style.display = 'block';
        } else {
            eleveFields.style.display = 'none';
            profFields.style.display = 'none';
            adminFields.style.display = 'none';
        }
    }
</script>

<form action="" method="post">

    <div>
        <label for='nom'>Nom</label><br>
        <input id='nom' type="text" name=nom required>
    </div>
    <div>
        <label for='prenom'>Prénom</label><br>
        <input id='prenom' name="Prenom" type="text" required>
    </div>
    <div>
        <label for='id'>Identifiant</label><br>
        <input id='id' name="id" type="text" required>
        <?php
        if (isset($_POST['boutton'])) {
            $idCheck = false;
            foreach ($listes as $liste) {
                if ($liste['Identifiant'] != $_POST['id']) {
                    $idCheck = true;
                    break; // Ajoutez un break pour sortir de la boucle une fois que la correspondance est trouvée
                }
            }
            if ($idCheck == false) {
                echo "Cet identifiant est déjà pris, veuillez en choisir un autre. ";
            }
        }
        ?>
    </div>
    <div>
        <label for='MDP'>Mot de passe</label><br>
        <input id='MDP' name="MDP" type="text" required>
    </div>
    <div>
        <label for='CMDP'>Confirmer votre mot de passe</label><br>
        <input id='CMDP' name="CMDP" type="password" required>
        <?php
        if (isset($_POST["boutton"])) {

            if ($_POST["MDP"] == $_POST['CMDP']) {
                $mdpCheck = true;

            } else {
                $mdpCheck = false;
                echo "Les mots de passe ne sont pas identiques !";
            }

        }
        ?>
    </div>
    <div>
        Êtes-vous :<br>
        <select name="statut" id="statut" onchange="toggleFields()">
            <option value=""></option>
            <option value="ELEVE">Un élève</option>
            <option value="PROF">Un professeur</option>
            <option value="ADMIN">Un admin</option>
        </select>
    </div>
    <div id="eleveFields" style="display: none;">
        <label for="select">Sa classe:</label><br>
        <select name="Classe">
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
        <label for="cle">Entrez une clé de connexion</label><br>
        <input id='cle' name="cleE" type="text">
    </div>
    <div id="profFields" style="display: none;">
        <label for="select">Sa matière:</label><br>
        <select name="Matière">
            <option value="Anglais">Anglais</option>
            <option value="Mathématiques">Mathématiques</option>
            <option value="Français">Français</option>
            <option value="SVT">SVT</option>
            <option value="Sport">Sport</option>
            <option value="Physique-Chimie">Physique-Chimie</option>
            <option value="Histoire-géographie">Histoire-géographie</option>
        </select><br>
        <label for="cle">Entrez une clé de connexion</label><br>
        <input id='cle' name="cleP" type="text">
    </div>
    <div id="adminFields" style="display: none;">
        <label for="cle">Entrez une clé de connexion</label><br>
        <input id='cle' name="cleA" type="text">
        <?php

        if (isset($_POST["boutton"])) {
            $keycheck = false;
            echo "Formulaire soumis<br>";
            foreach ($cles as $cle) {
                if ($cle['Clé'] == $_POST['cleA'] || $cle['Clé'] == $_POST['cleE'] || $cle['Clé'] == $_POST['cleP'] && $cle['Type'] == $_POST['statut']) {
                    $keycheck = true;
                }
            }
            if ($keycheck != true) {
            }
        }
        ?>
    </div>
    <br>
    <input type="submit" name="boutton" value="Valider">
</form>


<?php
if (isset($_POST["boutton"])) {
    if ($mdpCheck == true && $idCheck == true && $keycheck == true) {

        $InsIquery = $bdd->prepare('INSERT INTO inscrit(Nom, Prenom, Statut,Mdp ,Identifiant) VALUES (? , ? , ?  , ? , ?)');
        $InsIquery->execute(array($_POST['nom'], $_POST['Prenom'], $_POST['statut'], $_POST['CMDP'], $_POST['id']));


        $SelectID = $bdd->prepare('SELECT Id_inscrit FROM inscrit WHERE identifiant = ?');
        $SelectID->execute(array($_POST['id']));
        $Ident = $SelectID->fetch();

        switch ($_POST['statut']) {
            case 'ELEVE':
                $InsEquery = $bdd->prepare('INSERT INTO infoeleve(Id_eleve,Classe) VALUES (?,?)');
                $InsEquery->execute(array($Ident['Id_inscrit'], $_POST["Classe"]));
                $delete = $bdd->prepare('DELETE FROM cles WHERE Clé = ?');
                $delete->execute(array($_POST['cleE']));
                break;
            case 'PROF':
                $InsEquery = $bdd->prepare('INSERT INTO infoprof(Id_prof,Enseigne) VALUES (?,?)');
                $InsEquery->execute(array($Ident['Id_inscrit'], $_POST["Matière"]));
                $delete = $bdd->prepare('DELETE FROM cles WHERE Clé = ?');
                $delete->execute(array($_POST['cleP']));
            case 'ADMIN':
                $delete = $bdd->prepare('DELETE FROM cles WHERE Clé = ?');
                $delete->execute(array($_POST['cleA']));
                break;
            default:
                break;
        }
        echo "Conditions satisfaites pour l'insertion dans la base de données<br>";


    } elseif ($mdpCheck == false || $idCheck == false || $keycheck == false) {
        echo "Conditions non satisfaites pour l'insertion dans la base de données<br>";
    }
}



?>

</body>