# 🔔 VillagerBell
VillagerBell is a project to make it easier to send messages.
This is done through multiple endpoints that can be used for mobile.

## 🔧 Install dependencies
First you need to install all PHP and JavaScript dependencies.

PHP
```bash
composer install
```

## ⚙️ Web server configuration
Ensure that your web server's document root (e.g., Apache, Nginx) is configured to point to the `public/` directory of this 
project.

## 🔨 Asset Compilation
To generate the final, minified CSS files for a production environment, run the following command:
```bash
php bin/console sass:build
```
This will compile the SCSS file from the `assets/styles` directory into CSS and place them in the 
`public/build/styles` folder.

### 🔄 For development
For real-time compilation while developing, you should **use the built-in File Watcher in PhpStorm**. This 
automatically generates a fresh `.css` file every time you save an SCSS file. 

## 📜 License

[MIT](https://choosealicense.com/licenses/mit/)