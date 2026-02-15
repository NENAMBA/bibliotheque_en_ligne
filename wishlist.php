<?php
session_start();
require_once "./config/database.php";

// Vérifier authentification
if(!isLoggedIn()){
    header("Location: connexion.html");
    exit();
}

initializeDatabase();

// Récupérer la wishlist de l'utilisateur
$conn = connectDB();
$stmt = $conn->prepare("
    SELECT l.id, l.titre, l.auteur, l.description, l.image_couverture, l.genre, l.prix
    FROM wishlists w
    JOIN livres l ON w.livre_id = l.id
    WHERE w.lecteur_id = ?
    ORDER BY w.date_ajout DESC
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$books = [];
while($row = $result->fetch_assoc()){
    $books[] = $row;
}

$stmt->close();
$conn->close();

$user_name = isset($_SESSION['user_prenom']) ? $_SESSION['user_prenom'] : '';
$book_count = count($books);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Liste de Lecture - BiblioApp</title>
    <link rel="stylesheet" href="CSS/pro-dark.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header-container">
        <div class="logo">BiblioApp</div>
        
        <nav class="nav">
            <div class="nav-right">
                <div class="user-info">
                    <span>👤 <?php echo htmlspecialchars($user_name); ?></span>
                    <a href="index.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">🏠 Accueil</a>
                </div>
                <form method="POST" action="traitement/logout.php" style="margin: 0;">
                    <button type="submit" class="btn-logout">Déconnexion</button>
                </form>
            </div>
        </nav>
    </div>
</header>

<!-- WISHLIST SECTION -->
<div class="wishlist-container">
    <div class="wishlist-header">
        <h1 class="wishlist-title">❤️ Ma Liste de Lecture</h1>
        <p class="wishlist-count">
            <?php 
            if($book_count === 0){
                echo "Aucun livre sauvegardé";
            } elseif($book_count === 1){
                echo "1 livre sauvegardé";
            } else {
                echo $book_count . " livres sauvegardés";
            }
            ?>
        </p>
    </div>
    
    <?php if(empty($books)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">📚</div>
            <div class="empty-state-text">Votre liste de lecture est vide</div>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">
                Explorez notre bibliothèque et ajoutez vos livres préférés
            </p>
            <a href="index.php" class="empty-state-link">Découvrir les livres</a>
        </div>
    <?php else: ?>
        <div class="books-grid">
            <?php foreach($books as $book): ?>
                <div class="book-card">
                    <div class="book-image">
                        <?php if(!empty($book['image_couverture']) && file_exists("images/couvertures/" . $book['image_couverture'])): ?>
                            <img src="images/couvertures/<?php echo htmlspecialchars($book['image_couverture']); ?>" alt="<?php echo htmlspecialchars($book['titre']); ?>">
                        <?php else: ?>
                            <div class="book-image no-image">📖</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="book-info">
                        <h3 class="book-title"><?php echo htmlspecialchars($book['titre']); ?></h3>
                        <p class="book-author"><?php echo htmlspecialchars($book['auteur']); ?></p>
                        <p class="book-description"><?php echo htmlspecialchars(substr($book['description'] ?? '', 0, 80)) . '...'; ?></p>
                        
                        <div class="book-footer">
                            <span class="book-price"><?php echo htmlspecialchars($book['prix'] ?? '0') . '€'; ?></span>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="details.php?id=<?php echo $book['id']; ?>" class="book-btn" style="flex: 1; text-align: center; text-decoration: none;">Voir</a>
                                <form method="POST" action="traitement/traitement_wishlist.php" style="flex: 1;">
                                    <input type="hidden" name="livre_id" value="<?php echo $book['id']; ?>">
                                    <input type="hidden" name="action" value="remove">
                                    <button type="submit" class="book-btn" style="width: 100%;">Retirer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-content">
        <p class="footer-text">© 2026 BiblioApp - Bibliothèque Digitale Professionnelle</p>
    </div>
</footer>

</body>
</html>
