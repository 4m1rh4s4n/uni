<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## نصب و راه اندازی

پیش نیاز ها:
php >= 7.4
composer
mysql

داخل پروژه دستور های زیر رو به ترتیب در ترمینال وارد کنید:

```
composer update
```

بعد از آن فایل تنظیمات را تغییر نام بدهید کنید و اطلاعات دیتابیس و جدول را در آن وارد کنید

> .env.example -> .env

> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=laravel
> DB_USERNAME=root
> DB_PASSWORD=

سپس

```
php artisan migrate
```

```
php artisan key:generate
```

با دستور زیر میتونید پروژه رو روی رایانه شخصی خودتون اجرا کنید

```
php artisan serve
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.
