<?php

namespace luya\admin\base;

/**
 * Defines a structure for the Admin search, called generic search.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface GenericSearchInterface
{
    public function genericSearchFields();

    public function genericSearch($searchQuery);
    
    /**
     * The state provider is used to click on the items. Retuns an array with a configuration for the
     * angular state provider. Example
     *
     * ```
     * return [
     *     'state' => 'custom.cmsedit',
     *     'params' => [
     *         'navId' => 'id'
     *     ]
     * ];
     * ```
     *
     * The example above would look like this in the angular context
     *
     * ```
     * $state.go('custom.cmsedit', { navId : 1 });
     * ```
     *
     * All variable for the params are based on the `generichSearchFields()`, if a variable is defined in the
     * generichSearchFields() method it can be used with % prefix in params value.
     *
     * If genericSearchStateProvider() returns **false** the ability to click on the detail icon is disabled.
     *
     * @return array|boolean Returns the state config or when not clickable returns false
     */
    public function genericSearchStateProvider();
    
    /**
     * An array with fields which will be hidden in the search output, but are available for the State Provider functions.
     * 
     * @return array An array with fields which should be hide from the results, where value is the field name:
     * 
     * ```php
     * return [
     *     'hide', 'me', 'too',
     * ];
     * ```
     */
    public function genericSearchHiddenFields();
}
