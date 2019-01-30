Projet 4 : Réalisation d'une billetterie pour le Musée du Louvre
=======

A Symfony project created on November 18, 2018, 4:52 pm.

Installation
------------

```bash
#cloner le projet existant.
$ cd projects.
$ git clone https://github.com/Anam0rph053/Projet_4_CPDM_DEV.git

#installer les dépendances
$ cd my_project_name/
$ composer install

#Mettre en place la Base de données
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update

#Lancer le server
$ php bin/console server:run

#Lancer les test unitaires et fonctionnelles
$ php bin/console vendor/bin/phpunit
```



