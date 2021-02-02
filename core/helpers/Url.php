<?php

namespace luya\helpers;

use luya\yii\helpers\Url as HelpersUrl;

/**
 * Helper methods when dealing with URLs and Links.
 *
 * Extends the {{yii\helpers\BaseUrl}} class by some usefull functions like:
 *
 * + {{luya\helpers\Url::trailing()}}
 * + {{luya\helpers\Url::toInternal()}}
 * + {{luya\helpers\Url::toAjax()}}
 * + {{luya\helpers\Url::ensureHttp()}}
 *
 * An example of create an URL based on Route in the UrlManager:
 *
 * ```php
 * Url::toRoute(['/module/controller/action']);
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Url extends HelpersUrl
{
}
