<?php

namespace luya\rest;

use luya\traits\RestBehaviorsTrait;

/**
 * Basic Rest Controller.
 *
 * The below test controller can be access for everyone and is public.
 *
 * ```php
 * class TestPublicController extends \luya\rest\Controller
 * {
 *     // this method is public and visible for everyone.
 *     public function actionIndex()
 *     {
 *         return ['foo', 'bar'];
 *     }
 * }
 * ```
 *
 * In order to provide secure rest controllers you have to implement the {{luya\rest\UserBehaviorInterface}}.
 *
 * ```php
 * class TestSecureController extends \luya\rest\Controller implements \luya\rest\UserBehaviorInterface
 * {
 *     public function userAuthClass()
 *     {
 *         return \app\models\User::class;
 *     }
 *
 *     // this method is protected by the `app\models\User` model.
 *     public function actionIndex()
 *     {
 *         return ['foo', 'bar'];
 *     }
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Controller extends \yii\rest\Controller
{
    use RestBehaviorsTrait;
}
