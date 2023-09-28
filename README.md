all command from app directory

location of php config (do not change nothing)
 php --ini

composer  https://getcomposer.org/download/

install
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

sudo mv composer.phar /usr/local/bin/composer

create app
composer create-project laravel/laravel myapp


start laravel server over apache http://localhost:8000/
php artisan serve

laraveladmin package
https://laravel-admin.org/docs/en/README


install:
composer require encore/laravel-admin
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
php artisan admin:install

laravel/sanctum install
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

commit 137. Backend,dummy register, login with sanctum p6
php artisan make:controller Api\\UserController