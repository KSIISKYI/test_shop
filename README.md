### This project was developed as a test task by EnjoyDevelop company

## Used technologies:

:point_right: native PHP8, JS

:point_right: Own MVC Framework(simple mvc pattern)

:point_right: Twig

### The project is divided into :two: parts.

#### :one: Admin Features:

:large_orange_diamond:  users(create, delete);

:large_orange_diamond:  categoris of products(create, edit, delete);

:large_orange_diamond:  products(create, edit, delete);

:large_orange_diamond:  orders(create, edit, delete);

#### :one: Customer Features:

:large_orange_diamond: products (add, delete) to the shopping cart;

:large_orange_diamond:  editing the shopping cart;

:large_orange_diamond:  order processing;

## Installation:
1. Clone the repository:
```
git clone https://github.com/KSIISKYI/test_shop.git
```
2. Move to root application directory:
```
cd test_shop/
```
3. Install composer:
```
composer install
```
4. Rename .env.example to .env:
```
mv .env.example to .env
```
5. Set credentials for db
6. Make migrations:
```
php database/db_seed.php
```
7. Run http server on 8000 port:
```
php -S localhost:8000 -t public
```
### Credentials for logging into the test account

###### Admin
```
username: admin@gmail.com
password: Zxcvbnm2
```

###### Customer
```
username: username1@gmail.com
password: Zxcvbnm2
```


#### Enjoy :joy:
