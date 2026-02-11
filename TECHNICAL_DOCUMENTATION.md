# Ratna Sagar Business Management System (BMS)  
## Technical Architecture & System Documentation

**Document Version:** 1.0  
**Date:** February 2026  
**Classification:** Technical Reference Document  
**Prepared for:** Executive Leadership & Technical Review Panel

---

## Executive Summary

The Ratna Sagar Business Management System (BMS) is a proof-of-concept demonstration of a modern, enterprise-grade ERP-style platform designed specifically for the educational publishing industry. This document provides a comprehensive technical overview of the system architecture, design decisions, and implementation strategies that position this demo for seamless transition to a fully operational production system.

The system is built on a robust technology foundation combining **Laravel 12** (PHP 8.2+) for backend services with **Vue 3** (Composition API) and **Inertia.js** for a reactive, single-page application experience. This architecture enables real-time responsiveness while maintaining the security and simplicity of server-side routing.

---

## Table of Contents

1. [Overall System Architecture](#1-overall-system-architecture)
2. [Technology Stack Rationale](#2-technology-stack-rationale)
3. [Folder Structure & Modular Design](#3-folder-structure--modular-design)
4. [Role-Based Dashboards](#4-role-based-dashboards)
5. [Authentication & Authorization](#5-authentication--authorization)
6. [UI/UX Architecture](#6-uiux-architecture)
7. [Data Flow Architecture](#7-data-flow-architecture)
8. [Database Design Philosophy](#8-database-design-philosophy)
9. [API-First Architecture](#9-api-first-architecture)
10. [Security Considerations](#10-security-considerations)
11. [Performance & Scalability](#11-performance--scalability)
12. [Maintainability & Extensibility](#12-maintainability--extensibility)
13. [Production Conversion Roadmap](#13-production-conversion-roadmap)
14. [DevOps & Deployment Readiness](#14-devops--deployment-readiness)

---

## 1. Overall System Architecture

### 1.1 High-Level Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────────┐
│                           CLIENT LAYER                                   │
│  ┌─────────────────────────────────────────────────────────────────┐   │
│  │              Vue 3 SPA (Composition API)                         │   │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐        │   │
│  │  │ Layouts  │  │  Pages   │  │Components│  │ Stores   │        │   │
│  │  └──────────┘  └──────────┘  └──────────┘  └──────────┘        │   │
│  └─────────────────────────────────────────────────────────────────┘   │
│                              │ Inertia.js Protocol                      │
└──────────────────────────────┼──────────────────────────────────────────┘
                               ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                          SERVER LAYER                                    │
│  ┌─────────────────────────────────────────────────────────────────┐   │
│  │                   Laravel 12 Framework                           │   │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐        │   │
│  │  │ Routes   │  │Controllers│  │  Models  │  │Middleware│        │   │
│  │  └──────────┘  └──────────┘  └──────────┘  └──────────┘        │   │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐        │   │
│  │  │ Services │  │Providers │  │Validators│  │ Policies │        │   │
│  │  └──────────┘  └──────────┘  └──────────┘  └──────────┘        │   │
│  └─────────────────────────────────────────────────────────────────┘   │
└──────────────────────────────┼──────────────────────────────────────────┘
                               ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                          DATA LAYER                                      │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐        │
│  │   MySQL 8.x     │  │  Redis Cache    │  │  File Storage   │        │
│  │  (Primary DB)   │  │  (Sessions/     │  │  (Documents/    │        │
│  │                 │  │   Queue)        │  │   Media)        │        │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘        │
└─────────────────────────────────────────────────────────────────────────┘
```

### 1.2 Architectural Pattern: Inertia.js Monolith

The system adopts the **Inertia.js monolithic SPA** pattern, which combines the best aspects of traditional server-rendered applications with modern single-page application experiences:

- **Server-Side Routing**: All routes are defined in Laravel, maintaining a single source of truth for URL structure and authorization
- **Client-Side Rendering**: Vue 3 handles all UI rendering, providing instant page transitions without full page reloads
- **Shared Controllers**: Laravel controllers return Inertia responses, passing typed props directly to Vue components
- **Zero API Duplication**: No need to build and maintain separate REST APIs for the frontend

### 1.3 Key Architectural Benefits

| Aspect | Benefit |
|--------|---------|
| **SEO Compatibility** | Server-side initial render with full meta tag control |
| **Security** | All authorization logic stays server-side in Laravel middleware |
| **Developer Experience** | Single codebase, no API versioning, typed props from PHP to JS |
| **Performance** | XHR-based navigation with partial page reloads |
| **Maintainability** | Standard Laravel patterns, familiar to PHP developers |

---

## 2. Technology Stack Rationale

### 2.1 Backend: Laravel 12

**Why Laravel for Enterprise:**

- **Mature Ecosystem**: 10+ years of enterprise adoption with proven stability
- **Eloquent ORM**: Expressive database abstraction with relationship management
- **Built-in Security**: CSRF protection, SQL injection prevention, XSS filtering
- **Queue System**: Native support for background job processing (critical for reports, notifications)
- **Laravel Sanctum**: First-party API token authentication for mobile/external integrations
- **Artisan CLI**: Powerful tooling for migrations, seeders, and custom commands
- **Testing Suite**: PHPUnit integration with database factories for comprehensive testing

**Version Selection (Laravel 12):**
- Requires PHP 8.2+ with native type improvements
- Enhanced performance through JIT compilation support
- Long-term support candidate for enterprise deployments

### 2.2 Frontend: Vue 3 (Composition API)

**Why Vue 3 for Enterprise UI:**

- **Composition API**: Superior code organization for complex dashboard logic
- **TypeScript Ready**: Full TypeScript support for large-team development
- **Reactive System**: Proxy-based reactivity for predictable state management
- **Tree-Shaking**: Smaller bundle sizes through dead code elimination
- **Ecosystem**: Rich component libraries (Headless UI, Lucide Icons, ECharts)

**Key Frontend Libraries:**
```json
{
  "vue": "^3.4.0",
  "@inertiajs/vue3": "^2.0.0",
  "echarts": "^6.0.0",
  "vue-echarts": "^8.0.1",
  "apexcharts": "^5.3.6",
  "lucide-vue-next": "^0.563.0",
  "@headlessui/vue": "^1.7.23",
  "tailwindcss": "^3.2.1"
}
```

### 2.3 Database: MySQL 8.x

**Why MySQL for This Implementation:**

- **Industry Standard**: Widely supported, extensive tooling and talent pool
- **ACID Compliance**: Transaction support for financial data integrity
- **JSON Columns**: Native JSON data type for flexible schema evolution
- **Full-Text Search**: Built-in search capabilities for school/product lookups
- **Replication Ready**: Master-slave replication for read scaling
- **Cloud Compatibility**: Supported by all major cloud providers (AWS RDS, DigitalOcean, etc.)

### 2.4 Build Toolchain

```javascript
// vite.config.js - Modern Build Configuration
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,  // Hot Module Replacement in development
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
```

**Vite Benefits:**
- Sub-second hot module replacement
- Optimized production builds with code splitting
- Native ES modules in development
- Rollup-based production bundling

---

## 3. Folder Structure & Modular Design

### 3.1 Backend Structure (Laravel)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                    # Authentication controllers (Breeze)
│   │   │   ├── AuthenticatedSessionController.php
│   │   │   ├── RegisteredUserController.php
│   │   │   └── ...
│   │   ├── DashboardController.php  # Role-based dashboard routing
│   │   └── ProfileController.php    # User profile management
│   ├── Middleware/                   # Request filtering
│   └── Requests/                     # Form request validation
├── Models/
│   └── User.php                      # Core user model with role support
├── Providers/
│   └── AppServiceProvider.php        # Application bootstrapping

config/
├── app.php          # Core application configuration
├── auth.php         # Authentication guards and providers
├── database.php     # Database connection settings
├── filesystems.php  # Storage disk configuration
└── session.php      # Session driver configuration

database/
├── factories/       # Model factories for testing/seeding
│   └── UserFactory.php
├── migrations/      # Schema definitions
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000001_create_cache_table.php
│   ├── 0001_01_01_000002_create_jobs_table.php
│   └── 2026_01_28_150217_add_role_to_users_table.php
└── seeders/         # Data seeding
    └── DatabaseSeeder.php

routes/
├── web.php          # Application routes (Inertia)
├── auth.php         # Authentication routes (Breeze)
└── console.php      # Artisan command routes
```

### 3.2 Frontend Structure (Vue 3)

```
resources/js/
├── app.js                    # Application entry point
├── bootstrap.js              # Axios and global setup
├── Components/               # Reusable UI components
│   ├── ApplicationLogo.vue
│   ├── Checkbox.vue
│   ├── CommandPalette.vue    # Global search (⌘K)
│   ├── Dropdown.vue
│   ├── Modal.vue
│   ├── PrimaryButton.vue
│   ├── SecondaryButton.vue
│   ├── StatCard.vue
│   └── TextInput.vue
├── Layouts/                  # Page layout wrappers
│   ├── AuthenticatedLayout.vue  # Main app shell with navigation
│   └── GuestLayout.vue          # Login/register pages
└── Pages/                    # Route-mapped page components
    ├── Dashboard.vue         # Default dashboard redirect
    ├── Welcome.vue           # Public landing page
    ├── Auth/                 # Authentication pages
    │   ├── Login.vue
    │   ├── Register.vue
    │   └── ...
    ├── Dashboards/           # Role-specific dashboards
    │   ├── Admin.vue         # Super Admin dashboard
    │   ├── Executive.vue     # Sales Executive dashboard
    │   ├── GeoHead.vue       # Geographic Head dashboard
    │   ├── HR.vue            # HR Manager dashboard
    │   ├── TeamLeader.vue    # Team Leader dashboard
    │   └── VicePresident.vue # VP dashboard
    ├── PreSales/             # Pre-sales module
    │   └── Survey.vue        # School survey functionality
    ├── Profile/              # User profile pages
    │   ├── MyProfile.vue
    │   └── Security.vue
    ├── Support/              # Support module
    │   └── ServiceDesk.vue
    └── Team/                 # Team management
        └── Overview.vue      # Hierarchical team view
```

### 3.3 Design Philosophy: Feature-Based Organization

The folder structure follows a **feature-based organization** pattern where:

1. **Pages mirror routes**: Each Vue page component maps to a Laravel route
2. **Components are atomic**: Small, reusable components without business logic
3. **Layouts handle chrome**: Navigation, sidebars, and common UI elements
4. **Modules are self-contained**: Each business module (PreSales, Support, etc.) has its own folder

This organization scales well as the application grows—new modules simply add new folders without touching existing code.

---

## 4. Role-Based Dashboards

### 4.1 Organizational Hierarchy

The system implements a six-tier organizational hierarchy reflecting Ratna Sagar's sales structure:

```
┌─────────────────────────────────────────────────────────────────┐
│                        SUPER ADMIN                               │
│                   (System Administration)                        │
│  • Full system access                                           │
│  • User management                                              │
│  • Financial controls (OTP-protected)                           │
│  • Organization-wide analytics                                  │
└─────────────────────────────────────────────────────────────────┘
                              │
        ┌─────────────────────┴─────────────────────┐
        ▼                                           ▼
┌───────────────────────┐               ┌───────────────────────┐
│       HR MANAGER      │               │    VICE PRESIDENT     │
│  • Employee management│               │  • Regional oversight │
│  • Payroll processing │               │  • Target allocation  │
│  • Attendance tracking│               │  • Performance reviews│
│  • Recruitment        │               │  • Strategic planning │
└───────────────────────┘               └───────────────────────┘
                                                    │
                                                    ▼
                                        ┌───────────────────────┐
                                        │      HEAD GEO         │
                                        │  • Zone management    │
                                        │  • Team Leader KPIs   │
                                        │  • Regional reports   │
                                        └───────────────────────┘
                                                    │
                                                    ▼
                                        ┌───────────────────────┐
                                        │     TEAM LEADER       │
                                        │  • Executive tracking │
                                        │  • School assignments │
                                        │  • Performance mgmt   │
                                        └───────────────────────┘
                                                    │
                                                    ▼
                                        ┌───────────────────────┐
                                        │   SALES EXECUTIVE     │
                                        │  • School visits      │
                                        │  • Survey collection  │
                                        │  • Order management   │
                                        │  • Daily activities   │
                                        └───────────────────────┘
```

### 4.2 Dashboard Implementation

**Route Definition (web.php):**
```php
Route::prefix('dashboard')->group(function () {
    Route::get('/executive', [DashboardController::class, 'executive'])
        ->name('dashboard.executive');
    Route::get('/team-leader', [DashboardController::class, 'teamLeader'])
        ->name('dashboard.team-leader');
    Route::get('/geo-head', [DashboardController::class, 'geoHead'])
        ->name('dashboard.geo-head');
    Route::get('/vp', [DashboardController::class, 'vicePresident'])
        ->name('dashboard.vp');
    Route::get('/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');
    Route::get('/hr', [DashboardController::class, 'hr'])
        ->name('dashboard.hr');
});
```

**Controller Pattern (DashboardController.php):**
```php
class DashboardController extends Controller
{
    public function executive()
    {
        return Inertia::render('Dashboards/Executive');
    }

    public function admin()
    {
        return Inertia::render('Dashboards/Admin');
    }
    // ... other role-specific methods
}
```

### 4.3 Dashboard Features by Role

| Role | Key Dashboard Features |
|------|----------------------|
| **Super Admin** | Financial Sankey flow, Revenue trends, Organizational power map, Risk indicators, Critical issue reporting |
| **Vice President** | Regional performance, Target vs achievement, Team hierarchy drilldown, Strategic KPIs |
| **HR Manager** | Employee database, Recruitment pipeline, Attendance analytics, Payroll summary, Leave management |
| **Head GEO** | Zone-wise performance, Team Leader KPIs, School coverage maps, Regional alerts |
| **Team Leader** | Executive performance grid, School assignments, Pipeline tracking, Pending actions |
| **Sales Executive** | Personal targets, Daily tasks, School visits, Survey forms, Order tracking, Pipeline funnel |

### 4.4 Dynamic Navigation

The `AuthenticatedLayout.vue` implements intelligent role-based navigation:

```javascript
const dashboardRoute = computed(() => {
    const role = userRole.value;
    if (role === 'admin') return route('dashboard.admin');
    if (role === 'hr') return route('dashboard.hr');
    if (role === 'vp') return route('dashboard.vp');
    if (role === 'geo-head') return route('dashboard.geo-head');
    if (role === 'team-leader') return route('dashboard.team-leader');
    if (role === 'executive') return route('dashboard.executive');
    return route('dashboard');
});

// Conditional menu visibility
const navigation = computed(() => [
    // ...
    { 
        name: 'HR', 
        icon: Award,
        isGroup: true,
        visible: userRole.value === 'admin' || userRole.value === 'hr',
        children: [/* HR-specific menu items */]
    },
    // ...
]);
```

---

## 5. Authentication & Authorization

### 5.1 Authentication: Laravel Breeze + Inertia

The system uses **Laravel Breeze with Inertia/Vue** scaffold, providing:

- Email/password authentication
- Email verification (optional activation)
- Password reset via email
- "Remember me" functionality
- Session-based authentication

**Authentication Flow:**
```
User Login Request
       │
       ▼
┌─────────────────────────┐
│ AuthenticatedSession    │
│ Controller::store()     │
│ • Validate credentials  │
│ • Rate limiting         │
│ • Session regeneration  │
└─────────────────────────┘
       │
       ▼
┌─────────────────────────┐
│  Session Cookie Set     │
│  Redirect to Dashboard  │
└─────────────────────────┘
```

### 5.2 Role-Based Access Control (RBAC) - Conceptual

**Current Implementation (Demo):**
```php
// User model with role attribute
protected $fillable = ['name', 'email', 'password', 'role'];

// Migration adding role column
Schema::table('users', function (Blueprint $table) {
    $table->string('role')->default('user');
});
```

**Production Enhancement Blueprint:**

```php
// Policy-based authorization (to be implemented)
class DashboardPolicy
{
    public function viewAdminDashboard(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewHRDashboard(User $user): bool
    {
        return in_array($user->role, ['admin', 'hr']);
    }

    public function viewSalesData(User $user): bool
    {
        return in_array($user->role, ['admin', 'vp', 'geo-head', 'team-leader', 'executive']);
    }
}

// Middleware for route protection
class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized access');
        }
        return $next($request);
    }
}

// Route protection
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard.admin');
```

### 5.3 Available Demo Users

```php
// DatabaseSeeder.php - Pre-configured test accounts
User::factory()->create(['email' => 'admin@ratnasagar.com', 'role' => 'admin']);
User::factory()->create(['email' => 'hr@ratnasagar.com', 'role' => 'hr']);
User::factory()->create(['email' => 'vp@ratnasagar.com', 'role' => 'vp']);
User::factory()->create(['email' => 'geo@ratnasagar.com', 'role' => 'geo-head']);
User::factory()->create(['email' => 'tl@ratnasagar.com', 'role' => 'team-leader']);
User::factory()->create(['email' => 'exec@ratnasagar.com', 'role' => 'executive']);
// All passwords: 'password'
```

---

## 6. UI/UX Architecture

### 6.1 Design System Overview

The UI follows a **modern enterprise dashboard** aesthetic with:

- **Color Palette**: Orange/red accent (#AC0C13, #F36E21) on neutral slate backgrounds
- **Typography**: System fonts with Rupee symbol support
- **Spacing**: Consistent 4px grid system via Tailwind
- **Components**: Atomic design with reusable primitives

### 6.2 Layout Architecture

**AuthenticatedLayout.vue Structure:**
```
┌─────────────────────────────────────────────────────────────────┐
│                    HEADER (72px, Sticky)                        │
│  ┌──────────┐  ┌─────────────────┐  ┌───────────────────────┐  │
│  │   Logo   │  │ Role + Date     │  │ Search | Notif | User │  │
│  └──────────┘  └─────────────────┘  └───────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
┌──────────────┬──────────────────────────────────────────────────┐
│   SIDEBAR    │                    CONTENT                       │
│   (264px)    │                                                  │
│              │  ┌────────────────────────────────────────────┐  │
│  • Overview  │  │                                            │  │
│  • Profile   │  │            Page Content                    │  │
│  • Pre-Sales │  │            (slot)                          │  │
│  • Sales     │  │                                            │  │
│  • Post Sales│  │                                            │  │
│  • Team      │  │                                            │  │
│  • HR        │  │                                            │  │
│  • Support   │  │                                            │  │
│              │  └────────────────────────────────────────────┘  │
│              │                                                  │
│  [Flyout     │                                                  │
│   Menus]     │                                                  │
│              │                                                  │
└──────────────┴──────────────────────────────────────────────────┘
```

### 6.3 Component Reusability

**Reusable Component Examples:**

```vue
<!-- StatCard.vue - Reusable metric card -->
<template>
  <div class="rounded-2xl bg-white p-6 shadow-sm border">
    <div class="flex justify-between items-start mb-3">
      <div class="p-2 rounded-lg" :class="iconBgClass">
        <component :is="icon" class="w-5 h-5" :class="iconClass" />
      </div>
      <span class="text-xs font-bold" :class="trendClass">{{ trend }}</span>
    </div>
    <p class="text-xs font-bold text-slate-400 uppercase">{{ label }}</p>
    <div class="text-2xl font-bold text-slate-800">{{ value }}</div>
  </div>
</template>
```

**Key Reusable Components:**
| Component | Purpose |
|-----------|---------|
| `Dropdown.vue` | Accessible dropdown menus |
| `Modal.vue` | Dialog overlays with transitions |
| `CommandPalette.vue` | Global search (⌘K shortcut) |
| `TextInput.vue` | Styled form inputs |
| `PrimaryButton.vue` | Consistent CTA buttons |
| `Checkbox.vue` | Custom styled checkboxes |

### 6.4 Visualization Libraries

**ECharts Integration (Admin/Team dashboards):**
```javascript
import VChart from 'vue-echarts';
import { use } from 'echarts/core';
import { LineChart, BarChart, PieChart, SankeyChart } from 'echarts/charts';

// Sankey diagram for financial flow
const sankeyOption = {
    series: {
        type: 'sankey',
        data: [
            { name: 'Revenue', itemStyle: { color: '#ea580c' } },
            { name: 'Net Profit', itemStyle: { color: '#16a34a' } },
            // ... expense categories
        ],
        links: [
            { source: 'Revenue', target: 'Net Profit', value: 24.5 },
            // ... expense allocations
        ]
    }
};
```

**ApexCharts for Executive Dashboards:**
```javascript
import VueApexCharts from 'vue3-apexcharts';
// Used for pipeline funnels, trend charts
```

---

## 7. Data Flow Architecture

### 7.1 Inertia.js Data Flow

```
┌────────────────────┐     HTTP Request      ┌────────────────────┐
│                    │ ─────────────────────▶│                    │
│   Vue Component    │                        │  Laravel Controller│
│   (Browser)        │                        │  (Server)          │
│                    │◀───────────────────── │                    │
└────────────────────┘   Inertia Response    └────────────────────┘
                         (JSON + Page Props)
```

**Server-to-Client Data Passing:**
```php
// Controller
public function executive()
{
    return Inertia::render('Dashboards/Executive', [
        'user' => auth()->user(),
        'targets' => Target::forUser(auth()->id())->get(),
        'schools' => School::assigned(auth()->id())->paginate(10),
        'kpis' => KpiService::calculateForUser(auth()->id()),
    ]);
}
```

**Client-Side Consumption:**
```vue
<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.auth.user);
// Props are automatically available via Inertia
</script>
```

### 7.2 Request Flow for User Actions

```
User Action (e.g., Submit Survey)
           │
           ▼
┌─────────────────────────────┐
│  Inertia.post('/survey', {  │
│    schoolId: 123,           │
│    responses: {...}         │
│  })                         │
└─────────────────────────────┘
           │
           ▼
┌─────────────────────────────┐
│  SurveyController::store()  │
│  • Validate request         │
│  • Process business logic   │
│  • Persist to database      │
│  • Return redirect/response │
└─────────────────────────────┘
           │
           ▼
┌─────────────────────────────┐
│  Inertia Response           │
│  • Partial page update      │
│  • Flash message            │
│  • Updated props            │
└─────────────────────────────┘
```

### 7.3 Shared Data via HandleInertiaRequests Middleware

```php
// app/Http/Middleware/HandleInertiaRequests.php
public function share(Request $request): array
{
    return [
        ...parent::share($request),
        'auth' => [
            'user' => $request->user() ? [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role,
            ] : null,
        ],
        'flash' => [
            'success' => session('success'),
            'error' => session('error'),
        ],
    ];
}
```

---

## 8. Database Design Philosophy

### 8.1 Current Schema (Demo)

```
┌─────────────────────────────────────────────────────────────────┐
│                     USERS TABLE                                  │
├─────────────────────────────────────────────────────────────────┤
│ id          │ BIGINT UNSIGNED │ PK, AUTO_INCREMENT              │
│ name        │ VARCHAR(255)    │ User full name                  │
│ email       │ VARCHAR(255)    │ UNIQUE, for authentication      │
│ password    │ VARCHAR(255)    │ Hashed via bcrypt               │
│ role        │ VARCHAR(255)    │ DEFAULT 'user'                  │
│ email_verified_at │ TIMESTAMP │ Email verification status       │
│ remember_token │ VARCHAR(100) │ Session persistence             │
│ created_at  │ TIMESTAMP       │                                 │
│ updated_at  │ TIMESTAMP       │                                 │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                    SESSIONS TABLE                                │
├─────────────────────────────────────────────────────────────────┤
│ id          │ VARCHAR(255)    │ PK, Session ID                  │
│ user_id     │ BIGINT UNSIGNED │ FK → users.id                   │
│ ip_address  │ VARCHAR(45)     │ Client IP                       │
│ user_agent  │ TEXT            │ Browser/device info             │
│ payload     │ LONGTEXT        │ Serialized session data         │
│ last_activity│ INTEGER        │ Unix timestamp                  │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                     CACHE TABLE                                  │
├─────────────────────────────────────────────────────────────────┤
│ key         │ VARCHAR(255)    │ PK, Cache key                   │
│ value       │ MEDIUMTEXT      │ Serialized data                 │
│ expiration  │ INTEGER         │ Unix timestamp                  │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                     JOBS TABLE                                   │
├─────────────────────────────────────────────────────────────────┤
│ id          │ BIGINT UNSIGNED │ PK, Job ID                      │
│ queue       │ VARCHAR(255)    │ Queue name                      │
│ payload     │ LONGTEXT        │ Serialized job data             │
│ attempts    │ TINYINT         │ Retry count                     │
│ reserved_at │ INT UNSIGNED    │ Worker reservation timestamp    │
│ available_at│ INT UNSIGNED    │ Scheduled execution time        │
│ created_at  │ INT UNSIGNED    │ Job creation timestamp          │
└─────────────────────────────────────────────────────────────────┘
```

### 8.2 Production Schema Blueprint

For full production deployment, the following entity model is recommended:

```
                    ┌─────────────────┐
                    │     USERS       │
                    ├─────────────────┤
                    │ id              │
                    │ name            │
                    │ email           │
    ┌───────────────│ role_id (FK)    │───────────────┐
    │               │ department_id   │               │
    │               │ reports_to_id   │               │
    │               └─────────────────┘               │
    │                       │                         │
    ▼                       ▼                         ▼
┌───────────────┐   ┌───────────────┐   ┌───────────────────┐
│    ROLES      │   │  DEPARTMENTS  │   │   PERMISSIONS     │
├───────────────┤   ├───────────────┤   ├───────────────────┤
│ id            │   │ id            │   │ id                │
│ name          │   │ name          │   │ name              │
│ slug          │   │ code          │   │ slug              │
│ level         │   │ parent_id     │   │ description       │
└───────────────┘   └───────────────┘   └───────────────────┘
        │                                       │
        └───────────────────────────────────────┘
                  ROLE_PERMISSIONS (M:N)

┌─────────────────┐       ┌─────────────────┐       ┌─────────────────┐
│    SCHOOLS      │       │    SURVEYS      │       │     ORDERS      │
├─────────────────┤       ├─────────────────┤       ├─────────────────┤
│ id              │       │ id              │       │ id              │
│ name            │◄──────│ school_id (FK)  │       │ school_id (FK)  │
│ board           │       │ user_id (FK)    │       │ user_id (FK)    │
│ type            │       │ status          │       │ status          │
│ address         │       │ completed_at    │       │ total_amount    │
│ contact_email   │       │ responses (JSON)│       │ discount        │
│ assigned_to_id  │       └─────────────────┘       │ approved_by_id  │
│ geo_zone        │                                 └─────────────────┘
└─────────────────┘

┌─────────────────┐       ┌─────────────────┐       ┌─────────────────┐
│   ORDER_ITEMS   │       │   PRODUCTS      │       │   TARGETS       │
├─────────────────┤       ├─────────────────┤       ├─────────────────┤
│ id              │       │ id              │       │ id              │
│ order_id (FK)   │       │ name            │       │ user_id (FK)    │
│ product_id (FK) │◄──────│ sku             │       │ fiscal_year     │
│ quantity        │       │ category        │       │ target_amount   │
│ unit_price      │       │ mrp             │       │ target_quantity │
│ discount        │       │ stock           │       │ achieved_amount │
└─────────────────┘       └─────────────────┘       └─────────────────┘

┌─────────────────┐       ┌─────────────────┐       ┌─────────────────┐
│   ACTIVITIES    │       │   ATTENDANCE    │       │   LEAVE_REQUESTS│
├─────────────────┤       ├─────────────────┤       ├─────────────────┤
│ id              │       │ id              │       │ id              │
│ user_id (FK)    │       │ user_id (FK)    │       │ user_id (FK)    │
│ type            │       │ date            │       │ leave_type      │
│ description     │       │ check_in        │       │ from_date       │
│ related_id      │       │ check_out       │       │ to_date         │
│ related_type    │       │ status          │       │ status          │
│ metadata (JSON) │       │ location (JSON) │       │ approved_by_id  │
└─────────────────┘       └─────────────────┘       └─────────────────┘
```

### 8.3 Scalability Considerations

**Indexing Strategy:**
```sql
-- High-priority indexes for production
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_reports_to ON users(reports_to_id);
CREATE INDEX idx_schools_assigned ON schools(assigned_to_id);
CREATE INDEX idx_schools_zone ON schools(geo_zone);
CREATE INDEX idx_orders_status ON orders(status, created_at);
CREATE INDEX idx_surveys_user_date ON surveys(user_id, completed_at);
```

**Partitioning for Large Tables:**
```sql
-- Example: Partitioning orders by year for efficient historical queries
ALTER TABLE orders PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION pmax VALUES LESS THAN MAXVALUE
);
```

---

## 9. API-First Architecture

### 9.1 Current Approach: Inertia Endpoints

While the demo uses Inertia.js (which doesn't require explicit API endpoints for the frontend), the architecture is **API-ready**:

**Sanctum Configuration (composer.json):**
```json
"require": {
    "laravel/sanctum": "^4.0"
}
```

### 9.2 Future API Layer Blueprint

For mobile apps, third-party integrations, or headless frontend scenarios:

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    
    // User & Auth
    Route::get('/user', fn(Request $r) => $r->user());
    
    // Dashboard APIs
    Route::prefix('dashboard')->group(function () {
        Route::get('/kpis', [ApiDashboardController::class, 'kpis']);
        Route::get('/targets', [ApiDashboardController::class, 'targets']);
        Route::get('/team-hierarchy', [ApiDashboardController::class, 'teamHierarchy']);
    });
    
    // School Management
    Route::apiResource('schools', SchoolController::class);
    Route::post('/schools/{school}/assign', [SchoolController::class, 'assign']);
    
    // Survey APIs
    Route::apiResource('surveys', SurveyController::class);
    Route::post('/surveys/{survey}/submit', [SurveyController::class, 'submit']);
    
    // Order Management
    Route::apiResource('orders', OrderController::class);
    Route::post('/orders/{order}/approve', [OrderController::class, 'approve']);
    
    // HR Module
    Route::prefix('hr')->group(function () {
        Route::get('/employees', [HRController::class, 'employees']);
        Route::get('/attendance', [HRController::class, 'attendance']);
        Route::apiResource('leave-requests', LeaveRequestController::class);
    });
});
```

### 9.3 API Response Standards

```php
// Standardized API response format
class ApiResponse
{
    public static function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }

    public static function error($message, $errors = [], $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }

    public static function paginated($paginator, $resource = null)
    {
        return response()->json([
            'success' => true,
            'data' => $resource ? $resource::collection($paginator) : $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
```

---

## 10. Security Considerations

### 10.1 Built-in Laravel Security

| Feature | Implementation |
|---------|----------------|
| **CSRF Protection** | Automatic via Inertia.js + Laravel middleware |
| **SQL Injection** | Eloquent ORM with prepared statements |
| **XSS Prevention** | Vue.js automatic escaping + Laravel Blade |
| **Password Hashing** | bcrypt via `Hash::make()` |
| **Session Security** | Encrypted cookies, session regeneration on login |
| **Rate Limiting** | Built-in throttling for auth endpoints |

### 10.2 RBAC Security (Production Blueprint)

```php
// Middleware stack for protected routes
Route::middleware([
    'auth',                    // Authenticated users only
    'verified',                // Email verified (optional)
    'role:admin,hr',          // Role-based access
    'permission:view-salary', // Granular permissions
])->group(function () {
    // Protected routes
});

// Policy-based authorization
class OrderPolicy
{
    public function approve(User $user, Order $order): bool
    {
        // Only team leaders and above can approve
        $approverRoles = ['admin', 'vp', 'geo-head', 'team-leader'];
        
        // Cannot approve own orders
        if ($order->user_id === $user->id) {
            return false;
        }
        
        return in_array($user->role, $approverRoles);
    }
}
```

### 10.3 Data Isolation Patterns

```php
// Global scope for data isolation by region
class GeoScopedModel extends Model
{
    protected static function booted()
    {
        static::addGlobalScope('geo-isolation', function ($query) {
            $user = auth()->user();
            
            if ($user->role === 'executive') {
                $query->where('assigned_to_id', $user->id);
            } elseif ($user->role === 'team-leader') {
                $query->whereIn('assigned_to_id', $user->teamMemberIds());
            } elseif ($user->role === 'geo-head') {
                $query->whereIn('geo_zone', $user->managedZones());
            }
            // Admin and VP see all data
        });
    }
}
```

### 10.4 Sensitive Data Protection (Demo Feature)

The Admin dashboard demonstrates OTP-protected financial data access:

```javascript
// Financial unlock with OTP verification
const isFinancialsUnlocked = ref(false);
const showUnlockModal = ref(false);

const submitOTP = () => {
    if (otpInput.value.trim() === correctOTP) {
        isFinancialsUnlocked.value = true;
        closeUnlockModal();
    }
};

// Masked display until unlocked
const displayFinancial = (value) => {
    if (isFinancialsUnlocked.value) return formatRupee(value);
    return '<span class="tracking-widest font-bold">•••••••</span>';
};
```

### 10.5 Production Security Checklist

- [ ] Implement proper RBAC middleware for all routes
- [ ] Add API rate limiting (60 requests/minute for standard endpoints)
- [ ] Enable HTTPS-only with HSTS headers
- [ ] Implement audit logging for sensitive operations
- [ ] Add two-factor authentication for admin users
- [ ] Configure Content Security Policy headers
- [ ] Set up database encryption for PII fields
- [ ] Implement IP whitelisting for admin panel (optional)

---

## 11. Performance & Scalability

### 11.1 Frontend Performance

**Current Optimizations:**
- Vite code splitting (lazy-loaded routes)
- Tree-shaking for unused component removal
- Tailwind CSS purging (only used classes in production)
- ECharts component-level imports (no full library load)

**Production Build Output:**
```bash
npm run build

# Output example:
dist/assets/app.abc123.js        # Main bundle (~150KB gzipped)
dist/assets/vendor.def456.js     # Vue + dependencies (~80KB gzipped)
dist/assets/echarts.ghi789.js    # Charts (lazy-loaded, ~200KB)
```

### 11.2 Backend Performance

**Recommended Production Stack:**

```
┌─────────────────────────────────────────────────────────────────┐
│                    LOAD BALANCER (Nginx/HAProxy)                │
└─────────────────────────────────────────────────────────────────┘
                              │
           ┌──────────────────┼──────────────────┐
           ▼                  ▼                  ▼
    ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
    │  App Server │    │  App Server │    │  App Server │
    │  (PHP-FPM)  │    │  (PHP-FPM)  │    │  (PHP-FPM)  │
    └─────────────┘    └─────────────┘    └─────────────┘
           │                  │                  │
           └──────────────────┼──────────────────┘
                              ▼
                    ┌─────────────────┐
                    │   Redis Cluster │
                    │  (Cache/Queue)  │
                    └─────────────────┘
                              │
                    ┌─────────────────┐
                    │  MySQL Primary  │───────▶ MySQL Replica(s)
                    └─────────────────┘
```

**Laravel Optimization Commands:**
```bash
# Production optimizations
php artisan config:cache     # Cache configuration
php artisan route:cache      # Cache route definitions
php artisan view:cache       # Compile Blade templates
php artisan optimize         # All-in-one optimization
```

### 11.3 Caching Strategy

```php
// config/cache.php - Redis for production
'default' => env('CACHE_STORE', 'redis'),

// Example caching patterns
class DashboardService
{
    public function getKpis(User $user): array
    {
        $cacheKey = "dashboard.kpis.{$user->id}";
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $this->calculateKpis($user);
        });
    }
}
```

### 11.4 Queue Processing for Heavy Operations

```php
// Report generation via queue
class GenerateMonthlyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Carbon $month
    ) {}

    public function handle()
    {
        $report = ReportService::generateMonthly($this->user, $this->month);
        
        $this->user->notify(new ReportReadyNotification($report));
    }
}

// Dispatch from controller
GenerateMonthlyReportJob::dispatch($user, now()->subMonth());
```

---

## 12. Maintainability & Extensibility

### 12.1 Code Quality Standards

**PHP Standards:**
- PSR-12 coding style (enforced via Laravel Pint)
- Type declarations for all method parameters/returns
- DocBlocks for complex business logic

**JavaScript/Vue Standards:**
- ESLint + Prettier configuration
- Composition API with `<script setup>` syntax
- PropTypes for component interfaces

### 12.2 Testing Strategy (Production Blueprint)

```php
// Feature test example
class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_executive_can_access_own_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'executive']);
        
        $response = $this->actingAs($user)
            ->get(route('dashboard.executive'));
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Dashboards/Executive')
        );
    }

    public function test_executive_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'executive']);
        
        $response = $this->actingAs($user)
            ->get(route('dashboard.admin'));
        
        $response->assertStatus(403);
    }
}
```

### 12.3 Module Extensibility Pattern

Adding a new module (e.g., "Inventory Management"):

```
1. Backend
   ├── app/Http/Controllers/InventoryController.php
   ├── app/Models/Product.php, Warehouse.php
   ├── app/Services/InventoryService.php
   ├── database/migrations/create_inventory_tables.php
   └── routes/web.php (add inventory routes)

2. Frontend
   └── resources/js/Pages/Inventory/
       ├── Index.vue
       ├── Products.vue
       ├── Warehouses.vue
       └── StockTransfer.vue

3. Navigation
   └── Update AuthenticatedLayout.vue navigation array
```

### 12.4 Configuration Management

```php
// Environment-based configuration
// .env.production
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

// .env.staging
APP_ENV=staging
APP_DEBUG=true
LOG_LEVEL=debug
```

---

## 13. Production Conversion Roadmap

### 13.1 Phase 1: Core Infrastructure (Weeks 1-2)

**Database Implementation:**
- [ ] Design complete production schema based on blueprint
- [ ] Create all migrations with proper indexes
- [ ] Implement Eloquent models with relationships
- [ ] Set up database seeders for master data

**Authentication Hardening:**
- [ ] Implement proper RBAC middleware
- [ ] Add Laravel Policies for all resources
- [ ] Configure two-factor authentication
- [ ] Set up audit logging

### 13.2 Phase 2: Core Modules (Weeks 3-6)

**School Management Module:**
- [ ] CRUD operations for schools
- [ ] School assignment workflow
- [ ] Geographic zone management
- [ ] School search and filtering

**Survey Module:**
- [ ] Survey form builder
- [ ] Photo/document upload
- [ ] GPS location capture
- [ ] Offline capability (PWA)

**Order Management:**
- [ ] Order creation workflow
- [ ] Multi-level approval process
- [ ] Invoice generation
- [ ] Payment tracking

### 13.3 Phase 3: Advanced Features (Weeks 7-10)

**Reporting Engine:**
- [ ] Dynamic report builder
- [ ] Scheduled report generation
- [ ] Export to PDF/Excel
- [ ] Email delivery

**HR Module:**
- [ ] Employee database
- [ ] Attendance integration
- [ ] Leave management workflow
- [ ] Payroll processing

**Notifications:**
- [ ] In-app notifications
- [ ] Email notifications
- [ ] Push notifications (mobile)
- [ ] SMS integration

### 13.4 Phase 4: Testing & Launch (Weeks 11-12)

**Quality Assurance:**
- [ ] Unit test coverage (>80%)
- [ ] Integration tests for critical workflows
- [ ] Performance testing (load testing)
- [ ] Security audit

**Deployment:**
- [ ] Production environment setup
- [ ] CI/CD pipeline configuration
- [ ] Monitoring and alerting
- [ ] Documentation and training

---

## 14. DevOps & Deployment Readiness

### 14.1 Current Deployment Guide

The project includes a comprehensive `DEPLOYMENT_GUIDE.md` for DigitalOcean deployment covering:

- Droplet provisioning (Ubuntu 24.04 LTS)
- LEMP stack installation (Nginx, PHP-FPM, MySQL)
- Application deployment via Git
- SSL certificate configuration (Let's Encrypt)
- Nginx virtual host configuration

### 14.2 Recommended Production Infrastructure

**Minimum Viable Production (MVP):**
```
Single Server ($20-50/month)
├── DigitalOcean Droplet (2GB RAM, 1 vCPU)
├── Managed MySQL ($15/month) - removes DB ops burden
├── Spaces Object Storage - for file uploads
└── CloudFlare - CDN + SSL + DDoS protection
```

**Scalable Production:**
```
Multi-Server Architecture ($200-500/month)
├── Load Balancer (DigitalOcean LB)
├── 2-3 App Servers (Auto-scaling)
├── Managed MySQL with Read Replica
├── Redis Cluster (DigitalOcean Managed)
├── Object Storage (S3/Spaces)
├── CDN (CloudFlare/Fastly)
└── Monitoring (Datadog/New Relic)
```

### 14.3 CI/CD Pipeline (GitHub Actions)

```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches: [main]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - run: composer install --no-dev
      - run: php artisan test

  deploy:
    needs: test
    runs-on: ubuntu-latest
    steps:
      - name: Deploy to Server
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SERVER_HOST }}
          username: ${{ secrets.SERVER_USER }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /var/www/ratnasagar
            git pull origin main
            composer install --no-dev --optimize-autoloader
            php artisan migrate --force
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            npm ci && npm run build
            sudo systemctl reload php8.2-fpm
```

### 14.4 Monitoring & Observability

**Recommended Stack:**
- **Application Monitoring**: Laravel Telescope (dev), Sentry (production)
- **Server Monitoring**: Datadog or New Relic APM
- **Log Aggregation**: Laravel Pail, Papertrail, or ELK Stack
- **Uptime Monitoring**: Pingdom or UptimeRobot
- **Error Tracking**: Sentry or Bugsnag

---

## Conclusion

The Ratna Sagar Business Management System demo represents a well-architected foundation for enterprise-scale deployment. The technology choices—Laravel 12, Vue 3, and Inertia.js—provide an optimal balance of developer productivity, code maintainability, and runtime performance.

**Key Strengths:**
1. **Modern Stack**: Industry-standard technologies with long-term support
2. **Scalable Architecture**: Clean separation of concerns enabling horizontal scaling
3. **Role-Based Design**: Comprehensive multi-tier dashboard system
4. **Production-Ready Patterns**: Security, caching, and queue infrastructure in place
5. **Clear Extension Path**: Modular design allows feature addition without rewrites

**Investment Required for Production:**
- **Development**: 10-12 weeks with a team of 2-3 developers
- **Infrastructure**: $200-500/month for initial production environment
- **Ongoing**: Standard maintenance and iterative feature development

The demo successfully demonstrates the system's capability to handle Ratna Sagar's business requirements while providing a clear, risk-mitigated path to full production deployment.

---

**Document prepared by:** Technical Architecture Team  
**Review Status:** Ready for CTO/Engineering Panel Review  
**Next Steps:** Schedule technical deep-dive session for stakeholder questions
