<?php

namespace luya\cms\base;

trigger_error('TwigBlock is deprecated.', E_USER_DEPRECATED);


/**
 * Default Twig Block Behavior.
 *
 * Until all blocks extends from PhpBlock or TwigBlock directly, the default base block implements the TwigBlock.
 * This is mainly to avoid BC breaks with old blocks. In future all blocks must be extend from PhpBlock or TwigBlock.
 *
 * @deprecated Will be removed in 1.0.0
 * @todo Remove in 1.0.0 release.
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Block extends TwigBlock
{
}
