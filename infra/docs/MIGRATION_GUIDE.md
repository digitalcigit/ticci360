# Guide de Migration des Données (Prod Mutualisé -> VPS Staging)

Ce guide décrit la procédure pour cloner les données réelles (Base de données et Fichiers médias) du serveur de production actuel (Shared Hosting) vers le nouvel environnement de Staging sur le VPS.

## 1. Pré-requis
- Accès SSH/FTP au serveur de production actuel (Source).
- Accès SSH au serveur VPS (Destination).
- Nom du conteneur de base de données VPS : `ticci_db`
- Nom du conteneur applicatif VPS : `ticci_app`

## 2. Export depuis la Production (Source)

### 2.1 Base de Données
Connectez-vous à la production (via phpMyAdmin ou mysqldump) et exportez la base de données.

```bash
# Exemple si accès SSH disponible sur le mutualisé
mysqldump -u [USER] -p[PASSWORD] [DB_NAME] > production_backup.sql
```

### 2.2 Fichiers Médias
Compressez les dossiers contenant les uploads (images produits, etc.).
Généralement situés dans `public/storage` ou `storage/app/public`.

```bash
# Exemple
cd /chemin/vers/site/public
tar -czf media_backup.tar.gz storage/
```

## 3. Transfert vers le VPS (Destination)

Utilisez SCP ou SFTP pour envoyer les deux fichiers (`production_backup.sql` et `media_backup.tar.gz`) sur le VPS dans le dossier `/opt/ticci360/tmp` (créez le dossier si nécessaire).

```bash
# Depuis votre poste local ou le serveur source
scp -P 8483 production_backup.sql aidciadmin@104.37.188.51:/opt/ticci360/
scp -P 8483 media_backup.tar.gz aidciadmin@104.37.188.51:/opt/ticci360/
```

## 4. Import sur le VPS Staging

### 4.1 Import de la Base de Données

1. Connectez-vous au VPS.
2. Copiez le fichier SQL dans le conteneur DB (ou lisez-le directement).

```bash
cd /opt/ticci360

# Import via docker exec (Attention : cela écrase la base existante)
# Assurez-vous que les variables d'environnement (DB_PASSWORD, etc.) sont chargées ou remplacez les valeurs.
# Note: Le mot de passe est dans le fichier .env

cat production_backup.sql | docker exec -i ticci_db mysql -u [DB_USER] -p[DB_PASSWORD] [DB_NAME]
```

*Astuce : Vous pouvez trouver les credentials dans le fichier `.env` sur le VPS.*

### 4.2 Import des Médias

1. Décompressez l'archive des médias.
2. Copiez les fichiers dans le volume Docker de l'application.

```bash
# Créer un dossier temporaire
mkdir -p temp_media
tar -xzf media_backup.tar.gz -C temp_media

# Copier dans le conteneur (ajustez le chemin source selon la structure de votre tar)
# Si l'archive contient 'storage/':
docker cp temp_media/storage/. ticci_app:/var/www/public/storage/

# Fixer les permissions (L'utilisateur dans le conteneur est souvent www-data ou root, ajustez selon le Dockerfile)
docker exec -u root ticci_app chown -R www-data:www-data /var/www/public/storage
```

## 5. Finalisation

Après l'import, lancez les commandes de nettoyage Laravel :

```bash
docker compose -f infra/docker/prod/docker-compose.yml exec -T app php artisan cache:clear
docker compose -f infra/docker/prod/docker-compose.yml exec -T app php artisan storage:link
```

Vérifiez ensuite sur https://staging.tic.ci que les produits et images apparaissent correctement.
