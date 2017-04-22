<p align="center">
  <img src="https://luya.io/img/luya_logo_flat_icon.png" alt="LUYA Logo"/>
</p>

> 11, April 2017: We have released another RC Version of LUYA: [1.0.0-RC3](https://luya.io/news/third-release-candidate-1-0-0-rc3).

The [Yii 2 PHP Framework](https://github.com/yiisoft/yii2) wrapper which provides out of the box functions like an **administration interface**, a beautiful looking **content management system**, **payment** modules, **agency workflows** and other tools to develop your website pretty fast!

[![Build Status](https://travis-ci.org/luyadev/luya.svg?branch=master)](https://travis-ci.org/luyadev/luya)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/luyadev/luya/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/luyadev/luya/?branch=master)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-core/downloads)](https://packagist.org/packages/luyadev/luya-core)
[![Join the chat at https://gitter.im/luyadev/luya](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/luyadev/luya)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

![Luya Admin](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/luya-beta8.png)

## Installation

We have a made an absolut easy to understand *STEP-BY-STEP* Guide to install LUYA:

+ [How to install](https://luya.io)
+ [Video Tutorials](https://luya.io/videos)
+ [How to upgrade current website](https://luya.io/guide/install-upgrade)

Other helpfull informations

+ [Changelog](CHANGELOG.md)
+ [Version upgrade Breaks](UPGRADE.md)

## Questions and Problems

If you have any questions or problems, don't hesitate to create a [new issue](https://github.com/luyadev/luya/issues/new) on the project repository.

+ [Issues on GitHub](https://github.com/luyadev/luya/issues)
+ [Ask us in Gitter](https://gitter.im/luyadev/luya)

#### Contribution

We are always looking for people who share their thoughts, code and problems with us. Below the links to the contribution guides:

[Help us building LUYA](https://luya.io/guide/luya-collaboration)

#### ROADMAP

+ ✓ beta7 release (June 2016)
+ ✓ beta8 release (August 2016) - Last NEW features will be implemented (cms permissions).
+ ✓ rc1 release (October 2016) - Merge admin and frontend modules into each other. Add luya vendor namespace prefix to all modules.
+ ✓ rc2 release (November 2016) - Bug fixes, PHP Doc and Guide improvements, basic features implementation.
+ ✓ rc3 release (April 2017) - Large API breaks and new features, therefore the rc3 release in order to get latest bugs reports and informations from Developers.
+ version 1.0.0 (Q3 2017) - First stable release of LUYA.

#### Unit Test

1. Create Database (example luya_env_phpunit)
2. Insert Database dump from `tests/data/sql/1.0.0-RC3.sql`
3. Rename phpunit.xml.dist to phpunit.xml
4. Change dsn, username and passwort in phpunit.xml
5. Ensure you have installed current composer packages `composer install` with dev packages.
6. Execute the phpunit bin file `./vendor/bin/phpunit`.

#### Shield

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

```
[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
```