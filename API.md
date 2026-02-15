# 🔌 API & Endpoints - Bibliothèque en Ligne

## 📋 Table des Matières

- [Pages Publiques](#pages-publiques)
- [Pages Authentifiées](#pages-authentifiées)
- [Endpoints de Traitement](#endpoints-de-traitement)
- [Structure des Réponses](#structure-des-réponses)

---

## 📖 Pages Publiques

### 1. Page d'Accueil
```
GET /index.php
```
**Description** : Affiche la page d'accueil avec liste des livres  
**Authentification** : Non requise  
**Paramètres** : Aucun  
**Réponse** : Page HTML

---

### 2. Page de Connexion
```
GET /connexion.html
```
**Description** : Formulaire de connexion  
**Authentification** : Non requise  
**Paramètres** : 
- `error` (optional) : Type d'erreur (invalid, empty, invalid_email)
- `success` (optional) : Message de succès (registered)

**Exemple** :
```
/connexion.html?success=registered
/connexion.html?error=invalid
```

---

### 3. Page d'Inscription
```
GET /inscription.html
```
**Description** : Formulaire d'inscription  
**Authentification** : Non requise  
**Paramètres** : Aucun  
**Réponse** : Page HTML

---

### 4. Détails du Livre
```
GET /details.php?id=[BOOK_ID]
```
**Description** : Affiche les détails complets d'un livre  
**Authentification** : Non requise (wishlist requiert authentification)  
**Paramètres** :
- `id` (required) : ID du livre (integer)
- `success` (optional) : Message de succès
- `error` (optional) : Message d'erreur

**Exemple** :
```
/details.php?id=1
/details.php?id=1&success=added
```

**Réponse** :
```html
- Affiche le livre avec image
- Affiche toutes les informations
- Boutons Ajouter/Retirer de wishlist (si connecté)
```

---

### 5. Résultats de Recherche
```
GET /traitement/resultat.php?search=[QUERY]
```
**Description** : Affiche les résultats de recherche  
**Authentification** : Non requise  
**Paramètres** :
- `search` (required) : Terme de recherche (string)

**Exemple** :
```
/traitement/resultat.php?search=Hugo
/traitement/resultat.php?search=roman
```

**Recherche sur** : titre, auteur, description, genre

---

### 6. Ajouter un Livre
```
GET /ajout_livre.html
```
**Description** : Formulaire pour ajouter un nouveau livre  
**Authentification** : Non requise  
**Réponse** : Page HTML avec formulaire

---

## 🔐 Pages Authentifiées

### 1. Ma Wishlist
```
GET /wishlist.php
```
**Description** : Affiche la liste de lecture personnelle  
**Authentification** : **REQUISE**  
**Paramètres** : 
- `success` (optional) : Message de succès (removed)
- `error` (optional) : Message d'erreur

**Redirection** : Si non connecté → `/connexion.html?error=login_required`

**Réponse** : Page HTML avec liste des livres de la wishlist

---

## 🔄 Endpoints de Traitement

### 1. Inscription (POST)
```
POST /traitement/traitement_inscription.php
```

**Description** : Crée un nouveau compte utilisateur  
**Authentification** : Non requise  
**Content-Type** : application/x-www-form-urlencoded

**Paramètres** :
```
nom (required, 2-100 chars)
prenom (required, 2-100 chars)
email (required, format email)
password (required, 8+ chars, 1 maj, 1 chiffre)
password_confirm (required, doit correspondre à password)
```

**Validation Côté Serveur** :
- ✅ Tous les champs remplis
- ✅ Format email valide
- ✅ Mot de passe fort
- ✅ Email non existant en base

**Réponse Succès** :
```
Redirection → /connexion.html?success=registered
```

**Réponse Erreur** :
```
Redirection → /inscription.html?error=[MESSAGE]
```

**Codes d'Erreur** :
- `invalid_method` : Méthode HTTP incorrecte
- `email_exists` : Email déjà utilisé
- `db_error` : Erreur base de données

---

### 2. Connexion (POST)
```
POST /traitement/traitement_login.php
```

**Description** : Authentifie un utilisateur  
**Authentification** : Non requise  
**Content-Type** : application/x-www-form-urlencoded

**Paramètres** :
```
email (required, format email)
password (required, string)
remember (optional, checkbox "remember me")
```

**Validation Côté Serveur** :
- ✅ Tous les champs remplis
- ✅ Email valide
- ✅ Email existe en base
- ✅ Mot de passe correct (password_verify)

**Réponse Succès** :
```
Crée session PHP avec:
- $_SESSION['user_id']
- $_SESSION['user_email']
- $_SESSION['user_nom']
- $_SESSION['user_prenom']
- $_SESSION['login_time']

Redirection → /index.php?success=login
```

**Réponse Erreur** :
```
Redirection → /connexion.html?error=[ERROR_TYPE]
```

**Codes d'Erreur** :
- `empty` : Champs vides
- `invalid_email` : Email invalide
- `invalid` : Email/mot de passe incorrect
- `inactive` : Compte désactivé

---

### 3. Ajouter un Livre (POST)
```
POST /traitement/traitement_livre.php
Content-Type: multipart/form-data
```

**Description** : Ajoute un nouveau livre avec upload d'image  
**Authentification** : Non requise (optionnel)

**Paramètres** :
```
titre (required, 2-255 chars)
auteur (required, 2-255 chars)
description (optional, max 5000 chars)
maison_edition (optional, max 255 chars)
nombre_exemplair (optional, 1-9999, default=1)
genre (optional, max 100 chars)
isbn (optional, max 20 chars)
date_publication (optional, format YYYY-MM-DD)
prix (optional, decimal)
image_couverture (optional, file: JPG/PNG/WebP, max 5MB)
```

**Validation Côté Serveur** :
- ✅ Titre et auteur présents
- ✅ Format date valide
- ✅ Type MIME image valide
- ✅ Taille fichier < 5MB
- ✅ Génération nom fichier sécurisé

**Upload** :
- Dossier : `/images/couvertures/`
- Nom : `livre_[uniqid]_[timestamp].[ext]`

**Réponse Succès** :
```
Redirection → /index.php?success=book_added&id=[BOOK_ID]
```

**Réponse Erreur** :
```
Redirection → /ajout_livre.html?error=[MESSAGE]
```

**Codes d'Erreur** :
- `invalid_method` : Méthode HTTP incorrecte
- `invalid_file_type` : Type d'image invalide
- `file_too_large` : Fichier > 5MB
- `upload_failed` : Échec de l'upload
- `db_error` : Erreur base de données
- `insert_failed` : Échec insertion DB

---

### 4. Gestion Wishlist (POST)
```
POST /traitement/traitement_wishlist.php
```

**Description** : Ajoute ou retire un livre de la wishlist  
**Authentification** : **REQUISE**  
**Content-Type** : application/x-www-form-urlencoded

**Paramètres** :
```
action (required) : "add" ou "remove"
livre_id (required, integer)
```

**Validation Côté Serveur** :
- ✅ Utilisateur connecté
- ✅ Livre existe
- ✅ Action valide

**Réponse Succès (Add)** :
```
Redirection → /details.php?id=[LIVRE_ID]&success=added
```

**Réponse Succès (Remove)** :
```
Redirection → /wishlist.php?success=removed
(ou /details.php?id=... si appelé depuis details)
```

**Réponse Erreur** :
```
Redirection → /index.php?error=[MESSAGE]
```

**Codes d'Erreur** :
- `login_required` : Utilisateur non connecté
- `invalid_method` : Méthode HTTP incorrecte
- `invalid_data` : Données manquantes/invalides
- `book_not_found` : Livre n'existe pas
- `add_failed` : Échec ajout wishlist
- `remove_failed` : Échec suppression wishlist

---

### 5. Déconnexion
```
GET /traitement/logout.php
```

**Description** : Déconnecte l'utilisateur  
**Authentification** : Recommandée (mais non stricte)

**Paramètres** : Aucun

**Actions** :
- Détruit la session PHP
- Supprime les cookies
- Redirection → `/connexion.html?logout=success`

---

## 📊 Structure des Réponses

### Réponses avec Sessions

**Après Login Réussi** :
```php
$_SESSION = [
    'user_id' => 1,
    'user_email' => 'user@example.com',
    'user_nom' => 'Dupont',
    'user_prenom' => 'Jean',
    'login_time' => 1674067200
];
```

### Structure Base de Données

#### Table `lecteurs` (Utilisateurs)
```json
{
    "id": 1,
    "nom": "Dupont",
    "prenom": "Jean",
    "email": "user@example.com",
    "mot_de_passe": "$2y$12$...", // BCrypt
    "date_inscription": "2024-01-19 10:30:00",
    "actif": true
}
```

#### Table `livres`
```json
{
    "id": 1,
    "titre": "Les Misérables",
    "auteur": "Victor Hugo",
    "description": "...",
    "maison_edition": "Actes Sud",
    "nombre_exemplair": 5,
    "image_couverture": "images/couvertures/livre_abc123_1705676400.jpg",
    "genre": "Roman historique",
    "isbn": "978-2-253-08970-6",
    "date_publication": "1862-01-01",
    "prix": "12.99",
    "date_ajout": "2024-01-19 10:30:00"
}
```

#### Table `wishlists`
```json
{
    "id": 1,
    "lecteur_id": 1,
    "livre_id": 5,
    "date_ajout": "2024-01-19 14:22:00"
}
```

---

## 🔒 Sécurité des Endpoints

### Validations Implémentées

| Endpoint | SQL Injection | XSS | CSRF | Auth |
|----------|--------------|-----|------|------|
| Login | ✅ Prepared Stmt | ✅ htmlspecialchars | - | N/A |
| Inscription | ✅ Prepared Stmt | ✅ sanitize() | - | N/A |
| Ajouter Livre | ✅ Prepared Stmt | ✅ sanitize() | - | - |
| Wishlist | ✅ Prepared Stmt | ✅ htmlspecialchars | - | ✅ Required |
| Recherche | ✅ Prepared Stmt | ✅ htmlspecialchars | - | N/A |

### Recommandations

1. **HTTPS en Production** : Utilisez HTTPS pour toutes les données sensibles
2. **CSRF Token** : Implémentez les tokens CSRF (future amélioration)
3. **Rate Limiting** : Limitez les tentatives de connexion
4. **Logs d'Audit** : Enregistrez les actions sensibles

---

## 🧪 Exemples cURL

### Inscription
```bash
curl -X POST http://localhost/db_bibliotheque/traitement/traitement_inscription.php \
  -d "nom=Dupont&prenom=Jean&email=test@example.com&password=TestPass123&password_confirm=TestPass123"
```

### Connexion
```bash
curl -X POST http://localhost/db_bibliotheque/traitement/traitement_login.php \
  -d "email=test@example.com&password=TestPass123" \
  -c cookies.txt
```

### Ajouter Livre
```bash
curl -X POST http://localhost/db_bibliotheque/traitement/traitement_livre.php \
  -F "titre=Mon Livre" \
  -F "auteur=Auteur" \
  -F "description=Description" \
  -F "nombre_exemplair=5" \
  -F "image_couverture=@couverture.jpg"
```

### Ajouter à Wishlist
```bash
curl -X POST http://localhost/db_bibliotheque/traitement/traitement_wishlist.php \
  -d "action=add&livre_id=1" \
  -b cookies.txt
```

---

**Dernière mise à jour** : 19 janvier 2026  
**Version** : 1.0.0
