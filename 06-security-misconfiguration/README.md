# Security Misconfiguration

:bookmark_tabs: Mode d'emploi :

## Désactivation du Directory Listing/Browsing

1.  Rendez-vous à l'URI `/06-security-misconfiguration/directory-listing`. Quelles informations y trouvez vous ? La fonctionnalité que vous venez de découvrir, qui est très souvent activée par défaut, est appelée le **Direcory Listing** (ou parfois **Directory Browsing**) et donne la possibilité aux utilisateurs d'une application web d'afficher le contenu d'un répertoire présent sur le serveur. Même si cette fonctionnalité peut être utile dans certains cas précis (par exemple lister un ensemble de fichiers téléchargeables pour l'utilisateur), elle constitue un problème de sécurité dans la plupart des cas. En effet, il n'est par exemple pas souhaitable de lister les fichiers de configuration présents sur le serveur.

2.  Dans le dossier `06-security-misconfiguration/directory-listing`, ouvrez le fichier appelé `.htaccess`. Les fichiers `.htaccess` fournissent une méthode pour modifier la configuration du serveur au niveau de chaque répertoire.

3.  Dans ce fichier, ajoutez une ligne :

    ```
    # Désactivation du directory listing
    Options -Indexes
    ```

4.  Retournez sur la page `/06-security-misconfiguration/directory-listing`. Les fichiers sont-ils listés ? Si la réponse est non, bravo :tada: ! Vous venez de désactiver le **Directory Listing** dans ce répertoire. Sinon, recommencez l'étape 2 et 3.

## Masquage de l'utilisation de PHP

1.  Rendez-vous à l'URI `/06-security-misconfiguration/hide-php`, vous remarquerez que des informations sur la version de PHP sont exposées. De plus, sur chaque requête effectuée sur le serveur, une entête de réponse HTTP `X-Powered-By : PHP/<version de php>` est renvoyée, ce qui donne de précieuses informations sur le serveur. Cela ne constitue pas de risque direct de sécurité en soi, mais permet potentiellement d'exposer une version de PHP désuette (et possiblement vulnérable) qui peut être une invitation à une potentielle attaque.

2.  Voyons comment configurer PHP de manière plus sécurisée. Trouvez le fichier `php.ini` puis faites-en une copie de manière à avoir une backup d'une configuration standard. Ouvrez le fichier `php.ini`. Trouvez la ligne `expose_php` et remplacez **True** par **False**. Redémarrez le serveur et retournez sur la page `/06-security-misconfiguration/hide-php`. L'utilisation de PHP devrait être masquée.

3.  Rendez-vous à l'URI `/06-security-misconfiguration/hide-php/hello_world.php`. :warning: Même si l'utilisation de PHP est masquée, nos pages web ont comme extension... **PHP** ! Voyons comment il est possible de masquer ces extensions, ou même de les remplacer par quelque chose de totalement différent. Ouvrez le fichier `.htaccess` dans le dossier `hide-php`. Ajoutez les lignes suivantes.

    ```
    # Activation du moteur de réécriture
    RewriteEngine on

    # Réécriture de l'URI /ressource/index.php vers /ressource/index
    RewriteRule ^([^.?]+)$ %{REQUEST_URI}.php [L]

    # Retourne une erreur 404 si la ressource demandée termine par .php
    RewriteCond %{THE_REQUEST} "^[^ ]* .*?\.php[? ].*$"
    RewriteRule .* - [L,R=404]
    ```

4.  Rendez-vous à l'URI `/06-security-misconfiguration/hide-php/hello_world.php` et vérifiez que l'erreur retournée est bien une erreur 404 (Not Found). La page `/06-security-misconfiguration/hide-php/hello_world` devrait afficher "**Hello world!**". :tada: ! Vous venez de masquer l'utilisation de PHP sur le serveur.

## Authentification côté Apache

1. Voyons comment il est possible de protéger des fichiers/répertoires sur le serveur avec un mot de passe. Rendez-vous à l'URI `/06-security-misconfiguration/authentication/protected/info.php`. Le fichier PHP présenté n'a qu'une instruction : `phpinfo();`. Cela permet d'afficher de nombreuses informations sur PHP, concernant sa configuration courante : options de compilation, extensions, version, informations sur le serveur... Il s'agit d'un très bon outil de débogage mais il n'est **absolument pas souhaitable** qu'une personne extérieure ait accès à ce fichier.

2. Dans le fichier `.htaccess` du dossier `authentication`, ajoutez les instructions suivantes en vérifiant la justesse du chemin du fichier .htpasswd :

   ```
   AuthType Basic
   AuthName "Zone protégée"
   # Cette ligne indique l'emplacement l'emplacement du fichier .htpasswd
   AuthUserFile "C:/xampp/htdocs/06-security-misconfiguration/authentication/protected/.htpasswd"
   require valid-user
   ```

3. Dans le fichier `authentication/protected/.htpasswd`, ajoutez les lignes suivantes :

   ```
   john_doe:$2y$10$Iqa0pEUXr2j4PhKGS2XHxOA9.Jx5uGs/XQQ.7rPKsPj9NSpX2yKKa
   ```

4. :tada: Bravo ! Nous venons d'indiquer au fichier `.htaccess` la présence d'un dossier protégé. Les informations de connexion permettant d'accéder au dossier `protected` sont situées dans le fichier `.htpasswd`. Ici, nous venons d'ajouter l'utilisateur **john_doe** avec comme mot de passe **Authentication\$John2020**.

5. Vérifiez le bon fonctionnement de l'authentification en retournant sur la page `/06-security-misconfiguration/authentication/protected/info.php`.

## Masquage des erreurs PHP

1. Les messages d'erreurs PHP peuvent montrer peuvent contenir des informations sur la structure interne de l'application Web, il est vivement recommandé de ne jamais les afficher sur le serveur en production. Rendez vous sur la page `/06-security-misconfiguration/hide-errors/error_script.php`.

2. Dans le dossier `hide-errors`, ouvrez le fichier `.htaccess` et ajoutez la ligne suivante :

   ```
   php_flag display_errors off
   ```

   Il est également possible de modifier cette option dans le fichier php.ini, ce qui est recommandé dans une utilisation réelle.

3. Retournez sur la page `/06-security-misconfiguration/hide-errors/error_script.php` et vérifiez que l'erreur n'est plus affichée. :tada: Bravo ! Vous avez réussi à masquer les erreurs de PHP.

4. Nous n'avons masqué que les erreurs de PHP, nous avons toujours laissé les erreurs HTML, les erreurs de démarrage, les erreurs de log, il est bien-entendu possible de les masquer également.
