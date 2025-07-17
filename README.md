# phpickle

> **Architected & Designed by  (SRD) 🚀**

A modern, smart, and robust PHP MVC framework.

## Features
- MVC architecture (Controllers, Models, Views)
- Smart, array-based routing (config/routes.php)
- Centralized asset management (config/assets.php)
- Database migrations and schema sync (migrations/)
- Simple, extensible ORM
- Automatic global asset loading (CDN/local)
- Easy configuration (config/config.php)
- CLI migration runner

## Getting Started

### 1. Clone the Repository

### 2. Configure Your Environment
- Edit `config/config.php` for app and database settings.
- Edit `config/assets.php` to add global CSS/JS/CDN links.

### 3. Set Up the Database
- Edit `migrations/schema.php` to define your tables.
- Run migrations:
```
php migrations/migrate.php sync
```

### 4. Serve the App
- Point your web server to the `public/` directory. (done with htaccess)
- Or use PHP's built-in server:
```
php -S localhost:8000 -t public
```

### 5. Add Routes and Controllers
- Define routes in `config/routes.php`.
- Create controllers in `app/Controllers/`.
- Create models in `app/Models/`.
- Create views in `app/Views/`.

## Example Route
```php
['GET', '/users', 'HomeController@users'],
```

## Example Controller
```php
class HomeController extends Controller {
    public function users() {
        $userModel = new \App\Models\User();
        $users = $userModel->all();
        header('Content-Type: application/json');
        echo json_encode($users);
    }
}
```

## Migration Commands
- `php migrations/migrate.php sync` (default, full sync)
- `php migrations/migrate.php create` (create DB/tables only)
- `php migrations/migrate.php update-schema` (update schema file only)
- `php migrations/migrate.php status` (show DB/schema status)

## License
MIT

---

> Framework crafted with passion by **Santo Rabidas (SRD)** 
