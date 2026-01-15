---
stepsCompleted: [1, 2, 3, 4]
inputDocuments: 
  - _bmad-output/2-planning/prd.md
  - _bmad-output/planning-artifacts/architecture.md
---

# TICCI 360 - Epic Breakdown

## Overview

This document provides the complete epic and story breakdown for TICCI 360, decomposing the requirements from the PRD, UX Design if it exists, and Architecture requirements into implementable stories.

## Requirements Inventory

### Functional Requirements

FR-01.1: The system must expose product data via secure endpoints.
FR-01.2: The API must support dynamic filtering (categories, attributes, prices).
FR-01.3: The system must manage frontend client authentication via secure mechanism (Sanctum Stateful Cookies + CSRF).
FR-02.1: The user can navigate between product pages without full browser reload.
FR-02.2: The frontend must support Server-Side Rendering (SSR) to ensure optimal SEO.
FR-02.3: The catalogue must reflect backend prices/stock in real-time or quasi-real-time.
FR-UJ-01: Implement "Hybrid Journey" - Seamless transition from Showroom "Buy" to Legacy Cart with item added.
FR-UJ-02: Implement "Expert B2B" - Custom quote request component and "Expert Opinion" section.

### NonFunctional Requirements

NFR-01.1: Frontend must respond in < 500ms for 95% of navigation requests.
NFR-01.2: Architecture must allow containerized deployment (Docker) on VPS.
NFR-02.1: All frontend-API communications must be encrypted via TLS.
NFR-02.2: Customer and product data must be hosted on own VPS infrastructure (Sovereignty).
NFR-UI: Mobile-first Responsive Design.
NFR-Doc: Up-to-date OpenAPI/Swagger documentation for each version.
NFR-Ops: Automated deployment pipeline to VPS.
NFR-SEO: Zero Broken Links (Strict URL structure preservation).

### Additional Requirements

- **Starter Template:** Use `create-next-app@latest` with TypeScript, ESLint, Tailwind, App Router, `src/` dir, and `@/*` alias.
- **Tech Stack:** Next.js (Frontend), Laravel Botble (Backend), MySQL 8.4 (Docker), Redis (Docker).
- **Architecture Pattern:** Hybrid Monolith/Headless with Shared Session (Redis + Sanctum Stateful).
- **API Standards:** REST JSON, snake_case, `{ data, meta }` wrapper, Standard Error format.
- **Frontend State:** Zustand v5.0.10 for Client State (Optimistic Cart).
- **Caching:** ISR with Tag-based revalidation (`product:{id}`).
- **Infrastructure:** Central Nginx Reverse Proxy (Container) -> Docker Bridge -> Next.js.
- **Project Structure:** Monorepo `ticci360` with `apps/showroom` and `infra/`.
- **Integration:** Strict configuration of `SESSION_DOMAIN` (.tic.ci) and CORS headers for cross-subdomain session continuity.

### FR Coverage Map

FR-01.1: Epic 1 - Secure endpoints for product data exposure
FR-01.2: Epic 2 - Dynamic filtering API support
FR-01.3: Epic 1 - Secure frontend authentication (Sanctum)
FR-02.1: Epic 2 - Seamless client-side navigation
FR-02.2: Epic 2 - SSR implementation for SEO
FR-02.3: Epic 2 - Real-time price/stock reflection
FR-UJ-01: Epic 3 - Hybrid Journey implementation
FR-UJ-02: Epic 4 - Expert B2B features

## Epic List

### Epic 1: Secure Data Access & Sovereign Foundation
Establish the sovereign VPS technical foundation and expose critical data via a secure API to enable modern frontend development.
**FRs covered:** FR-01.1, FR-01.3, NFR-01.2, NFR-02.1, NFR-02.2, NFR-Ops

### Epic 2: High-Performance Digital Showroom
Deliver an ultra-fast, SEO-optimized product catalog experience that maximizes discovery without relying on legacy display logic.
**FRs covered:** FR-01.2, FR-02.1, FR-02.2, FR-02.3, NFR-01.1, NFR-UI, NFR-SEO

### Epic 3: Seamless Hybrid Commerce
Connect the modern discovery experience to the legacy transaction engine transparently, ensuring session continuity.
**FRs covered:** FR-UJ-01

### Epic 4: B2B Expert Services
Digitize TICCI's consulting expertise to capture and process qualified B2B leads.
**FRs covered:** FR-UJ-02

## Epic 1: Secure Data Access & Sovereign Foundation

Establish the sovereign VPS technical foundation and expose critical data via a secure API to enable modern frontend development.

### Story 1.1: Sovereign VPS Infrastructure Setup

As a DevOps Engineer,
I want to provision the Docker environment on the VPS with central Nginx and isolated data services,
So that the application has a secure, consistent, and sovereign runtime environment.

**Acceptance Criteria:**

**Given** A clean VPS environment with Docker installed and existing Nginx
**When** I deploy the `ticci` Docker stack (MySQL 8.4, Redis, Network)
**Then** The services are up and healthy
**And** The central Nginx routes `ticci` traffic to the new stack
**And** Data volumes are properly mounted and persistent

### Story 1.2: Legacy Data Exposure (API v1 Setup)

As a Backend Developer,
I want to establish the API structure within the legacy Laravel application,
So that I can expose data in a standardized, versioned format without breaking existing functionality.

**Acceptance Criteria:**

**Given** The legacy Laravel codebase
**When** I implement the `/api/v1/health` endpoint
**Then** It returns a 200 OK JSON response following the standard wrapper `{ data, meta }`
**And** Global error handling returns standardized JSON error objects
**And** No existing web routes are affected

### Story 1.3: Secure Authentication Mechanism (Sanctum)

As a Security Engineer,
I want to configure Laravel Sanctum for stateful authentication,
So that the modern frontend can securely authenticate users via HTTP-only cookies across subdomains.

**Acceptance Criteria:**

**Given** The Laravel API and a separate frontend domain (e.g., localhost or staging)
**When** I attempt a login via the API
**Then** A session cookie is set for the `.tic.ci` domain (or configured root)
**And** CSRF protection is active and validated
**And** CORS headers allow requests from the trusted frontend origin

### Story 1.4: Product Catalog API (Read-Only)

As a Frontend Developer,
I want access to product and category data via the API,
So that I can display the catalog in the new Showroom interface.

**Acceptance Criteria:**

**Given** Authenticated or public access to the API
**When** I request `/api/v1/products` or `/api/v1/categories`
**Then** I receive a paginated list of active products/categories
**And** The data structure matches the defined `snake_case` DTO contract
**And** Response times are optimized for read performance

## Epic 2: High-Performance Digital Showroom

Deliver an ultra-fast, SEO-optimized product catalog experience that maximizes discovery without relying on legacy display logic.

### Story 2.1: Next.js Foundation & Monorepo Structure

As a Frontend Architect,
I want to initialize the Next.js Showroom application within the monorepo structure,
So that development can proceed with a stable, standardized foundation.

**Acceptance Criteria:**

**Given** A clean `ticci360` directory
**When** I initialize `apps/showroom` with Next.js App Router, TypeScript, and Tailwind
**Then** The folder structure follows the defined `src/features/*` pattern
**And** Linting and formatting rules are active
**And** A "Hello World" page is accessible via the local dev server

### Story 2.2: Product Catalog Listing (SSR & ISR)

As a Shopper,
I want to browse product categories and lists that load instantly,
So that I can discover products without waiting for slow database queries.

**Acceptance Criteria:**

**Given** The Product API is available
**When** I visit `/product-categories/[slug]` or `/products`
**Then** The page is server-rendered (SSR) with current data
**And** ISR tags are properly assigned for future invalidation
**And** SEO meta tags (title, description) are correctly populated from API data

### Story 2.3: Product Detail Page (SEO Optimized)

As a Shopper,
I want to view detailed information about a product on a dedicated page,
So that I can make an informed purchase decision.

**Acceptance Criteria:**

**Given** A specific product slug
**When** I navigate to `/products/[slug]`
**Then** I see the product images, price, stock status, and description
**And** The page URL is strictly preserved (no broken links)
**And** Canonical tags point to the legacy URL (during hybrid phase)
**And** Structured Data (JSON-LD) is present for rich snippets

### Story 2.4: Instant Search & Filtering (Client-Side)

As a Shopper,
I want to filter products and search by keywords dynamically,
So that I can narrow down my selection without page reloads.

**Acceptance Criteria:**

**Given** A product list is displayed
**When** I type in the search bar or select a filter (price, brand)
**Then** The product list updates instantly (client-side transition)
**And** The URL query parameters update to reflect the current filter state
**And** The back button works correctly to restore previous state

## Epic 3: Seamless Hybrid Commerce

Connect the modern discovery experience to the legacy transaction engine transparently, ensuring session continuity.

### Story 3.1: Hybrid Cart Integration (Add to Cart Action)

As a Shopper,
I want to add items to my cart directly from the Showroom interface,
So that I can build my order without leaving the modern experience.

**Acceptance Criteria:**

**Given** A product page with an "Add to Cart" button
**When** I click the button
**Then** A POST request is sent to `/api/v1/cart/add` with the product ID
**And** The request includes the HTTP-only session cookie
**And** The backend confirms the addition with the new cart total
**And** The UI updates optimistically or via confirmation

### Story 3.2: Floating Cart Preview (Mini-Cart)

As a Shopper,
I want to see a summary of my cart contents on every page,
So that I can keep track of my spending and selected items.

**Acceptance Criteria:**

**Given** I have items in my cart
**When** I view the site header or click the cart icon
**Then** I see the "Mini-Cart" with item count and total price
**And** The data is fetched from `/api/v1/cart` (ensuring sync with Legacy backend)

### Story 3.3: Checkout Redirect Handover

As a Shopper,
I want to proceed to payment seamlessly,
So that I can finalize my purchase on the secure legacy checkout.

**Acceptance Criteria:**

**Given** I am ready to buy
**When** I click "Checkout" in the Showroom
**Then** I am redirected to the legacy checkout URL (e.g., `www.tic.ci/checkout`)
**And** My session is preserved (I see my items in the legacy cart)
**And** No login is required again (if I was already logged in)

## Epic 4: B2B Expert Services

Digitize TICCI's consulting expertise to capture and process qualified B2B leads.

### Story 4.1: Expert Quote Request Form

As a B2B Client,
I want to request a custom quote with my company details (SIRET, specific needs),
So that I can get a personalized offer for my professional equipment.

**Acceptance Criteria:**

**Given** I am on the "Pro" page or a product page
**When** I fill out the quote request form (Name, Company, SIRET, Needs)
**Then** A POST request is sent to `/api/v1/leads/quote`
**And** I receive a success confirmation message
**And** The lead is stored in the backend (or sent via email to sales)

### Story 4.2: Expert Opinion Integration

As a Shopper,
I want to read the "Engineer's Opinion" on technical products,
So that I can understand the real value beyond the technical specs.

**Acceptance Criteria:**

**Given** A product with an expert review available in the backend
**When** I view the product detail page
**Then** I see a dedicated "L'avis de l'Expert" section
**And** The content is fetched from the `expert_review` API field
**And** It is visually distinct from the standard description
