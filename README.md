# WolfShop Project
## About setup project
    Coding assessment - PHP Version
### Prerequisite
- Install [Docker](https://docs.docker.com/desktop)
### Run command following these step:
1. Go to `docker` folder
2. Build docker services `docker compose up -d`
3. Access app bash `docker compose exec php bash`
- Install app `composer install`
- Create .env file from .env.example and update your configuration.
- Install app key `php artisan key:generate`
- Install DB `php artisan migrate`
- Create master data `php artisan db:seed`
4. Run Unit test `php artisan test`
5. Import data `php artisan items:import`
