<?php

namespace luya\web;

use yii\base\InvalidConfigException;
use yii\web\User;

/**
 * Group User Component.
 *
 * User class to login based on {{yii\web\User}}, but allows you to check whether a user is in this group or not.
 *
 * The {{luya\web\GroupUserIdentityInterface}} Interface must be implemented by the User Model used in {{yii\web\User::$identityClass}}.
 *
 * Assume we have made 3 groups:
 *
 * + group-a
 * + group-b
 * + group-c
 *
 * And we assume we have different users login forms which have access only to the defined groups.
 *
 * ```php
 * class app\UserCustomers implements GroupUserIdentityInterface
 * {
 *     public function getGroups()
 *     {
 *         return ['group-a', 'group-c'];
 *     }
 * }
 * ```
 *
 * ```php
 * class app\UserCompanys implements GroupUserIdentityInterface
 * {
 *     public function getGroups()
 *     {
 *         return ['group-b'];
 *     }
 * }
 * ```
 *
 * Lets perform the login on the IdentiyInterface base:
 *
 * ```php
 * Yii::$app->user->login(\app\UserCompanys);
 * ```
 *
 * Lets say the validation of the UserCompanys was successfull based on the validation
 * rules of the same class (IdentityInterface). Now we can quickly check if the the
 * user is allowed in the current group:
 *
 * ```php
 * if (Yii::$app->user->inGroup('group-b')) {
 *     // this user can see those parts of the Website.
 * }
 * ```
 *
 * > THE BELOW CODE REQUIRES IMPLEMENTATIONS FIRST AND IS STILL PART OF THE CONCEPT!
 *
 * The above usecase is very straight forward in templates, a more common scenario are
 * the useaccess of access restricting filters. The below example will show how action1 and
 * action2 will have seperate allowed groups. while action3 can be access as guest. If
 * there is no gues defined all actions which are not in the allowed list for the groups
 * are denied automatically.
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'access' => [
 *             'class' => 'authadmin\filters\GroupAuth',
 *             'allow' => [
 *                 'action1' => ['group-b'],
 *                 'action2' => ['group-a', 'group-c'],
 *              ],
 *              'guest' => ['action3'],
 *         ],
 *     ];
 * }
 * ```
 *
 * Another use case is to make sure some files are only by access by the allowed group,
 * for this scenario. Therefore you can assign groups to a file which will be allowed
 * to download/see this file. To make sure the defined group can acces the file is a global
 * event which happens before file download, as the bootstrap proccess of luya modules can
 * particpate on.
 *
 * ```php
 * public function init()
 * {
 *     parent::init();
 *     Yii::$app->on(Admin::EVENT_BEFORE_FILE_DOWNLOAD, [$this, 'verifyUserGroup']);
 * }
 *
 * public function verifyUserGroup($event)
 * {
 *     $event->isValid = (!$event->hasPermissions() || Yii::$app->user->inGroup($event->getFileGroups()));
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class GroupUser extends User
{
    /**
     * Checks whether a user exists for the provided group based on the GroupUserIdentityInterface implementation
     *
     * @param string|array $alias
     * @return bool
     * @throws InvalidConfigException
     */
    public function inGroup($alias)
    {
        if ($this->isGuest) {
            return false;
        }

        $identity = $this->identity;

        if (!$identity instanceof GroupUserIdentityInterface) {
            throw new InvalidConfigException('The $identityClass must be instance of luya\web\GroupUserIdentityInterface.');
        }


        $groups = (array) $alias;
        foreach ($groups as $groupAlias) {
            if (in_array($groupAlias, $identity->authGroups())) {
                return true;
            }
        }

        return false;
    }
}
