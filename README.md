LUYA
====

The [Yii 2](https://github.com/yiisoft/yii2) wrapper which provides out of the box functions like an **administration interface**, a beautiful looking **content management system**, **payment** modules, **agency workflows** and other tools to develop your website pretty fast!

![PHP7](https://img.shields.io/badge/php7-yes-green.svg)
[![Build Status](https://travis-ci.org/luyadev/luya.svg?branch=master)](https://travis-ci.org/luyadev/luya)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/luyadev/luya/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/luyadev/luya/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya?branch=master)
[![Total Downloads](https://poser.pugx.org/zephir/luya/downloads)](https://packagist.org/packages/zephir/luya) 
[![Join the chat at https://gitter.im/zephir/luya](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/zephir/luya)

![Luya Admin](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/luya-beta5.png)

#### ATTENTION

**We have moved all repositories to the new HQ of LUYA, `luyadev` instead of `zephir`. In order to update your packages, remove `zephir` and replace with `luyadev` in your composer require section. The old packages will still work for a while.**

### Installation

We have a made an absolut easy to understand *STEP-BY-STEP* Guide to install LUYA:

+ ![Deutsch](https://raw.githubusercontent.com/savetheinternet/Tinyboard/master/static/flags/de.png) [Installationsanleitung](https://luya.io/de/handbuch)
+ ![English](https://raw.githubusercontent.com/savetheinternet/Tinyboard/master/static/flags/us.png) [Setup Guide](https://luya.io/en/guide)

### Questions and Problems

If you have any questions or problems, don't hesitate to create a [new issue](https://github.com/zephir/luya/issues/new) on the project repository.

+ [Issues on GitHub](https://github.com/luyadev/luya/issues)
+ [Ask us in Gitter](https://gitter.im/luyadev/luya)

### Contribution

We are always looking for people who share their thoughts, code and problems with us. Below the links to the contribution guides:

+ ![Deutsch](https://raw.githubusercontent.com/savetheinternet/Tinyboard/master/static/flags/de.png) [Anleitung](https://luya.io/de/handbuch/luya-collaboration)
+ ![English](https://raw.githubusercontent.com/savetheinternet/Tinyboard/master/static/flags/us.png) [Guide](https://luya.io/en/guide/luya-collaboration)


### Unit Tests

1. Create Database (example luya_phpunit)
2. Insert Database dump from `tests/sql/1.0.0-beta6.sql`
3. Rename phpunit.xml.dist to phpunit.xml
4. Change dsn, username and passwort in phpunit.xml
5. Ensure you have installed current composer packages `composer install`.
6. Execute the phpunit bin file `./vendor/bin/phpunit`.
