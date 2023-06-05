# Php-ecommerce

Ecommerce website for INFOST-490 Capstone class

## Description

This project is an ecommerce website built using pure PHP. It utilizes the PHP Pimple library to simplify dependency management and improve modularity for the frontend.

## Features

- Product Catalog: The website provides a catalog of products with details such as title, description, price, and availability.

- User Registration and Authentication: Users can create accounts, log in, and manage their profiles. Authenticated users can also place orders and view their order history.

- Shopping Cart: The website includes a shopping cart feature that allows users to add products, update quantities, and remove items.

- Order Management: Admin users have access to order management functionalities. They can view, process, and fulfill orders placed by customers.

- Responsive Design: The frontend is designed to be responsive using Ajax, providing an optimal browsing experience.

## Project Structure

The entire backend is in admin, disregard the server directory

```
.
├── README.md
├── account.php
├── admin
│   ├── Backend
│   │   ├── Ajax.php
│   │   ├── Config.php
│   │   ├── Container.php
│   │   ├── Database.php
│   │   ├── Global.php
│   │   ├── HelperFunctions.php
│   │   ├── Login.php
│   │   ├── PasswordHasher.php
│   │   ├── Product.php
│   │   ├── Register.php
│   │   ├── Response.php
│   │   ├── Role.php
│   │   ├── SecureSession.php
│   │   ├── Upload.php
│   │   ├── User.php
│   │   └── Validator.php
│   ├── composer.json
│   ├── includes
│   │   ├── _tablesProducts.php
│   │   ├── _tablesUsers.php
│   │   ├── adminFooter.php
│   │   └── adminHeader.php
│   ├── js
│   │   ├── checkout.js
│   │   ├── common.js
│   │   ├── dataTables.bootstrap5.min.js
│   │   ├── jquery.dataTables.min.js
│   │   ├── productImage.js
│   │   ├── products.js
│   │   ├── setup.js
│   │   └── users.js
│   ├── products.php
│   ├── showImage.php
│   ├── showImageP.php
│   ├── style.css
│   ├── test.php
│   └── users.php
├── cart.php
├── checkout.php
├── contact.php
├── index.php
├── layouts
│   ├── footer.php
│   └── header.php
├── login.php
├── logout.php
├── order_details.php
├── payment.php
├── register.php
├── server
│   └── place_order.php
├── shop.php
└── single_product.php
```

## Usage

1. Clone the project repository:

   ```
   https://github.com/TwiceBoogie/Php-ecommerce.git
   ```

2. Install dependencies using Composer:
   ```
   composer install
   ```
3. Configure the project in `admin/Backend/Config.php`
4. Create the database and make sure to import the database schema using the provided SQL file. _(Note: when you create a new account, make sure to change the users role in MySQL to admin in order to access admin features)_
5. Start a local PHP development server:
   ```
   php -S localhost:8000 -t public
   ```
