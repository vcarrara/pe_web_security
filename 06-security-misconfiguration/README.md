# Security Misconfiguration

:bookmark_tabs: Mode d'emploi :

1.  Rendez-vous à l'URI `/06-security-misconfiguration/`. Quelles informations y trouvez vous ? La fonctionnalité que vous venez de découvrir, qui est souvent activée par défaut, est appelée le **Direcory Listing** (ou parfois **Directory Browsing**) et donne la possibilité aux utilisateurs d'une application web d'afficher le contenu d'un répertoire présent sur le serveur. Même si cette fonctionnalité peut être utile dans certains cas précis (par exemple lister un ensemble de fichiers téléchargeables pour l'utilisateur), elle constitue un problème de sécurité dans la plupart des cas. En effet, il n'est pas souhaitable de lister les fichiers de configuration présents sur le serveur.

2.  Dans le dossier `06-security-misconfiguration`, créez un fichier appelé `.htaccess`.

3.  Dans ce fichier, ajoutez une ligne :

    ```
    # Désactivation du directory listing
    Options -Indexes
    ```

4.  Retournez sur la page `/06-security-misconfiguration/`. Les fichiers sont-ils listés ? Si la réponse est non, bravo :tada: ! Vous venez de désactiver le **Directory Listing** dans ce répertoire. Sinon, recommencez l'étape 2 et 3.

5.  Rendez-vous à l'URI `/06-security-misconfiguration/`, vous remarquerez que des informations sur la version de PHP sont exposées. De plus, sur chaque requête effectuée sur le serveur, une entête de réponse HTTP `X-Powered-By : PHP/<version de php>` est renvoyée, ce qui donne de précieuses informations sur le serveur.

6.  Voyons comment configurer PHP de manière plus sécurisée. Trouvez le fichier `php.ini` puis faites-en une copie de manière à avoir une backup d'une configuration standard. Ouvrez le fichier `php.ini`. Trouvez la ligne `expose_php` et remplacez **True** par **False**. Redémarrez le serveur et retournez sur la page `/06-security-misconfiguration/`. L'utilisation de PHP devrait être masquée.

7. Rendez-vous à l'URI `/06-security-misconfiguration/hello_world.php`. :warning: Même si l'utilisation de PHP est masquée, nos pages web ont comme extension... **PHP** ! Voyons comment il est possible de masquer ces extensions, ou même de les remplacer par quelque chose de totalement différent. Ouvrez le fichier `.htaccess` que vous avez créé a l'étape 2. Ajoutez les lignes suivantes.

    ```
    # Activation du moteur de réécriture
    RewriteEngine on
    
    # Réécriture de l'URI /ressource/index.php vers /ressource/index
    RewriteRule ^([^.?]+)$ %{REQUEST_URI}.php [L]
    
    # Retourne une erreur 404 si la ressource demandée termine par .php
    RewriteCond %{THE_REQUEST} "^[^ ]* .*?\.php[? ].*$"
    RewriteRule .* - [L,R=404]
    ```

8. Rendez-vous à l'URI `/06-security-misconfiguration/hello_world.php` et vérifiez que l'erreur retournée est bien une erreur 404 (Not Found). La page `/06-security-misconfiguration/hello_world` devrait afficher "**Hello world!**"