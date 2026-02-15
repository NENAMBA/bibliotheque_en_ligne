<?php
session_start();
require_once "../config/database.php";

initializeDatabase();

// Récupérer le terme de recherche
$search_term = isset($_GET['search']) ? sanitize($_GET['search']) : '';

if(empty($search_term)){
    header("Location: ../index.php");
    exit();
}

// Rechercher dans la base de données
$conn = connectDB();
$search_pattern = '%' . $search_term . '%';

$stmt = $conn->prepare("
    SELECT id, titre, auteur, description, image_couverture, genre, prix
    FROM livres
    WHERE titre LIKE ? 
       OR auteur LIKE ? 
       OR description LIKE ? 
       OR genre LIKE ?
    ORDER BY titre ASC
");

$stmt->bind_param("ssss", $search_pattern, $search_pattern, $search_pattern, $search_pattern);
$stmt->execute();
$result = $stmt->get_result();

$books = [];
while($row = $result->fetch_assoc()){
    $books[] = $row;
}

$stmt->close();
$conn->close();

$is_logged_in = isLoggedIn();
$user_name = isset($_SESSION['user_prenom']) ? $_SESSION['user_prenom'] : '';
$book_count = count($books);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats : <?php echo htmlspecialchars($search_term); ?> - BiblioApp</title>
    <link rel="stylesheet" href="../CSS/pro-dark.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header-container">
        <div class="logo">BiblioApp</div>
        
        <nav class="nav">
            <a href="../index.php" style="color: var(--text-primary); text-decoration: none; margin-right: auto;">← Retour</a>
            <div class="nav-right">
                <?php if($is_logged_in): ?>
                    <div class="user-info">
                        <span>👤 <?php echo htmlspecialchars($user_name); ?></span>
                        <a href="../wishlist.php" style="color: var(--accent); text-decoration: none; font-weight: 600;">❤️ Ma Liste</a>
                    </div>
                    <form method="POST" action="../traitement/logout.php" style="margin: 0;">
                        <button type="submit" class="btn-logout">Déconnexion</button>
                    </form>
                <?php else: ?>
                    <a href="../connexion.html" class="btn-login">Connexion</a>
                    <a href="../inscription.html" class="btn-register">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<!-- SEARCH RESULTS SECTION -->
<div class="container">
    <section class="section">
        <div style="margin-bottom: 2rem;">
            <h2 class="section-title">
                🔍 Résultats de recherche
            </h2>
            <p style="color: var(--text-secondary); font-size: 1.1rem;">
                Recherche : <strong style="color: var(--accent);"><?php echo htmlspecialchars($search_term); ?></strong>
            </p>
            <p style="color: var(--text-secondary); margin-top: 0.5rem;">
                <?php 
                if($book_count === 0){
                    echo "Aucun résultat trouvé";
                } elseif($book_count === 1){
                    echo "1 livre trouvé";
                } else {
                    echo $book_count . " livres trouvés";
                }
                ?>
            </p>
        </div>
        
        <?php if(empty($books)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <div class="empty-state-text">Aucun livre ne correspond à votre recherche</div>
                <p style="color: var(--text-secondary); margin-bottom: 2rem;">
                    Essayez avec d'autres mots-clés
                </p>
                <a href="../index.php" class="empty-state-link">Retour à l'accueil</a>
            </div>
        <?php else: ?>
            <div class="books-grid">
                <?php foreach($books as $book): ?>
                    <div class="book-card">
                        <div class="book-image">
                            <?php if(!empty($book['image_couverture']) && file_exists("../images/couvertures/" . $book['image_couverture'])): ?>
                                <img src="../images/couvertures/<?php echo htmlspecialchars($book['image_couverture']); ?>" alt="<?php echo htmlspecialchars($book['titre']); ?>">
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
                                <a href="../details.php?id=<?php echo $book['id']; ?>" class="book-btn">Détails</a>
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
    </div>
</footer>

</body>
</html>
