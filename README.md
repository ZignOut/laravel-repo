# Installatin Guide

run this command in the terminal of your. project root <br><br>
`composer require zignout/laravel-repo`
<br>

## composer.json

place the following line in composer.json.

<code>

    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "\\Zignout\\laravelRepo": "vendor/zignout/laravel-repo/src" //Add this line**
        },
        "classmap": [
            "database/seeds",
            "database/factories"
        ]
    },
</code>

## config/app.php

add the following line in config\app.php.

<code>
    'providers' => [

        /*
         * Package Service Providers...
         */
        Zignout\LaravelRepo\RepositoryProvider::class,
    ]
</code>

## Run this command

`php artisan vendor:publish`<br>

and choose the package name.