#!/bin/bash

# Quick Deploy Script for TICCI 360 on VPS
# Use this for fast deployments (< 2 min) when only code changes are made.
# For Docker/infrastructure changes, use the full deploy.sh script.
# Location: /opt/ticci360/infra/scripts/quick-deploy.sh

set -e

# Configuration
PROJECT_ROOT="/opt/ticci360"
COMPOSE_FILE="$PROJECT_ROOT/docker-compose.yml"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

START_TIME=$(date +%s)

# 1. Update Codebase
log_info "Updating codebase from GitHub..."
cd "$PROJECT_ROOT"

# Fix permissions using Docker (avoids sudo password prompt)
log_info "Ensuring correct file permissions..."
docker run --rm -v "$PROJECT_ROOT":/workdir alpine chown -R $(id -u):$(id -g) /workdir

git fetch origin main
git reset --hard origin/main

# 2. Restart Containers (NO REBUILD)
log_info "Restarting Docker containers (no rebuild)..."
docker compose -f "$COMPOSE_FILE" up -d --force-recreate

# 3. Post-Deployment Tasks (Laravel)
log_info "Running Laravel post-deployment tasks..."
docker compose -f "$COMPOSE_FILE" exec -T app php artisan optimize:clear
docker compose -f "$COMPOSE_FILE" exec -T app php artisan config:cache
docker compose -f "$COMPOSE_FILE" exec -T app php artisan route:cache
docker compose -f "$COMPOSE_FILE" exec -T app php artisan view:cache
docker compose -f "$COMPOSE_FILE" exec -T app php artisan migrate --force

# 4. Calculate elapsed time
END_TIME=$(date +%s)
ELAPSED=$((END_TIME - START_TIME))

log_info "Quick Deployment Completed in ${ELAPSED}s! 🚀"
log_info "Check status at: https://staging.tic.ci and https://api-staging.tic.ci"
