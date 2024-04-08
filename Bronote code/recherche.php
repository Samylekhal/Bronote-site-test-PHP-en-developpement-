<?php
require 'header.php';
if (isset($_GET["search"])) {
    if ($_SESSION["Statut"] == "ADMIN") {
        $query = 'SELECT inscrit.Id_inscrit,inscrit.Nom,inscrit.Prenom,inscrit.Statut, infoeleve.Classe,infoprof.Enseigne  
        FROM  inscrit 
        LEFT JOIN infoeleve ON inscrit.Id_inscrit = infoeleve.Id_eleve 
        LEFT JOIN infoprof ON inscrit.Id_inscrit = infoprof.Id_prof 
        WHERE
        inscrit.Nom LIKE :search OR
        inscrit.Prenom LIKE :search OR
        inscrit.Statut LIKE :search OR 
        infoeleve.Classe LIKE :search OR 
        infoprof.Enseigne LIKE :search
        ORDER BY inscrit.Nom ASC';

    } elseif ($_SESSION["Statut"] == "PROF") {
        $query =
            'SELECT Id_inscrit, Nom,  Prenom, Classe,Statut 
        FROM inscrit INNER JOIN infoeleve on inscrit.Id_inscrit = infoeleve.Id_eleve 
        WHERE 
        Classe LIKE :search or 
        Nom LIKE :search or 
        Prenom LIKE :search or 
        Statut LIKE :search
        ORDER BY Nom ASC';
    }
    $like = '%' . $_GET["search"] . '%';

    $res = $bdd->prepare($query);
    $res->execute(array(':search' => $like));
    $lignes = $res->fetchAll();
}




?>
<form action=Tbord.php>
    <input type="submit" value="retour" name="retour">
</form>

<form action="recherche.php" method="get">

    <label for="search">Saisie</label>
    <br>
    <input type="text" id="search" name="search">
    <br>
    <input type="submit" value="valider">

    <div>
        <?php
        if ($_SESSION["Statut"] == "ADMIN" && isset($_GET["search"])) {
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Profils</th>';
            echo '<th>Nom</th>';
            echo '<th>Prénom</th>';
            echo '<th>Statut</th>';
            echo '<th>Classe</th>';
            echo '<th>Enseigne</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($lignes as $ligne) {
                if ($ligne["Classe"] == null && $ligne["Enseigne"] == null) {
                    $ligne["Classe"] = "//";
                    $ligne["Enseigne"] = "//";
                } elseif ($ligne["Enseigne"] == null) {
                    $ligne["Enseigne"] = "//";
                } elseif ($ligne["Classe"] == null) {
                    $ligne["Classe"] = "//";
                }

                echo '<tr>';
                echo '<td><a href="Profil.php?id=' . $ligne["Id_inscrit"] . '">Profil</a></td>';
                echo '<td>' . $ligne["Nom"] . '</td>';
                echo '<td>' . $ligne["Prenom"] . '</td>';
                echo '<td>' . $ligne["Statut"] . '</td>';
                echo '<td>' . $ligne["Classe"] . '</td>';
                echo '<td>' . $ligne["Enseigne"] . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } elseif ($_SESSION["Statut"] == "PROF" && isset($_GET["search"])) {
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Profils</th>';
            echo '<th>Nom</th>';
            echo '<th>Prénom</th>';
            echo '<th>Statut</th>';
            echo '<th>Classe</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($lignes as $ligne) {



                echo '<tr>';
                echo '<td><a href="Profil.php?id=' . $ligne["Id_inscrit"] . '">Profil</a></td>';
                echo '<td>' . $ligne["Nom"] . '</td>';
                echo '<td>' . $ligne["Prenom"] . '</td>';
                echo '<td>' . $ligne["Statut"] . '</td>';
                echo '<td>' . $ligne["Classe"] . '</td>';
                echo '</tr>';
            }
        }


        ?>
    </div>

</form>

</main>
</body>