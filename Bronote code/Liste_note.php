<?php
require 'header.php';

if ($_SESSION['Statut'] == 'ELEVE') {
    header('location:Tbord.php');
}

$queryListe = $bdd->query('SELECT * FROM note');
$listenotes = $queryListe->fetchAll();

$queryIns = $bdd->prepare('SELECT Enseigne FROM infoprof WHERE Id_prof = ? ');
$queryIns->execute(array($_SESSION['Id_inscrit']));

$MAT = $queryIns->fetch();
?>

<form action=Tbord.php>
    <input type="submit" value="retour" name="retour">
</form>

<table border="1">
    <thead>
        <tr>
            <th>Matière</th>
            <th>Note max</th>
            <th>Intitule</th>
            <th>Coefficient</th>
            <th>Classe</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($_SESSION['Statut'] == 'ADMIN') {

            foreach ($listenotes as $listenote) {
                echo "<tr>";
                echo "<td>" . $listenote['Matiere'] . "</td>";
                echo "<td>" . $listenote['note'] . "</td>";
                echo "<td>" . $listenote['Intitule'] . "</td>";
                echo "<td>" . $listenote['Coeff'] . "</td>";
                echo "<td>" . $listenote['Classe'] . "</td>";

                ?>
                <td>
                    <a href="Modif_note.php?id=<?= $listenote['Id_note'] ?>">Modifier</a>
                </td>
                <td>
                    <form action="Liste_note.php" method='Post'>
                        <input type="hidden" name="supprimer" value="<?= $listenote['Id_note'] ?>" />
                        <input type="submit" value='supprimer'>

                    </form>
                </td>
                <?php
                echo "<tr>";

            }

        } elseif ($_SESSION['Statut'] == 'PROF') {
            foreach ($listenotes as $listenote) {
                if ($MAT['Enseigne'] == $listenote['Matiere']) {
                    echo "<tr>";
                    echo "<td>" . $listenote['Matiere'] . "</td>";
                    echo "<td>" . $listenote['note'] . "</td>";
                    echo "<td>" . $listenote['Intitule'] . "</td>";
                    echo "<td>" . $listenote['Coeff'] . "</td>";
                    echo "<td>" . $listenote['Classe'] . "</td>";

                    ?>
                    <td>
                        <a href="Modif_note.php?id=<?= $listenote['Id_note'] ?>">Modifier</a>
                    </td>
                    <td>
                        <form action="Liste_note.php" method='Post'>
                            <input type="hidden" name="supprimer" value="<?= $listenote['Id_note'] ?>" />
                            <input type="submit" value='supprimer'>

                        </form>
                    </td>
                    <?php
                    echo "<tr>";
                }
            }
        }

        ?>


        <?php
        if (isset($_POST['supprimer'])) {
            $DELquery = $bdd->prepare('DELETE FROM note WHERE Id_note = ?');
            $DELquery->execute(array($_POST['supprimer']));
            header('Location: Liste_note.php');
        }

        ?>
    </tbody>
</table>