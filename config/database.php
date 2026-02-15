<?php

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_bibliotheque');

function connectDB(){
    // Première connexion sans spécifier la DB pour créer la DB si elle n'existe pas
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
    if($conn === false){
        die("Erreur: Connexion au serveur MySQL impossible - " . mysqli_connect_error());
    }
    
    // Créer la base de données si elle n'existe pas
    $create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if(!mysqli_query($conn, $create_db)){
        die("Erreur: Impossible de créer la base de données - " . mysqli_error($conn));
    }
    
    // Sélectionner la base de données
    if(!mysqli_select_db($conn, DB_NAME)){
        die("Erreur: Impossible de sélectionner la base de données - " . mysqli_error($conn));
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Fonction pour initialiser/mettre à jour le schéma de la base de données
function initializeDatabase(){
    $conn = connectDB();
    
    // 1. Création/Mise à jour table livres
    $sql_livres = "CREATE TABLE IF NOT EXISTS livres (
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
    
    if(!mysqli_query($conn, $sql_livres)){
        return "Erreur création table livres: " . mysqli_error($conn);
    }
    
    // 2. Vérifier et ajouter les colonnes manquantes
    $columns_to_check = ['image_couverture', 'genre', 'isbn', 'prix', 'date_publication', 'pdf_file'];
    foreach($columns_to_check as $col){
        $check_col = "SHOW COLUMNS FROM livres LIKE '$col'";
        $result = mysqli_query($conn, $check_col);
        if(mysqli_num_rows($result) == 0){
            switch($col){
                case 'image_couverture':
                    $add_col = "ALTER TABLE livres ADD COLUMN image_couverture VARCHAR(255) AFTER nombre_exemplair";
                    break;
                case 'genre':
                    $add_col = "ALTER TABLE livres ADD COLUMN genre VARCHAR(100)";
                    break;
                case 'isbn':
                    $add_col = "ALTER TABLE livres ADD COLUMN isbn VARCHAR(20)";
                    break;
                case 'prix':
                    $add_col = "ALTER TABLE livres ADD COLUMN prix DECIMAL(10, 2)";
                    break;
                case 'date_publication':
                    $add_col = "ALTER TABLE livres ADD COLUMN date_publication DATE";
                    break;
                case 'pdf_file':
                    $add_col = "ALTER TABLE livres ADD COLUMN pdf_file VARCHAR(255)";
                    break;
            }
            @mysqli_query($conn, $add_col);
        }
    }
    
    // 3. Création/Mise à jour table lecteurs (utilisateurs)
    $sql_lecteurs = "CREATE TABLE IF NOT EXISTS lecteurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(255) NOT NULL,
        date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        actif BOOLEAN DEFAULT TRUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if(!mysqli_query($conn, $sql_lecteurs)){
        return "Erreur création table lecteurs: " . mysqli_error($conn);
    }
    
    // 4. Vérifier et corriger la colonne prenom (typo prenomn)
    $check_prenom = "SHOW COLUMNS FROM lecteurs LIKE 'prenom'";
    $result = mysqli_query($conn, $check_prenom);
    if(mysqli_num_rows($result) == 0){
        // Essayer de renommer le champ mal orthographié s'il existe
        $check_prenomn = "SHOW COLUMNS FROM lecteurs LIKE 'prenomn'";
        $result_prenomn = mysqli_query($conn, $check_prenomn);
        if(mysqli_num_rows($result_prenomn) > 0){
            $rename = "ALTER TABLE lecteurs CHANGE COLUMN prenomn prenom VARCHAR(100) NOT NULL";
            mysqli_query($conn, $rename);
        }
    }
    
    // 5. Vérifier et ajouter colonne mot_de_passe si elle n'existe pas
    $check_pwd = "SHOW COLUMNS FROM lecteurs LIKE 'mot_de_passe'";
    $result = mysqli_query($conn, $check_pwd);
    if(mysqli_num_rows($result) == 0){
        $add_pwd = "ALTER TABLE lecteurs ADD COLUMN mot_de_passe VARCHAR(255) NOT NULL DEFAULT ''";
        mysqli_query($conn, $add_pwd);
    }
    
    // 6. Création table wishlists
    $sql_wishlists = "CREATE TABLE IF NOT EXISTS wishlists (
        id INT AUTO_INCREMENT PRIMARY KEY,
        lecteur_id INT NOT NULL,
        livre_id INT NOT NULL,
        date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (lecteur_id) REFERENCES lecteurs(id) ON DELETE CASCADE,
        FOREIGN KEY (livre_id) REFERENCES livres(id) ON DELETE CASCADE,
        UNIQUE KEY unique_wish (lecteur_id, livre_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if(!mysqli_query($conn, $sql_wishlists)){
        return "Erreur création table wishlists: " . mysqli_error($conn);
    }
    
    $conn->close();
    return true;
}

// Fonction pour valider et nettoyer les données
function sanitize($data){
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Fonction pour vérifier si un utilisateur est connecté
function isLoggedIn(){
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Fonction pour rediriger vers la page de connexion si pas connecté
function requireLogin(){
    if(!isLoggedIn()){
        header("Location: /db_bibliotheque/connexion.html");
        exit();
    }
}

?>












?>