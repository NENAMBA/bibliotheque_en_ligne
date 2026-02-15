# 🧪 Guide de Test - Bibliothèque en Ligne

## Accès au Site

**URL** : http://localhost/db_bibliotheque/

## 📋 Checklist de Test

### 1. **Page d'Accueil (index.php)**
- [ ] Vérifier que le header s'affiche correctement
- [ ] Vérifier la hero section avec boutons
- [ ] Vérifier que les livres s'affichent en grille (s'il y en a)
- [ ] Vérifier la barre de recherche
- [ ] Vérifier le footer
- [ ] Tester sur mobile (responsive design)

### 2. **Inscription (inscription.html)**
- [ ] Accès via bouton "Inscription"
- [ ] Validation côté client :
  - [ ] Champs vides → message d'erreur
  - [ ] Nom < 2 caractères → erreur
  - [ ] Email invalide → erreur
  - [ ] Mot de passe < 8 caractères → erreur
  - [ ] Pas de majuscule dans mot de passe → erreur
  - [ ] Pas de chiffre dans mot de passe → erreur
  - [ ] Mots de passe ne correspondent pas → erreur
- [ ] Inscription valide → redirection vers connexion avec message
- [ ] Tester doublon d'email → erreur "email déjà utilisé"

### 3. **Connexion (connexion.html)**
- [ ] Accès via bouton "Connexion"
- [ ] Email/mot de passe invalides → erreur "Email ou mot de passe incorrect"
- [ ] Email valide, mot de passe invalide → erreur
- [ ] Connexion valide → redirection vers index.php avec session
- [ ] Vérifier que le header affiche le prénom de l'utilisateur
- [ ] Vérifier le bouton "Déconnexion"

### 4. **Ajouter un Livre (ajout_livre.html)**
- [ ] Accès via bouton "+ Ajouter un livre"
- [ ] Validation côté client :
  - [ ] Titre vide → erreur
  - [ ] Auteur vide → erreur
  - [ ] Image > 5MB → erreur
  - [ ] Image format invalide (ex: .txt) → erreur
- [ ] Ajout valide :
  - [ ] Tous les champs remplis
  - [ ] Image JPG/PNG uploadée
  - [ ] Redirection vers index.php avec message succès
  - [ ] Vérifier que le livre apparaît dans la grille

### 5. **Détails du Livre (details.php?id=X)**
- [ ] Accès via bouton "Détails" sur un livre
- [ ] Affichage correct de la couverture
- [ ] Affichage correct des infos (titre, auteur, description, etc.)
- [ ] Affichage du stock disponible
- [ ] Affichage du prix (s'il existe)
- [ ] Genre affiché en badge
- [ ] Bouton "Ajouter à ma wishlist" visible et fonctionnel (si connecté)
- [ ] Bouton "Retirer de ma wishlist" affiché si déjà dans wishlist
- [ ] Bouton "Retour" fonctionne
- [ ] Page accessible sans connexion (affichage "Se connecter pour ajouter")

### 6. **Recherche (traitement/resultat.php)**
- [ ] Recherche par titre → résultats corrects
- [ ] Recherche par auteur → résultats corrects
- [ ] Recherche par genre → résultats corrects
- [ ] Recherche vide → aucun résultat ou tous les livres
- [ ] Recherche inexistante → message "Aucun résultat trouvé"
- [ ] Compteur de résultats correct
- [ ] Bouton "Détails" sur chaque résultat fonctionne

### 7. **Wishlist (wishlist.php)**
- [ ] Accès via "Ma Wishlist" dans le header (si connecté)
- [ ] Affichage "Wishlist vide" si aucun livre
- [ ] Affichage des livres ajoutés
- [ ] Compteur de livres correct
- [ ] Bouton "Détails" fonctionne
- [ ] Bouton "Retirer" fonctionne
- [ ] Suppression dans wishlist → message succès

### 8. **Déconnexion (traitement/logout.php)**
- [ ] Clic sur "Déconnexion"
- [ ] Session détruite
- [ ] Redirection vers connexion
- [ ] Vérifier que les boutons "Inscription/Connexion" sont visibles
- [ ] Vérifier que "Ma Wishlist" n'est plus visible

### 9. **Responsive Design**
- [ ] Desktop (1920px) : ✅ OK
- [ ] Tablette (768px) : Vérifier grille, header, texte
- [ ] Mobile (375px) : Vérifier tous les éléments

### 10. **Performance et Sécurité**
- [ ] Injection SQL (test) : Entrez `' OR '1'='1` → Ne fonctionne pas
- [ ] XSS (test) : Entrez `<script>alert('xss')</script>` → Échappé correctement
- [ ] Temps de chargement : < 2 secondes
- [ ] Images de couverture chargent correctement

## 📝 Données de Test

### Utilisateur Test 1
```
Email: test@email.com
Mot de passe: TestPassword123
Nom: Dupont
Prénom: Jean
```

### Utilisateur Test 2
```
Email: alice@email.com
Mot de passe: AlicePass456
Nom: Martin
Prénom: Alice
```

### Livre Test
```
Titre: Les Misérables
Auteur: Victor Hugo
Description: Un chef-d'œuvre de la littérature française
Genre: Roman historique
ISBN: 978-2-253-08970-6
Prix: 12.99 €
Exemplaires: 5
```

## 🔍 Scénarios de Test Avancés

### Scénario 1: Complet (Nouvel utilisateur)
1. Accédez à la page d'accueil
2. Cliquez sur "Inscription"
3. Remplissez le formulaire avec les données du test
4. Cliquez sur "Créer mon compte"
5. Vérifiez que vous êtes redirigé vers connexion
6. Connectez-vous avec le nouvel email/mot de passe
7. Vérifiez le message de succès et votre prénom dans le header
8. Ajoutez un nouveau livre
9. Recherchez ce livre
10. Cliquez sur détails
11. Ajoutez-le à votre wishlist
12. Accédez à votre wishlist
13. Vérifiez que le livre y est
14. Retirez-le de la wishlist
15. Vérifiez qu'il a été retiré
16. Cliquez sur déconnexion

### Scénario 2: Validation des Données
1. Tentez de vous inscrire avec un email invalide → Erreur
2. Tentez de vous connecter avec un email inexistant → Erreur
3. Tentez d'ajouter un livre sans titre → Erreur
4. Tentez d'ajouter un livre avec une image trop volumineuse → Erreur
5. Tentez de vous inscrire avec un mot de passe faible → Erreur

### Scénario 3: Sécurité
1. Tentez une injection SQL dans la barre de recherche
2. Tentez une injection XSS
3. Essayez d'accéder à wishlist.php sans être connecté
4. Essayez de modifier l'URL pour accéder à une wishlist d'un autre utilisateur

## 📊 Critères d'Acceptation

- ✅ Tous les champs de formulaire se valident correctement
- ✅ Les images s'uploadent et s'affichent
- ✅ La recherche fonctionne sur tous les critères
- ✅ La wishlist persiste en base de données
- ✅ Les sessions gèrent correctement l'authentification
- ✅ Le design est responsive sur tous les écrans
- ✅ Aucune erreur PHP dans les logs
- ✅ Aucune vulnérabilité SQL injection détectée
- ✅ Aucune vulnérabilité XSS détectée

## 🐛 Rapport de Bugs

Si vous trouvez un bug, notez:
- **Étapes à reproduire**
- **Comportement attendu**
- **Comportement réel**
- **Navigateur et version**
- **Mobile/Desktop**

## ✅ Conclusion du Test

Tous les tests réussis = ✅ **Prêt pour la production**

---

**Date du test** : [À remplir]  
**Testeur** : [À remplir]  
**Résultats** : [À remplir]
