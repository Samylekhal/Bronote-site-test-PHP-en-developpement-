<?php
require 'header.php';

if (isset($_SESSION['Id_inscrit'])) {
    # code...
} else {
    header('Location:Connexion.php');
}

?>
<div>
    <h1>
        Bienvenue sur Bronote
        <?= $_SESSION["Prenom"] ?>
    </h1>
</div>

<div>
    <?php
    switch ($_SESSION['Statut']) {
        case 'ADMIN':
            echo '<a href="Profil.php?id=' . $_SESSION['Id_inscrit'] . '">Votre profil</a> <a href="recherche.php">Faire une recherche</a><br>';
            echo '<a href="Crea_profil.php">Ajouter un individu</a>' . " " . "<a href='Crea_note.php'>Créer une note</a>" . " " . "<a href='Liste_note.php'>Liste des notes</a>";
            break;
        case 'ELEVE':
            echo '<a href="Profil.php?id=' . $_SESSION['Id_inscrit'] . '">Votre profil</a> <a href="Notes.php?id=' . $_SESSION['Id_inscrit'] . '">Vos notes</a><br>';
            break;
        case 'PROF':
            echo '<a href="Profil.php?id=' . $_SESSION['Id_inscrit'] . '">Votre profil</a> <a href="recherche.php">Faire une recherche</a><br>' . " " . "<a href='Crea_note.php'>Créer une note</a>" . " " . "<a href='Liste_note.php'>Liste des notes</a>";
            break;
        default:
            break;
    }
    ?>
</div>
</main>
</body>