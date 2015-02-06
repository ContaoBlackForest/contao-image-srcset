<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Table tl_layout
 */

// Palettes
$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] = str_replace('{expert_legend:', '{legend_imageSecSet:hide},activateImageSecSet;{expert_legend:', $GLOBALS['TL_DCA']['tl_layout']['palettes']['default']);

//Fields
$fields = array
(
	'activateImageSecSet' => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_layout']['activateImageSecSet'],
		'exclude'   => true,
		'inputType' => 'checkbox',
		'sql'       => "char(1) NOT NULL default ''"
	)
);

$GLOBALS['TL_DCA']['tl_layout']['fields'] = array_merge($GLOBALS['TL_DCA']['tl_layout']['fields'], $fields);
 
 
 
 
 
  