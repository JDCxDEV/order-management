# Order Manage System



## Installation

Install Environment

```bash
  docker-compose build --no-cache
  docker-compose create
```


Inside the on sail-8.2/app image run the following

```bash
  composer install
  php artisan migrate:refresh --seed
  php artisan key:generate
  npm install
  npm run build
```

Run on the wsl project root

```bash
  ./vendor/bin/sail up
```


Inside the on sail-8.2/app image run the following

```bash
  composer update
  php artisan migrate:refresh --seed
  php artisan key:generate
  npm install
  npm run build
```

Example Users

```bash
  manager account
  email: test@example.com
  password: password
```

```bash
  user account
  email: user@example.com
  password: password
```
    
