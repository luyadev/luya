<?php

namespace luya\base;

/**
 * Defines a module as Admin Module.
 *
 * All administration modules must implement the AdminModuleInterface, this allows LUYA to
 * deliver modules on the area the are used. Some modules are only used in frontend others
 * are just in administration context those modules must implement `AdminModuleInterface`.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface AdminModuleInterface
{
    /**
     * The menu object from the {{\luya\admin\components\AdminMenuBuilder}} class in order to store and build the administration
     * module menu elements.
     *
     * @return false|\luya\admin\components\AdminMenuBuilderInterface
     */
    public function getMenu();

    /**
     * Returns all Asset files to registered in the administration interfaces.
     *
     * As the adminstration UI is written in angular, the assets must be pre assigned to the adminisration there for the `getAdminAssets()` method exists.
     *
     * ```php
     * public function getAdminAssets()
     * {
     *     return [
     *          'luya\admin\assets\Main',
     *          'luya\admin\assets\Flow',
     *     ];
     * }
     * ```
     *
     * @return array An array with with assets files where the array has no key and the value is the path to the asset class.
     */
    public function getAdminAssets();

    /**
     * Returns all message identifier for the current module which should be assigned to the javascript admin interface.
     *
     * As the administration UI is written in angular, translations must also be available in different javascript section of the page.
     *
     * The response array of this method returns all messages keys which will be assigned:
     *
     * Example:
     *
     * ```php
     * public function getJsTranslationMessages()
     * {
     *     return ['js_ngrest_rm_page', 'js_ngrest_rm_confirm', 'js_ngrest_error'],
     * }
     * ```
     *
     * Assuming the aboved keys are also part of the translation messages files.
     *
     * In the javascript code you can access assigned js translation message like followed:
     *
     * ```js
     * i18n['js_ngrest_rm_page'];
     * ```
     *
     * @return array An array with values of the message keys based on the Yii translation system.
     */
    public function getJsTranslationMessages();
}
