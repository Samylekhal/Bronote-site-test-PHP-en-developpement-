<?php
require 'header.php';

if ($_SESSION['Statut'] != 'ADMIN') {
    header('location:Tbord.php');
}


if (isset($_POST['Suite'])) {
    $nom = $_POST['Nom'];
    $prenom = $_POST['prenom'];
    $statut = $_POST['Statut'];
    $mdp = $_POST['MDP'];
    $identifiant = $_POST['ident'];
    $classe = '';
    $matiere = '';

} else {
    $nom = "";
    $prenom = "";
    $statut = "";
    $mdp = "";
    $identifiant = "";
    $classe = '';
    $matiere = '';
}

if (isset($_POST['Confirmer'])) {
    $nom = $_POST['Nom'];
    $prenom = $_POST['prenom'];
    $statut = $_POST['Statut'];
    $mdp = $_POST['MDP'];
    $identifiant = $_POST['ident'];

    $classe = isset($_POST['classe']) ? $_POST['classe'] : "";
    $matiere = isset($_POST['matière']) ? $_POST['matière'] : "";

    $insert = 'INSERT INTO inscrit(Nom, Prenom,Statut,Mdp,Identifiant) VALUES (:nom, :prenom, :statut, :mdp, :identifiant)';
    $INS = $bdd->prepare($insert);
    $INS->execute(array(':nom' => $nom, ':prenom' => $prenom, ':statut' => $statut, ':mdp' => $mdp, ':identifiant' => $identifiant));


    $selID = $bdd->prepare('SELECT Id_inscrit FROM inscrit WHERE Nom = ? AND Prenom = ? AND Statut = ? AND Mdp = ? AND Identifiant = ?');
    $selID->execute(array($nom, $prenom, $statut, $mdp, $identifiant));

    $IDinfo = $selID->fetch();

    if ($statut == 'ELEVE') {
        $insE = $bdd->prepare('INSERT INTO infoeleve(Id_eleve,Classe) VALUES (?,?)');
        $insE->execute(array($IDinfo['Id_inscrit'], $classe));
    } elseif ($statut == 'PROF') {
        $insP = $bdd->prepare('INSERT INTO infoprof(Id_prof,Enseigne) VALUES (?,?)');
        $insP->execute(array($IDinfo['Id_inscrit'], $matiere));
    }
}
?>

<form action=Tbord.php>
    <input type="submit" value="retour" name="retour">
</form>
<br>
<br>
<form action="Crea_profil.php" method=POST>

    <label for="nom">Nom</label>
    <br>
    <input type="text" id=nom name=Nom require value=<?= $nom ?>>
    <br>


    <label for="Prenom">Prenom</label>
    <br>
    <input type="text" id=prenom name=prenom require value=<?= $prenom ?>>
    <br>


    <label for="ident">Son identifiant</label>
    <br>
    <input type="text" id=ident name=ident require value=<?= $identifiant ?>>
    <br>

    <label for="mdp">Son mot de passe</label>
    <br>
    <input type="text" id=mdp name=MDP require value=<?= $mdp ?>>
    <br>

    <label for="">Quel est son statut ?:</label>
    <br>
    <select name="Statut">
        <option value=<?= $statut ?>><?= $statut ?></option>
        <option value="ELEVE">élève</option>
        <option value="PROF">professeur</option>
        <option value="ADMIN">Admin</option>
    </select>
    <br>
    <input type="submit" name="Suite" value="suite">
    <br>
    <?php
    switch ($statut) {
        case 'ELEVE':
            echo "<br>" . '<label for="classe">Sa classe:</label>' . " ";
            echo '<select name="classe">';
            echo '<option value="6a">6a</option>';
            echo '<option value="6b">6b</option>';
            echo '<option value="6c">6c</option>';
            echo '<option value="5a">5a</option>';
            echo '<option value="5b">5b</option>';
            echo '<option value="5c">5c</option>';
            echo '<option value="4a">4a</option>';
            echo '<option value="4b">4b</option>';
            echo '<option value="4c">4c</option>';
            echo '<option value="3a">3a</option>';
            echo '<option value="3b">3b</option>';
            echo '<option value="3c">3c</option>';
            echo '</select>';

            echo "<br>" . "<input type='submit' name='Confirmer' value='Confirmer'>";
            break;
        case 'PROF':
            echo "<br>" . "Sa matière d'ensignement:" . "<br> ";
            echo '<select name="matière" >';
            echo '<option value=' . $matiere . '></option>';
            echo '<option value="Anglais">Anglais</option>';
            echo '<option value="Mathématiques">Mathématiques</option>';
            echo '<option value="Français">Français</option>';
            echo '<option value="SVT">SVT</option>';
            echo '<option value="Sport">Sport</option>';
            echo '<option value="Physique-Chimie">Physique-Chimie</option>';
            echo '<option value="Histoire-géographie">Histoire-géographie</option>';
            echo '</select>';

            echo "<br>" . "<input type='submit' name='Confirmer' value='Confirmer'>";
            break;
        case 'ADMIN':
            echo "<br>" . "<input type='submit' name='Confirmer' value='Confirmer'>";
            break;
        default:
            break;
    }

    ?>
</form>