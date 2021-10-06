<h1>ToDolist</h1>
<hr>
Amélioration d'une application existante de ToDo & Co.

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/5e14b5b898024ed0a9f52f72e5d09467)](https://www.codacy.com/gh/benjaminroche4/ToDoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=benjaminroche4/ToDoList&amp;utm_campaign=Badge_Grade)

<h2>Instalation du projet</h2>
<hr>

1. Cloner ou télécharger le repository GitHub dans le dossier voulu :

```
https://github.com/benjaminroche4/ToDoList.git
```

2. Télécharger les dépendances nécessaires à l'aide de composer :
```
$ composer install 
```

3. Configurer la connexion à la base de données dans le fichier ".env" à la racine du projet : 
```
DATABASE_URL="mysql://root:root@127.0.0.1:8889/db_name?serverVersion=13&charset=utf8"
```

4. Installer la base de données à l'aide des commandes suivantes dans votre terminal :
```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:migrate
```

5. Télécharger les fixtures :
```
$ php bin/console doctrine:fixtures:load
```

6. Lancez le serveur à l'aide du terminal de commande :
```
$ symfony server:start
```

Le projet est à présent prêt à être utilisé. 

<h2>Tests unitaires</h2>
<hr>
Pour faire fonctionner l'ensemble des tests unitaires utiliser la commande : 

```
$ php bin/phpunit tests 
```

<h2>Contribution</h2>
<hr>
Voir la documentation : <a href="#">CONTRIBUTING.md</a>.