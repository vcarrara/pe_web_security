# Security Misconfiguration

:wrench: Fichiers de configuration :

_Il est vivement recommandé d'effectuer des sauvegardes de ces fichiers avant de les modifier_.

- Le fichier de configuration du Serveur HTTP Apache est **httpd.conf**. Il est possible de modifier la configuration du serveur au niveau de chaque répertoire grace aux fichiers **.htaccess**.

- Le fichier de configuration de PHP est **php.ini**.

:bookmark_tabs: Mode d'emploi :

## Désactivation du Directory Listing/Browsing

1.  Rendez-vous à l'URI `/06-security-misconfiguration/directory-listing`. Quelles informations y trouvez vous ? La fonctionnalité que vous venez de découvrir, qui est très souvent activée par défaut, est appelée le **Directory Listing** (ou parfois **Directory Browsing**) et donne la possibilité aux utilisateurs d'une application web d'afficher le contenu d'un répertoire présent sur le serveur. Même si cette fonctionnalité peut être utile dans certains cas précis (par exemple lister un ensemble de fichiers téléchargeables pour l'utilisateur), elle constitue un problème de sécurité dans la plupart des cas. En effet, il n'est par exemple pas souhaitable de lister les fichiers de configuration présents sur le serveur.

2.  Dans le dossier `06-security-misconfiguration/directory-listing`, ouvrez le fichier appelé `.htaccess`. Les fichiers `.htaccess` fournissent une méthode pour modifier la configuration du serveur au niveau de chaque répertoire.

3.  Dans ce fichier, ajoutez une ligne :

    ```
    # Désactivation du directory listing
    Options -Indexes
    ```

4.  Retournez sur la page `/06-security-misconfiguration/directory-listing`. Les fichiers sont-ils listés ? Si la réponse est non, bravo :tada: ! Vous venez de désactiver le **Directory Listing** dans ce répertoire. Sinon, recommencez l'étape 2 et 3.

## Masquage de l'utilisation de PHP

1. Rendez-vous à l'URI `/06-security-misconfiguration/hide-php`, vous remarquerez que de nombreuses informations sur la version de PHP et d'Apache sont exposées.

2. Rendez-vous à l'URI `/06-security-misconfiguration/hide-php/hello_world.php`. Grâce à votre navigateur, examinez les entêtes (headers) qui sont renvoyés par le serveur avec le fichier **hello_world.php**.

   Avec Chrome ou Firefox :

   - <kbd>F12</kbd>
   - Network
   - Raffraichissez la page ou <kbd>Ctrl</kbd>+<kbd>R</kbd>
   - Sélectionnez le fichier hello_world.php
   - **Response Headers**

   Vous devriez voir plusieurs entêtes de réponse HTTP dont deux particulières :

   - `X-Powered-By`, avec comme valeur PHP et sa version.
   - `Server`, avec comme valeur Apache et sa version, le sytème d'exploitation associé, PHP et sa version.

   Ces informations donnent de précieuses informations sur le serveur. Cela ne constitue pas de risque direct de sécurité en soi, mais permet potentiellement d'exposer une version de PHP ou d'Apache désuette (et possiblement vulnérable) qui peut être une invitation à une potentielle attaque.

3. Voyons comment configurer PHP de manière plus sécurisée. Trouvez le fichier `php.ini` puis faites-en une copie de manière à avoir une backup d'une configuration standard. Ouvrez le fichier `php.ini`. Trouvez la ligne `expose_php` et remplacez **True** par **False** (ou **On** par **Off** selon la valeur). Redémarrez le serveur et retournez sur la page `/06-security-misconfiguration/hide-php`. L'utilisation de PHP devrait être masquée et l'entête `X-Powered-By` devrait ne plus être renvoyée.

4. Il est également possible de masquer l'utilisation du serveur Apache en modifiant le fichier `httpd.conf`. Ajoutez les lignes suivantes à la fin du fichier :

   ```
   # Masquage de la version d'Apache
   ServerTokens Prod
   # Désactivation de la signature serveur
   ServerSignature Off
   ```

   Allez sur la page `/06-security-misconfiguration/hide-php`, l'utilisation d'Apache devrait également être masquée. De plus, l'entête `Server` ne devrait renvoyer que `Apache`.

5. Rendez-vous à l'URI `/06-security-misconfiguration/hide-php/hello_world.php`. :warning: Même si l'utilisation de PHP est masquée, nos pages web ont comme extension... **PHP** ! Voyons comment il est possible de masquer ces extensions, ou même de les remplacer par quelque chose de totalement différent. Ouvrez le fichier `.htaccess` dans le dossier `hide-php`. Ajoutez les lignes suivantes.

   ```
   # Activation du moteur de réécriture
   RewriteEngine on

   # Réécriture de l'URI /ressource/index.php vers /ressource/index
   RewriteRule ^([^.?]+)$ %{REQUEST_URI}.php [L]

   # Retourne une erreur 404 si la ressource demandée termine par .php
   RewriteCond %{THE_REQUEST} "^[^ ]* .*?\.php[? ].*$"
   RewriteRule .* - [L,R=404]
   ```

6. Rendez-vous à l'URI `/06-security-misconfiguration/hide-php/hello_world.php` et vérifiez que l'erreur retournée est bien une erreur 404 (Not Found). La page `/06-security-misconfiguration/hide-php/hello_world` devrait afficher "**Hello world!**". :tada: ! Vous venez de masquer l'utilisation de PHP sur le serveur.

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

1. Les messages d'erreurs PHP peuvent montrer peuvent contenir des informations sur la structure interne de l'application web, il est vivement recommandé de ne jamais les afficher sur le serveur en production. Rendez vous sur la page `/06-security-misconfiguration/hide-errors/error_script.php`.

2. Dans le dossier `hide-errors`, ouvrez le fichier `.htaccess` et ajoutez la ligne suivante :

   ```
   php_flag display_errors off
   ```

   Il est également possible de modifier cette option dans le fichier php.ini, ce qui est recommandé dans une utilisation réelle.

3. Retournez sur la page `/06-security-misconfiguration/hide-errors/error_script.php` et vérifiez que l'erreur n'est plus affichée. :tada: Bravo ! Vous avez réussi à masquer les erreurs de PHP.

4. Nous n'avons masqué que les erreurs de PHP, nous avons toujours laissé les erreurs HTML, les erreurs de démarrage, les erreurs de log, il est bien-entendu possible de les masquer également.

## Protection DoS/DDoS

Une attaque par déni de service est une attaque ayant pour but de rendre indisponible un service et d'empêcher les utilisateurs d'un service de l'utiliser. Il est possible de se protéger de ces attaques en utilisant le module **mod_evasive**. Ce module permet de répondre au traffic de l'application web en proposant plusieurs options de configuration, on peut par exemple définir le nombre maximum de fois où une page est appelée par secondes et définir un laps de temps où l'adresse IP de l'utilisateur sera bloquée. Cette méthode permet notamment des attaques de **Brute Force** ou de [**Credential Stuffing**](https://github.com/vcarrara/pe_web_security/tree/main/02-broken-authentication). Il est recommandé de consulter [cette ressource](https://github.com/jzdziarski/mod_evasive) afin d'en savoir plus sur les options de configuration disponibles.

1. Téléchargez et installez le module **mod_evasive**.

   Sur Windows :

   - [Téléchargez le module mod_evasive](https://www.apachelounge.com/download/)
   - Ouvrez l'archive et déposez `mod_evasive.so` dans le dossier `modules` d'Apache
   - Dans le fichier `httpd.conf` ajoutez les instructions suivantes :

     ```
     # Chargement du module
     LoadModule evasive_module modules/mod_evasive.so

     # Configuration du module
     DOSEnabled true
     # Seuil de requête pour la même page (ou URI) par interval de page
     # Une fois que le seuil a été atteind, l'adresse IP du client est ajouté à la blacklist
     DOSPageCount 2
     DOSPageInterval 1
     # Seuil du nombre total de requête pour n'importe quel object d'un même client (images, css, ...)
     # Une fois que le seuil a été atteind, l'adresse IP du client est ajouté à la blacklist
     DOSSiteCount 100
     DOSSiteInterval 1     
     # Période durant laquelle on bloque le client
     DOSBlockingPeriod 10
     ```

   Sur Linux :

   - [Consultez cette ressource](https://www.nomachine.com/AR02R01077)

2. Redémarrez Apache

3. Raffraichissez la page plusieurs fois d'affilée, que se passe t'il ? Si vous recevez une erreur 403 : **Forbidden**, :tada: Bravo ! Vous venez d'empêcher le rechargement massif de votre application web !
