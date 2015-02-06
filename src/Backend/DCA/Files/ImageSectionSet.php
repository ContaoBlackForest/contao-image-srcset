<?php
/**
 * Contao Image SrcSet
 * Copyright (C) 2015 Sven Baumann
 *
 * PHP version 5
 *
 * @package   contaoblackforest/contao-image-srcset
 * @file      ImageSectionSet.php
 * @author    Sven Baumann <baumann.sv@gmail.com>
 * @author    Dominik Tomasi <dominik.tomasi@gmail.com>
 * @license   LGPL-3.0+
 * @copyright ContaoBlackforest 2015
 */


namespace ContaoBlackforest\Backend\DCA\Files;


/**
 * Class ImageSectionSet
 *
 * DCA controller class
 *
 * @package ContaoBlackforest\Backend\DCA\Files
 */
class ImageSectionSet extends \Backend
{
	/**
	 * checked if file is an supported image
	 *
	 * @param \DataContainer
	 */
	public function controlVisibility(\DataContainer $dc)
	{
		if (\Input::get('do') === 'files' && \Input::get('act') === 'edit') {
			$suffix          = explode('/', finfo_file(finfo_open(FILEINFO_MIME_TYPE), TL_ROOT . '/' . $dc->id))[1];
			$supportFileType = array_flip(explode(',', \Config::get('validImageTypes')));

			if (!isset($supportFileType[$suffix])) {
				$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = str_replace(';activateSrcSet,imageSrcSet', '', $GLOBALS['TL_DCA']['tl_files']['palettes']['default']);
			}
		}
	}
} 