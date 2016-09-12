<?php

namespace luya\cms\base;

/**
 * Default Twig Block Behavior.
 *
 * Until all blocks extends from PhpBlock or TwigBlock directly, the default base block implements the TwigBlock.
 * This is mainly to avoid BC breaks with old blocks. In future all blocks must be extend from PhpBlock or TwigBlock.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Block extends TwigBlock
{
}
