# PHP

Example [PHP](https://www.php.net/) app. A single PHP file runs as is, with no framework, Composer or build step.

## Deploy settings

| Field | Value |
| --- | --- |
| Build | Railpack |
| Project directory | `/` |
| Install command | leave empty |
| Build command | leave empty |
| Start command | leave empty |
| Application port | `8000` |
| Health check path | `/` |

## <a name="dev"></a>Run locally

```bash
# start the built-in development server
php -S localhost:8000
```

The app opens at http://localhost:8000.

Requires PHP 8.2 or later.
