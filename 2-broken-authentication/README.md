# Broken Authentication

## Credential stuffing avec Selenium (**Node.js**).

[Comment prévenir le credential stuffing](https://cheatsheetseries.owasp.org/cheatsheets/Credential_Stuffing_Prevention_Cheat_Sheet.html)

Le credential stuffing est un type de cyberattaque où des informations de comptes volées consistant généralement en des listes d'identifiants et les mots de passe associés (souvent obtenus de manière frauduleuse) sont utilisés pour obtenir un accès non autorisé à des comptes utilisateurs par le biais de demandes de connexion automatisée à grande échelle adressées à des applications Web1.

Contrairement au cassage de mot de passe, une attaque de credential stuffing ne tente pas de trouver un mot de passe par une attaque par force brute. L'attaquant automatise plutôt des tentatives de connexions en utilisant de milliers ou même de millions de paires d'identifiants / mots de passe précédemment découverts.

Selenium est projet englobant un éventail d’outils et de librairies permettant l’automtisation des navigateurs internet.

Ouvrez un terminal dans le dossier `attaquant`. L'application `credentialStuffing` est un script qui va simuler une multitude de connexions sur notre site internet. Il va, suivant un nom d'utilisateur donné, tester à la chaîne des centaines de mots de passe parmi une liste des mots de passe les plus fréquemments utilisés.

0. Ajoutez [geckodriver](https://github.com/mozilla/geckodriver/releases) aux variables d'environnement PATH de la machine.

1. Installez les dépendances nécessaires grâce à la commande ci-dessous.

```
$ npm install
```

2. Lancez le script pour l'utilisateur **brokenauth**. Si tout se passe bien, vous devriez découvrir son mot de passe.

```
$ node credentialStuffing.js --username <username>
```
