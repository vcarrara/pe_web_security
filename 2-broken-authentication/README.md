# Broken Authentication

Le credential stuffing est un type de cyberattaque où des informations de comptes volées consistant généralement en des listes d'identifiants et les mots de passe associés (souvent obtenus de manière frauduleuse) sont utilisés pour obtenir un accès non autorisé à des comptes utilisateurs par le biais de demandes de connexion automatisée à grande échelle adressées à des applications Web.

Contrairement au cassage de mot de passe, une attaque de credential stuffing ne tente pas de trouver un mot de passe par une attaque par force brute. L'attaquant automatise plutôt des tentatives de connexions en utilisant de milliers ou même de millions de paires d'identifiants / mots de passe précédemment découverts.

Voici les [mots de passe les moins sécurisés](https://github.com/danielmiessler/SecLists/tree/master/Passwords) par SecLists, un organisme qui fournit un ensemble de listes de mots de passe faibles et/ou très fréquemment utilisés dans le but de tester la sécurité d'applications.

[Comment prévenir le credential stuffing](https://cheatsheetseries.owasp.org/cheatsheets/Credential_Stuffing_Prevention_Cheat_Sheet.html)

## Credential stuffing avec Ajax (**Node.js**).

Il est possible d'envoyer un certain nombre de requêtes HTTP vers notre script de connexion, en essayant un large nombre de mot de passe parmis les plus utilisés. On envoie ainsi plusieurs centaines de requêtes **POST** vers notre script avec pour chaque appel un mot de passe fréquemment utilisé différent. Si la connexion échoue, rien ne se passe, mais si la connexion réussit, une redirection est envoyée vers la page `index.php`, ce qui se traduit par un code HTTP 302. Ce code de réponse 302, lorsqu'il est interpellé par le navigateur, se traduit par une requête GET automatique vers la redirection, c'est ce qu'il a fallu simuler dans le script.

Ouvrez un terminal dans le dossier `attaquant/ajax`. L'application `credentialStuffing` est un script qui va simuler une multitude de connexions sur notre site internet via des appels ajax POST.

:bookmark_tabs: Mode d'emploi :

1. Installez les dépendances nécessaires grâce à la commande ci-dessous.

```
$ npm install
```

2. Lancez le script pour l'utilisateur **brokenauth**. Si tout se passe bien, vous devriez découvrir son mot de passe.

```
$ node credentialStuffing.js --username <username>
```

## Credential stuffing avec Selenium (**Node.js**).

Selenium est projet englobant un éventail d’outils et de librairies permettant l’automtisation des navigateurs internet.

Ouvrez un terminal dans le dossier `attaquant/selenium`. L'application `credentialStuffing` est un script qui va simuler une multitude de connexions sur notre site internet. Il va, suivant un nom d'utilisateur donné, tester à la chaîne des centaines de mots de passe parmi une liste des mots de passe les plus fréquemments utilisés.

:loudspeaker: Prérequis :

- Ajoutez [geckodriver](https://github.com/mozilla/geckodriver/releases) aux variables d'environnement PATH de la machine.

:bookmark_tabs: Mode d'emploi :

1. Installez les dépendances nécessaires grâce à la commande ci-dessous.

```
$ npm install
```

2. Lancez le script pour l'utilisateur **brokenauth**. Si tout se passe bien, vous devriez découvrir son mot de passe.

```
$ node credentialStuffing.js --username <username>
```
