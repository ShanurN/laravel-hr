# Mini-CRM Project

A lightweight CRM system for collecting support tickets via a universal widget and managing them through an administrative panel.

## Features
- **Universal Widget**: Modern, AJAX-enabled contact form for lead generation.
- **Admin Panel**: Role-based access (Spatie) for managing tickets and updating statuses.
- **API**: RESTful endpoints for ticket creation and statistics.
- **Rate Limiting**: Constraint of 1 ticket per 24 hours per email/phone.
- **Media Library**: Support for file attachments using Spatie MediaLibrary.
- **Testing**: Feature tests for core API functionality.
- **Documentation**: OpenAPI/Swagger specification and Architectural Decisions doc.

## Technical Stack
- Laravel 12
- PHP 8.4
- SQLite (Local Development)
- Tailwind CSS

## Quick Start (Local)

### Prerequisites
- PHP 8.4
- Composer
- SQLite

### Installation
1. Clone the repository.
2. Install dependencies:
   ```bash
   composer install
   ```
3. Prepare environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Setup database:
   ```bash
   touch database/database.sqlite
   # Make sure .env has DB_CONNECTION=sqlite
   php artisan migrate:fresh --seed
   ```
5. Run dev server:
   ```bash
   php artisan serve
   ```

## Admin Access
- **URL**: `http://localhost:8000/admin/tickets`
- **Credentials**:
  - **Admin**: `admin@example.com` / `password`
  - **Manager**: `manager@example.com` / `password`

## Widget
- **URL**: `http://localhost:8000/widget`
- **Embed Code**:
  ```html
  <iframe src="http://localhost:8000/widget" width="100%" height="600px" frameborder="0"></iframe>
  ```

## API Documentation
- **OpenAPI Spec**: See `openapi.yaml`
- **POST `/api/tickets`**: Submit a new ticket (FormData with `name`, `email`, `phone`, `subject`, `text`, `file`).
- **GET `/api/tickets/statistics`**: Get status statistics (Query param `period`: `day`, `week`, `month`).

## Running Tests
```bash
php artisan test
```

## Architectural Decisions
Refer to [ARCHITECTURAL_DECISIONS.md](ARCHITECTURAL_DECISIONS.md) for detailed design rationale.
