<?php
/**
 * Contao Image SrcSet
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @package   contaoblackforest/contao-image-srcset
 * @file      config.php
 * @author    Sven Baumann <baumann.sv@gmail.com>
 * @author    Dominik Tomasi <dominik.tomasi@gmail.com>
 * @license   LGPL-3.0+
 * @copyright ContaoBlackforest 2015
 */

$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('\ContaoBlackforest\Frontend\Image\ImageSectionSet', 'cachedImages');
$GLOBALS['TL_HOOKS']['modifyFrontendPage'][] = array('\ContaoBlackforest\Frontend\Image\ImageSectionSet', 'replaceImageTags');
