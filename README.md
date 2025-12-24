
# TOUCHE PAS AU KLAXON

Application web interne de covoiturage inter-sites, développée en PHP selon une architecture MVC, sans framework.

---

## Contexte du projet

Dans une entreprise disposant de plusieurs implantations géographiques, de nombreux trajets sont réalisés quotidiennement entre les sites.  
Ces déplacements sont souvent effectués avec un faible taux de remplissage des véhicules.

L’objectif de cette application est de :
- diffuser les trajets planifiés au sein de l’entreprise,
- favoriser le covoiturage entre collaborateurs,
- réduire l’impact environnemental et optimiser les déplacements.

L’application est destinée à être déployée sur **l’intranet de l’entreprise**.

---

## Fonctionnalités principales

### Utilisateur non connecté
- Accès à la page d’accueil
- Consultation des trajets futurs disposant encore de places disponibles
- Accès au formulaire de connexion

### Utilisateur connecté
- Consultation détaillée des trajets (contact, places, horaires)
- Création d’un trajet
- Modification et suppression de ses propres trajets
- Accès à un tableau de bord utilisateur

### Administrateur
- Accès à un tableau de bord administrateur
- Liste des utilisateurs
- Gestion des agences (création, modification, suppression)
- Consultation et suppression de tous les trajets

---

## Architecture technique

Le projet respecte une **architecture MVC** sans framework.

### Structure
TOUCHE-PAS-AU-KLAXON/
│
├── .git/
│
├── app/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── HomeController.php
│   │   └── TripController.php
│   │
│   ├── Models/
│   │   ├── Agency.php
│   │   ├── Trip.php
│   │   └── User.php
│   │
│   └── Views/
│       ├── admin/
│       │   ├── agencies/
│       │   │   ├── edit.php
│       │   │   └── index.php
│       │   ├── dashboard.php
│       │   ├── trips.php
│       │   └── users.php
│       │
│       ├── auth/
│       │   └── login.php
│       │
│       ├── dashboard/
│       │   └── index.php
│       │
│       ├── home/
│       │   └── index.php
│       │
│       ├── layouts/
│       │   ├── flash.php
│       │   ├── footer.php
│       │   └── header.php
│       │
│       └── trips/
│           ├── create.php
│           └── edit.php
│
├── config/
│   ├── config.php
│   └── routes.php
│
├── core/
│   ├── Auth.php
│   ├── Controller.php
│   ├── Database.php
│   └── Router.php
│
├── database/
│   ├── schema.sql
│   └── seed.sql
│
├── docs/
│   └── mcd/
│       └── MCD_Touche_pas_au_klaxon.pdf
│
├── public/
│   ├── .htaccess
│   └── index.php
│
├── tools/
│   ├── db_test.php
│   └── hash.php
│
├── .gitignore
└── README.md


### MVC
Cette séparation permet une meilleure lisibilité du code, facilite la maintenance
et rend l’application facilement extensible dans le cadre de futurs projets intranet.
- **Models** : accès aux données via PDO
- **Views** : affichage HTML (sans logique métier)
- **Controllers** : logique applicative et routage

---

## Routage

- Router maison basé sur la combinaison : METHOD / path
- Normalisation du chemin dans `public/index.php`
- Dispatch final via :
    ```php
    $router->dispatch($path, $_SERVER['REQUEST_METHOD']);

### Exemple de flux de requête

Exemple : accès à la liste des trajets administrateur

1. Requête HTTP : GET /admin/trips
2. Passage par public/index.php
3. Router → AdminController::trips()
4. Appel du modèle Trip
5. Transmission des données à la vue admin/trips.php
6. Affichage via le layout global

---

## Sécurité

### Sessions
Les informations utilisateur sont stockées en session :
    ```php
    $_SESSION['user'] = [
    'id',
    'firstname',
    'lastname',
    'email',
    'phone',
    'role'
    ];
    
### Authentification & rôles
Fonctions disponibles dans core/Auth.php :
isLoggedIn()
currentUser()
currentUserId()
isAdmin()
requireLogin()
requireAdmin()
>> Aucune classe Auth:: n’est utilisée (helpers fonctionnels uniquement).

### Protection CSRF
Génération : csrfToken()
Vérification : verifyCsrfToken()
Champ utilisé dans tous les formulaires POST :
    ```html
    <input type="hidden" name="csrf" value="...">

###  Accès protégés
Pages utilisateur → requireLogin()
Pages admin → requireAdmin()

---

## Base de données

### Tables principales
- users
- agencies
- trips

### Champs clés (trips)
- author_id
- contact_id
- departure_agency_id
- arrival_agency_id
- departure_at
- arrival_at
- total_seats
- available_seats

### Contraintes
- Clés étrangères
- Contraintes de cohérence métier
- ON DELETE RESTRICT
- Timestamps

Les scripts sont disponibles dans :
- database/schema.sql
- database/seed.sql

---

## Installation locale

### Prérequis
- PHP ≥ 8.1
- MySQL ou MariaDB
- Serveur local (XAMPP / MAMP / WAMP)
- Git

### Étapes
1.  Cloner le dépôt :
git clone https://github.com/SarahDbrn/touche-pas-au-klaxon.git

2. Importer la base de données :
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql

3. Configurer la connexion DB :
config/config.php

4. Démarrer le serveur local

5. Accéder à l’application :
http://localhost/touche-pas-au-klaxon/public

---

## Comptes de test

### Administrateur
Email : admin@tpak.local
Mot de passe : Password123!

### Utilisateur
Email : alex@tpak.local
Mot de passe : Password123!

---

## Documentation

- MCD : docs/mcd/MCD_Touche_pas_au_klaxon.pdf
- Scripts SQL : dossier database/
- Code commenté (DocBlock)

---

## Outils & bonnes pratiques
- PDO avec requêtes préparées
- Validation des données serveur
- Gestion des erreurs
- Séparation stricte des responsabilités
- Versioning Git

---

## Auteure
Projet réalisé par Sarah Debruyne
Dans le cadre d’un devoir pédagogique PHP / MVC.

---

## Licence
Projet pédagogique – usage académique uniquement.

---