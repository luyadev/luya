Installtion on MAC OSX with MAMP
---
Use a different DSN in the Config
```
'dsn' => 'mysql:host=localhost;dbname=luyaweb;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
```

Create a .bash_profile file in your home folder (cd ~) with following content
```
export PATH=/Applications/MAMP/bin/php/php5.6.2/bin:$PATH
```
***Attention:*** If you've [ZSH](https://github.com/robbyrussell/oh-my-zsh) installed, add the above "export" line to the ***end*** of the ***.zshrc*** file in your home directory (~/.zshrc).

change the php version to your current active php version. To verify and test this informations use:
```
which php
php -i
```