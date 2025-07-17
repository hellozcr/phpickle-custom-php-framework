# phpickle Features

> **Architected & Designed by Santo Rabidas (SRD) 🚀**

## Why phpickle is the Best
- **Simplicity:** Minimal setup, easy to understand, and quick to get started.
- **Smart Automation:** Handles migrations, asset management, and routing with minimal manual work.
- **Modern Practices:** Uses best practices from modern frameworks, but stays lightweight and flexible.
- **Extensible:** Easy to add new features, middleware, or extend core classes.
- **Developer Experience:** Designed for productivity, with clear structure and helpful CLI tools.

## Core Features

### 1. MVC Architecture
- Clean separation of Controllers, Models, and Views.

### 2. Smart Routing
- Array-based, method-aware routes in `config/routes.php`.
- Supports parameters, RESTful patterns, and future middleware.

### 3. Centralized Asset Management
- Manage all CSS/JS/CDN links in `config/assets.php`.
- Auto-registers and renders assets globally.

### 4. Database Migration & Schema Sync
- Master schema file (`migrations/schema.php`) for all tables.
- CLI migration runner (`migrations/migrate.php`) for DB/table creation and schema sync.
- Auto-updates schema file with new tables from DB.

### 5. Simple ORM
- Base Model with PDO connection and helpers.
- Easy to create models for any table.

### 6. Easy Configuration
- All app and DB settings in `config/config.php`.

### 7. CLI Tools
- Migration runner with multiple commands (sync, create, update-schema, status).

### 8. Error Handling
- 404 and controller/method not found handling.

### 9. Extensible Structure
- Add new features, middleware, or helpers easily.

### 10. Smart Asset Auto-Rendering
- No duplicate includes, assets can be added from anywhere.

## Unique/Smart Features
- **Schema auto-sync:** Keeps DB and schema file in sync.
- **Central asset config:** One place for all dependencies.
- **Automatic asset rendering:** No manual includes in every view.
- **Migration auto-detection:** Finds and adds missing tables to schema.
- **Ready for extension:** Add middleware, REST APIs, or more advanced features easily.

---

**phpickle: The smart, modern, and developer-friendly PHP framework.**

> Framework crafted with passion by **Santo Rabidas (SRD)** 