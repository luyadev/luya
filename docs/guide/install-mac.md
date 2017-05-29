# Installation on MAC OSX

The installation process does not differ to the [basic installation](install.md) but on several osx setups you may use different config values as described below.

Most OSX Apache services does not work with the default unix socket defined in your php.ini (as it could be of the wrong loaded php profile), so you have to define an additional unix socket inside your dsn configuration of the database component:

#### MAMP

```php
'dsn' => 'mysql:host=localhost;dbname=luyaweb;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
```

#### XAMPP

```php
'dsn' => 'mysql:host=localhost;dbname=luyaweb;unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock',
```

## Misc issues

Create a .bash_profile file in your home folder (cd ~) with following content

```sh
export PATH=/Applications/MAMP/bin/php/php5.6.2/bin:$PATH
```

***Attention:*** If you've [ZSH](https://github.com/robbyrussell/oh-my-zsh) installed, add the above "export" line to the ***end*** of the ***.zshrc*** file in your home directory (~/.zshrc).

change the php version to your current active php version. To verify and test this informations use:

```
which php
php -i
```

> Visit the [Installation Problems and Questions Site](install-problems.md) when you have any problems with the LUYA Setup.
