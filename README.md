# CryptoBox

## Install environment

### Install apache

```shell
sudo apt-get install apache2
```

### Install php

```shell
sudo apt-get install php7.2 php7.2-curl php7.2-mbstring php7.2-xml php7.2-mysql
```

### Install mysql

```shell
sudo apt-get install mysql
```

## Installation

### Get sources from github :

```shell
git clone https://github.com/JeremieSamson/cryptotrade.git
```

### Update cache, log & sessions permissions

Mac 

```shell
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" var/cache var/logs var/sessions
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" var/cache var/logs var/sessions
```

Linux

```shell
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs var/sessions
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs var/sessions
```

### Add VHost 

```shell
<VirtualHost *:80>
        ServerAdmin webmaster@ylly.fr
        ServerName cryptobox.local
        DocumentRoot /var/www/YOUR_PROJECT_DIRECTORY/web

        <Directory /var/www/YOUR_PROJECT_DIRECTORY/web>
                Options Indexes ExecCGI FollowSymLinks MultiViews
                AllowOverride all
                Order allow,deny
                Allow from all
        </Directory>

        Header set Access-Control-Allow-Origin "*"
        ErrorLog /var/log/apache2/error-cryptobox.log
        LogLevel error
        CustomLog /var/log/apache2/access-cryptobox.log vhost_combined_time_end
</VirtualHost>
```

### Create Twitter App

1. Go to [Twitter App](https://apps.twitter.com/)
2. Click on 'Create new app
3. Type Name, Description and Website
4. Add Twitter consumer key, consumer secret, access token and access token secret in yout parameter.yml
 
### Install [composer](https://getcomposer.org) 
 
 
```shell
curl -sS https://getcomposer.org/installer | php
```
 
### Install vendor :
 
```shell
php composer.phar install
```

### Deploy assets
 
```shell
php bin/console assets:install
```

### Create database & schema
 
```shell
php bin/console doctrine:schema:create
php bin/console doctrine:schema:update --force
```

### Load fixtures
 
```shell
php bin/console doctrine:load
```