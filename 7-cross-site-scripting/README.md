# Cross-Site Scripting (XSS).

Pour cette preuve de concept, deux utilisateurs seront mobilisés :

- **john_doe**, dont le mot de passe est **CroSS-SitE\$John2020**
- **super_jane**, dont le mot de passe est **CroSS-SitE\$Jane2020**

Le but va être de se connecter avec le compte de **super_jane**, sans utiliser directement son mot de passe. On admettra que John est l'attaquant, et que Jane est la victime.

:loudspeaker: Prérequis :

0. Vérifier que les informations de connexion vers la base de données sont correctes dans le fichier `models/Database.php`.
1. Créer les tables de la base de données, grâce au fichier `sql/create.sql`.
2. Insérer les données, grâce au fichier `sql/insert.sql`.

:bookmark_tabs: Mode d'emploi

1. Connectez-vous avec le compte de **john_doe**.
2. Postez le message 'Hello World!' sur le forum. Le message devrait s'afficher sous les autres.
3. Ouvrez le fichier `index.php`, repérez la ligne où le message est affiché (dans une balise `<span>`). Cela sera utile pour comprendre la suite.
4. Envoyez un nouveau message contenant du code HTML, par exemple `<button class="btn btn-danger">Panic button</button>`. Que se passe-t'il ?.
5. Vous l'aurez compris, il est possible d'envoyer toute balise HTML. Essayez maintenant d'incorporer une image.
6. Il est possible d'exploiter l'étape 5 pour créer une attaque par déni de service (DDoS). Renseignez-vous sur cette attaque.
7. Attaquez le site en envoyant une image légèrement modifiée. Ajoutez un attribut style dans la balise `<img>`, ayant pour valeur `style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh"`. Le site est-il encore utilisable ?.
8. Supprimez les trois derniers messages dans la base de données.
9. Allons plus loin, voyons s'il est possible d'exécuter du code Javascript. En utilisant la méthode présentée ci-dessus, faîtes que l'instruction `alert('Vive javascript!')` soit exécutée à chaque fois que la page est rechargée.
10. Passons au vif du sujet, voyons s'il est possible de "voler" la session de super_jane avec cette méthode. Quelle instruction javascript permet d'avoir accès aux cookies d'une page web ?.
11. En PHP, chaque session est identifiée de manière unique par un cookie de session (**PHPSESSID**). Cette information est personnelle et ne doit en aucun cas être communiquée à une tierce personne. Cet identifiant permettrait à un attaquant de "voler" votre identité, en se faisant passer pour quelqu'un d'autre au niveau du serveur. Jetez un oeil au script `malveillant/index.php`. Que fait ce code ?
12. Préparez un message permettant d'exécuter une requête Ajax GET avec JQuery (`$.get(uri)`) vers notre script malveillant (dont l'uri est `malveillant/index.php`) ayant un paramètre GET appelé cookie. Ce paramètre aura pour valeur les cookies de la page sous la forme d'une chaîne de caractères (en utilisant l'instruction trouvée à la question 10). Envoyez le message. Que se passera-t'il quand un utilisateur rechargera la page ?
13. Vous venez comprendre comment des instructions confidentielles peuvent être envoyées vers un serveur malveillant à l'aide d'attaques XSS. Dans cet exemple le script malveillant est sur le même serveur que l'application de forum. Dans la vrai vie le script malveillant peut être créé par n'importe qui et être hébergé sur n'importe quel serveur.
14. Sur un autre navigateur, mettez-vous dans la peau de Jane en vous connectant avec le compte de **super_jane**. Vérifiez que le fichier `malveillant/cookies.txt` contient les informations des cookies de john_doe, mais aussi ceux de super_jane. En utilisant les informations de ce fichier, modifiez le cookie de session de john_doe en le remplaçant par celui de super_jane. Rechargez la page. :tada: Bravo, vous venez d'usurper l'identité de super_jane !
