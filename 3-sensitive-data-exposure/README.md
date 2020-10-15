# To be completed.

:loudspeaker: Prérequis :

0. Vérifier que les informations de connexion vers la base de données sont correctes dans le fichier `models/Database.php`.
1. Créer les tables de la base de données, grâce au fichier `sql/create.sql`.

:bookmark_tabs: Mode d'emploi :

1. Rendez-vous sur la page `no-hash/index.php`. Il s'agit d'un formulaire d'inscription permettant de créer un nouvel utilisateur pour l'application et de l'ajouter dans la base de données. Créez l'utilisateur **john_doe_no_hash** ayant pour mot de passe **CroSS-SitE\$NoHash2020**.
2. Jetez un oeil à la table `USERS` de la base de données. L'utilisateur **john_doe_no_hash** devrait y avoir été ajouté.
3. Quelle remarque pouvons-nous faire sur le mot de passe ? Que se passe-t'il si les informations de la base de données fuitent ?
4. Il existe une méthode permettant d'éviter que des informations sensibles (mots de passe, informations bancaires, etc...) soient enregistrées "en clair". Ainsi, on peut faire appel à des fonctions de **hachage**. Il s'agit de fonctions qui, à partir d'une donnée d'entrée, calcule une empreinte numérique qui permet d'identifier une ressource. On peut ainsi comparer ceci à la signature d'une personne.
5. Afin de sécuriser un peu plus notre application, nous allons "hacher" notre mot de passe afin qu'il n'apparaisse pas en clair dans la base de données. Au moment de la connexion, au lieu de vérifier que le mot de passe entré par l'utilisateur est le même que le mot de passe en clair dans la base, nous allons vérifier que les **hash** des deux mots de passe sont les mêmes.
6. Rendez-vous sur la page `md5/index.php`. Il s'agit d'un formulaire semblable à celui de la première question, à une exception près, le mot de passe est haché avant d'être stocké en base de données. Vérifiez le bon fonctionnement du formulaire, le mot de passe en base de données devrait être une suite de chiffres et de lettres bien différents du mot de passe initial. Créez un nouvel utilisateur, **john_doe_md5** avec un mot de passe simple : **abricot**.
7. :warning: Attention ! L'algorithme **MD5** est **TOTALEMENT déprécié**. Cette fonction a été créée en 1991 et a connu plusieurs failles graves, ce qui en fait une fonction de hachage **à bannir**, bien qu'elle soit parfois encore utilisée. On peut, par exemple, utiliser des [Rainbow Tables](https://fr.wikipedia.org/wiki/Rainbow_table), des structures de données qui permettent de retrouver un mot de passe à partir de son hash.
8. Rendez-vous sur le site [md5decrypt.net](https://md5decrypt.net/) et essayez de retrouver votre mot de passe initial en entrant le hash qui a été ajouté dans la base de données.
9. Voyons comment utiliser une méthode plus sécurisée. Réitérons l'expérience avec la page `password-hash/index.php`. Ce script va hacher le mot de passe de l'utilisateur avant de le mettre dans la base de données, mais c'est PHP qui va choisir l'algorithme le plus adapté, grâce à la fonction [password_hash](https://www.php.net/manual/fr/function.password-hash.php). Depuis PHP 5.5.0, l'algorithme utilisé est [bcrypt](https://fr.wikipedia.org/wiki/Bcrypt). 

```php
// Pour hacher un mot de passe
$hash = password_hash('mon_mot_de_passe', PASSWORD_DEFAULT);
// Pour vérifier qu'un mot de passe en clair est le même qu'un mot de passe haché
$egal = password_verify('mon_mot_de_passe', $mot_de_passe_haché);
```

10. :exclamation: password_hash va également ajouter un [grain de sel](https://fr.wikipedia.org/wiki/Salage_(cryptographie)) au hash. C'est une méthode qui renforce la sécurité des données hachées en y ajoutant une donnée supplémentaire afin d’empêcher que deux informations identiques conduisent à la même empreinte. Cela permet de lutter contre différentes attaques comme par exemple les attaques par Rainbow Tables. On notera tout de même que la meilleure fâçon de prévenir ces attaques est d'utiliser un mot de passe fort.
