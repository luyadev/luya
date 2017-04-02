<?php

namespace luya\base;

/**
 * Defines a module as Core Module.
 *
 * A core modules has nothing incommon with being stored in the luyadev repostiroy, core modules should not appear
 * in some parts of the application, for example when choosing a module from the module block a core module such as
 * `admin` or `cms` should not be found, therfore those modules implements the CoreModuleInterface.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface CoreModuleInterface
{
}
