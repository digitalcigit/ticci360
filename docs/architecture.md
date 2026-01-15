# System Architecture - Botble/Laravel

## High-Level Structure
TICCI runs on the **Botble CMS**, which imposes a specific directory structure on top of Laravel.

### 1. Platform Core (`platform/core`)
Contains the kernel of the CMS.
- **Base**: Core traits and controllers.
- **Setting**: Configuration management.
- **Table**: Data tables generation.
- **ACL**: User permissions and roles.

### 2. Plugins Architecture (`platform/plugins`)
Functionality is encapsulated in independent plugins. Key plugins detected:
- **Ecommerce**: Product, Order, Customer management.
- **Marketplace**: Multi-vendor capabilities (if active).
- **Payment**: Payment gateway integrations.
- **Location**: Country/City management.

### 3. Theme System (`platform/themes`)
- **Active Theme**: `farmart`
- **Structure**:
  - `views/`: Blade templates.
  - `partials/`: Reusable UI chunks.
  - `widgets/`: Sidebar/Footer blocks.
  - `assets/`: Raw JS/SCSS files.
  - `public/`: Compiled assets (exposed to web).

## Data Flow
1. **Request** hits `public/index.php`.
2. **Laravel Router** dispatches to Controller (Core or Plugin).
3. **Controller** interacts with Repositories (Data Access Layer).
4. **Repository** queries Database via Eloquent Models.
5. **Controller** returns View (Theme Blade file) or JSON (API).

## Customization Strategy
- **DO NOT** modify `platform/core` or `platform/plugins` directly (updates will overwrite).
- **DO** use `platform/themes/farmart` for frontend changes.
- **DO** create custom plugins for new B2B features (e.g., `plugins/ticci-services`).
