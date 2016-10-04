<?php

namespace luya\base;

/**
 * Mark a module as Core Module.
 *
 * A core modules has nothing incommon with being stored in the luyadev repostiroy, core modules should not appear
 * in some parts of the application, for example when choosing a module from the module block a core module such as
 * `admin` or `cms` should not be found, therfore those modules implements the CoreModuleInterface.
 *
 * @since 1.0.0-RC1
 * @author Basil Suter <basil@nadar.io>
 */
interface CoreModuleInterface
{
}
