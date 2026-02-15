# ⚡ Démarrage Rapide - Bibliothèque en Ligne

## 🚀 En 3 Étapes

### Étape 1: Démarrer les Services
```bash
# Démarrez XAMPP (ou votre serveur local)
# 1. Ouvrez XAMPP Control Panel
# 2. Démarrez "Apache"
# 3. Démarrez "MySQL"
```

### Étape 2: Accédez au Site
```
URL: http://localhost/db_bibliotheque/
```

### Étape 3: Commencez à Utiliser
1. **Première visite** → Cliquez sur "Inscription"
2. **Créez un compte** → Remplissez le formulaire
3. **Connectez-vous** → Accédez à votre compte
4. **Explorez les livres** → Cherchez, consultez les détails
5. **Construisez votre wishlist** → Ajoutez vos livres favoris

## 📚 Fonctionnalités Principales

| Fonction | Comment y accéder |
|----------|------------------|
| 🏠 Accueil | Cliquez sur "📚 Bibliothèque" |
| 📖 Tous les livres | Faites défiler la page d'accueil |
| 🔍 Rechercher | Utilisez la barre de recherche |
| 📝 Inscription | Bouton "Inscription" en haut |
| 🔐 Connexion | Bouton "Connexion" en haut |
| ➕ Ajouter un livre | Bouton "+ Ajouter un livre" |
| ❤️ Ma Wishlist | Accessible après connexion |
| 📄 Détails du livre | Cliquez sur "Détails" sur un livre |

## 🎯 Scénarios d'Utilisation

### Je suis un Visiteur
1. Cliquez sur "Inscription"
2. Créez votre compte avec un email et mot de passe
3. Connectez-vous
4. Explorez les livres
5. Ajoutez vos livres favoris à votre wishlist

### Je suis un Administrateur
1. Allez dans "Admin" en haut
2. Ou cliquez sur "+ Ajouter un livre"
3. Remplissez les informations du livre
4. Uploadez la couverture
5. Cliquez "Ajouter le livre"

## ⚙️ Configuration Minimale

**Fichier à vérifier** : `config/database.php`

```php
define('DB_HOST', 'localhost');    // ✅ Correct
define('DB_USER', 'root');         // ✅ Correct (XAMPP défaut)
define('DB_PASS', '');             // ✅ Correct (XAMPP défaut)
define('DB_NAME', 'db_bibliotheque'); // ✅ Doit exister
```

**Si vous changez les identifiants MySQL**, mettez à jour ces valeurs.

## 🐛 Problèmes Courants

### "Impossible de se connecter à la base de données"
```bash
# Solution:
# 1. Vérifiez que MySQL est démarré dans XAMPP
# 2. Vérifiez les identifiants dans config/database.php
# 3. Assurez-vous que la base de données 'db_bibliotheque' existe
```

### "L'image n'a pas pu être uploadée"
```bash
# Solution:
# 1. Vérifiez que le dossier 'images/couvertures/' existe
# 2. Vérifiez les permissions (755)
# 3. Utilisez un fichier JPG, PNG ou WebP
# 4. Vérifiez que le fichier fait moins de 5MB
```

### "Erreur 404 - Página no encontrada"
```bash
# Solution:
# Assurez-vous que l'URL est correcte:
# http://localhost/db_bibliotheque/
#
# Et NON:
# http://localhost/db_bibliotheque/index.php
```

## 🔐 Données de Test

Vous pouvez utiliser ces données pour tester:

**Compte de test:**
- Email: `demo@test.com`
- Mot de passe: `DemoPass123`

**Créez le compte en:**
1. Cliquez "Inscription"
2. Remplissez avec les données ci-dessus
3. Acceptez les conditions

## 📖 Documentation Complète

Pour la documentation technique complète, consultez [README.md](README.md)

Pour le guide de test détaillé, consultez [TESTING.md](TESTING.md)

## ✅ Vérification d'Installation

Visitez cette URL pour vérifier que tout fonctionne:

```
http://localhost/db_bibliotheque/
```

Vous devriez voir:
- ✅ En-tête avec logo "📚 Bibliothèque"
- ✅ Hero section avec message de bienvenue
- ✅ Boutons "Inscription" et "Connexion"
- ✅ Section "Nos livres disponibles"
- ✅ Barre de recherche
- ✅ Footer avec copyright

## 🆘 Besoin d'Aide ?

1. **Consultez README.md** pour les détails techniques
2. **Consultez TESTING.md** pour tester les fonctionnalités
3. **Vérifiez les logs PHP** : `/var/log/apache2/error.log`
4. **Contactez l'administrateur** pour les problèmes de serveur

---

**Prêt à explorer la bibliothèque ?** 📚✨

Cliquez sur [Accueil](index.php) pour commencer!
