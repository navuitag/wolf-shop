# WolfShop Project
## About setup project
    Coding assessment - PHP Version
### Prerequisite
- Install [Docker](https://docs.docker.com/desktop)
### Run command following these step:
    1. Go to docker folder
    2. Run command ```docker compose up -d```
    3. Run command ```docker compose exec php bash```
      a. composer install
      b. Create .env file from .env.example and update your configuration.
      c. php artisan key:generate
      d. php artisan migrate:reset
      e. php artisan db:seed
    4. How to run Unit test
       Run command ```php artisan test```
    5. How to import data
        Run command ```php artisan items:import```
