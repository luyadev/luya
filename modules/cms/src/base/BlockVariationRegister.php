<?php

namespace luya\cms\base;

use yii\helpers\Inflector;

/**
 * Generate Block Flavor Variations.
 *
 * The register output generates:
 *
 * ```php
 * textBlock::class => [
 *                   'variation1' => [
 *                       'title' => 'Variation Auswahl für Fetti Font Css Class',
 *                       'cfgs' => ['cssClass' => 'fetti-font-css-class'],
 *                       'vars' => ['textType' => 1],
 *                   ],
 *               ]
 * ```
 *
 * In order to configure the blockVariations property of the cms admin module:
 *
 * ```php
 * TextBlock::variations()
 *     ->add('bold', 'Bold Font with Markdown')->cfgs(['cssClass' => 'bold-font-class'])->vars(['textType' => 1])
 *     ->add('italic', 'Italic Font')->cfgs(['cssClass' => 'italic-font-class'])
 *     ->register(),
 * VideoBlock::variations()
 *     ->add('bold', 'Bold Videos')->cfgs([])->register(),
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BlockVariationRegister
{
    /**
     * @var \luya\cms\base\InternalBaseBlock Internal base block from where the BlockFlavor has been instantiatet.
     */
    protected $block;
    
    private $_variations = [];
    
    private $_tempIdentifier;
    
    /**
     * @param InternalBaseBlock $block
     */
    public function __construct(InternalBaseBlock $block)
    {
        $this->block = $block;
    }
    
    /**
     * Register a new flavor.
     *
     * @param string $identifier
     * @param string $title
     * @return \luya\cms\base\BlockVariationRegister
     */
    public function add($identifier, $title)
    {
        $identifier = Inflector::slug($identifier);
        $this->_variations[$identifier] = [
            'title' => $title,
            'cfgs' => [],
            'vars' => [],
            'extras' => [],
        ];
        $this->_tempIdentifier = $identifier;
        return $this;
    }
    
    /**
     * Flavor CFG variables.
     *
     * @param array $config
     * @return \luya\cms\base\BlockVariationRegister
     */
    public function cfgs(array $config)
    {
        $this->_variations[$this->_tempIdentifier]['cfgs'] = $config;
        return $this;
    }
    
    /**
     * Flavor VAR variables.
     *
     * @param array $config
     * @return \luya\cms\base\BlockVariationRegister
     */
    public function vars(array $config)
    {
        $this->_variations[$this->_tempIdentifier]['vars'] = $config;
        return $this;
    }
    
    /**
     * Flavor EXTRA variables.
     *
     * @param array $config
     * @return \luya\cms\base\BlockVariationRegister
     */
    public function extras(array $config)
    {
        $this->_variations[$this->_tempIdentifier]['extras'] = $config;
        return $this;
    }
    
    /**
     * @return array
     */
    public function register()
    {
        return [$this->block->className() => $this->_variations];
    }
}
