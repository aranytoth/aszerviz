# CLAUDE.md - AI Assistant Guide for Aszerviz

This document provides comprehensive information about this Laravel application codebase for AI assistants to work effectively on the project.

## Project Overview

**Aszerviz** is a workshop/garage management system built for the Hungarian market. It handles:
- Workshop management (worksheets/quotes/invoices)
- Client and vehicle records
- Multi-tenant garage operations
- Calendar/appointment scheduling
- Content management system (CMS) for pages and posts
- Multilingual content (Hungarian primary, English secondary)
- Integration with Szamlazz.hu (Hungarian invoicing system)

**Primary Language:** Hungarian (route paths, UI, database content)
**Target Market:** Hungarian automotive workshops and garages
**Architecture:** Monolithic Laravel application with server-rendered Blade templates

## Technology Stack

### Backend
- **Framework:** Laravel 12.0
- **PHP Version:** 8.2+
- **Database:** SQLite (default), MySQL/MariaDB supported
- **Authentication:** Laravel Sanctum 4.0 (API tokens)
- **Authorization:** Spatie Laravel Permission 6.21 (RBAC)
- **Search:** Laravel Scout 10.20 + Meilisearch 1.16
- **PDF Generation:** DomPDF 3.1
- **Media Management:** Spatie Laravel Media Library 11.14
- **Translations:** Spatie Laravel Translatable 6.11
- **Invoicing:** Szamlazz.hu integration (custom component)
- **Queue:** Database driver

### Frontend
- **Build Tool:** Vite 7.0.4
- **CSS Frameworks:** Tailwind CSS 4.0 + Bootstrap 5.2.3 (hybrid)
- **JavaScript:** Vanilla JS with jQuery, Axios
- **Template Engine:** Blade
- **SASS:** Version 1.56.1

### Development Tools
- **Testing:** PHPUnit 11.5.3
- **Code Style:** Laravel Pint 1.13
- **Local Development:** Laravel Sail 1.41
- **Log Viewer:** Laravel Pail 1.2.2
- **Scaffolding:** Laravel UI 4.6
- **Concurrency:** Concurrently 9.0.1

## Directory Structure

```
/home/user/aszerviz/
├── app/
│   ├── Components/           # Custom components (Szamlazz integration)
│   ├── Enums/               # PHP 8.2 enums (PageStatus, PageType)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/       # Admin panel controllers (24 controllers)
│   │   │   ├── Auth/        # Authentication controllers
│   │   │   └── Public/      # Public-facing controllers
│   │   ├── Middleware/      # HTTP middleware
│   │   └── Requests/        # Form requests
│   ├── Jobs/                # Queue jobs (OptimizeVideo)
│   ├── Mail/                # Mailable classes (Offer, Test)
│   ├── Models/              # 17 Eloquent models
│   ├── Providers/           # Service providers
│   ├── Services/            # Business logic services (TranslationService)
│   ├── Traits/              # Reusable traits (SearchableInAllLocales, Uploadable)
│   └── helpers.php          # Global helper functions (auto-loaded)
├── bootstrap/               # Framework bootstrap
├── config/                  # Configuration files
│   ├── app.php             # App config (locales: hu, en)
│   └── site.php            # Custom site config (translation groups)
├── database/
│   ├── factories/          # Model factories
│   ├── migrations/         # 19 database migrations
│   └── seeders/            # Database seeders
├── public/
│   ├── static/             # Static assets (CSS, JS, images, fonts)
│   └── index.php           # Entry point
├── resources/
│   ├── css/                # Tailwind CSS
│   ├── js/                 # JavaScript files
│   ├── sass/               # SASS files
│   ├── views/              # 72 Blade templates
│   │   ├── admin/          # Admin panel views
│   │   ├── auth/           # Authentication views
│   │   ├── calendar/       # Calendar interface
│   │   ├── client/         # Client management views
│   │   ├── company/        # Company management views
│   │   ├── garage/         # Garage management views
│   │   ├── layouts/        # Layout templates
│   │   ├── mail/           # Email templates
│   │   ├── pdf/            # PDF templates
│   │   ├── vehicle/        # Vehicle management views
│   │   └── worksheet/      # Worksheet/quote views
│   └── lang/               # Language files (if any)
├── routes/
│   ├── web.php             # Public routes + auth
│   ├── admin.php           # Admin panel routes (separate file)
│   ├── api.php             # API endpoints (v1)
│   └── console.php         # Artisan commands
├── storage/
│   ├── app/                # Application storage
│   ├── logs/               # Log files
│   └── framework/          # Framework files (cache, sessions)
├── tests/
│   ├── Feature/            # Feature tests
│   └── Unit/               # Unit tests
├── .env.example            # Environment configuration template
├── composer.json           # PHP dependencies
├── package.json            # Node dependencies
├── phpunit.xml             # PHPUnit configuration
└── vite.config.js          # Vite build configuration
```

## Development Setup

### Initial Setup

```bash
# 1. Clone repository (if needed)
git clone <repository-url>
cd aszerviz

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Set up database (SQLite default)
touch database/database.sqlite
php artisan migrate

# 6. (Optional) Seed database
php artisan db:seed

# 7. Start Meilisearch for search functionality
# See: https://www.meilisearch.com/docs/learn/getting_started/installation
# Default: http://localhost:7700 with masterKey

# 8. Run development server (all services)
composer dev
```

### Development Commands

```bash
# Start all services (server, queue, logs, vite) - RECOMMENDED
composer dev

# Or start services individually:
php artisan serve                    # Development server
php artisan queue:listen --tries=1   # Queue worker
php artisan pail --timeout=0         # Log viewer
npm run dev                          # Vite HMR

# Run tests
composer test
# or
php artisan test

# Code formatting
./vendor/bin/pint

# Build for production
npm run build
```

### Environment Configuration

Key `.env` settings:

```ini
APP_LOCALE=en              # Default: en (should be 'hu' for Hungarian)
APP_FALLBACK_LOCALE=en
APP_TIMEZONE=Europe/Budapest

DB_CONNECTION=sqlite       # Or mysql

QUEUE_CONNECTION=database  # Queue driver
CACHE_STORE=database       # Cache driver
SESSION_DRIVER=database    # Session driver

SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://localhost:7700
MEILISEARCH_KEY=masterKey

MAIL_MAILER=log           # Use smtp in production
```

## Architecture & Patterns

### Multi-Tenancy Structure

```
Company (organizations)
  ↓
Garage (locations)
  ↓
Users & Worksheets
```

- Companies can have multiple garages
- Users belong to a specific garage
- Worksheets are scoped to garages
- Worksheet IDs include company prefix for unique identification

### Key Architectural Patterns

1. **Active Record (Eloquent ORM)**
   - No repository pattern
   - Models contain business logic
   - Direct database interaction through models

2. **Service Layer (Selective)**
   - Used for complex cross-cutting concerns
   - Example: `TranslationService` for database-driven translations
   - Not used for standard CRUD operations

3. **UUID Primary Keys**
   - Most models use UUIDs instead of auto-increment IDs
   - Better for distributed systems and security
   - Uses Laravel's `HasUuids` trait

4. **Eager Loading**
   - Models define `$with` property for common relationships
   - Prevents N+1 query problems
   - Example: `Worksheet` always loads `client`, `vehicle`, `items`, `images`

5. **Trait-Based Functionality**
   - `SearchableInAllLocales` - Auto-indexes in all languages for Scout
   - `Uploadable` - File upload handling
   - `HasRoles` - Spatie Permission integration

6. **Enum Usage (PHP 8.2)**
   - Type-safe constants with methods
   - Example: `PageStatus::Draft`, `PageType::...`
   - Include label methods for display

7. **Database-Driven Translations**
   - NOT using Laravel's file-based translations
   - Custom translation system with `translations` and `translation_values` tables
   - Helper: `trans_db($key, $locale, $default)`
   - Cached for 24 hours
   - Format: `group.key` (e.g., 'menu.home', 'common.save')

8. **History Tracking**
   - Worksheet model stores history as JSON array
   - Tracks status changes with timestamps and user IDs
   - Immutable audit trail

## Database Schema & Models

### Core Models (17 total)

#### Workshop Management
```php
// Client.php - Customer records
- id (UUID)
- name, email, phone
- address fields
- company_vat (for business customers)
- Relationships: worksheets(), vehicles()

// Vehicle.php - Vehicle records
- id (UUID)
- license_plate, chassis, brand, model, color, year
- Relationships: client(), worksheets()

// Worksheet.php - Main business entity (quotes/invoices)
- id (UUID)
- worksheet_id (auto-generated from garage prefix)
- client_id, vehicle_id, garage_id
- status (1=OPEN, 2=PROGRESS, 10=CLOSED, 11=DELETED)
- history (JSON array)
- Relationships: client(), vehicle(), items(), images(), garage()
- Computed: totalNetto(), totalVat()

// WorksheetItem.php - Line items (parts/labor)
- id (UUID)
- worksheet_id
- name, netto, vat, quantity

// WorksheetImage.php - Photos/videos of work
- id (UUID)
- worksheet_id, type, path

// Garage.php - Workshop locations
- id (UUID)
- company_id, name, address fields
- owner_id (user who manages this garage)

// Company.php - Parent organizations
- id (UUID)
- name, owner_id
```

#### Content Management
```php
// Page.php - Translatable pages
- Uses: Translatable trait, SearchableInAllLocales trait
- id (UUID)
- Translatable: title, lead, content, slug
- page_status_id (enum), page_type_id (enum)
- additional (JSON for flexible fields)
- Scout indexed for full-text search

// Post.php - Blog posts
- Similar structure to Page

// Category.php - Content categorization
- id (UUID), name, slug, status

// Tag.php - Tagging system
- id (UUID), name, slug

// PageCategory, PageTag - Pivot tables
```

#### Translation System
```php
// Translation.php
- id (UUID)
- group (e.g., 'menu', 'common')
- key (e.g., 'home', 'save')

// TranslationValue.php
- translation_id
- lang (e.g., 'hu', 'en')
- value (translated text)
```

#### System
```php
// User.php
- Uses: HasUuids, HasApiTokens, HasRoles
- id (UUID)
- name, email, password
- garage_id (multi-tenant)
- company_id
- status (10=ACTIVE, 11=SUSPENDED)
- Roles: mechanic, manager, admin

// Calendar.php
- Events/appointments
```

### Important Database Conventions

1. **Primary Keys:** Most tables use UUIDs
2. **Timestamps:** `created_at`, `updated_at` on all models
3. **Soft Deletes:** Used selectively (check model traits)
4. **JSON Fields:** `history` in worksheets, `additional` in pages
5. **Status Fields:** Typically use integers (10=active/closed, 11=inactive/deleted)

## Routing Conventions

### Route Organization

Routes are split into multiple files:

**routes/web.php** - Public routes
```php
// Public access
GET / - Homepage (SiteController)
GET /ajanlat/{worksheet} - Public worksheet view

// Authentication (Laravel UI)
Auth::routes(['register' => false]); // Registration disabled

// Admin routes loaded separately
```

**routes/admin.php** - Admin panel (prefix: `/admin`)
```php
// All routes use 'auth:web' middleware
// Hungarian route names:

// Worksheets (munkalap = worksheet)
GET  /admin/munkalap
GET  /admin/munkalap/uj
POST /admin/munkalap/mentes
GET  /admin/munkalap/{worksheet}
GET  /admin/munkalap/szerkesztes/{worksheet}
POST /admin/munkalap/modositas/{worksheet}
GET  /admin/munkalap/pdf/{worksheet}
POST /admin/munkalap/email/{worksheet}

// Clients (ugyfelek = clients)
GET  /admin/ugyfelek
POST /admin/ugyfelek/mentes
// ... similar pattern

// Vehicles (gepjarmuvek = vehicles)
GET  /admin/gepjarmuvek
// ... similar pattern

// RESTful resources
Route::resource('tags', TagController::class);
```

**routes/api.php** - API endpoints (prefix: `/api/v1`)
```php
// Protected by 'auth:sanctum'
GET /api/v1/search/vehicle
GET /api/v1/search/client
GET /api/user
```

### Naming Conventions

- **Named routes:** All routes have names (e.g., `worksheet.edit`, `client.view`)
- **Route paths:** Hungarian in admin (munkalap, ugyfelek, gepjarmuvek)
- **Controllers:** Singular resource name + "Controller"
- **RESTful patterns:** Used for standard resources (Tags)
- **Custom actions:** Named explicitly (pdf, email, status)

## Frontend Architecture

### CSS Architecture (Hybrid Approach)

The application uses **both** Tailwind CSS 4.0 and Bootstrap 5.2.3:

**Why Hybrid?**
- Bootstrap: Legacy UI components, grid system, utilities
- Tailwind: Modern utility-first styling for new features

**Structure:**
```
resources/
├── css/
│   └── app.css              # Tailwind CSS entry point
├── sass/
│   ├── app.scss             # Main SASS entry (imports Bootstrap)
│   ├── _variables.scss      # Custom variables
│   └── _variables_app.scss  # App-specific variables
└── public/static/css/
    └── app.min.css          # Static CSS (legacy)
```

**Vite Configuration:**
```javascript
// vite.config.js
input: [
    'resources/sass/app.scss',    // Bootstrap + custom SASS
    'resources/js/app.js',         // JavaScript
    'public/static/css/app.min.css' // Static CSS
]
```

**Using in Blade:**
```blade
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
```

### JavaScript Architecture

**Stack:**
- jQuery (primary library)
- Axios (HTTP client with CSRF token)
- Bootstrap 5 JS (components)
- MetisMenu (navigation)
- Node Waves (ripple effects)

**Structure:**
```javascript
// resources/js/bootstrap.js
import 'bootstrap';
import axios from 'axios';

// Set up Axios with CSRF token
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// resources/js/app.js
import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

// AJAX setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

### Static Assets

Located in `/public/static/`:
```
static/
├── css/        # Bootstrap, custom CSS
├── js/         # jQuery, Bootstrap, plugins
├── libs/       # Third-party libraries
├── images/     # Static images
├── fonts/      # Custom fonts
└── docs/       # Documentation files
```

### Blade Template Organization

**Layouts:**
```blade
layouts/
├── app.blade.php      # Main layout
├── admin.blade.php    # Admin panel layout
├── auth.blade.php     # Authentication layout
└── public.blade.php   # Public-facing layout
```

**Components:**
- Located in `resources/views/components/`
- Can be used as `<x-component-name />`

**Best Practices:**
- Use `@extends` for layout inheritance
- Use `@section` and `@yield` for content areas
- Use `@include` for reusable partials
- Use `old()` helper for form repopulation
- Always include CSRF token in forms: `@csrf`

## Key Features & Business Logic

### Worksheet Management (Core Feature)

**Workflow:**
1. Create worksheet → Select/create client → Select/create vehicle
2. Add items (parts/labor) with VAT calculation
3. Add photos/videos of work
4. Update status: OPEN → PROGRESS → CLOSED
5. Generate PDF quote/invoice
6. Email to client
7. (Optional) Generate Szamlazz.hu invoice

**Key Controllers:**
- `Admin/WorksheetController` - Main CRUD operations
- `Admin/WorksheetItemController` - Line items
- `Admin/WorksheetImageController` - Photo/video uploads

**Key Files:**
- `app/Models/Worksheet.php` - Model with business logic
- `resources/views/worksheet/` - View templates
- `resources/views/pdf/worksheet.blade.php` - PDF template
- `app/Mail/Offer.php` - Email functionality

### Client & Vehicle Management

**Pattern: Upsert Strategy**
```php
// Check if ID exists
if (!empty($params['Client']['id'])) {
    // Update existing
    $client = Client::find($params['Client']['id']);
    $client->update($data);
} else {
    // Create new
    $client = Client::create($data);
}
```

This pattern allows inline creation during worksheet creation.

### Multi-language Content (CMS)

**Using Spatie Translatable:**
```php
// In model
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'lead', 'content', 'slug'];
}

// In controller
$page->setTranslation('title', 'hu', 'Magyar cím');
$page->setTranslation('title', 'en', 'English title');
$page->save();

// In view
{{ $page->getTranslation('title', 'hu') }}
// or
{{ $page->translate('title', 'hu') }}
```

**Custom Translation Helper:**
```php
// Usage: trans_db('menu.home', 'hu', 'Home')
// Retrieves from database, caches for 24 hours
trans_db($key, $locale, $default)
```

### Search Functionality (Scout + Meilisearch)

**Indexed Models:**
- Page (with `SearchableInAllLocales` trait)
- Post
- (Add others as needed)

**Custom Trait for Multi-language Search:**
```php
// app/Traits/SearchableInAllLocales.php
trait SearchableInAllLocales
{
    // Automatically creates separate indexes for each language
    // e.g., pages_hu, pages_en
}
```

**Usage:**
```php
// Search in specific locale
Page::search('keyword')->get();
```

### PDF Generation

**Pattern:**
```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('pdf.worksheet', [
    'worksheet' => $worksheet,
    'client' => $client,
    'vehicle' => $vehicle
]);

// Save to storage
$filename = "worksheet_{$worksheet->id}.pdf";
$pdf->save(storage_path("app/public/pdf/{$filename}"));

// Return download
return $pdf->download($filename);

// Stream to browser
return $pdf->stream();
```

### Szamlazz.hu Integration

**Custom Component:**
- Location: `app/Components/Szamlazz/`
- Local Composer package
- Used for Hungarian invoicing requirements

**Configuration:**
- Set up credentials in `.env`
- Integration code in worksheet controllers

### Queue Jobs

**Current Jobs:**
```php
// app/Jobs/OptimizeVideo.php
- Background video processing for worksheet images
- Implements ShouldQueue interface
```

**Running Queue:**
```bash
php artisan queue:listen --tries=1
# or
php artisan queue:work
```

## Development Workflows

### Adding a New Feature

1. **Create Migration:**
   ```bash
   php artisan make:migration create_tablename_table
   # Edit migration file
   php artisan migrate
   ```

2. **Create Model:**
   ```bash
   php artisan make:model ModelName
   ```

   Common traits to add:
   ```php
   use HasUuids;           // For UUID primary keys
   use SoftDeletes;        // For soft deletes
   use HasTranslations;    // For translatable fields
   use Searchable;         // For Scout search
   ```

3. **Create Controller:**
   ```bash
   php artisan make:controller Admin/ModelNameController
   ```

4. **Add Routes:**
   ```php
   // routes/admin.php
   Route::get('/modelname', [ModelNameController::class, 'index']);
   Route::get('/modelname/uj', [ModelNameController::class, 'create']);
   // ... etc
   ```

5. **Create Views:**
   ```bash
   # Create in resources/views/modelname/
   index.blade.php
   create.blade.php
   edit.blade.php
   show.blade.php
   ```

6. **Test:**
   ```bash
   composer test
   ```

### Modifying Existing Features

1. **Find the route** in `routes/admin.php` or `routes/web.php`
2. **Locate the controller** in the route definition
3. **Find the model** used by the controller
4. **Check the views** rendered by the controller
5. **Make changes** to model/controller/view as needed
6. **Test** manually and with automated tests

### Database Changes

**Adding a field:**
```bash
php artisan make:migration add_field_to_table --table=tablename
```

```php
// In migration
public function up()
{
    Schema::table('tablename', function (Blueprint $table) {
        $table->string('new_field')->nullable();
    });
}

public function down()
{
    Schema::table('tablename', function (Blueprint $table) {
        $table->dropColumn('new_field');
    });
}
```

**Run migration:**
```bash
php artisan migrate
```

**Rollback if needed:**
```bash
php artisan migrate:rollback
php artisan migrate:rollback --step=1  # Rollback specific number
```

### Working with Translations

**Add translation key:**
```php
// In controller or setup
Translation::create([
    'group' => 'menu',
    'key' => 'new_item'
]);

// Add values for each language
$translation->values()->create([
    'lang' => 'hu',
    'value' => 'Új elem'
]);

$translation->values()->create([
    'lang' => 'en',
    'value' => 'New item'
]);
```

**Use in views:**
```blade
{{ trans_db('menu.new_item', app()->getLocale(), 'New Item') }}
```

### Git Workflow

**Current Branch Pattern:**
```bash
# Feature branches follow: claude/claude-md-<session-id>
git checkout -b claude/claude-md-mi2w1oxblh09wq10-01Bf1yGTqa8gChXRRkTCcYeg

# Make changes
git add .
git commit -m "Descriptive commit message"

# Push with upstream tracking
git push -u origin <branch-name>
```

**Commit Message Style:**
(Based on recent commits)
- Use lowercase
- Be descriptive but concise
- Examples: "worksheet pdf-ek, video", "calendar ok", "scout init, translates"

## Testing

### Running Tests

```bash
# Run all tests
composer test
# or
php artisan test

# Run specific test
php artisan test --filter TestName

# Run with coverage
php artisan test --coverage
```

### Writing Tests

**Feature Test Example:**
```php
// tests/Feature/WorksheetTest.php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Worksheet;

class WorksheetTest extends TestCase
{
    public function test_user_can_view_worksheet()
    {
        $user = User::factory()->create();
        $worksheet = Worksheet::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('worksheet.view', $worksheet));

        $response->assertStatus(200);
    }
}
```

**Unit Test Example:**
```php
// tests/Unit/WorksheetTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Worksheet;

class WorksheetTest extends TestCase
{
    public function test_worksheet_calculates_total_correctly()
    {
        $worksheet = Worksheet::factory()->create();
        // Add items...

        $this->assertEquals(1000, $worksheet->totalNetto());
    }
}
```

### Test Database

- Uses SQLite in-memory database
- Configured in `phpunit.xml`
- Automatically migrated for each test

## Code Conventions

### PHP Code Style

**Follow Laravel conventions:**
- PSR-12 coding standard
- Use Laravel Pint for formatting: `./vendor/bin/pint`
- Type hints for method parameters and return types
- Use PHP 8.2 features (enums, readonly, etc.)

**Naming Conventions:**
```php
// Classes: PascalCase
class WorksheetController {}

// Methods: camelCase
public function viewWorksheet() {}

// Variables: camelCase
$clientData = [];

// Constants: UPPER_SNAKE_CASE
const STATUS_OPEN = 1;

// Database tables: snake_case, plural
worksheets, worksheet_items

// Database columns: snake_case
created_at, client_id
```

### File Organization

**Controllers:**
- Place admin controllers in `app/Http/Controllers/Admin/`
- Place public controllers in `app/Http/Controllers/Public/`
- One controller per file
- Group related actions in same controller

**Models:**
- Place in `app/Models/`
- One model per file
- Define relationships at the top
- Then scopes, accessors, mutators
- Finally, other methods

**Views:**
- Group by feature in `resources/views/`
- Use descriptive names matching controller actions
- Partials start with underscore: `_form.blade.php`

### Code Documentation

**DocBlocks:**
```php
/**
 * Retrieve worksheet by ID with related data
 *
 * @param string $id UUID of the worksheet
 * @return \App\Models\Worksheet
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
 */
public function getWorksheet(string $id): Worksheet
{
    return Worksheet::with(['client', 'vehicle', 'items'])
        ->findOrFail($id);
}
```

**Comments:**
- Explain "why", not "what"
- Use for complex business logic
- Avoid obvious comments
- Keep updated with code changes

### Security Best Practices

1. **CSRF Protection:**
   ```blade
   <form method="POST">
       @csrf
       <!-- form fields -->
   </form>
   ```

2. **Mass Assignment Protection:**
   ```php
   // In models
   protected $fillable = ['name', 'email']; // Whitelist
   // or
   protected $guarded = ['id']; // Blacklist
   ```

3. **SQL Injection Prevention:**
   ```php
   // Use Eloquent or Query Builder (parameterized)
   User::where('email', $email)->first(); // Safe

   // NEVER use raw SQL with user input directly
   DB::select("SELECT * FROM users WHERE email = '$email'"); // UNSAFE
   ```

4. **XSS Prevention:**
   ```blade
   {{ $variable }}           <!-- Escaped (safe) -->
   {!! $variable !!}         <!-- Unescaped (use with caution) -->
   ```

5. **Authorization:**
   ```php
   // Check permissions
   if (auth()->user()->can('edit-worksheet')) {
       // Allow action
   }

   // In controllers
   $this->authorize('update', $worksheet);
   ```

6. **File Upload Validation:**
   ```php
   $request->validate([
       'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
   ]);
   ```

## Important Files & Configuration

### Key Configuration Files

**config/app.php**
- Available locales: `['hu', 'en']`
- Timezone: `Europe/Budapest`
- Providers and aliases

**config/site.php**
- Custom configuration
- Translation groups: `['common', 'menu']`

**config/auth.php**
- Authentication guards
- User providers
- Password reset settings

**config/filesystems.php**
- Storage disks configuration
- Public disk for uploaded files

**config/scout.php**
- Meilisearch configuration
- Index prefix and queue settings

### Environment Variables

**Required:**
```ini
APP_KEY=               # Generate with: php artisan key:generate
DB_CONNECTION=sqlite   # Or mysql
```

**For Production:**
```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aszerviz
DB_USERNAME=root
DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=

SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://localhost:7700
MEILISEARCH_KEY=your-master-key
```

### Helper Functions

**Available in:** `app/helpers.php`

Key helper (example):
```php
/**
 * Retrieve translation from database
 *
 * @param string $key Format: 'group.key'
 * @param string $locale Language code (hu, en)
 * @param string $default Fallback value
 * @return string
 */
function trans_db($key, $locale, $default = '')
{
    return app(TranslationService::class)->get($key, $locale, $default);
}
```

## Common Tasks & Examples

### Task: Add a New Admin Page

```php
// 1. Create route (routes/admin.php)
Route::get('/ujoldal', [UjoldalController::class, 'index'])
    ->name('ujoldal.index');

// 2. Create controller
php artisan make:controller Admin/UjoldalController

// 3. Implement controller
namespace App\Http\Controllers\Admin;

class UjoldalController extends Controller
{
    public function index()
    {
        return view('ujoldal.index');
    }
}

// 4. Create view (resources/views/ujoldal/index.blade.php)
@extends('layouts.admin')

@section('content')
    <h1>Új Oldal</h1>
@endsection
```

### Task: Add Search to a Model

```php
// 1. Add Scout trait to model
use Laravel\Scout\Searchable;

class MyModel extends Model
{
    use Searchable;

    // 2. Define searchable fields
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

// 3. Import existing records
php artisan scout:import "App\Models\MyModel"

// 4. Use in controller
$results = MyModel::search($query)->get();
```

### Task: Send an Email

```php
// 1. Create mailable
php artisan make:mail MyNotification

// 2. Implement mailable
namespace App\Mail;

use Illuminate\Mail\Mailable;

class MyNotification extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('mail.notification')
            ->subject('Subject Here')
            ->attach(storage_path('app/file.pdf'));
    }
}

// 3. Send email
use App\Mail\MyNotification;
use Illuminate\Support\Facades\Mail;

Mail::to($user->email)->send(new MyNotification($data));

// 4. Queue email (for better performance)
Mail::to($user->email)->queue(new MyNotification($data));
```

### Task: Create a New Migration

```php
// Create migration
php artisan make:migration create_things_table

// Edit migration file
public function up()
{
    Schema::create('things', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('name');
        $table->text('description')->nullable();
        $table->integer('status')->default(1);
        $table->timestamps();
    });
}

// Run migration
php artisan migrate
```

### Task: Add Permissions

```php
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Create permission
Permission::create(['name' => 'edit worksheets']);
Permission::create(['name' => 'delete worksheets']);

// Create role
$role = Role::create(['name' => 'manager']);

// Assign permissions to role
$role->givePermissionTo('edit worksheets');
$role->givePermissionTo('delete worksheets');

// Assign role to user
$user->assignRole('manager');

// Check permission
if ($user->can('edit worksheets')) {
    // Allow action
}
```

## Multi-language Support

### System Configuration

**Available Locales:** `hu` (Hungarian), `en` (English)
**Primary Locale:** Hungarian
**Fallback Locale:** English

### Translation Approaches

**1. File-Based (Laravel Default) - NOT USED**
```php
// resources/lang/hu/messages.php
// This project doesn't use this approach
```

**2. Database-Driven (USED) - Custom Implementation**
```php
// Database tables: translations, translation_values
// Helper function: trans_db($key, $locale, $default)

// Usage in views:
{{ trans_db('menu.home', 'hu', 'Kezdőlap') }}

// Usage in controllers:
$title = trans_db('common.welcome', $locale, 'Welcome');
```

**3. Spatie Translatable (USED) - For Content**
```php
// Used for: Pages, Posts
// Translatable fields stored as JSON in database

// Model setup:
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;
    public $translatable = ['title', 'content', 'slug'];
}

// Setting translations:
$page->setTranslation('title', 'hu', 'Magyar cím');
$page->setTranslation('title', 'en', 'English title');
$page->save();

// Getting translations:
$title = $page->getTranslation('title', 'hu');
```

### Search with Multiple Languages

**Custom Trait:** `SearchableInAllLocales`
```php
// Automatically creates separate Scout indexes per language
// pages_hu, pages_en, etc.

// Usage in model:
use App\Traits\SearchableInAllLocales;
use Laravel\Scout\Searchable;

class Page extends Model
{
    use Searchable, SearchableInAllLocales;
}
```

## Special Considerations for AI Assistants

### Hungarian Language Context

This application is built for Hungarian users:
- **Route paths** use Hungarian words (munkalap, ugyfelek, gepjarmuvek)
- **Database content** is primarily in Hungarian
- **UI strings** should be in Hungarian by default
- **Translations** should always include Hungarian (hu) first

When adding new features:
1. Use Hungarian route names where user-facing
2. Add translations for both `hu` and `en`
3. Default to Hungarian in user-facing content

### Worksheet ID Generation

Worksheets use auto-generated IDs based on company/garage:
```php
// Format: {CompanyPrefix}-{GaragePrefix}-{Number}
// Example: ABC-01-0001

// Implemented in Worksheet model
// Don't manually set worksheet_id
```

### Szamlazz.hu Integration

- Hungarian invoicing system (legally required)
- Located in: `app/Components/Szamlazz/`
- Custom component, not a standard package
- Configuration required in production
- Handle with care - financial/legal implications

### Multi-tenant Considerations

When working with worksheets, clients, vehicles:
- **Always filter by `garage_id`** for the authenticated user
- Check user's garage: `auth()->user()->garage_id`
- Don't allow cross-garage data access
- Company → Garage → User hierarchy must be respected

**Example:**
```php
// GOOD - scoped to user's garage
$worksheets = Worksheet::where('garage_id', auth()->user()->garage_id)->get();

// BAD - returns all worksheets from all garages
$worksheets = Worksheet::all();
```

### Performance Considerations

1. **Use Eager Loading** to prevent N+1 queries:
   ```php
   $worksheets = Worksheet::with(['client', 'vehicle', 'items'])->get();
   ```

2. **Queue Long-Running Tasks:**
   ```php
   // Video optimization, email sending, PDF generation
   OptimizeVideo::dispatch($video);
   Mail::to($email)->queue(new Offer($worksheet));
   ```

3. **Cache Translations:**
   - Translation service already caches for 24 hours
   - Be aware when testing translation changes

4. **Scout Search:**
   - Remember to import models after adding Searchable trait
   - Meilisearch must be running
   - Index updates are queued

### Development Server Notes

**The `composer dev` command runs 4 services simultaneously:**
1. PHP artisan serve (web server)
2. Queue listener (background jobs)
3. Pail (log viewer)
4. Vite (HMR for frontend)

Always use `composer dev` for development to ensure all services are running.

### Deployment Considerations

Before deploying to production:

```bash
# 1. Environment
cp .env.example .env
# Edit .env for production settings

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm ci

# 3. Build assets
npm run build

# 4. Laravel optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Run migrations
php artisan migrate --force

# 6. Set permissions
chmod -R 755 storage bootstrap/cache

# 7. Set up queue worker (supervisor/systemd)
php artisan queue:work --tries=3

# 8. Set up Meilisearch in production
# Import searchable models:
php artisan scout:import "App\Models\Page"

# 9. Set up scheduler (cron)
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Version History & Recent Changes

Based on recent git commits:
- **79e6400**: Tag multilingual initialization
- **4b2f159**: Scout initialization, translation work
- **4fd3ac7**: Translation and category initialization
- **4beade8**: Translation init, multilang init, pages init
- **e6c6ea6**: Calendar functionality complete
- **73e9f68**: Video optimization job, font added
- **c62983d**: Worksheet PDFs, video support
- **77de1b3**: Worksheet modifications
- **5b7b2c8**: Szamlazz.hu initialization
- **870b802**: Worksheet email, PDF, status, history, roles
- **f057124**: Initial project setup

## Troubleshooting

### Common Issues

**Issue: Meilisearch connection error**
```bash
# Check if Meilisearch is running
curl http://localhost:7700

# Start Meilisearch
# (Installation: https://www.meilisearch.com/docs/learn/getting_started/installation)

# Verify .env settings
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://localhost:7700
MEILISEARCH_KEY=masterKey
```

**Issue: Queue jobs not processing**
```bash
# Start queue worker
php artisan queue:listen --tries=1

# Or use composer dev which includes queue worker
composer dev
```

**Issue: Translations not appearing**
```bash
# Clear cache
php artisan cache:clear

# Check database has translations
php artisan tinker
>>> Translation::with('values')->get();
```

**Issue: Vite not hot reloading**
```bash
# Restart Vite
npm run dev

# Check vite.config.js is correct
# Ensure @vite directive is in Blade layout
```

**Issue: Permission denied on storage**
```bash
# Fix permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Issue: Database locked (SQLite)**
```bash
# Stop all PHP processes
killall php

# Or switch to MySQL for multi-user development
# Update .env:
DB_CONNECTION=mysql
```

## Additional Resources

- **Laravel Documentation:** https://laravel.com/docs/12.x
- **Spatie Permission:** https://spatie.be/docs/laravel-permission
- **Spatie Translatable:** https://spatie.be/docs/laravel-translatable
- **Laravel Scout:** https://laravel.com/docs/12.x/scout
- **Meilisearch:** https://www.meilisearch.com/docs
- **Tailwind CSS:** https://tailwindcss.com/docs
- **Bootstrap 5:** https://getbootstrap.com/docs/5.2

---

**Document Version:** 1.0
**Last Updated:** 2025-11-17
**Laravel Version:** 12.0
**PHP Version:** 8.2+

This document should be updated whenever significant architectural changes are made to the codebase.
