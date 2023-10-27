# Order Manage System



## Installation

Install Laravel Sail 

```bash
  docker compose-build --no-cache
  ./vendor/bin/sail up
  ./vendor/bin/sail up
```


Inside the on sail-8.2/app image run the following

```bash
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
    
