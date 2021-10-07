<h1>Contribution au projet ToDoList</h1>
ToDoList est un projet auquel tu peux contribuer. Ce document à été rédigé dans le but de t’informer sur les process de 
qualité et règles à respecter afin que le projet reste stable. 
    <ul>
        <li><a href="#directives">Directives de soumission</a></li>
        <li><a href="#regles">Règles à respecter</a></li>
    </ul>
<hr>

<h2>Directives de soumission</h2>
<h3>1. Installez le projet en local</h3>
Dans un premier temps il est important de récupérer et d’installer le projet en local afin d’y apporter les modifications 
nécessaires. Suivez les étapes de l'installation dans le fichier <a href="https://github.com/benjaminroche4/ToDoList/blob/master/README.md">README.md</a>.

<h3>2. Créez une issue</h3>
Rendez-vous dans l'onglet "Issues" du repository GitHub est cliquez sur "New issue". 
Donnez un titre clair et une description la plus précise possible de ce que vous souhaitez modifier ou developper. 
Cela permettra de suivre la nouvelle tâche et son avencement. 

<h3>3. Créez une nouvelle branche</h3>
À présent, créez une nouvelle branche pour votre contribution. Nommez la de façon claire afin de pouvoir s'y retrouver facilement
s'y possible en anglais. 
Par exemple : 
```
$ git checkout -b new-branch-name
```

<h3>4. Testez vos modifications</h3>
Lancez les tests unitaires afin de voir si ils fonctionnent toujours après vos modifications.
```
$ php bin/phpunit tests 
```
Si besoin mettez à jour les tests existants ou créez-en de nouveaux pour tester votre contribution.

<h3>5. Push et pull request</h3>
Pour finir, envoyez vos modifications sur le repoistory GitHub et créez une pull request. Si vos modifications sont acceptées 
alors elles seront deployées vers la branche principale et mise en production. 
<hr>

<h2>Règles à respecter</h2>
    <ul>
        <li>Votre code doit être commenté en anglais. Il doit être facile pour les prochains developpeurs de s'y retrouver.
        Utiliser des phrases concis pour décrire au mieux l'utilité.</li>
        <li>Indenter votre code la bonne manière. Prenez exemple sur les parties déjà developper.</li>
        <li>Pensez aux performances de l'application. Faites des requêtes qui permettront d'avoir les meilleurs résultats de requêtes.</li>
        <li>Respectez les bonnes pratiques PSR-1.</li> 
    </ul>

Vous êtes à présent prêt pour contribuer au projet ! 