# Injection

## Injection SQL

Pour cette preuve de concept, deux utilisateurs seront mobilisés :

- **john_doe**, dont le mot de passe est **CroSS-SitE\$John2020**
- **super_jane**, dont le mot de passe est **CroSS-SitE\$Jane2020**

:bookmark_tabs: Scénario :

Nous allons nous mettre dans la peau de **john_doe** qui aura le rôle de l'attaquant. Son but est de se connecter sur le compte d'un admin de son entreprise qui est super_jane.
Comme beaucoup de personne, john_doe connaît l'identifiant de l'admin qui est souvent sur le même modèle que les identifiants des compte utilisateurs lambda. C'est-à-dire soit une adresse mail (celle de l'entreprise) ou bien c'est tout simplement "admin" ou "super_admin".

Pour pouvoir atteindre son objectif, john va utiliser l'**injection SQL** car il se doute que le portail d'authentification n'est pas très sécurisé.

1. Connectez-vous au compte de **john_doe** pour vérifier que tout fonctionne bien.
2. Déconnectez-vous et essayer de vous connecter au compte administrateur de super_jane. Bien sûr sans son mot de passe il est impossible de s'y connecter.
3. Sachant que l'instruction SQL qui permet l'authentification est du format ci-dessous, essayez d'effectuer une injection SQL. Essayez de trouver une instruction à saisir dans le champ de l'identifiant permettant de rendre le mot de passe facultatif. _Indice -> utilisez les caractère '#' ou '--' permettant d'écrire un commentaire en SQL_.

```sql
# Ceci est un commentaire
-- Ceci est un autre commentaire
SELECT username FROM Users WHERE username = 'username' AND pass = 'password';
```

4. Une fois l'injection trouvée, saisissez là et connectez-vous au compte administrateur de super_jane.
5. :tada: Bravo vous avez réussi !

Bonus : Sur le même schéma, essayer de supprimer l'utilisateur bob de la base de données.

Bien sûr cet exemple est très basique mais permet de comprendre ce genre de faille et les potentiels dégâts qu'elle peut engendrer.

## Injection Eval

`eval` est une fonction PHP permettant d'exécuter une chaîne de caractères en tant que code PHP. Par exemple, les deux codes présentés ci-dessous font la même chose.

```php
eval('$array = array()');
// fait la même chose que
$array = array();
```

Il faut être extrêmement vigilant lorsqu'on utilise cette fonction, il faut être sûr que la chaîne de caractères qui va être exécutée est sûre.

:bookmark_tabs: Scénario :

Voyons comment il est possible d'exécuter du code malveillant en exploitant l'**injection eval**.

1. Rendez-vous sur la page `calculatrice.php`. Le principe est assez simple, l'utilisateur entre une expression mathématique dans un champ prévu à cet effet. Lorsque le formulaire est envoyé, l'expression, reçue sous la forme d'une chaîne de caractères, est exécutée en tant que code PHP et est affectée à une variable. Examinez le contenu du fichier afin d'en comprendre le fonctionnement.
2. Vérifiez le bon fonctionnement de la page en calculant l'expression `3*2 - 5`.
3. Quelle expression PHP permet de calculer la puissance d'un nombre ? Modifier le calcul précedent afin d'ajouter 2 à la puissance 5 en utilisant la fonction trouvée. Le calcul devrait ressembler à ceci : `3*2 - 5 + <expression PHP>`.
4. Vous l'aurez compris, il est possible d'exploiter ce fonctionnement afin d'exécuter du code malveillant sur le serveur.
5. Validez le formulaire avec comme valeur de calcul : `1+1; echo "<h1>Ce site n'est pas sécurisé</hi>"`. Que se passe t'il ?
6. L'expression précédente exploite la faille que nous présentons mais l'attaque n'est pas comprométente pour le serveur. Essayez maintenant d'exécuter `phpinfo()` après un calcul banal. Quelles informations pouvez-vous voir ?
7. :collision: phpinfo() apporte de nombreuses informations sur le serveur PHP, qui pourraient être utilisées à des fins malveillantes si elles tombaient entre de mauvaises mains. C'est pourquoi la fonction `phpinfo()` ne doit jamais être utilisé sur un site publié en production ! Bien qu'elle permette d'apporter des informations pour des attaques futures, elle n'attaque pas le serveur directement. Voyons comment aller plus loin en attaquant le serveur directement.
8. Essayez de modifier le fichier `calculatrice.php` en exploitant l'injection `eval`. Faites que l'instruction `echo "Le fichier a été modifié";` soit ajoutée à la fin du fichier `calculatrice.php`.

```php
# Indice
file_put_contents('<nom_du_fichier>', '<contenu>', FILE_APPEND | LOCK_EX);
```

9. Vous l'aurez compris, il est possible de modifier n'importe quel fichier sur le serveur afin d'en modifier le contenu. Toute fonction PHP peut ainsi être exécutée de manière non contrôlée (ajout/supression de fichiers/répertoires, exécution de commandes SHELL, accès au code source de l'application PHP, ...).
10. Affichez le code source de la page `connexion.php` en utilisant le formulaire de la calculatrice. _Indice : Affichez le contenu dans une balise `<xmp>`, cela permettra de ne pas inteprêter le contenu HTML du fichier_.

```php
# Indice
echo '<xmp>' . file_get_contents('<nom_du_fichier>') . '</xmp>';
```

11. :warning: (peut être risqué) Tuez le processus Apache. La fonction [shell_exec](https://www.php.net/manual/fr/function.shell-exec.php) permet d'exécuter une commande via le Shell et retourne le résultat sous forme de chaîne de caractères.

- Avec Windows et Xampp :

  Grâce à la fonction présentée ci-dessus et au formulaire de la calculatrice, listez les processus qui écoutent le port 80 sur le serveur grâce à la commande `netstat -ano | findstr :<numéro_de_port>`. Vous devriez trouver l'identifiant (**PID**) du processus ayant l'état **LISTENING** sur le port 80. Maintenant, vous devriez pouvoir tuer le processus (httpd.exe) qui correspond au serveur Apache / PHP et ainsi rendre le site **totalement inutilisable** grâce à la commande `taskkill /PID <identifiant_de_processus>`.

:tada: Félicitations, vous venez d'effectuer une attaque DDoS sur le serveur.

Vous l'aurez compris, l'**injection eval** est extrêmement dangereuse et est l'entrée pour pléthores d'attaques informatiques. Les points qui ont été présentés ne sont qu'une infime partie des possibilités offertes par cette faille.
