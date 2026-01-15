# Technology Stack & Dependencies

## Core Frameworks
- **Laravel Framework**: v9.21
  - Foundation for the entire application.
  - Usage: Routing, Eloquent ORM, Middleware, Service Container.
- **Botble CMS**: v6.x (dev branch)
  - E-commerce specific layer on top of Laravel.
  - Components: Core, Plugins, Themes, Widgets.

## Frontend Stack
- **Vue.js**: v3.3.4
  - Used for dynamic components in the admin panel and parts of the storefront.
- **jQuery**: v3.7.1
  - Legacy DOM manipulation, widely used in the Farmart theme.
- **Bootstrap**: v5.3.5
  - CSS framework for responsive layout.
- **Sass**: v1.87
  - CSS pre-processor for theme customization.

## Key Dependencies
- **guzzlehttp/guzzle**: ^7.2 (HTTP Client)
- **intervention/image**: Image processing (implied by CMS standard).
- **barryvdh/laravel-dompdf**: PDF generation (invoicing).
- **maatwebsite/excel**: Excel export/import (product management).

## Dev Tools
- **Laravel Mix**: Asset compilation pipeline.
- **Prettier**: Code formatting.
- **PHPUnit**: Testing framework.
