<?php

namespace luya\console;

use Yii;
use yii\helpers\StringHelper;
use yii\helpers\Inflector;
use luya\base\AdminModuleInterface;
use luya\base\CoreModuleInterface;

/**
 * Console Command base class.
 *
 * The main different to the `\luya\console\Controller` is by adding default options to each command like
 * the verbose and interactive properties you can always access and use. In addition there are some helper
 * methods commonly used to build wizzwards within command controllers.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Command extends \luya\console\Controller
{
    /**
     * @var boolean Whether the verbose printing is enabled from options parameter or not.
     */
    public $verbose = false;
    
    /**
     * @var boolean Whether the command is in interactive mode or not, provided by option paremeters.
     */
    public $interactive = true;
    
    /**
     * Method to print informations directly when verbose is enabled.
     *
     * @param string $message
     * @param string $section
     */
    public function verbosePrint($message, $section = null)
    {
        if ($this->verbose) {
            $this->output((!empty($section)) ? $section . ': ' . $message : $message);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return ['verbose', 'interactive'];
    }
    
    // HELPER METHODS

    /**
     * Get selection list of all module types.
     *
     * @return string
     */
    public function selectModuleType()
    {
        return $this->select('What type of Module you want to create?', [
            'frontend' => 'Frontend Modules are used to render views.',
            'admin' => 'Admin Modules are used when the Data-Managment should be done inside the Administration area.',
        ]);
    }
    
    /**
     * Get selection list for console commands with defined options.
     *
     * @param array $options Define behavior of the module selector prompt, options are name-value pairs. The following options are available:
     *
     * - onlyAdmin: boolean, if enabled all not admin modules will not be included
     * - hideCore: boolean, if enabled all core modules (from luya dev team) will be hidden.
     *
     * @return string The name (ID) of the selected module.
     */
    public function selectModule(array $options = [])
    {
        $modules = [];
        foreach (Yii::$app->getModules() as $id => $object) {
            if (!$object instanceof \luya\base\Module) {
                continue;
            }
            if (isset($options['onlyAdmin']) && $options['onlyAdmin']) {
                if (!$object instanceof AdminModuleInterface) {
                    continue;
                }
            }
    
            if (isset($options['hideCore']) && $options['hideCore']) {
                if ($object instanceof CoreModuleInterface) {
                    continue;
                }
            }
            $modules[$id] = $id;
        }
    
        $text = (isset($options['text'])) ? $options['text'] : 'Please select a module:';
    
        return $this->select($text, $modules);
    }
    
    /**
     * Generates a class name with camelcase style and specific suffix, if not already provided
     *
     * @param string $string The name of the class, e.g.: hello_word would
     * @param string $suffix The suffix to append on the class name if not eixsts, e.g.: MySuffix
     * @return string The class name e.g. HelloWorldMySuffix
     */
    public function createClassName($string, $suffix = false)
    {
        $name = Inflector::camelize($string);
    
        if ($suffix !== false && StringHelper::endsWith($name, $suffix, false)) {
            $name = substr($name, 0, -(strlen($suffix)));
        }
    
        return $name . $suffix;
    }
    
    /**
     * Generates the LUYA text which all generator files should include.
     *
     * @param string $command The command which is used like `admin/crud/create``.
     * @return string The text to insert.
     */
    public function getGeneratorText($command)
    {
        return 'File has been created with `'.$command.'` command.';
    }
}
