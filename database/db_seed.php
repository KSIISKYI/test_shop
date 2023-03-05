<?php

require_once 'DB.php';

$dbh = DB::get_connection();

$dbh->query('DROP DATABASE IF EXISTS ' . $_ENV['DATABASE']);
$dbh->query('CREATE DATABASE ' . $_ENV['DATABASE']);

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(40) NOT NULL,
	email VARCHAR(40) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
	password VARCHAR(60) NOT NULL
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(40) NOT NULL
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.products (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(60) NOT NULL,
    category_id INT NOT NULL,
	description TEXT NOT NULL,
    guest_price DECIMAL NOT NULL,
    price DECIMAL NOT NULL,
    for_authorized BOOLEAN DEFAULT 0,
    quantity_in_stock SMALLINT,
    CONSTRAINT products_categories_fk FOREIGN KEY (category_id) REFERENCES {$_ENV['DATABASE']}.categories(id) ON DELETE CASCADE
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.product_images (
	id INT AUTO_INCREMENT PRIMARY KEY,
    path CHAR(100) NOT NULL,
    product_id INT NOT NULL,
    CONSTRAINT product_images_profiles_fk FOREIGN KEY (product_id) REFERENCES {$_ENV['DATABASE']}.products(id) ON DELETE CASCADE
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.carts (
	id INT AUTO_INCREMENT PRIMARY KEY
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.cart_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	cart_id INT NOT NULL,
	product_id INT NOT NULL,
    quantity SMALLINT DEFAULT 1,
    CONSTRAINT cart_items_carts_fk FOREIGN KEY (cart_id) REFERENCES {$_ENV['DATABASE']}.carts(id) ON DELETE CASCADE,
    CONSTRAINT cart_items_products_fk FOREIGN KEY (product_id) REFERENCES {$_ENV['DATABASE']}.products(id) ON DELETE CASCADE
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.shippers (
	id INT AUTO_INCREMENT PRIMARY KEY,
	company_name CHAR(40) NOT NULL
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.orders (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT,
    total DECIMAL NOT NULL,
    shipper_id INT NOT NULL,
    delivery_address CHAR(60) NOT NULL,
    delivery_city CHAR(15) NOT NULL,
    delivery_region CHAR(15) NOT NULL,
    post_code CHAR(10) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT orders_users_fk FOREIGN KEY (user_id) REFERENCES {$_ENV['DATABASE']}.users(id) ON DELETE CASCADE,
    CONSTRAINT orders_shippers_fk FOREIGN KEY (shipper_id) REFERENCES {$_ENV['DATABASE']}.shippers(id) ON DELETE CASCADE
);");

$dbh->query("CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']}.order_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	order_id INT NOT NULL,
	product_id INT NOT NULL,
    quantity SMALLINT DEFAULT 1,
    CONSTRAINT order_items_orders_fk FOREIGN KEY (order_id) REFERENCES {$_ENV['DATABASE']}.orders(id) ON DELETE CASCADE,
    CONSTRAINT order_items_products_fk FOREIGN KEY (product_id) REFERENCES {$_ENV['DATABASE']}.products(id) ON DELETE CASCADE
);");


// data

$dbh->query("INSERT INTO {$_ENV['DATABASE']}.categories(name)
    VALUES
        ('Laptops and computers'),
        ('Smartphones, TV and electronics'),
        ('Goods for gamers'),
        ('Household appliances'),
        ('Home goods'),
        ('Tools and auto goods'),
        ('Plumbing and repair'),
        ('Dacha, garden and city'),
        ('Sports and hobbies'),
        ('Clothes, shoes and jewelry'),
        ('Beauty and health'),
        ('Children\'s goods'),
        ('Animal products'),
        ('Office, school, books'),
        ('Alcoholic beverages and products')
");

$dbh->query("INSERT INTO {$_ENV['DATABASE']}.shippers(company_name)
    VALUES
        ('Nova poshta'),
        ('Ukrposhta')
");

$dbh->query("INSERT INTO {$_ENV['DATABASE']}.users(username, email, is_admin, password)
    VALUES
        ('username1', 'username1@gmail.com', 0, '\$2y\$10\$8Gq5gOQ75zxuzRlmNBJGkuPzAYBjHZ5wF.0lSYohjt8gd/6VqQxAe'),
        ('username2', 'username2@gmail.com', 0, '\$2y\$10\$8Gq5gOQ75zxuzRlmNBJGkuPzAYBjHZ5wF.0lSYohjt8gd/6VqQxAe'),
        ('username3', 'username3@gmail.com', 0, '\$2y\$10\$8Gq5gOQ75zxuzRlmNBJGkuPzAYBjHZ5wF.0lSYohjt8gd/6VqQxAe'),
        ('username4', 'username4@gmail.com', 0, '\$2y\$10\$8Gq5gOQ75zxuzRlmNBJGkuPzAYBjHZ5wF.0lSYohjt8gd/6VqQxAe'),
        ('admin', 'admin@gmail.com', 1, '\$2y\$10\$8Gq5gOQ75zxuzRlmNBJGkuPzAYBjHZ5wF.0lSYohjt8gd/6VqQxAe')
");

$dbh->query("INSERT INTO {$_ENV['DATABASE']}.products(name, category_id, description, guest_price, price, for_authorized, quantity_in_stock)
    VALUES
        (
            'Laptop Acer Aspire 7 A715-42G-R3EZ', 
            1, 
            'Screen 15.6\" IPS (1920x1080) Full HD, matte / AMD Ryzen 5 5500U (2.1 - 4.0 GHz) / RAM 16 GB / SSD 512 GB / nVidia GeForce GTX 1650, 4 GB / without OD / LAN / Wi-Fi / Bluetooth / web camera / without OS / 2.15 kg / black',
            30999,
            29999,
            0,
            12
        ),
        (
            'Laptop Apple MacBook Air 13\" M1 256GB 2020 (MGND3) Gold', 
            1, 
            'Screen 13.3\" Retina (2560x1600) WQXGA, glossy / Apple M1 / RAM 8 GB / SSD 256 GB / Apple M1 Graphics / Wi-Fi / Bluetooth / macOS Big Sur / 1.29 kg / gold',
            41999,
            29999,
            0,
            5
        ),
        (
            'Mobile phone Samsung Galaxy M33 5G 6/128GB Blue', 
            2, 
            'Screen (6.6\", TFT, 2408x1080) / Samsung Exynos 1280 (2.0 GHz + 2.4 GHz) / main quad camera: 50 MP + 5 MP + 2 MP + 2 MP, front camera: 8 MP / RAM 6 GB / 128 GB built-in memory + microSD (up to 1 TB) / 3G / LTE / 5G / GPS / support for 2 SIM cards (Nano-SIM) / Android 12 / 5000 mAh',
            9999,
            9499,
            0,
            154
        ),
        (
            'Mobile phone Apple iPhone 14 128GB Starlight', 
            2, 
            'Screen (6.1\", OLED (Super Retina XDR), 2532x1170) / Apple A15 Bionic / dual main camera: 12 MP + 12 MP, front camera: 12 MP / 128 GB of built-in memory / 3G / LTE / 5G / GPS / support for 2 SIM cards (eSIM) / iOS 16',
            37999,
            36999,
            0,
            78
        )
");

