
# Installation du thème

## Installation :
- PHP version : `> 8.2`
- Configure the `.env.local` file - For local installation and the `.env` for production installation
- Then `sudo composer install` into the root
- Into the theme folder : `nvm use v14.16.1` & `sudo npm i`


## Develop :
- `grunt watch`


## Mise en place du déploiement - Staging :
- Pour le staging : se rendre dans Github, onglet Settings puis Secrets and variables > Actions
- Ajouter un repository secret DEPLOY_KEY_STAGING - Coller la clé privée SSH

## Mise en place du déploiement - Production :
- Se rendre dans Github > Settings > Secrets & Variables > Actions
- Création d'un New Repository Secret : FTP_PROD_PASSWORD
- Création d'un New Repository Secret : FTP_PROD_USERNAME


## Staging :
- https://speedernet.julien-brochard.fr/
- to push to preproduction website : git branch > develop then git add ., git commit -m 'my commit', git push origin develop


## Prod 
- https://www.speedernet.com/

