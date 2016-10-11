<p align="center">
  <img src="https://luya.io/img/luya_logo_flat_icon.png" alt="LUYA Logo"/>
</p>

> 4, October 2016: We have released the first release candidate of LUYA: [1.0.0-RC1](https://luya.io/news/first-release-candidate-1-0-0-rc1).

The [Yii 2 PHP Framework](https://github.com/yiisoft/yii2) wrapper which provides out of the box functions like an **administration interface**, a beautiful looking **content management system**, **payment** modules, **agency workflows** and other tools to develop your website pretty fast!

![PHP7](https://img.shields.io/badge/php7-yes-green.svg)
[![Build Status](https://travis-ci.org/luyadev/luya.svg?branch=master)](https://travis-ci.org/luyadev/luya)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/luyadev/luya/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/luyadev/luya/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya?branch=master)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-core/downloads)](https://packagist.org/packages/luyadev/luya-core)
[![Join the chat at https://gitter.im/zephir/luya](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/luyadev/luya)

![Luya Admin](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide1.0/img/luya-beta8.png)

**ATTENTION: We have MOVED all repositories to the new HQ of LUYA, `luyadev` instead of `zephir`. In order to update your packages, remove `zephir` and replace with `luyadev` in your composer require section. The old packages will still work for a while.**

## Installation

We have a made an absolut easy to understand *STEP-BY-STEP* Guide to install LUYA:

+ [How to install LUYA](https://luya.io)
+ [LUYA Video Tutorials](https://luya.io/video-tutorials)
+ [How to upgrade current LUYA website](https://luya.io/guide/install-upgrade)

Other helpfull informations

+ [Changelog](CHANGELOG.md)
+ [Version upgrade Breaks](UPGRADE.md)

## Questions and Problems

If you have any questions or problems, don't hesitate to create a [new issue](https://github.com/zephir/luya/issues/new) on the project repository.

+ [Issues on GitHub](https://github.com/luyadev/luya/issues)
+ [Ask us in Gitter](https://gitter.im/luyadev/luya)

#### Contribution

We are always looking for people who share their thoughts, code and problems with us. Below the links to the contribution guides:

[Help us building LUYA](https://luya.io/en/guide/luya-collaboration)

#### ROADMAP

+ ✓ beta7 release (June 2016)
+ ✓ beta8 release (August 2016) - Last NEW features will be implemented (cms permissions).
+ ✓ rc1 release (October 2016) - PHP Code Documentations and Guides updates.
+ rc2 release (December) - Moving admin and frontend modules into one repository, remove subsplit process and make modules independent.
+ version 1.0.0 (towards the end of year 2016) - First stable release of LUYA *yay*.

#### Unit Test

1. Create Database (example luya_phpunit)
2. Insert Database dump from `tests/data/sql/1.0.0-RC1.sql`
3. Rename phpunit.xml.dist to phpunit.xml
4. Change dsn, username and passwort in phpunit.xml
5. Ensure you have installed current composer packages `composer install` with dev packages.
6. Execute the phpunit bin file `./vendor/bin/phpunit`.
