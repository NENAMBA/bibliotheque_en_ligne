<?php
session_start();
require_once "./config/database.php";

initializeDatabase();

$conn = connectDB();
$books = [];
$stmt = $conn->prepare("SELECT id, titre, auteur, description, image_couverture, genre, prix FROM livres ORDER BY date_ajout DESC LIMIT 12");

if($stmt === false){
    die("Erreur de préparation: " . $conn->error);
}

if(!$stmt->execute()){
    die("Erreur d'exécution: " . $stmt->error);
}

$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}
$stmt->close();
$conn->close();

$user_name = isset($_SESSION['user_prenom']) ? $_SESSION['user_prenom'] : '';
$is_logged_in = isLoggedIn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Digitale - Accueil</title>
    <link rel="stylesheet" href="CSS/pro-dark.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header-container">
        <div class="logo">BiblioApp</div>
        
        <nav class="nav">
            <div class="nav-right">
                <a href="ajout_livre.html" class="btn-login" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border-color: #2ecc71; text-decoration: none;">📚 Ajouter un Livre</a>
                
                <?php if($is_logged_in): ?>
                    <div class="user-info">
                        <span>👤 <?php echo htmlspecialchars($user_name); ?></span>
                        <a href="wishlist.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">❤️ Ma Liste</a>
                    </div>
                    <form method="POST" action="traitement/logout.php" style="margin: 0;">
                        <button type="submit" class="btn-logout">Déconnexion</button>
                    </form>
                <?php else: ?>
                    <a href="connexion.html" class="btn-login">Connexion</a>
                    <a href="inscription.html" class="btn-register">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Explorez votre Bibliothèque</h1>
        <p class="hero-subtitle">Découvrez, sauvegardez et gérez vos livres préférés</p>
        
        <form method="GET" action="traitement/resultat.php" class="hero-search">
            <input 
                type="text" 
                name="search" 
                placeholder="Chercher un livre, auteur..."
                required
            >
            <button type="submit">🔍</button>
        </form>
    </div>
</section>

<!-- LIVRES SECTION -->
<div class="container">
    <section class="section">
        <h2 class="section-title">Livres Récemment Ajoutés</h2>
        
        <?php if(empty($books)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📚</div>
                <div class="empty-state-text">Aucun livre disponible pour le moment</div>
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
                                <a href="details.php?id=<?php echo $book['id']; ?>" class="book-btn">Détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-content">
        <p class="footer-text">© 2026 BiblioApp - Bibliothèque Digitale Professionnelle</p>
        <div class="footer-links">
            <a href="#about">À Propos</a>
            <a href="#contact">Contact</a>
            <a href="#privacy">Confidentialité</a>
            <a href="#terms">Conditions</a>
        </div>
        <p class="footer-text" style="font-size: 0.9rem; margin-top: 1rem;">
            Créé avec ❤️ pour les amoureux de lecture
        </p>
    </div>
</footer>

</body>
</html>
