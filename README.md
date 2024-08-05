# Laravel 8 My Blog

Best practices on [Laravel](http://laravel.com/) to present cases of use of the framework's features like:

- [Authentication](https://laravel.com/docs/8.x/authentication)
- API
    - Token authentication
    - [API Resources](https://laravel.com/docs/8.x/eloquent-resources)
    - Versioning
- [Blade](https://laravel.com/docs/8.x/blade)
- [Broadcasting](https://laravel.com/docs/8.x/broadcasting)
- [Cache](https://laravel.com/docs/8.x/cache)
- [Filesystem](https://laravel.com/docs/8.x/filesystem)
- [Helpers](https://laravel.com/docs/8.x/helpers)
- [Localization](https://laravel.com/docs/8.x/localization)
- [Mail](https://laravel.com/docs/8.x/mail)
- [Migrations](https://laravel.com/docs/8.x/migrations)
- [Policies](https://laravel.com/docs/8.x/authorization)
- [Providers](https://laravel.com/docs/8.x/providers)
- [Requests](https://laravel.com/docs/8.x/validation#form-request-validation)
- [Seeding & Factories](https://laravel.com/docs/8.x/seeding)
- [Testing](https://laravel.com/docs/8.x/testing)
- [Homestead](https://laravel.com/docs/8.x/homestead)

Beside Laravel, this project uses other tools like:

- [Bootstrap 4](https://getbootstrap.com/)
- [Font Awesome](http://fontawesome.io/)
- [Vue.js](https://vuejs.org/)
- [axios](https://github.com/mzabriskie/axios)
- [yajra/laravel-datatables](https://github.com/yajra/laravel-datatables)
- [unisharp/laravel-filemanager](https://github.com/UniSharp/laravel-filemanager)

## Installation

Setting up your development environment on your local machine :
```bash
$ git clone https://github.com/GRkode/app_blog.git
$ cd app_blog
$ cp .env.example .env
$ composer install
$ php artisan key:generate
$ php artisan storage:link
$ php artisan serve
```

Now you can access the application via [http://localhost:8000](http://localhost:8000).

## Before starting
You need to run the migrations with the seeds :
```bash
$ php artisan migrate --seed
```

This will create a new user that you can use to sign in :
```Admin user
email: admin@gmail.com
password: password
```
```user
email: user@gmail.com
password: password
```

## Useful commands
Seeding the database :
```bash
$ artisan db:seed
```

In development environnement, rebuild the database :
```bash
$ php artisan migrate:fresh --seed
```

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
