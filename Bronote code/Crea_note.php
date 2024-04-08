<?php
require 'header.php';

if ($_SESSION['Statut'] == 'ELEVE') {
    header('location:Tbord.php');
}


if ($_SESSION['Statut'] == 'PROF') {
    $query = $bdd->prepare('SELECT Enseigne FROM infoprof WHERE Id_prof = ?');
    $query->execute(array($_SESSION["Id_inscrit"]));

    $matiere = $query->fetch();
}


?>

<form action=Tbord.php>
    <input type="submit" value="retour" name="retour">
</form>
<br>
<form action="Crea_note.php" method='POST'>

    <label for="matière">Matière</label>
    <br>
    <?php

    if ($_SESSION['Statut'] == 'PROF') {
        ?>
        <select name="matière" id="matière">
            <option value="<?= $matiere['Enseigne'] ?>">
                <?= $matiere['Enseigne'] ?>
            </option>
        </select>


        <?php
    } elseif ($_SESSION['Statut'] == 'ADMIN') {
        ?>
        <select name="matière" id="matière">
            <option value=""></option>
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
    <br>

    <label for="intitule">Intitule</label>
    <br>
    <input id="intitule" name='intitule' type="text">
    <br>

    <label for="note">Note max</label>
    <br>
    <input id="note" name='note' type="text" require>
    <br>

    <label for="coeff">Coefficient</label>
    <br>
    <input id="coeff" type="text" name='coeff' require placeholder="ex: 0.5">
    <br>

    <label for="classe">Classe</label>
    <br>
    <select name="classe" id="classe">
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
    </select>
    <br>

    <input type="submit" name='valider' value="valider">
</form>

<?php
if (isset($_POST['valider'])) {


    $qI = $bdd->prepare('INSERT INTO note(Matiere,Intitule,note,Coeff,Classe) VALUES (?,?,?,?,?)');
    $qI->execute(array($_POST['matière'], $_POST['intitule'], $_POST['note'], $_POST['coeff'], $_POST['classe']));



}

?>