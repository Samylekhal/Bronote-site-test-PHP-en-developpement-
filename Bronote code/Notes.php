<?php
require 'header.php';

if (isset($_GET['id']) && $_GET['id'] != "") {
    if ($_SESSION['Statut'] == 'ELEVE' && $_SESSION['Id_inscrit'] != $_GET['id']) {
        header('location:Tbord.php');
    }
    $queryInfoeleve = $bdd->prepare('SELECT Id_eleve, Classe FROM infoeleve WHERE Id_eleve = ?');
    $queryInfoeleve->execute(array($_GET['id']));
    $infoeleve = $queryInfoeleve->fetch();


    // notes de l'élèves
    $querynNOTEL = $bdd->prepare('SELECT note.Id_note, Id_info  ,Matiere, Intitule, note ,Coeff ,note.Classe, ID_info, infoeleve.Id_eleve ,ID_noteleve ,noteleve 
    FROM note 
    JOIN infoeleve ON note.Classe = infoeleve.Classe 
    LEFT JOIN elevenote ON elevenote.id_eleve = infoeleve.ID_info and elevenote.id_note = note.Id_note 
    WHERE infoeleve.id_eleve = ? AND infoeleve.Classe = ?');
    $querynNOTEL->execute(array($infoeleve['Id_eleve'], $infoeleve['Classe']));
    $Tabnotes = $querynNOTEL->fetchAll();

    $queryMat = $bdd->query('SELECT DISTINCT Matiere FROM note ORDER BY Matiere ASC ');
    $Matières = $queryMat->fetchAll();


} else {
    header("Location:Tbord.php");
    die;
}

?>

<form action=Tbord.php>
    <input type="submit" value="retour" name="retour">
</form>


<?php
foreach ($Matières as $matiere) { ?>
    <h3>
        <?= $matiere['Matiere'] ?>
    </h3>

    <table border="1">
        <thead>
            <tr>
                <th>Intitule</th>
                <th>Coeff</th>
                <th>Note </th>
                <th>Note sur:</th>
                <th>Note max</th>
                <th>Note min</th>
                <th>Note Moyenne</th>
                <?php
                if ($_SESSION['Statut'] != 'ELEVE') {
                    ?>
                    <th>Ajout/modif</th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($Tabnotes as $Tabnote) {
                if ($matiere['Matiere'] == $Tabnote['Matiere']) {
                    ?>
                    <td>
                        <?= $Tabnote['Intitule'] ?>
                    </td>
                    <td>
                        <?= $Tabnote['Coeff'] ?>
                    </td>
                    <td>
                        <?= $Tabnote['noteleve'] ?>
                    </td>
                    <td>
                        <?= $Tabnote['note'] ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <?php
                        $name = $Tabnote['Id_note'] . '-' . $Tabnote['Id_eleve'];
                        if ($_SESSION['Statut'] == 'ADMIN') {
                            ?>
                            <form action="" method="Post">
                                <input name='note ' type="text">
                                <input type="submit" name="<?= $name ?>" value="modifier la note">
                            </form>
                            <?php
                        } elseif ($_SESSION['Statut'] == 'PROF') {
                            $queryMATP = $bdd->prepare('SELECT Enseigne FROM infoprof WHERE Id_prof = ?');
                            $queryMATP->execute(array($_SESSION['Id_inscrit']));
                            $MATP = $queryMATP->fetch();
                            if ($matiere['Matiere'] == $MATP['Enseigne']) {
                                ?>
                                <form action="" method="Post">
                                    <input name='note' type="text">
                                    <input type="submit" name="<?= $name ?>" value="modifier la note">
                                </form>
                                <?php

                            }


                        }
                        if (isset($_POST[$name]) && isset($_POST['note'])) {
                            if ($Tabnote['ID_noteleve'] == null) {
                                $Iquery = $bdd->prepare('INSERT INTO elevenote (noteleve, id_eleve, id_note) VALUES (?, ?, ?)');
                                $Iquery->execute(array($_POST['note'], $Tabnote['Id_info'], $Tabnote['Id_note']));
                            } else {
                                $Uquery = $bdd->prepare('UPDATE elevenote SET noteleve = ? WHERE ID_noteleve = ?');
                                $Uquery->execute(array($_POST['note'], $Tabnote['ID_noteleve']));
                            }
                        }

                        ?>
                    </td>
                    <?php
                }
            }



            ?>

        </tbody>
        <tfoot>

        </tfoot>
    </table>
    <?php
}
?>