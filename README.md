# pe_web_security

Preuves de concept sur la sécurité des applications web, exploitant les risques de sécurité principaux déterminés par OWASP, en utilisant une couche **Apache / MySQL / PHP**.

:memo: [OWASP Top Ten Web Application Security Risks](https://owasp.org/www-project-top-ten/)

- [x] [Injection](https://owasp.org/www-project-top-ten/2017/A1_2017-Injection)
- [x] [Broken Authentication](https://owasp.org/www-project-top-ten/2017/A2_2017-Broken_Authentication)
- [x] [Sensitive Data Exposure](https://owasp.org/www-project-top-ten/2017/A3_2017-Sensitive_Data_Exposure)
- [ ] [XML External Entities (XXE)](<https://owasp.org/www-project-top-ten/2017/A4_2017-XML_External_Entities_(XXE)>)
- [ ] [Broken Access Control](https://owasp.org/www-project-top-ten/2017/A5_2017-Broken_Access_Control)
- [x] [Security Misconfiguration](https://owasp.org/www-project-top-ten/2017/A6_2017-Security_Misconfiguration)
- [x] [Cross-Site Scripting (XSS)](<https://owasp.org/www-project-top-ten/2017/A7_2017-Cross-Site_Scripting_(XSS)>)
- [ ] [Insecure Deserialization](https://owasp.org/www-project-top-ten/2017/A8_2017-Insecure_Deserialization)
- [ ] [Using Components with Known Vulnerabilities](https://owasp.org/www-project-top-ten/2017/A9_2017-Using_Components_with_Known_Vulnerabilities)
- [ ] [Insufficient Logging & Monitoring](https://owasp.org/www-project-top-ten/2017/A10_2017-Insufficient_Logging%2526Monitoring)

:wrench: La version de PHP utilisée lors de l'expertise est **7.4.10**

<hr />
<br />

:loudspeaker: Il est à noter qu'Apache/PHP sous XAMPP/WAMP utilise des configurations souvent différentes qu'avec Docker.

## Fonctionnement classique

1. Démarrez Apache et MySQL.
2. Créez la base de données MySQL et son utilisateur grâce au fichier `/init_db/init.sql`.
3. Servez le dossier `www` sur le serveur Apache (_voir étape optionnelle_).
4. Vérifiez la conformité des informations de connexion dans `www/config/Database.php`.

### Optionnel

Il est possible de changer le dossier servi par Apache (htdocs sous Xampp par exemple) en modifiant le fichier `httpd.conf` d'Apache.

1. Trouvez le tag `DocumentRoot "C:/xampp/htdocs"` et modifier le chemin par le chemin du dossier désiré.
2. Trouvez la ligne suivante et modifiez là en indiquant le chemin désiré `<Directory "C:/xampp/htdocs">`.
3. Redémarrez le serveur Apache.

## Fonctionnement avec Docker (:warning: en cours)

1. Démarrez les conteneurs (_la base de données devrait être automatiquement remplie lors du premier démarrage des conteneurs_).

   ```
   $ docker-compose up [-d]
   ```

   Pour arrêter les conteneurs, arrêtez le processus Docker grâce à <kbd>Ctrl</kbd>+<kbd>c</kbd> ou :

   ```
   $ docker-compose down
   ```

2. Vérifiez la conformité des informations de connexion dans `www/config/Database.php`.

<hr />
Réalisé par [@vcarrara](https://github.com/vcarrara) & [@aclairet](https://github.com/aclairet), 2020.
