# Déploiement Railway - Djiméra Design Manager

## Option recommandée

Déployer l'application comme un service Laravel Railway avec une base PostgreSQL.

Railway détecte Laravel automatiquement et l'exécute avec PHP-FPM/Caddy. Le guide officiel Railway recommande :

- déploiement depuis GitHub ;
- variables d'environnement Laravel ;
- service PostgreSQL ou MySQL ;
- commande de build front `npm run build` ;
- commande de pré-déploiement pour migrations/cache ;
- domaine public généré dans l'onglet Networking.

## 1. Préparer GitHub

Depuis le dossier du projet :

```bash
git init
git add .
git commit -m "Prepare Djimera Design Manager for Railway"
```

Créez ensuite un dépôt GitHub, puis poussez le projet :

```bash
git branch -M main
git remote add origin https://github.com/VOTRE_COMPTE/djimera-design.git
git push -u origin main
```

## 2. Créer le projet Railway

1. Ouvrir `https://railway.com`.
2. Se connecter.
3. Cliquer sur `New Project`.
4. Choisir `Deploy from GitHub repo`.
5. Sélectionner le dépôt `djimera-design`.

## 3. Ajouter la base de données

Dans le projet Railway :

1. Cliquer sur `New`.
2. Choisir `Database`.
3. Choisir `PostgreSQL`.

## 4. Variables d'environnement

Dans le service Laravel, onglet `Variables`, ajouter :

```env
APP_NAME="Djiméra Design Manager"
APP_ENV=production
APP_KEY=base64:REMPLACER_PAR_VOTRE_CLE
APP_DEBUG=false
APP_URL=https://VOTRE-DOMAINE-RAILWAY

APP_LOCALE=fr
APP_FALLBACK_LOCALE=fr
APP_FAKER_LOCALE=fr_FR

LOG_CHANNEL=stderr
LOG_LEVEL=info

DB_CONNECTION=pgsql
DB_URL=${{Postgres.DATABASE_URL}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public

MAIL_MAILER=log
MAIL_FROM_ADDRESS="contact@djimera-design.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

Pour générer `APP_KEY` localement :

```bash
php artisan key:generate --show
```

Copiez la valeur affichée dans Railway.

## 5. Build et pré-déploiement

Dans le service Laravel Railway :

### Build Command

```bash
npm run build
```

### Pre-Deploy Command

```bash
chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh
```

## 6. Domaine public HTTPS

Dans le service Laravel :

1. Aller dans `Settings`.
2. Ouvrir `Networking`.
3. Cliquer sur `Generate Domain`.
4. Copier l'URL générée.
5. Mettre cette URL dans la variable `APP_URL`.
6. Redéployer.

## 7. Images et fichiers uploadés

Pour conserver les images des modèles après les redéploiements, ajouter un volume Railway.

Chemin de montage conseillé :

```text
/app/storage/app/public
```

Sans volume, les images uploadées peuvent être perdues lors d'un redéploiement.

## 8. Après le premier déploiement

Créer le premier utilisateur admin :

1. Ouvrir `/register`.
2. Créer votre compte.
3. Aller ensuite dans `Utilisateurs` pour créer les autres comptes.

Si vous voulez désactiver les inscriptions publiques ensuite, retirez ou protégez la route `/register`.

## 9. PWA mobile

Après déploiement HTTPS :

### iPhone

Safari -> ouvrir l'URL Railway -> Partager -> Ajouter à l'écran d'accueil.

### Android

Chrome -> ouvrir l'URL Railway -> menu -> Ajouter à l'écran d'accueil / Installer l'application.
