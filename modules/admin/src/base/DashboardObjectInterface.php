<?php

namespace luya\admin\base;

/**
 * Dashboard Interface which all Dashboard Objects needs to implement.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface DashboardObjectInterface
{
    /**
     * Returns the template string.
     *
     * The string is an angular template which can contain angular conditions like ng-repeat, ng-if, etc.
     *
     * @return string The angular template.
     */
    public function getTemplate();
    
    /**
     * Get the API Url.
     *
     * @return string Returns the api url where the dashboard object collect its data from, which then will be injected into the template in order to render.
     */
    public function getDataApiUrl();
    
    /**
     * Get the Title.
     *
     * @return string Returns the title of the current dashboard item, like "last logins" etc.
     */
    public function getTitle();
}
