# Installation on MAC OSX

> The installation process does not differ to the [general installation](install.md) but on several OSX systems you may use different config values as described below.

## Installation

**[Follow the general installation guide](install.md) and then use the OSX specific settings below.**

Most OSX Apache services does not work with the default unix socket defined in your php.ini (as it could be of the wrong loaded PHP profile), so you have to define an additional unix socket inside your dsn configuration of the database component:

#### MAMP

```php
'dsn' => 'mysql:host=localhost;dbname=luyaweb;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
```

#### XAMPP

```php
'dsn' => 'mysql:host=localhost;dbname=luyaweb;unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock',
```

## Misc issues

Create or use the existing `.bash_profile` or `.profile` file in your home folder (cd ~) with following content

```sh
export PATH=/Applications/MAMP/bin/php/php5.6.2/bin:$PATH
```
After editing this file needs be reloaded by running the following command in your terminal:

```sh
source ~/.bash_profile
```

If you've [ZSH](https://github.com/robbyrussell/oh-my-zsh) installed, add the above "export" line to the *end* of the .zshrc file in your home directory (~/.zshrc).

Change the PHP version to your current active PHP version. To verify and test this informations use:

```sh
which php
php -i
```

> Visit the [Installation Problems and Questions Site](install-problems.md) if you get any problems with the LUYA setup.
