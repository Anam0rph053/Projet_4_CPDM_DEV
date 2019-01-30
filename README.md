Projet 4 : Réalisation d'une billetterie pour le Musée du Louvre
=======

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/42b1e8032f4f47e5bab703645029c0ac)](https://app.codacy.com/app/Anam0rph053/Projet_4_CPDM_DEV?utm_source=github.com&utm_medium=referral&utm_content=Anam0rph053/Projet_4_CPDM_DEV&utm_campaign=Badge_Grade_Dashboard)

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
```
Usage
-----
Lancer cette commande pour pouvoir éxécuter l'application dans votre navigateur internet. 
```bash
#Lancer le server
$ php bin/console server:run
```
Tests
-----
```bash
#Lancer les test unitaires et fonctionnelles
$ php bin/console vendor/bin/phpunit
```



