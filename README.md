# Book Store

Ceci est une application Symfony d'entrainement proposant
une e-commerce pour vendre des livres entre particulier.

## Installation

1. Télécharger et extraire le projet, ou bien
   utiliser `git clone`

2. Installer les dépendences avec `composer install`

3. Configurer votre base de données dans le fichier
   `.env`

4. Créer votre base de données : `symfony console doctrine:database:create`

5. Mettre en place le schéma : `symfony console doctrine:schema:update --force`

6. Installer les fixtures dans la base de données : `symfony console hautelook:fixtures:load`

7. Démarrer le server : `symfony console server:start`
