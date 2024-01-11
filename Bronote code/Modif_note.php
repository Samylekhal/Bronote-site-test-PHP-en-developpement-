<?php

require 'header.php';

if (isset($_GET['id']) && $_SESSION != 'ELEVE') {
    $query = 'SELECT * FROM note WHERE Id_note = ? ';
    $req = $bdd->prepare($query);
    $req->execute(array($_GET['id']));


    $infos = $req->fetch();



} else {
    header('Location:Liste_note.php');
    die;
}

?>
<form action=Tbord.php>
    <input type="submit" value="retour" name="retour">
</form>

<form action="Modif_note.php?id=<?= $_GET['id'] ?>" method="post">

    <label for="matière">Matière</label>
    <br>
    <?php

    if ($_SESSION['Statut'] == 'PROF') {
        ?>
        <select name="matière" id="matière">
            <option value="<?= $infos['Matiere'] ?>">
                <?= $infos['Matiere'] ?>
            </option>
        </select>


        <?php
    } elseif ($_SESSION['Statut'] == 'ADMIN') {
        ?>
        <select name="matière" id="matière">
            <option value="<?= $infos['Matiere'] ?>">
                <?= $infos['Matiere'] ?>
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
    <br>

    <label for="intitule">Intitule</label>
    <br>
    <input id="intitule" type="text" name="intitule" value="<?= $infos['Intitule'] ?>">
    <br>

    <label for="note">Note max</label>
    <br>
    <input id="note" type="text" name="note" value="<?= $infos['note'] ?>">
    <br>

    <label for="coeff">Coeff</label>
    <br>
    <input id="coeff" type="text" name="coeff" value="<?= $infos['Coeff'] ?>">
    <br>

    <label for="classe">Classe</label>
    <br>
    <input id="classe" type="text" name="classe" value="<?= $infos['Classe'] ?>">
    <br>

    <input type="submit" name="boutton" value="modifier">

</form>

<?php

if (isset($_POST['boutton'])) {
    $Iquery = 'UPDATE note SET Matiere = ?, Intitule = ?, note = ?, Coeff = ? , Classe = ? WHERE Id_note= ?';
    $reqI = $bdd->prepare($Iquery);
    $reqI->execute(array($_POST["matière"], $_POST['intitule'], $_POST['note'], $_POST['coeff'], $_POST['classe'], $_GET['id']));
    echo "<br>" . "Modification terminé !" . "<br>";
    echo "<a href=Liste_note.php >Retourner à la liste ?</a>";
}
?>