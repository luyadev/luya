<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 21.02.17
 * Time: 11:02
 */

namespace cmstests\src\widgets;

use Yii;
use cmstests\CmsFrontendTestCase;
use luya\cms\widgets\NavTree;

class NavTreeTest extends CmsFrontendTestCase
{
    public function testDefaultOutput()
    {
        $expectedHtml = '<ul class="nav__list nav__list--1"><li class="nav__item nav__item--homepage "><a class="nav__link nav__link--active" href="/luya/envs/dev/public_html/">homepage</a></li><li class="nav__item nav__item--page-1"><a class="nav__link" href="page-1">Page 1</a><ul class="nav__list nav__list--2"><li class="nav__item nav__item--page-11"><a class="nav__link" href="page-11">Page 1.1</a></li><li class="nav__item nav__item--page-12"><a class="nav__link" href="page-12">Page 1.2</a><ul class="nav__list nav__list--3"><li class="nav__item nav__item--page-121"><a class="nav__link" href="page-121">Page 1.2.1</a></li><li class="nav__item nav__item--page-122"><a class="nav__link" href="page-122">Page 1.2.2</a></li><li class="nav__item nav__item--page-123"><a class="nav__link" href="page-123">Page 1.2.3</a></li></ul></li><li class="nav__item nav__item--page-13"><a class="nav__link" href="page-13">Page 1.3</a></li></ul></li></ul>';

        Yii::$app->menu->setLanguageContainer('en', CmsFrontendTestCase::mockMenuArray());

        $this->assertSame($expectedHtml, NavTree::widget());
    }

    public function testOutputWithArguments()
    {
        $expectedHtml = '<nav class="nav"><ul class="nav__list nav__list--1"><li class="nav__item nav__item--1 nav__item--homepage nav__item--1 nav__item--active"><a class="nav__link nav__link--1 nav__item--homepage nav__item--1 nav__link--active" href="/luya/envs/dev/public_html/">homepage</a></li><li class="nav__item nav__item--1 nav__item--page-1 nav__item--2"><a class="nav__link nav__link--1 nav__item--page-1 nav__item--2" href="page-1">Page 1</a><ul class="nav__list nav__list--2"><li class="nav__item nav__item--2 nav__item--page-11 nav__item--3"><a class="nav__link nav__link--2 nav__item--page-11 nav__item--3" href="page-11">Page 1.1</a></li><li class="nav__item nav__item--2 nav__item--page-12 nav__item--4"><a class="nav__link nav__link--2 nav__item--page-12 nav__item--4" href="page-12">Page 1.2</a><ul class="nav__list nav__list--3"><li class="nav__item nav__item--3 nav__item--page-121 nav__item--6"><a class="nav__link nav__link--3 nav__item--page-121 nav__item--6" href="page-121">Page 1.2.1</a></li><li class="nav__item nav__item--3 nav__item--page-122 nav__item--7"><a class="nav__link nav__link--3 nav__item--page-122 nav__item--7" href="page-122">Page 1.2.2</a></li><li class="nav__item nav__item--3 nav__item--page-123 nav__item--8"><a class="nav__link nav__link--3 nav__item--page-123 nav__item--8" href="page-123">Page 1.2.3</a></li></ul></li><li class="nav__item nav__item--2 nav__item--page-13 nav__item--5"><a class="nav__link nav__link--2 nav__item--page-13 nav__item--5" href="page-13">Page 1.3</a></li></ul></li></ul></nav>';

        Yii::$app->menu->setLanguageContainer('en', CmsFrontendTestCase::mockMenuArray());

        $this->assertSame($expectedHtml, NavTree::widget([
            'listDepthClassPrefix' => 'nav__list--',

            'linkActiveClass' => 'nav__link--active',
            'itemActiveClass' => 'nav__item--active',

            'wrapperOptions' => [
                'tag' => 'nav',
                'class' => 'nav'
            ],
            'listOptions' => [
                'tag' => 'ul',
                'class' => 'nav__list'
            ],
            'itemOptions' => [
                'tag' => 'li',
                'class' => 'nav__item nav__item--{{depth}} nav__item--{{alias}} nav__item--{{id}}'
            ],
            'linkOptions' => [
                'tag' => 'a',
                'class' => 'nav__link nav__link--{{depth}} nav__item--{{alias}} nav__item--{{id}}'
            ],
        ]));
    }

    public function testOutputWithoutListClass()
    {
        $expectedHtml = '<ul class=" nav__list--1"><li class="nav__item nav__item--homepage "><a class="nav__link nav__link--active" href="/luya/envs/dev/public_html/">homepage</a></li><li class="nav__item nav__item--page-1"><a class="nav__link" href="page-1">Page 1</a><ul class=" nav__list--2"><li class="nav__item nav__item--page-11"><a class="nav__link" href="page-11">Page 1.1</a></li><li class="nav__item nav__item--page-12"><a class="nav__link" href="page-12">Page 1.2</a><ul class=" nav__list--3"><li class="nav__item nav__item--page-121"><a class="nav__link" href="page-121">Page 1.2.1</a></li><li class="nav__item nav__item--page-122"><a class="nav__link" href="page-122">Page 1.2.2</a></li><li class="nav__item nav__item--page-123"><a class="nav__link" href="page-123">Page 1.2.3</a></li></ul></li><li class="nav__item nav__item--page-13"><a class="nav__link" href="page-13">Page 1.3</a></li></ul></li></ul>';

        Yii::$app->menu->setLanguageContainer('en', CmsFrontendTestCase::mockMenuArray());

        $this->assertSame($expectedHtml, NavTree::widget([
            'listOptions' => [
                'tag' => 'ul'
            ],
        ]));
    }

    public function testOutputWithWrongItemClassAttribute()
    {
        $expectedHtml = '<ul class="nav__list nav__list--1"><li class="nav__item nav__item--thisIsWrong "><a class="nav__link nav__link--active" href="/luya/envs/dev/public_html/">homepage</a></li><li class="nav__item nav__item--thisIsWrong"><a class="nav__link" href="page-1">Page 1</a><ul class="nav__list nav__list--2"><li class="nav__item nav__item--thisIsWrong"><a class="nav__link" href="page-11">Page 1.1</a></li><li class="nav__item nav__item--thisIsWrong"><a class="nav__link" href="page-12">Page 1.2</a><ul class="nav__list nav__list--3"><li class="nav__item nav__item--thisIsWrong"><a class="nav__link" href="page-121">Page 1.2.1</a></li><li class="nav__item nav__item--thisIsWrong"><a class="nav__link" href="page-122">Page 1.2.2</a></li><li class="nav__item nav__item--thisIsWrong"><a class="nav__link" href="page-123">Page 1.2.3</a></li></ul></li><li class="nav__item nav__item--thisIsWrong"><a class="nav__link" href="page-13">Page 1.3</a></li></ul></li></ul>';

        Yii::$app->menu->setLanguageContainer('en', CmsFrontendTestCase::mockMenuArray());

        $this->assertSame($expectedHtml, NavTree::widget([
            'itemOptions' => [
                'class' => 'nav__item nav__item--{{thisIsWrong}}'
            ],
        ]));
    }

    public function testOutputWithMaxDepth()
    {
        $expectedHtml = '<ul class="nav__list nav__list--1"><li class="nav__item nav__item--homepage "><a class="nav__link nav__link--active" href="/luya/envs/dev/public_html/">homepage</a></li><li class="nav__item nav__item--page-1"><a class="nav__link" href="page-1">Page 1</a></li></ul>';

        Yii::$app->menu->setLanguageContainer('en', CmsFrontendTestCase::mockMenuArray());

        $this->assertSame($expectedHtml, NavTree::widget([
            'maxDepth' => 1
        ]));
    }

    public function testOutputWithStartItem()
    {
        $expectedHtml = '<ul class="nav__list nav__list--1"><li class="nav__item nav__item--page-11"><a class="nav__link" href="page-11">Page 1.1</a></li><li class="nav__item nav__item--page-12"><a class="nav__link" href="page-12">Page 1.2</a><ul class="nav__list nav__list--2"><li class="nav__item nav__item--page-121"><a class="nav__link" href="page-121">Page 1.2.1</a></li><li class="nav__item nav__item--page-122"><a class="nav__link" href="page-122">Page 1.2.2</a></li><li class="nav__item nav__item--page-123"><a class="nav__link" href="page-123">Page 1.2.3</a></li></ul></li><li class="nav__item nav__item--page-13"><a class="nav__link" href="page-13">Page 1.3</a></li></ul>';

        Yii::$app->menu->setLanguageContainer('en', CmsFrontendTestCase::mockMenuArray());

        $this->assertSame($expectedHtml, NavTree::widget([
            'startItem' => Yii::$app->menu->findOne(['nav_id' => 2])
        ]));
    }

    public function testWithoutListTag()
    {
        $expectedHtml = '<li class="nav__item nav__item--homepage "><a class="nav__link nav__link--active" href="/luya/envs/dev/public_html/">homepage</a></li><li class="nav__item nav__item--page-1"><a class="nav__link" href="page-1">Page 1</a><ul class="nav__list nav__list--2"><li class="nav__item nav__item--page-11"><a class="nav__link" href="page-11">Page 1.1</a></li><li class="nav__item nav__item--page-12"><a class="nav__link" href="page-12">Page 1.2</a><ul class="nav__list nav__list--3"><li class="nav__item nav__item--page-121"><a class="nav__link" href="page-121">Page 1.2.1</a></li><li class="nav__item nav__item--page-122"><a class="nav__link" href="page-122">Page 1.2.2</a></li><li class="nav__item nav__item--page-123"><a class="nav__link" href="page-123">Page 1.2.3</a></li></ul></li><li class="nav__item nav__item--page-13"><a class="nav__link" href="page-13">Page 1.3</a></li></ul></li>';

        Yii::$app->menu->setLanguageContainer('en', CmsFrontendTestCase::mockMenuArray());

        $this->assertSame($expectedHtml, NavTree::widget([
            'ignoreFirstListTag' => true
        ]));
    }
}
