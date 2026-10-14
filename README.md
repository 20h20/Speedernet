
# Installation du thème

## Installation :
- PHP version : `> 8.2`
- Configure the `.env.local` file - For local installation and the `.env` for production installation
- Then `sudo composer install` into the root
- Into the theme folder : `nvm use v14.16.1` & `sudo npm i`


## Develop :
- `grunt watch`

## Mise en place du Token Git :
- Dans Personal access tokens > Fine-grained tokens, cliquer sur Generate new token.
- Remplir les champs :
    - Token name : Dashboard WP – Speedernet
    - Resource owner : 20h20
    - Expiration : 1 an, par exemple.
    - Repository access : Only select repositories > 20h20/Speedernet.
    - Permissions > Repository permissions > Contents : Read-only.
- Cliquer sur Generate token et copier la valeur dans le wp-config.php

## Mise en place du déploiement - Staging :
- Pour le staging : se rendre dans Github, onglet Settings puis Secrets and variables > Actions
- Ajouter un repository secret DEPLOY_KEY_STAGING - Coller la clé privée SSH

## Mise en place du déploiement - Production :



## Staging :
- https://speedernet.julien-brochard.fr/
- to push to preproduction website : git branch > develop then git add ., git commit -m 'my commit', git push origin develop


## Prod 
- https://www.speedernet.com/

