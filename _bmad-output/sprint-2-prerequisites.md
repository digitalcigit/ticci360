# Sprint 2 - Prérequis Techniques

**Date:** 18 Janvier 2026  
**Statut:** À résoudre avant développement  

---

## 🚨 Bloqueurs à Résoudre

### BUG-001: ProductResource Signature Incompatible (CRITIQUE)

**Fichier:** `/var/www/app/Http/Resources/ProductResource.php:15`

**Erreur:**
```
Declaration of App\Http\Resources\ProductResource::toArray(Illuminate\Http\Request $request): array 
must be compatible with Illuminate\Http\Resources\Json\JsonResource::toArray($request)
```

**Cause:** La méthode `toArray()` a une signature typée qui n'est pas compatible avec la classe parente Laravel.

**Solution:**
```php
// AVANT (incorrect)
public function toArray(Illuminate\Http\Request $request): array

// APRÈS (correct)
public function toArray($request): array
```

**Impact:** Sans cette correction, l'endpoint `/api/v1/products` retourne une erreur 500.

**Assigné à:** Agent Dev (Task 1.1 de Story 2.2)

---

## ✅ Prérequis Validés

| Prérequis | Statut | Vérifié le |
|-----------|--------|------------|
| VPS Docker Stack | ✅ OK | 2026-01-18 |
| ticci_app container | ✅ Running | 2026-01-18 |
| ticci_web (Nginx) | ✅ Running | 2026-01-18 |
| ticci_db (MySQL) | ✅ Running | 2026-01-18 |
| ticci_redis | ✅ Running | 2026-01-18 |
| SSL/HTTPS | ✅ OK | 2026-01-18 |
| Admin Dashboard | ✅ Accessible | 2026-01-18 |
| Base de données | ✅ 1251 produits | 2026-01-18 |

---

## 🔧 Configuration Environnement Showroom

### Variables d'environnement requises

Créer/Modifier `apps/showroom/.env.local`:

```env
# API Backend
NEXT_PUBLIC_API_URL=https://api-staging.tic.ci/api/v1

# URLs publiques
NEXT_PUBLIC_BASE_URL=https://staging.tic.ci
NEXT_PUBLIC_CANONICAL_BASE_URL=https://www.tic.ci

# Revalidation ISR (secondes)
REVALIDATE_PRODUCTS=3600
REVALIDATE_CATEGORIES=86400
```

---

## 📡 Endpoints API - État

| Endpoint | Statut | Notes |
|----------|--------|-------|
| `GET /api/v1/products` | ❌ Bloqué | BUG-001 |
| `GET /api/v1/products/{slug}` | ❌ Bloqué | BUG-001 |
| `GET /api/v1/categories` | ⚠️ À tester | Après fix BUG-001 |
| `GET /api/v1/health` | ✅ OK | Endpoint de santé |

---

## 📁 Structure Actuelle Showroom

```
apps/showroom/
├── src/
│   ├── app/
│   │   ├── page.tsx (placeholder)
│   │   ├── products/ (à développer)
│   │   └── quote/ (structure créée)
│   ├── components/
│   │   └── layout/ (existant)
│   ├── features/
│   │   ├── catalog/
│   │   │   └── components/ (à développer)
│   │   ├── cart/
│   │   │   ├── hooks/ (créé, vide)
│   │   │   └── components/ (créé, vide)
│   │   └── search/ (à créer)
│   ├── lib/
│   │   └── api/ (à créer)
│   └── types/ (existant)
├── public/
├── package.json
└── next.config.js
```

---

## 🔐 Accès et Credentials

### VPS SSH
```bash
ssh -p 8483 aidciadmin@104.37.188.51
```

### Admin Dashboard
- **URL:** https://api-staging.tic.ci/admin
- **Email:** info@tic.ci

### Conteneurs Docker
```bash
docker exec -it ticci_app bash    # PHP/Laravel
docker exec -it ticci_web bash    # Nginx
docker logs ticci_app             # Logs application
```

---

## 📋 Checklist Avant Développement

- [ ] BUG-001 corrigé et vérifié
- [ ] `curl https://api-staging.tic.ci/api/v1/products` retourne des données
- [ ] `curl https://api-staging.tic.ci/api/v1/categories` retourne des données
- [ ] `.env.local` créé dans `apps/showroom/`
- [ ] `npm install` exécuté dans `apps/showroom/`
- [ ] `npm run dev` démarre sans erreurs

---

## 📞 Contacts

- **Scrum Master / Coordinateur:** Cascade (AI)
- **Agent Dev:** À activer via `/dev`
- **Product Owner:** Client TICCI
