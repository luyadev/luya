<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

The [Yii 2 PHP Framework](https://github.com/yiisoft/yii2) wrapper which provides out of the box functions like an **administration interface**, a beautiful looking **content management system**, **payment** modules, **agency workflows** and other tools to develop your website pretty fast!

[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-core/v/stable)](https://packagist.org/packages/luyadev/luya-core)
[![Build Status](https://travis-ci.org/luyadev/luya.svg?branch=master)](https://travis-ci.org/luyadev/luya)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/luyadev/luya/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/luyadev/luya/?branch=master)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-core/downloads)](https://packagist.org/packages/luyadev/luya-core)
[![Join the Slack Team](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

![LUYA RC4 Admin](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/luya-rc4.png)

## Installation

We have a made an absolut easy to understand *STEP-BY-STEP* Guide to install LUYA:

+ [How to install](https://luya.io/guide/install)
+ [Video Tutorials](https://luya.io/videos)

Other helpfull informations:

+ [Read in the Guide](https://luya.io/guide)
+ [Checkout the API documentation](https://luya.io/api)
+ [Changelog](core/CHANGELOG.md)
+ [Version upgrade Breaks](core/UPGRADE.md)

## Questions and Problems

If you have any questions or problems, don't hesitate to find support in the following channels.

+ [Issues on GitHub](https://github.com/luyadev/luya/issues)
+ [Join the Slack Team](https://slack.luya.io)
+ [Ask us in Gitter](https://gitter.im/luyadev/luya)

## Bug Report

When reporting bugs, its important to understand where to create the issue. The most common modules are:

+ [Core](https://github.com/luyadev/luya) The core library, which extends the Yii Framework.
+ [CMS](https://github.com/luyadev/luya-module-cms) The Content Mangement System Admin and Frontend. Working with Blocks, render CMS Pages, etc.
+ [Admin](https://github.com/luyadev/luya-module-admin) The admin UI itself, including all CURD operations belongs to this module.

#### Contribution

We are always looking for people who share their thoughts, code and problems with us. Below the links to the contribution guides:

[Help us building LUYA](https://luya.io/guide/luya-collaboration)

#### Unit Test

1. Create Database (example luya_env_phpunit)
2. Insert Database dump from `tests/data/sql/1.0.0.sql`
3. Rename phpunit.xml.dist to phpunit.xml
4. Change dsn, username and password in phpunit.xml
5. Ensure you have installed current composer packages `composer install` with dev packages.
6. Execute the phpunit bin file `./vendor/bin/phpunit`.

#### Shield

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

```
[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
```
