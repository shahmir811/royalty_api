# Royalty Api

> Build backend APIs to integrate with Frontend React

## Install Dependencies

### Install laravel dependencies

Make a copy of .env.example and name file as .env
Update mysql credentials

```bash
composer install
```

### Generate secret keys

```bash
php artisan key:generate
php artisan jwt:secret
```

### Run server

```bash
php artisan serve
```

Application will run at port 8000
