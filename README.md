# BaseApp
Basic app scaffolding

## Prerequisites (minimum)

- Ubuntu 24.04.3 LTS (or other Linux distribution)
- Apache 2.4
- PHP 8.3
- MySQL 8.0
- Composer
- Git

> If you are using a different version of PHP, you need to update the `install.sh` script.

## LAMP stack install notes (Ubuntu)

```bash
sudo apt update && sudo apt -y upgrade
```

Install Apache2, PHP, MySQL, PHP extensions
```bash
sudo apt install -y apache2 mysql-server php libapache2-mod-php php-mysql php-cli php-curl php-gd php-mbstring php-xml php-zip
```

Enable and open firewall
```bash
sudo ufw allow "Apache Full" && sudo ufw allow mysql && sudo ufw allow OpenSSH
```

## Installation

Clone the repository
```bash
git clone https://github.com/stilmark/baseApp.git baseapp
```

Run the install script
```bash
./baseapp/.dist/bin/install.sh
```

The install script will:
- Create a logs directory
- Create a .env file
- Create a database user
- Create a database
- Update dependencies
- Build routes

## Enable Apache mods

Enable required Apache mods.

```bash
sudo a2enmod rewrite remoteip ssl
```

## Edit the Apache vhost file 

Edit the Apache vhost file `/baseapp/.dist/baseApp.vhost.conf` to fit your application and symlink it in the `/etc/apache2/sites-enabled` directory.

Example:
```bash
sudo ln -sfn /.../baseapp/.dist/baseApp.vhost.conf /etc/apache2/sites-enabled/baseApp.vhost.conf
```

> Update the path to where baseapp is installed.

Check the syntax of the vhost file:
```bash
sudo apachectl configtest
```

Restart Apache:
```bash
sudo service apache2 reload
```

## SSL certificate

BaseApp comes with a self-signed SSL certificate. You can find it in the `.dist/ssl` directory.

To use it, you need to add `/baseapp/.dist/ssl/base.dev.crt` to your keychain.

> If you change the domain in the vhost file, you need to update the certificate.

## DNS override (MAC)

Add the following line to your `/etc/hosts` file:
```bash
127.0.0.1 base.dev
```

> Be sure that to point the domain to the correct IP address.

## Edit the autoloader namespace
Edit the autoloader namespace in the composer.json file

By default the namespace is `BaseApp` and the autoloader paths are:

```json
"BaseApp\\Model\\": "app/models",
"BaseApp\\Controller\\": "app/controllers",
"BaseApp\\Class\\": "app/classes"
```

To change the namespace, update the namespace in the composer.json file and the autoloader paths in the composer.json file.

After updating the namespace, run the following command to update the autoloader:
```bash
composer dump-autoload
```

## Edit the Controller namespace

Edit the namespace in the .env file.

```env
CONTROLLER_NS=BaseApp\Controller\\
```

