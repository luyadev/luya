<?php

namespace luya\cms\base;

use Yii;

trigger_error('TwigBlock is deprecated.', E_USER_DEPRECATED);

/**
 * Represents a CMS Block with Twig views.
 *
 * @deprecated 1.0.0-RC2 Marked as deprecated and will be removed on 1.0.0 release.
 * @since 1.0.0-beta8
 * @author Basil Suter <basil@nadar.io>
 */
abstract class TwigBlock extends InternalBaseBlock implements TwigBlockInterface
{
    /**
     * Absolute renderFrontend method.
     *
     * @return string
     */
    public function renderFrontend()
    {
        $this->injectorSetup();
        return Yii::$app->twig->stringEnv->render($this->getTwigFrontendContent(), [
            'vars' => $this->getVarValues(),
            'cfgs' => $this->getCfgValues(),
            'placeholders' => $this->getPlaceholderValues(),
            'extras' => $this->getExtraVarValues(),
        ]);
    }
    
    public function renderAdmin()
    {
        $this->injectorSetup();
        return $this->twigAdmin();
    }
    
    /* protected and privates */
    
    /**
     * Returns the content of the frontend twig file.
     *
     * @return string Twig frontend file content
     *
     * @throws \Exception If the twig file doesn't exist
     */
    private function getTwigFrontendContent()
    {
        $twigFile = Yii::getAlias($this->getRenderFilePath('@app', 'twig'));
        if (file_exists($twigFile)) {
            return $this->baseRender('@app');
        }
    
        return $this->twigFrontend();
    }
    
    
    /**
     * @return string
     *
     * @throws \Exception
     */
    public function render()
    {
        $moduleName = $this->module;
        if (substr($moduleName, 0, 1) !== '@') {
            $moduleName = '@'.$moduleName;
        }
    
        return $this->baseRender($moduleName);
    }
    
    /**
     * @param $module
     *
     * @return string
     *
     * @throws \Exception
     */
    private function baseRender($module)
    {
        $twigFile = Yii::getAlias($this->getRenderFilePath($module, 'twig'));
        if (!file_exists($twigFile)) {
            throw new \Exception("Twig file '$twigFile' does not exists!");
        }
    
        return file_get_contents($twigFile);
    }
    
    /**
     * @param $app
     *
     * @return bool|string
     */
    protected function getRenderFilePath($app, $extension)
    {
        return $app.'/views/blocks/'.$this->getViewFileName($extension);
    }
}
