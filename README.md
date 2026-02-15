# 📚 Bibliothèque en Ligne - Documentation Complète

## 🎯 Vue d'ensemble

**Bibliothèque en ligne** est une application web professionnelle et élégante permettant aux utilisateurs de découvrir, ajouter et gérer leur collection personnelle de livres. Le site offre une expérience utilisateur optimisée avec un système d'authentification sécurisé, une gestion complète des livres, et une wishlist personnalisée.

## 🚀 Fonctionnalités Principales

### 1. **Authentification Sécurisée**
- ✅ Inscription avec validation des données
- ✅ Connexion avec vérification email/mot de passe
- ✅ Hashage sécurisé des mots de passe (BCrypt)
- ✅ Gestion des sessions PHP
- ✅ Fonction "Se souvenir de moi"

### 2. **Gestion des Livres**
- ✅ Affichage élégant des livres avec couverture (images uploadables)
- ✅ Détails complets : titre, auteur, description, genre, ISBN, prix, date de publication
- ✅ Ajout de nouveaux livres avec upload d'image de couverture
- ✅ Recherche avancée (titre, auteur, description, genre)
- ✅ Grille responsive de livres

### 3. **Wishlist (Liste de Lecture)**
- ✅ Ajouter/retirer des livres à sa wishlist personnelle
- ✅ Affichage dédié des livres favoris
- ✅ Gestion sécurisée avec authentification requise

### 4. **Design Professionnel**
- ✅ Interface élégante avec palette marron/or (#8B6F47, #D4A574)
- ✅ Design responsive (mobile, tablette, desktop)
- ✅ Animations fluides et transitions
- ✅ Page d'accueil avec hero section
- ✅ Navigation intuitive

## 📁 Structure du Projet

```
db_bibliotheque/
├── config/
│   └── database.php              # Configuration DB + fonctions utiles
├── traitement/
│   ├── traitement_login.php      # Traitement de la connexion
│   ├── traitement_inscription.php # Traitement de l'inscription
│   ├── traitement_livre.php      # Ajout de livres + upload images
│   ├── traitement_wishlist.php   # Gestion wishlist
│   ├── resultat.php              # Résultats de recherche
│   └── logout.php                # Déconnexion
├── images/
│   └── couvertures/              # Dossier des images de couvertures
├── CSS/
│   ├── style.css                 # Styles principaux
│   └── livres.css                # Styles alternatifs
├── recuperation/
│   └── recuperation_livre.php     # (Fichier non utilisé)
├── admin/
│   └── livre.php                 # Panel admin
├── index.php                     # Page d'accueil
├── connexion.html                # Page de connexion
├── inscription.html              # Page d'inscription
├── details.php                   # Détails d'un livre
├── wishlist.php                  # Liste de lecture personnelle
├── ajout_livre.html              # Formulaire ajout livre
└── README.md                     # Cette documentation
```

## 🔐 Sécurité Implémentée

1. **SQL Injection Prevention**
   - Utilisation de Prepared Statements
   - Paramètres liés (bind_param)

2. **Authentification**
   - Password hashing avec BCrypt (password_hash)
   - Vérification avec password_verify
   - Sessions PHP sécurisées

3. **Validation des Données**
   - Validation côté client (HTML5)
   - Validation côté serveur (PHP)
   - Sanitization des données

4. **Upload de Fichiers**
   - Validation du type MIME
   - Limite de taille (5MB)
   - Noms de fichiers sécurisés (uniqid)

5. **XSS Protection**
   - htmlspecialchars() pour l'affichage
   - Échappement des données

## 📊 Base de Données

### Tables Créées

#### `livres`
```sql
CREATE TABLE livres (
    id INT PRIMARY KEY AUTO_INCREMENT,
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
);
```

#### `lecteurs` (Utilisateurs)
```sql
CREATE TABLE lecteurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actif BOOLEAN DEFAULT TRUE
);
```

#### `wishlists`
```sql
CREATE TABLE wishlists (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lecteur_id INT NOT NULL,
    livre_id INT NOT NULL,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lecteur_id) REFERENCES lecteurs(id) ON DELETE CASCADE,
    FOREIGN KEY (livre_id) REFERENCES livres(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wish (lecteur_id, livre_id)
);
```

## 🚀 Installation et Configuration

### 1. **Prérequis**
- PHP 7.4 ou supérieur
- MySQL/MariaDB
- XAMPP ou serveur local équivalent

### 2. **Installation**

```bash
# 1. Cloner/placer le projet dans htdocs
cp -r db_bibliotheque /xampp/htdocs/

# 2. Configurer la base de données
# - Modifier config/database.php si nécessaire
# - Les tables sont créées automatiquement au premier accès

# 3. Accéder à l'application
# http://localhost/db_bibliotheque/
```

### 3. **Initialisation Automatique**
La fonction `initializeDatabase()` dans `config/database.php` :
- Crée les tables si elles n'existent pas
- Ajoute les colonnes manquantes
- Corrige les typos dans les noms de colonnes

## 📖 Guide d'Utilisation

### Pour les Visiteurs
1. Accédez à la page d'accueil
2. **Créer un compte** : Cliquez sur "Inscription"
   - Entrez nom, prénom, email, mot de passe (8+ caractères, majuscule, chiffre)
3. **Se connecter** : Cliquez sur "Connexion"
4. **Explorer les livres** : Consultez la grille des livres disponibles
5. **Rechercher** : Utilisez la barre de recherche
6. **Voir détails** : Cliquez sur "Détails" pour voir les infos complètes
7. **Gérer la wishlist** : Ajouter/retirer des livres à votre liste de lecture

### Pour les Administrateurs
1. Accédez à **Espace Admin**
2. Ajouter des livres : Cliquez sur "+ Ajouter un livre"
   - Remplissez tous les champs
   - Uploadez une couverture (JPG, PNG, WebP)
   - Cliquez "Ajouter le livre"
3. Voir les livres : La page admin affiche tous les livres disponibles

## 🎨 Palette de Couleurs

- **Primaire** : #8B6F47 (Marron)
- **Secondaire** : #D4A574 (Or)
- **Texte** : #333333
- **Arrière-plan** : #F5F5F5
- **Erreur** : #C33333
- **Succès** : #33CC33

## ⚙️ Fonctionnalités Techniques

### Sessions
- Stockage en $_SESSION
- Informations stockées : user_id, user_email, user_nom, user_prenom
- Vérification avec isLoggedIn()

### Upload d'Images
- Dossier destination : `images/couvertures/`
- Formats acceptés : JPEG, PNG, WebP
- Taille maximale : 5MB
- Validation MIME type

### Recherche
- Recherche par : titre, auteur, description, genre
- Requête préparée pour sécurité
- Résultats dynamiques avec pagination

## 🔧 Fichiers Importants

### `config/database.php`
- Fonctions :
  - `connectDB()` : Connexion à la DB
  - `initializeDatabase()` : Création/migration des tables
  - `sanitize()` : Nettoyage des données
  - `isLoggedIn()` : Vérification de connexion
  - `requireLogin()` : Redirection si non connecté

### `traitement/traitement_login.php`
- Vérification email/mot de passe
- Création de session
- Gestion du cookie "Se souvenir de moi"

### `traitement/traitement_inscription.php`
- Validation des données
- Vérification email en doublon
- Hashage du mot de passe
- Insertion en base de données

### `traitement/traitement_livre.php`
- Validation des données du livre
- Upload sécurisé de l'image
- Insertion en base de données
- Gestion des erreurs

### `traitement/traitement_wishlist.php`
- Vérification authentification
- Ajout/suppression de la wishlist
- Gestion des erreurs

## 🐛 Dépannage

### "Erreur : Base de données non connectée"
- Vérifier que MySQL est démarré
- Vérifier les identifiants dans `config/database.php`

### "L'image n'a pas pu être uploadée"
- Vérifier les permissions du dossier `images/couvertures/`
- Vérifier le format et la taille du fichier

### "Email déjà utilisé"
- Utilisez un autre email pour l'inscription
- Ou effectuez une réinitialisation de mot de passe (à implémenter)

## 🚀 Améliorations Futures

- [ ] Récupération de mot de passe oublié
- [ ] Système de notation/commentaires
- [ ] Catégories et tags pour les livres
- [ ] Recommandations personnalisées
- [ ] Export wishlist (PDF, email)
- [ ] Intégration paiement
- [ ] Notifications utilisateur
- [ ] Dashboard statistiques
- [ ] Modération contenu
- [ ] API REST

## 📝 Licence

Ce projet est créé à titre éducatif.

## 👥 Contact

Pour toute question ou suggestion, veuillez contacter l'administrateur du site.

---

**Version** : 1.0.0  
**Dernière mise à jour** : 19 janvier 2026  
**Statut** : ✅ Production Ready
