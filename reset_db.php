<?php
// Script pour réinitialiser complètement la base de données

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_bibliotheque');

// Connexion sans DB
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if(!$conn){
    die("Erreur de connexion: " . mysqli_connect_error());
}

// Supprimer la base de données existante
echo "Suppression de la base de données existante...<br>";
$drop_db = "DROP DATABASE IF EXISTS " . DB_NAME;
if(mysqli_query($conn, $drop_db)){
    echo "✓ Base de données supprimée<br>";
} else {
    echo "✗ Erreur lors de la suppression: " . mysqli_error($conn) . "<br>";
}

// Créer une nouvelle base de données
echo "Création de la base de données...<br>";
$create_db = "CREATE DATABASE " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if(mysqli_query($conn, $create_db)){
    echo "✓ Base de données créée<br>";
} else {
    echo "✗ Erreur lors de la création: " . mysqli_error($conn) . "<br>";
}

// Sélectionner la base de données
mysqli_select_db($conn, DB_NAME);

// Créer la table livres
echo "Création de la table 'livres'...<br>";
$sql_livres = "CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    description TEXT,
    maison_edition VARCHAR(255),
    nombre_exemplair INT DEFAULT 1,
    image_couverture VARCHAR(255),
    genre VARCHAR(100),
    isbn VARCHAR(20),
    date_publication DATE,
    prix DECIMAL(10, 2),
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if(mysqli_query($conn, $sql_livres)){
    echo "✓ Table 'livres' créée<br>";
} else {
    echo "✗ Erreur: " . mysqli_error($conn) . "<br>";
}

// Créer la table lecteurs
echo "Création de la table 'lecteurs'...<br>";
$sql_lecteurs = "CREATE TABLE lecteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actif BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if(mysqli_query($conn, $sql_lecteurs)){
    echo "✓ Table 'lecteurs' créée<br>";
} else {
    echo "✗ Erreur: " . mysqli_error($conn) . "<br>";
}

// Créer la table wishlists
echo "Création de la table 'wishlists'...<br>";
$sql_wishlists = "CREATE TABLE wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lecteur_id INT NOT NULL,
    livre_id INT NOT NULL,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lecteur_id) REFERENCES lecteurs(id) ON DELETE CASCADE,
    FOREIGN KEY (livre_id) REFERENCES livres(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wish (lecteur_id, livre_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if(mysqli_query($conn, $sql_wishlists)){
    echo "✓ Table 'wishlists' créée<br>";
} else {
    echo "✗ Erreur: " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);

echo "<br><strong style='color: green;'>✓ Base de données réinitialisée avec succès!</strong><br>";
echo "Vous pouvez maintenant accéder à <a href='index.php'>l'accueil</a>";
?>
