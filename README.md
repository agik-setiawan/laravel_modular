﻿# **Laravel Module**####Using Laravel With HMVC Concept or Modular Patern.####This module using Laravel >=5.6####for using this module Please Follow the Steps below:########Using Composer- composer require agik/laravel_module- add LaravModule\Providers\ModulesAppServiceProvider::class, in service provider- php artisan vendor:publish --tag=modules########Make Module- php artisan make:module Example. new directory modules/Example will created on root directory- entry http://localhost/your-app/public/example