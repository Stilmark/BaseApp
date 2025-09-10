# BaseApp
Basic app scaffolding

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

## Edit the Apache vhost file 

Edit the Apache vhost file `/baseapp/.dist/baseApp.vhost.conf` to fit your application and symlink it in the `/etc/apache2/sites-enabled` directory.

Example:
```bash
sudo ln -sfn /baseapp/.dist/baseApp.vhost.conf /etc/apache2/sites-enabled/baseApp.vhost.conf
```

Check the syntax of the vhost file:
```bash
sudo apachectl configtest
```

Restart Apache:
```bash
sudo apachectl reload
```

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
"BaseApp\Model": "app/models",
"BaseApp\Controller": "app/controllers",
"BaseApp\Class": "app/classes"
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

