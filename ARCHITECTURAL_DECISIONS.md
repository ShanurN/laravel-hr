# Architectural Decisions (ADR)

This document outlines the key architectural and technical decisions made during the development of the Mini-CRM.

## 1. Core Architecture: Service-Repository Pattern
**Decision**: Use of Service and Repository patterns alongside Laravel's standard MVC.
**Rationale**: 
- **Decoupling**: Repositories abstract the data access layer (Eloquent), making the logic less dependent on the database structure.
- **Reusable Logic**: Services encapsulate business processes (like ticket creation), allowing them to be reused by both the API and Web controllers (and potentially CLI/Jobs).
- **Testability**: Logic in services is easier to unit test in isolation.

## 2. Database: SQLite
**Decision**: Using SQLite for local development and testing.
**Rationale**: 
- **Portability**: No need for a complex database server setup (like MySQL/Postgres) to run the project.
- **Speed**: Extremely fast for running automated tests.

## 3. Media Handling: Spatie MediaLibrary
**Decision**: Use of `spatie/laravel-medialibrary` for file attachments.
**Rationale**: 
- **Industry Standard**: It's the most robust and flexible package for media management in Laravel.
- **Polymorphism**: Easily attach media to any model (Ticket) without creating custom pivot tables.

## 4. Authorization: Spatie Permission
**Decision**: Use of `spatie/laravel-permission` for RBAC (Role-Based Access Control).
**Rationale**: 
- **Flexibility**: Define roles (Admin, Manager) and permissions clearly.
- **Security**: Built-in middleware and directives for protecting routes and UI elements.

## 5. API Design: JSON Resources
**Decision**: Using Laravel API Resources for all API responses.
**Rationale**: 
- **Structural Consistency**: Ensures all API responses follow a predictable format.
- **Versioning Readiness**: Provides a layer to transform data without changing the underlying models.

## 6. Rate Limiting: Custom Request Validation
**Decision**: Custom validation rule within `StoreTicketRequest` for the "1 ticket per 24h" constraint.
**Rationale**: 
- **User Experience**: Providing a clear error message via standard Laravel validation is more user-friendly than a generic 429 response.
