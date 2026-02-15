<?php
session_start();
require_once "./config/database.php";

initializeDatabase();

// Données des 50 livres
$books_data = [
    ['titre' => 'L\'Alchimiste', 'auteur' => 'Paulo Coelho', 'genre' => 'Fiction', 'prix' => '18.99', 'year' => '1988', 'description' => 'Un jeune berger parte en quête de son trésor personnel à travers le désert.'],
    ['titre' => 'Le Seigneur des Anneaux', 'auteur' => 'J.R.R. Tolkien', 'genre' => 'Fantasy', 'prix' => '24.99', 'year' => '1954', 'description' => 'Une épopée fantasy mettant en scène des créatures imaginaires et des mondes magiques.'],
    ['titre' => '1984', 'auteur' => 'George Orwell', 'genre' => 'Dystopie', 'prix' => '16.99', 'year' => '1949', 'description' => 'Un roman dystopique décrivant un régime totalitaire oppressif et une surveillance de masse.'],
    ['titre' => 'Le Hobbit', 'auteur' => 'J.R.R. Tolkien', 'genre' => 'Fantasy', 'prix' => '19.99', 'year' => '1937', 'description' => 'L\'aventure d\'un petit hobbit qui découvre un monde grand et merveilleux.'],
    ['titre' => 'Le Code Da Vinci', 'auteur' => 'Dan Brown', 'genre' => 'Thriller', 'prix' => '20.99', 'year' => '2003', 'description' => 'Un professeur et une cryptographe enquêtent sur un meurtre au Louvre.'],
    ['titre' => 'Harry Potter à l\'école des sorciers', 'auteur' => 'J.K. Rowling', 'genre' => 'Fantasy', 'prix' => '17.99', 'year' => '1997', 'description' => 'Un jeune sorcier découvre l\'école de magie de Poudlard et ses mystères.'],
    ['titre' => 'La Nuit est mon Royaume', 'auteur' => 'Franck Thilliez', 'genre' => 'Thriller', 'prix' => '19.99', 'year' => '2012', 'description' => 'Un thriller haletant mêlant passé et présent dans une intrigue complexe.'],
    ['titre' => 'Les Misérables', 'auteur' => 'Victor Hugo', 'genre' => 'Classique', 'prix' => '22.99', 'year' => '1862', 'description' => 'L\'histoire épique de Jean Valjean et de la justice en France au XIXe siècle.'],
    ['titre' => 'Le Seigneur des mouches', 'auteur' => 'William Golding', 'genre' => 'Fiction', 'prix' => '14.99', 'year' => '1954', 'description' => 'Des enfants naufragés tentent de survivre et de s\'organiser sur une île déserte.'],
    ['titre' => 'Orgueil et Préjugés', 'auteur' => 'Jane Austen', 'genre' => 'Romantique', 'prix' => '13.99', 'year' => '1813', 'description' => 'Une histoire d\'amour et de mariage dans la société anglaise du XIXe siècle.'],
    ['titre' => 'Dune', 'auteur' => 'Frank Herbert', 'genre' => 'Science-Fiction', 'prix' => '21.99', 'year' => '1965', 'description' => 'Une épopée science-fiction sur la politique, la religion et l\'écologie sur une planète désertique.'],
    ['titre' => 'Fondation', 'auteur' => 'Isaac Asimov', 'genre' => 'Science-Fiction', 'prix' => '19.99', 'year' => '1951', 'description' => 'Une série fondatrice de la science-fiction moderne sur l\'effondrement et la reconstruction d\'un empire.'],
    ['titre' => 'Le Meilleur des Mondes', 'auteur' => 'Aldous Huxley', 'genre' => 'Dystopie', 'prix' => '17.99', 'year' => '1932', 'description' => 'Un roman dystopique décrivant une société future basée sur le contrôle et le bonheur artificiel.'],
    ['titre' => 'Fahrenheit 451', 'auteur' => 'Ray Bradbury', 'genre' => 'Science-Fiction', 'prix' => '15.99', 'year' => '1953', 'description' => 'Dans un futur où les livres sont brûlés, un pompier découvre le pouvoir de la littérature.'],
    ['titre' => 'Jane Eyre', 'auteur' => 'Charlotte Brontë', 'genre' => 'Romantique', 'prix' => '14.99', 'year' => '1847', 'description' => 'L\'histoire poignante d\'une jeune gouvernante et de son amour pour un homme mystérieux.'],
    ['titre' => 'Moby Dick', 'auteur' => 'Herman Melville', 'genre' => 'Aventure', 'prix' => '19.99', 'year' => '1851', 'description' => 'Une quête obsédante pour chasser une baleine blanche à travers les océans.'],
    ['titre' => 'Les Hauts de Hurlevent', 'auteur' => 'Emily Brontë', 'genre' => 'Romantique', 'prix' => '16.99', 'year' => '1847', 'description' => 'Une histoire passionnée et sombre d\'amour et de vengeance sur les landes anglaises.'],
    ['titre' => 'L\'Iliade', 'auteur' => 'Homère', 'genre' => 'Classique', 'prix' => '21.99', 'year' => '-800', 'description' => 'L\'épopée antique de la guerre de Troie et des dieux grecs.'],
    ['titre' => 'L\'Odyssée', 'auteur' => 'Homère', 'genre' => 'Classique', 'prix' => '21.99', 'year' => '-800', 'description' => 'Le voyage épique d\'Ulysse vers son retour à Ithaque.'],
    ['titre' => 'Le Comte de Monte-Cristo', 'auteur' => 'Alexandre Dumas', 'genre' => 'Aventure', 'prix' => '23.99', 'year' => '1844', 'description' => 'L\'histoire d\'un homme injustement emprisonné qui devient fabuleux et se venge.'],
    ['titre' => 'Notre-Dame de Paris', 'auteur' => 'Victor Hugo', 'genre' => 'Classique', 'prix' => '20.99', 'year' => '1831', 'description' => 'Une histoire tragique de bouffonnerie, d\'amour et de cathédrale au Moyen Âge.'],
    ['titre' => 'Les Trois Mousquetaires', 'auteur' => 'Alexandre Dumas', 'genre' => 'Aventure', 'prix' => '18.99', 'year' => '1844', 'description' => 'L\'amitié et les aventures de quatre mousquetaires à la cour de France.'],
    ['titre' => 'Ivanhoe', 'auteur' => 'Walter Scott', 'genre' => 'Aventure', 'prix' => '17.99', 'year' => '1819', 'description' => 'Un chevalier revient en Angleterre après les croisades et affronte l\'injustice.'],
    ['titre' => 'La Reine des Neiges', 'auteur' => 'Hans Christian Andersen', 'genre' => 'Conte', 'prix' => '12.99', 'year' => '1844', 'description' => 'Un conte de fées magique sur l\'amitié, l\'amour et la rédemption.'],
    ['titre' => 'Alice au Pays des Merveilles', 'auteur' => 'Lewis Carroll', 'genre' => 'Fantaisie', 'prix' => '13.99', 'year' => '1865', 'description' => 'Les aventures surréalistes d\'une jeune fille dans un monde bizarre et magique.'],
    ['titre' => 'Le Portrait de Dorian Gray', 'auteur' => 'Oscar Wilde', 'genre' => 'Littérature', 'prix' => '14.99', 'year' => '1890', 'description' => 'Un jeune homme dont le portrait vieillit à sa place dans ce conte moral fascinant.'],
    ['titre' => 'Frankenstein', 'auteur' => 'Mary Shelley', 'genre' => 'Horreur', 'prix' => '15.99', 'year' => '1818', 'description' => 'L\'histoire classique d\'un scientifique qui crée une créature monstrueuse.'],
    ['titre' => 'Dracula', 'auteur' => 'Bram Stoker', 'genre' => 'Horreur', 'prix' => '16.99', 'year' => '1897', 'description' => 'L\'histoire terrifiante du comte vampire qui terrorise l\'Angleterre victorienne.'],
    ['titre' => 'Le Fantôme de l\'Opéra', 'auteur' => 'Gaston Leroux', 'genre' => 'Romantique', 'prix' => '17.99', 'year' => '1909', 'description' => 'Un mystérieux fantôme habite les souterrains de l\'Opéra de Paris.'],
    ['titre' => 'Sherlock Holmes : Le Chien des Baskerville', 'auteur' => 'Arthur Conan Doyle', 'genre' => 'Mystère', 'prix' => '14.99', 'year' => '1901', 'description' => 'Un détective légendaire résout une affaire mystérieuse impliquant un chien maudit.'],
    ['titre' => 'L\'Étrange Cas du Dr Jekyll et Mr Hyde', 'auteur' => 'Robert Louis Stevenson', 'genre' => 'Horreur', 'prix' => '13.99', 'year' => '1886', 'description' => 'Un conte de transformation et de dualité morale dans la Londres victorienne.'],
    ['titre' => 'Les Enfants du Capitaine Grant', 'auteur' => 'Jules Verne', 'genre' => 'Aventure', 'prix' => '19.99', 'year' => '1868', 'description' => 'Un voyage autour du monde pour retrouver un capitaine disparu.'],
    ['titre' => 'Vingt Mille Lieues sous les Mers', 'auteur' => 'Jules Verne', 'genre' => 'Science-Fiction', 'prix' => '20.99', 'year' => '1870', 'description' => 'Une aventure sous-marine extraordinaire à bord du sous-marin Nautilus.'],
    ['titre' => 'Le Tour du Monde en Quatre-Vingts Jours', 'auteur' => 'Jules Verne', 'genre' => 'Aventure', 'prix' => '15.99', 'year' => '1873', 'description' => 'Un pari audacieux pour faire le tour du monde en quatre-vingts jours.'],
    ['titre' => 'La Machine à Remonter le Temps', 'auteur' => 'H.G. Wells', 'genre' => 'Science-Fiction', 'prix' => '14.99', 'year' => '1895', 'description' => 'Un inventeur crée une machine pour voyager dans le temps avec des conséquences étonnantes.'],
    ['titre' => 'L\'Homme Invisible', 'auteur' => 'H.G. Wells', 'genre' => 'Science-Fiction', 'prix' => '14.99', 'year' => '1897', 'description' => 'Un savant devient invisible et découvre les dangers du pouvoir sans limites.'],
    ['titre' => 'La Guerre des Mondes', 'auteur' => 'H.G. Wells', 'genre' => 'Science-Fiction', 'prix' => '16.99', 'year' => '1898', 'description' => 'L\'invasion de la Terre par des Martiens dans cette science-fiction pionnière.'],
    ['titre' => 'Les Aventures de Tom Sawyer', 'auteur' => 'Mark Twain', 'genre' => 'Aventure', 'prix' => '15.99', 'year' => '1876', 'description' => 'Les aventures espiègle d\'un jeune garçon dans l\'Amérique du XIXe siècle.'],
    ['titre' => 'Les Aventures de Huckleberry Finn', 'auteur' => 'Mark Twain', 'genre' => 'Aventure', 'prix' => '16.99', 'year' => '1884', 'description' => 'Un jeune garçon fugue et voyage sur le Mississippi en bateau avec un homme libre.'],
    ['titre' => 'Anne aux Pignons Verts', 'auteur' => 'Lucy Maud Montgomery', 'genre' => 'Jeunesse', 'prix' => '14.99', 'year' => '1908', 'description' => 'L\'histoire touchante d\'une jeune orpheline qui grandit en Amérique du Nord.'],
    ['titre' => 'Le Magicien d\'Oz', 'auteur' => 'L. Frank Baum', 'genre' => 'Fantaisie', 'prix' => '13.99', 'year' => '1900', 'description' => 'Une jeune fille transportée dans un pays magique cherche le chemin du retour.'],
    ['titre' => 'Robinson Crusoé', 'auteur' => 'Daniel Defoe', 'genre' => 'Aventure', 'prix' => '15.99', 'year' => '1719', 'description' => 'Un homme naufragé doit survivre seul sur une île déserte pendant des années.'],
    ['titre' => 'Gulliver\'s Travels', 'auteur' => 'Jonathan Swift', 'genre' => 'Satire', 'prix' => '16.99', 'year' => '1726', 'description' => 'Les voyages fantastiques d\'un explorateur dans des mondes étranges et mystérieux.'],
    ['titre' => 'Stendhal : Le Rouge et le Noir', 'auteur' => 'Stendhal', 'genre' => 'Littérature', 'prix' => '19.99', 'year' => '1830', 'description' => 'Le destin tumultueux d\'un jeune ambitieux dans la France post-napoléonienne.'],
    ['titre' => 'Balzac : La Peau de Chagrin', 'auteur' => 'Honoré de Balzac', 'genre' => 'Littérature', 'prix' => '18.99', 'year' => '1831', 'description' => 'Un jeune homme reçoit une peau magique qui exauce ses vœux à un prix terrible.'],
    ['titre' => 'Flaubert : Madame Bovary', 'auteur' => 'Gustave Flaubert', 'genre' => 'Littérature', 'prix' => '17.99', 'year' => '1856', 'description' => 'L\'histoire d\'une femme rongée par l\'ennui et les rêves romantiques impossibles.'],
    ['titre' => 'Zola : Germinal', 'auteur' => 'Émile Zola', 'genre' => 'Littérature', 'prix' => '19.99', 'year' => '1884', 'description' => 'Un roman puissant sur la vie des mineurs et la lutte des classes en France.'],
    ['titre' => 'Maupassant : Le Horla', 'auteur' => 'Guy de Maupassant', 'genre' => 'Horreur', 'prix' => '12.99', 'year' => '1886', 'description' => 'Une novella horrifiante sur un homme persécuté par une créature invisible.'],
    ['titre' => 'Daudet : Le Petit Chose', 'auteur' => 'Alphonse Daudet', 'genre' => 'Littérature', 'prix' => '14.99', 'year' => '1868', 'description' => 'L\'histoire poignante d\'un jeune garçon pauvre qui devient professeur.'],
    ['titre' => 'Sand : La Mare au Diable', 'auteur' => 'George Sand', 'genre' => 'Littérature', 'prix' => '13.99', 'year' => '1846', 'description' => 'Un beau roman rural sur la passion et l\'amour dans la campagne française.'],
    ['titre' => 'Lamartine : Graziella', 'auteur' => 'Alphonse de Lamartine', 'genre' => 'Littérature', 'prix' => '12.99', 'year' => '1852', 'description' => 'Une histoire romantique d\'amour passager sur une île méditerranéenne.'],
];

// Créer les dossiers nécessaires
$dirs = ['images/couvertures', 'pdfs'];
foreach($dirs as $dir){
    if(!is_dir($dir)){
        mkdir($dir, 0755, true);
    }
}

// Connexion à la base de données
$conn = connectDB();

// Supprimer les anciens livres (optionnel - décommenter si vous voulez repartir de zéro)
// mysqli_query($conn, "DELETE FROM livres");

// Couleurs pour les couvertures
$colors = [
    ['bg' => '#2c3e50', 'text' => '#ecf0f1'],
    ['bg' => '#8e44ad', 'text' => '#ecf0f1'],
    ['bg' => '#c0392b', 'text' => '#ecf0f1'],
    ['bg' => '#16a085', 'text' => '#ecf0f1'],
    ['bg' => '#2980b9', 'text' => '#ecf0f1'],
    ['bg' => '#f39c12', 'text' => '#2c3e50'],
    ['bg' => '#d35400', 'text' => '#ecf0f1'],
    ['bg' => '#27ae60', 'text' => '#ecf0f1'],
    ['bg' => '#34495e', 'text' => '#ecf0f1'],
    ['bg' => '#9b59b6', 'text' => '#ecf0f1'],
];

$total_added = 0;

foreach($books_data as $index => $book){
    // Vérifier si le livre existe déjà
    $check_stmt = $conn->prepare("SELECT id FROM livres WHERE titre = ? AND auteur = ?");
    $check_stmt->bind_param("ss", $book['titre'], $book['auteur']);
    $check_stmt->execute();
    
    if($check_stmt->get_result()->num_rows > 0){
        $check_stmt->close();
        continue; // Livre existe déjà
    }
    $check_stmt->close();
    
    // Créer le nom du fichier image (utiliser une API ou générateur)
    $color = $colors[$index % count($colors)];
    $image_name = uniqid('cover_') . '.png';
    
    // Générer une couverture simple avec GD (si disponible)
    if(extension_loaded('gd')){
        $img = imagecreatetruecolor(200, 300);
        
        // Convertir la couleur hex en RGB
        $hex = ltrim($color['bg'], '#');
        $bg_r = hexdec(substr($hex, 0, 2));
        $bg_g = hexdec(substr($hex, 2, 2));
        $bg_b = hexdec(substr($hex, 4, 2));
        $bg_color = imagecolorallocate($img, $bg_r, $bg_g, $bg_b);
        
        // Fond
        imagefilledrectangle($img, 0, 0, 200, 300, $bg_color);
        
        // Couleur du texte
        $hex_text = ltrim($color['text'], '#');
        $text_r = hexdec(substr($hex_text, 0, 2));
        $text_g = hexdec(substr($hex_text, 2, 2));
        $text_b = hexdec(substr($hex_text, 4, 2));
        $text_color = imagecolorallocate($img, $text_r, $text_g, $text_b);
        
        // Écrire le titre
        $title = substr($book['titre'], 0, 25);
        imagestring($img, 3, 10, 50, $title, $text_color);
        
        // Écrire l'auteur
        $author = substr($book['auteur'], 0, 20);
        imagestring($img, 2, 10, 250, $author, $text_color);
        
        // Sauvegarder l'image
        imagepng($img, "images/couvertures/" . $image_name);
        imagedestroy($img);
    }
    
    // Créer un PDF simple
    $pdf_name = uniqid('book_') . '.pdf';
    $pdf_path = "pdfs/" . $pdf_name;
    
    // Créer un PDF basique (texte brut)
    $pdf_content = "%PDF-1.4\n";
    $pdf_content .= "1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n";
    $pdf_content .= "2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n";
    $pdf_content .= "3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Contents 4 0 R/Resources<</Font<</F1<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>>>>>endobj\n";
    $pdf_content .= "4 0 obj<</Length " . strlen("BT /F1 12 Tf 50 700 Td (" . addslashes($book['titre']) . ") Tj 0 -20 Td (" . addslashes($book['auteur']) . ") Tj 0 -40 Td (" . addslashes($book['description']) . ") Tj ET") . ">>stream\nBT /F1 12 Tf 50 700 Td (" . addslashes($book['titre']) . ") Tj 0 -20 Td (" . addslashes($book['auteur']) . ") Tj 0 -40 Td (" . addslashes($book['description']) . ") Tj ET\nendstream endobj\n";
    $pdf_content .= "xref 0 5\n0000000000 65535 f\n0000000009 00000 n\n0000000058 00000 n\n0000000115 00000 n\n0000000244 00000 n\n";
    $pdf_content .= "trailer<</Size 5/Root 1 0 R>>\n";
    $pdf_content .= "startxref\n400\n%%EOF\n";
    
    file_put_contents($pdf_path, $pdf_content);
    
    // Insérer le livre en base de données
    $date_pub = $book['year'] . '-01-01';
    $stmt = $conn->prepare("
        INSERT INTO livres 
        (titre, auteur, description, maison_edition, nombre_exemplair, image_couverture, genre, isbn, date_publication, prix, pdf_file) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    // Créer des variables pour bind_param
    $titre = $book['titre'];
    $auteur = $book['auteur'];
    $description = $book['description'];
    $genre = $book['genre'];
    $prix_val = floatval($book['prix']);
    $nombre_exemplair = 5;
    $isbn = rand(1000000000, 9999999999);
    $isbn_str = (string)$isbn;
    $edition = "Éditions " . ucfirst(strtolower(substr($book['auteur'], 0, 5)));
    
    $stmt->bind_param(
        "ssssisssdss",
        $titre,
        $auteur,
        $description,
        $edition,
        $nombre_exemplair,
        $image_name,
        $genre,
        $isbn_str,
        $date_pub,
        $prix_val,
        $pdf_name
    );
    
    if($stmt->execute()){
        $total_added++;
    }
    $stmt->close();
}

$conn->close();

echo "<h2>✅ Import réussi!</h2>";
echo "<p>" . $total_added . " livres ont été ajoutés à votre bibliothèque.</p>";
echo "<p><a href='index.php'>← Retour à l'accueil</a></p>";
?>
