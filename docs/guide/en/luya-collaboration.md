Start collaboration
===================

How to collaborate with us and contribute to the LUYA Project.

1. Fork Luya
2. Recommended directory structure
3. Clone luya fork
4. Create luya-kickstarter project
4.1. Update config
4.2. Update composer.json
5. Define the upstream repo
6. Work routine 
7. Add changes to zephir/luya (Pull request)

1. Fork Luya
-------------
Fork the Luya project on Github: [https://github.com/zephir/luya](https://github.com/zephir/luya).
![fork-luya](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-fork.jpg "Fork Luya")

2. Recommended directory structure
------------------------------------
You will have two directories that depend on each other.

1. The «luya» directory
2. The «luya-kickstarter» directory

I will work with the following structure:
```
luya-working-dir/
├ luya/     	# https://github.com/zephir/luya
├ website/  	# https://github.com/zephir/luya-kickstarter
```

3. Clone luya fork
-------------------
Working directory: luya-working-dir/luya/

Use following command to clone the forked Luya project.

Don't forget to replace "username" with your Github username
```
git clone https://github.com/username/luya.git .
```

4. Create luya-kickstarter project
------------------------------------
Working directory: luya-working-dir/website/

1. Create the luya-kickstarter project with composer.
2. Move all files from the created directory into luya-working-dir/website/
```
composer create-project --prefer-dist zephir/luya-kickstarter:dev-master .
```
You will be asked if you want to remove the .git files. Answer with Y if you want to push the luya-kickstarter project into your own repository.
```
Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]? 
```

All files are now in the right place.

### 4.1 Update config
Copy local config template:
```
cp config/local.php.dist config/local.php
```
Edit local config and update db informations:
```
'db' => [
	'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=your_dbname;unix_socket=your_unix_socket',
    'username' => 'your_username',
    'password' => 'your_password'
]
```

Copy preproduction config:
```
cp config/prep.php.dist config/prep.php
```

Copy server config:
```
cp config/server.php.dist config/server.php
```

Per default, no other changes to the config are required.

### 4.2 Update composer
To work on luya modules, we have to update the composer.json.
Change it's content to the following:
```
{
    ...
    "require": {
        "yiisoft/yii2": "2.0.*"
    },
    "autoload" : {
        "psr-4" : {
            "luya\\" : "../luya/src/",
            "admin\\" : "../luya/modules/admin",
            "cms\\" : "../luya/modules/cms",
            "cmsadmin\\" : "../luya/modules/cmsadmin"
        }
    },
    ...
}
```
**Run:**
```
composer update
```

All luya relevant files are now loaded from the luya-working-dir/luya/ folder.

For more informations and troubleshooting: [https://github.com/zephir/luya-kickstarter](https://github.com/zephir/luya-kickstarter)

Working routine
----------------

***Firsttime***

Run following command:
```
./scripts/rebasemaster.sh init
```

***Otherwise:***

Run following command:
```
./scripts/rebasemaster.sh
```

Now that you're on the newest release, create a branch from master:
Don't forget to replace "newBranch" with a meaningful name.
```
git checkout -b newBranch master
```

Commit & Push all changes to this new branch.

Add changes to zephir/luya (Pull request)
-----------------------------------------
Now that you've committed and pushed all of your files, go to your forked luya project on Github.
Click on «Pull request» on the right side and then on the green button «New pull request».

On the following screen, choose your branch to merge, check everything and create the pull request.
![pull-request](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-pull-request.jpg "Pull request")


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
