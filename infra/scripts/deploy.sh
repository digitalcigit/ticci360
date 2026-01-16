#!/bin/bash

# Deploy Script for TICCI 360 on VPS
# Location: /opt/ticci360/infra/scripts/deploy.sh

set -e

# Configuration
PROJECT_ROOT="/opt/ticci360"
# DOCKER_DIR="$PROJECT_ROOT/infra/docker/prod" # Legacy path
COMPOSE_FILE="$PROJECT_ROOT/docker-compose.yml"
CENTRAL_NGINX="digitalcloud360-nginx-1"

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# 1. Update Codebase
log_info "Updating codebase..."
cd "$PROJECT_ROOT"
git pull origin main

# 2. Build & Restart Containers
log_info "Building and restarting Docker containers..."
# We stay in PROJECT_ROOT because docker-compose.prod.yml has context: .
# and expects to find apps/showroom/Dockerfile relative to root.
docker compose -f "$COMPOSE_FILE" build --no-cache
docker compose -f "$COMPOSE_FILE" up -d

# 3. Post-Deployment Tasks (Laravel)
log_info "Running Laravel post-deployment tasks..."
# Wait for DB to be ready might be needed here, or handle via healthchecks
echo "[INFO] Running post-deployment tasks..."
docker compose -f $COMPOSE_FILE exec -T app php artisan package:discover
docker compose -f $COMPOSE_FILE exec -T app php artisan vendor:publish --tag=laravel-assets --ansi --force
docker compose -f $COMPOSE_FILE exec -T app php artisan cms:publish:assets
docker compose -f $COMPOSE_FILE exec -T app php artisan migrate --force
docker compose -f $COMPOSE_FILE exec -T app php artisan optimize:clear
docker compose -f "$COMPOSE_FILE" exec -T app php artisan config:cache
docker compose -f "$COMPOSE_FILE" exec -T app php artisan route:cache
docker compose -f "$COMPOSE_FILE" exec -T app php artisan view:cache
docker compose -f "$COMPOSE_FILE" exec -T app php artisan storage:link

# 4. Update Nginx Config (if changed)
log_info "Updating Central Nginx configuration..."
docker cp "$PROJECT_ROOT/infra/nginx/sites-available/ticci.conf" "$CENTRAL_NGINX:/etc/nginx/sites-available/ticci.conf"

# Ensure symlink exists
docker exec "$CENTRAL_NGINX" ln -sf /etc/nginx/sites-available/ticci.conf /etc/nginx/sites-enabled/ticci.conf

# Reload Nginx
log_info "Reloading Central Nginx..."
docker exec "$CENTRAL_NGINX" nginx -t
docker exec "$CENTRAL_NGINX" nginx -s reload

log_info "Deployment Completed Successfully! 🚀"
log_info "Check status at: https://www.tic.ci and https://api.tic.ci"
