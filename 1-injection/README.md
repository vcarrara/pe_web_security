# Injection SQL.

Pour cette preuve de concept, deux utilisateurs seront mobilisés :

- **john_doe**, dont le mot de passe est **CroSS-SitE\$John2020**
- **super_jane**, dont le mot de passe est **CroSS-SitE\$Jane2020**

:bookmark_tabs: Scénario :

Nous allons nous mettre dans la peau de **john_doe** qui aura le rôle de l'attaquant. Son but est de se connecter sur le compte d'un admin de son entreprise qui est super_jane.
Comme beaucoup de personne, john_doe connaît l'identifiant de l'admin qui est souvent sur le même modèle que les identifiants des compte utilisateurs lambda. C'est-à-dire soit une adresse mail (celle de l'entreprise) ou bien c'est tout simplement "admin" ou "super_admin".

Pour pouvoir atteindre son objectif, john va utiliser l'**injection SQL** car il se doute que le portail d'authentification n'est pas très sécurisé.

1. Connectez-vous au compte de **john_doe** pour vérifier que tout fonctionne bien.
2. Déconnectez-vous et essayer de vous connecter au compte administrateur de super_jane. Bien sûr sans son mot de passe il est impossible de s'y connecter.
3. Sachant que l'instruction SQL qui permet l'authentification est du format ci-dessous, essayez d'effectuer une injection SQL. Essayez de trouver une instruction à saisir dans le champ de l'identifiant permettant de rendre le mot de passe facultatif. *Indice -> utilisez les caractère '#' ou '--' permettant d'écrire un commentaire en SQL*.

```sql
# Ceci est un commentaire
-- Ceci est un autre commentaire
SELECT username FROM Users WHERE username = 'username' AND pass = 'password';
```

4. Une fois l'injection trouvée, saisissez là et connectez-vous au compte administrateur de super_jane.
5. :tada: Bravo vous avez réussi !

Bonus : Sur le même schéma, essayer de supprimer l'utilisateur bob de la base de données.

Bien sûr cet exemple est très basique mais permet de comprendre ce genre de faille et les potentiels dégâts qu'elle peut engendrer.
