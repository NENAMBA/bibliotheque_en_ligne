<?php
require_once "./config/database.php";

initializeDatabase();

// Données des 50 livres avec ISBN réels
$books_data = [
    ['titre' => 'L\'Alchimiste', 'auteur' => 'Paulo Coelho', 'isbn' => '9782266086447'],
    ['titre' => 'Le Seigneur des Anneaux', 'auteur' => 'J.R.R. Tolkien', 'isbn' => '9782253063254'],
    ['titre' => '1984', 'auteur' => 'George Orwell', 'isbn' => '9782253045809'],
    ['titre' => 'Le Hobbit', 'auteur' => 'J.R.R. Tolkien', 'isbn' => '9782253058083'],
    ['titre' => 'Le Code Da Vinci', 'auteur' => 'Dan Brown', 'isbn' => '9782283019529'],
    ['titre' => 'Harry Potter à l\'école des sorciers', 'auteur' => 'J.K. Rowling', 'isbn' => '9782253048763'],
    ['titre' => 'La Nuit est mon Royaume', 'auteur' => 'Franck Thilliez', 'isbn' => '9782368125250'],
    ['titre' => 'Les Misérables', 'auteur' => 'Victor Hugo', 'isbn' => '9782253048879'],
    ['titre' => 'Le Seigneur des mouches', 'auteur' => 'William Golding', 'isbn' => '9782253046110'],
    ['titre' => 'Orgueil et Préjugés', 'auteur' => 'Jane Austen', 'isbn' => '9782253045830'],
    ['titre' => 'Dune', 'auteur' => 'Frank Herbert', 'isbn' => '9782253047032'],
    ['titre' => 'Fondation', 'auteur' => 'Isaac Asimov', 'isbn' => '9782253048541'],
    ['titre' => 'Le Meilleur des Mondes', 'auteur' => 'Aldous Huxley', 'isbn' => '9782253085652'],
    ['titre' => 'Fahrenheit 451', 'auteur' => 'Ray Bradbury', 'isbn' => '9782253043041'],
    ['titre' => 'Jane Eyre', 'auteur' => 'Charlotte Brontë', 'isbn' => '9782253038740'],
    ['titre' => 'Moby Dick', 'auteur' => 'Herman Melville', 'isbn' => '9782253039358'],
    ['titre' => 'Les Hauts de Hurlevent', 'auteur' => 'Emily Brontë', 'isbn' => '9782253040957'],
    ['titre' => 'L\'Iliade', 'auteur' => 'Homère', 'isbn' => '9782253041238'],
    ['titre' => 'L\'Odyssée', 'auteur' => 'Homère', 'isbn' => '9782253041436'],
    ['titre' => 'Le Comte de Monte-Cristo', 'auteur' => 'Alexandre Dumas', 'isbn' => '9782253045007'],
    ['titre' => 'Notre-Dame de Paris', 'auteur' => 'Victor Hugo', 'isbn' => '9782253049210'],
    ['titre' => 'Les Trois Mousquetaires', 'auteur' => 'Alexandre Dumas', 'isbn' => '9782253047544'],
    ['titre' => 'Ivanhoe', 'auteur' => 'Walter Scott', 'isbn' => '9782253055006'],
    ['titre' => 'La Reine des Neiges', 'auteur' => 'Hans Christian Andersen', 'isbn' => '9782070413683'],
    ['titre' => 'Alice au Pays des Merveilles', 'auteur' => 'Lewis Carroll', 'isbn' => '9782253058199'],
    ['titre' => 'Le Portrait de Dorian Gray', 'auteur' => 'Oscar Wilde', 'isbn' => '9782253050094'],
    ['titre' => 'Frankenstein', 'auteur' => 'Mary Shelley', 'isbn' => '9782253046257'],
    ['titre' => 'Dracula', 'auteur' => 'Bram Stoker', 'isbn' => '9782253047209'],
    ['titre' => 'Le Fantôme de l\'Opéra', 'auteur' => 'Gaston Leroux', 'isbn' => '9782253046776'],
    ['titre' => 'Sherlock Holmes : Le Chien des Baskerville', 'auteur' => 'Arthur Conan Doyle', 'isbn' => '9782253045564'],
    ['titre' => 'L\'Étrange Cas du Dr Jekyll et Mr Hyde', 'auteur' => 'Robert Louis Stevenson', 'isbn' => '9782253046288'],
    ['titre' => 'Les Enfants du Capitaine Grant', 'auteur' => 'Jules Verne', 'isbn' => '9782253047858'],
    ['titre' => 'Vingt Mille Lieues sous les Mers', 'auteur' => 'Jules Verne', 'isbn' => '9782253048187'],
    ['titre' => 'Le Tour du Monde en Quatre-Vingts Jours', 'auteur' => 'Jules Verne', 'isbn' => '9782253047703'],
    ['titre' => 'La Machine à Remonter le Temps', 'auteur' => 'H.G. Wells', 'isbn' => '9782253046981'],
    ['titre' => 'L\'Homme Invisible', 'auteur' => 'H.G. Wells', 'isbn' => '9782253045175'],
    ['titre' => 'La Guerre des Mondes', 'auteur' => 'H.G. Wells', 'isbn' => '9782253047599'],
    ['titre' => 'Les Aventures de Tom Sawyer', 'auteur' => 'Mark Twain', 'isbn' => '9782253043669'],
    ['titre' => 'Les Aventures de Huckleberry Finn', 'auteur' => 'Mark Twain', 'isbn' => '9782253043454'],
    ['titre' => 'Anne aux Pignons Verts', 'auteur' => 'Lucy Maud Montgomery', 'isbn' => '9782253047513'],
    ['titre' => 'Le Magicien d\'Oz', 'auteur' => 'L. Frank Baum', 'isbn' => '9782253049739'],
    ['titre' => 'Robinson Crusoé', 'auteur' => 'Daniel Defoe', 'isbn' => '9782253048504'],
    ['titre' => 'Gulliver\'s Travels', 'auteur' => 'Jonathan Swift', 'isbn' => '9782253042525'],
    ['titre' => 'Stendhal : Le Rouge et le Noir', 'auteur' => 'Stendhal', 'isbn' => '9782253045908'],
    ['titre' => 'Balzac : La Peau de Chagrin', 'auteur' => 'Honoré de Balzac', 'isbn' => '9782253047148'],
    ['titre' => 'Flaubert : Madame Bovary', 'auteur' => 'Gustave Flaubert', 'isbn' => '9782253046301'],
    ['titre' => 'Zola : Germinal', 'auteur' => 'Émile Zola', 'isbn' => '9782253048047'],
    ['titre' => 'Maupassant : Le Horla', 'auteur' => 'Guy de Maupassant', 'isbn' => '9782253054269'],
    ['titre' => 'Daudet : Le Petit Chose', 'auteur' => 'Alphonse Daudet', 'isbn' => '9782253055434'],
    ['titre' => 'Sand : La Mare au Diable', 'auteur' => 'George Sand', 'isbn' => '9782253043683'],
    ['titre' => 'Lamartine : Graziella', 'auteur' => 'Alphonse de Lamartine', 'isbn' => '9782253043010'],
];

// Créer le dossier s'il n'existe pas
if(!is_dir('images/couvertures')){
    mkdir('images/couvertures', 0755, true);
}

$conn = connectDB();
$downloaded = 0;
$failed = 0;

echo "<h2>📥 Téléchargement des couvertures de livres</h2>";
echo "<p>Cela peut prendre quelques minutes...</p>";
echo "<hr>";

foreach($books_data as $index => $book){
    echo "<p>[$index] Récupération: <strong>" . htmlspecialchars($book['titre']) . "</strong>... ";
    
    // Nettoyer l'ISBN
    $isbn = preg_replace('/[^0-9]/', '', $book['isbn']);
    
    if(strlen($isbn) < 10){
        echo "ISBN invalide<br>";
        $failed++;
        continue;
    }
    
    // Utiliser Open Library API
    $api_url = "https://openlibrary.org/api/books?bibkeys=ISBN:" . $isbn . "&format=json";
    
    try {
        // Récupérer les données JSON
        $json = @file_get_contents($api_url);
        
        if(!$json){
            echo "Pas de réponse API<br>";
            $failed++;
            continue;
        }
        
        $data = json_decode($json, true);
        
        if(!$data){
            echo "JSON invalide<br>";
            $failed++;
            continue;
        }
        
        $cover_url = null;
        
        // Chercher l'URL de couverture
        foreach($data as $key => $book_data){
            if(isset($book_data['cover_url'])){
                $cover_url = $book_data['cover_url'];
                break;
            }
        }
        
        if(!$cover_url){
            echo "Pas de couverture trouvée<br>";
            $failed++;
            continue;
        }
        
        // Télécharger l'image
        $image_content = @file_get_contents($cover_url);
        
        if(!$image_content){
            echo "Erreur de téléchargement<br>";
            $failed++;
            continue;
        }
        
        // Déterminer l'extension
        $headers = get_headers($cover_url, 1);
        $content_type = $headers['Content-Type'] ?? 'image/jpeg';
        $ext = 'jpg';
        
        if(strpos($content_type, 'png') !== false){
            $ext = 'png';
        } elseif(strpos($content_type, 'webp') !== false){
            $ext = 'webp';
        }
        
        // Générer le nom de fichier
        $image_name = uniqid('cover_') . '.' . $ext;
        $image_path = 'images/couvertures/' . $image_name;
        
        // Sauvegarder l'image
        if(file_put_contents($image_path, $image_content)){
            // Mettre à jour la base de données
            $stmt = $conn->prepare("UPDATE livres SET image_couverture = ? WHERE titre = ? AND auteur = ?");
            $auteur = $book['auteur'];
            $titre = $book['titre'];
            $stmt->bind_param("sss", $image_name, $titre, $auteur);
            
            if($stmt->execute()){
                echo "✅ Sauvegardée<br>";
                $downloaded++;
            } else {
                echo "⚠️ Sauvegardée mais pas de mise à jour DB<br>";
                $downloaded++;
            }
            $stmt->close();
        } else {
            echo "❌ Erreur d'enregistrement<br>";
            $failed++;
        }
        
        // Attendre un peu pour ne pas surcharger l'API
        sleep(1);
        
    } catch(Exception $e){
        echo "❌ Erreur: " . $e->getMessage() . "<br>";
        $failed++;
    }
    
    // Rafraîchissement du navigateur
    flush();
}

$conn->close();

echo "<hr>";
echo "<h3>✅ Résultats</h3>";
echo "<p>Couvertures téléchargées: <strong>" . $downloaded . "</strong></p>";
echo "<p>Échecs: <strong>" . $failed . "</strong></p>";
echo "<p><a href='index.php'>← Retour à l'accueil</a></p>";
?>
