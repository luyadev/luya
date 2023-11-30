<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

The [Yii 2 PHP Framework](https://github.com/yiisoft/yii2) wrapper which provides out of the box functions like an **administration interface**, a beautiful looking **content management system**, **payment** modules, **agency workflows** and other tools to develop your website pretty fast!

[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-core/v/stable)](https://packagist.org/packages/luyadev/luya-core)
![Tests](https://github.com/luyadev/luya/workflows/Tests/badge.svg)
[![Test Coverage](https://api.codeclimate.com/v1/badges/ef6b66d505ccf0b731b5/test_coverage)](https://codeclimate.com/github/luyadev/luya/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/ef6b66d505ccf0b731b5/maintainability)](https://codeclimate.com/github/luyadev/luya/maintainability)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-core/downloads)](https://packagist.org/packages/luyadev/luya-core)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)

![LUYA RC4 Admin](https://raw.githubusercontent.com/luyadev/luya/master/docs/images/cms.png)

## Installation

We have a made an absolut easy to understand *STEP-BY-STEP* Guide to install LUYA:

+ [How to install](https://luya.io/guide/installation/)
+ [Video Tutorials](https://www.youtube.com/@luyaio)

Other helpfull informations:

+ [Read in the Guide](https://luya.io/guide)
+ [Checkout the API documentation](https://api.luya.io)
+ [Changelog](core/CHANGELOG.md)
+ [Version upgrade Breaks](core/UPGRADE.md)

## Questions and Problems

If you have any questions or problems, don't hesitate to find support in the following channels.

+ [Issues on GitHub](https://github.com/luyadev/luya/issues)
+ [Join the Forum](https://github.com/orgs/luyadev/discussions)

## Bug Report

When reporting bugs, it is important to understand where to create the issue. The most common modules are:

+ [Core](https://github.com/luyadev/luya) The core library, which extends the Yii Framework.
+ [CMS](https://github.com/luyadev/luya-module-cms) The Content Management System Admin and Frontend. Working with Blocks, render CMS Pages, etc.
+ [Admin](https://github.com/luyadev/luya-module-admin) The admin UI itself, including all CRUD operations belongs to this module.

#### Contribution

We are always looking for people who share their thoughts, code and problems with us. Below the links to the contribution guides:

[Help us building LUYA](https://luya.io/guide/dev/collaboration.html)

#### Unit Test

1. Create Database (example luya_env_phpunit)
2. Insert Database dump from `tests/data/sql/1.0.0.sql`
3. Rename `phpunit.xml.dist` to `phpunit.xml`
4. Change dsn, username and password in `phpunit.xml`
5. Ensure you have installed current composer packages `composer install` with dev packages.
6. Execute the phpunit bin file `./vendor/bin/phpunit`.

#### Karma tests (JS)

1. Run `yarn install`
2. Run `yarn test` (for single run) or `yarn dev` to work on the tests

#### Shield

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

```
[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
```
