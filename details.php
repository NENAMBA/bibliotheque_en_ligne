<?php
session_start();
require_once "./config/database.php";

initializeDatabase();

// Récupérer l'ID du livre
$livre_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($livre_id <= 0){
    header("Location: index.php");
    exit();
}

// Récupérer les détails du livre
$conn = connectDB();
$stmt = $conn->prepare("SELECT * FROM livres WHERE id = ?");
$stmt->bind_param("i", $livre_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}

$book = $result->fetch_assoc();
$stmt->close();

// Vérifier si le livre est dans la wishlist
$in_wishlist = false;
if(isLoggedIn()){
    $stmt = $conn->prepare("SELECT id FROM wishlists WHERE lecteur_id = ? AND livre_id = ?");
    $stmt->bind_param("ii", $_SESSION['user_id'], $livre_id);
    $stmt->execute();
    $in_wishlist = $stmt->get_result()->num_rows > 0;
    $stmt->close();
}

$conn->close();

$is_logged_in = isLoggedIn();
$user_name = isset($_SESSION['user_prenom']) ? $_SESSION['user_prenom'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['titre']); ?> - BiblioApp</title>
    <link rel="stylesheet" href="CSS/pro-dark.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header-container">
        <div class="logo">BiblioApp</div>
        
        <nav class="nav">
            <div class="nav-right">
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

<!-- DETAIL SECTION -->
<div class="container">
    <div class="detail-container" style="margin-top: 3rem;">
        <div class="detail-grid">
            <div class="detail-image">
                <?php if(!empty($book['image_couverture']) && file_exists("images/couvertures/" . $book['image_couverture'])): ?>
                    <img src="images/couvertures/<?php echo htmlspecialchars($book['image_couverture']); ?>" alt="<?php echo htmlspecialchars($book['titre']); ?>">
                <?php else: ?>
                    📖
                <?php endif; ?>
            </div>
            
            <div class="detail-info">
                <h1><?php echo htmlspecialchars($book['titre']); ?></h1>
                <p class="detail-author">par <?php echo htmlspecialchars($book['auteur']); ?></p>
                
                <div class="detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Genre</span>
                        <span class="meta-value"><?php echo htmlspecialchars($book['genre'] ?? 'Non spécifié'); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Maison d'Édition</span>
                        <span class="meta-value"><?php echo htmlspecialchars($book['maison_edition'] ?? 'Non spécifiée'); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">ISBN</span>
                        <span class="meta-value"><?php echo htmlspecialchars($book['isbn'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Exemplaires</span>
                        <span class="meta-value"><?php echo htmlspecialchars($book['nombre_exemplair'] ?? 1); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Date Publication</span>
                        <span class="meta-value"><?php echo htmlspecialchars($book['date_publication'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Prix</span>
                        <span class="meta-value"><?php echo htmlspecialchars($book['prix'] ?? '0'); ?>€</span>
                    </div>
                </div>
                
                <div class="detail-description">
                    <h3 style="margin-bottom: 1rem; color: var(--text-primary);">Description</h3>
                    <p><?php echo htmlspecialchars($book['description'] ?? 'Pas de description disponible'); ?></p>
                </div>
                
                <div class="detail-actions">
                    <?php 
                    // Vérifier si le PDF existe
                    $has_pdf = !empty($book['pdf_file']) && file_exists("pdfs/" . $book['pdf_file']);
                    ?>
                    
                    <?php if($has_pdf): ?>
                        <div style="display: flex; gap: 0.5rem; flex: 1;">
                            <a href="lecture.php?id=<?php echo $livre_id; ?>&action=read" class="btn-wishlist" style="flex: 1; text-align: center; text-decoration: none; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                                📖 Lire le PDF
                            </a>
                            <a href="lecture.php?id=<?php echo $livre_id; ?>&action=download" class="btn-wishlist" style="flex: 1; text-align: center; text-decoration: none; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);">
                                ⬇️ Télécharger
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($is_logged_in): ?>
                        <form method="POST" action="traitement/traitement_wishlist.php" style="flex: 1;">
                            <input type="hidden" name="livre_id" value="<?php echo $livre_id; ?>">
                            <input type="hidden" name="action" value="<?php echo $in_wishlist ? 'remove' : 'add'; ?>">
                            <button type="submit" class="btn-wishlist <?php echo $in_wishlist ? 'added' : ''; ?>">
                                <?php echo $in_wishlist ? '❤️ Retirer de ma liste' : '🤍 Ajouter à ma liste'; ?>
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="connexion.html" class="btn-wishlist" style="display: flex; align-items: center; justify-content: center; text-decoration: none; flex: 1;">
                            🔐 Se connecter pour ajouter
                        </a>
                    <?php endif; ?>
                    <a href="index.php" class="btn-back">← Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-content">
        <p class="footer-text">© 2026 BiblioApp - Bibliothèque Digitale Professionnelle</p>
    </div>
</footer>

</body>
</html>






