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
 * File management set image srcset
 */

// Config
$GLOBALS['TL_DCA']['tl_files']['config']['onload_callback'] = array_merge($GLOBALS['TL_DCA']['tl_files']['config']['onload_callback'], array(array('\ContaoBlackforest\Backend\DCA\Files\ImageSectionSet', 'controlVisibility')));

// Palettes
/*if (!isset($GLOBALS['TL_DCA']['tl_files']['palettes']['__selector__'])) {
	$GLOBALS['TL_DCA']['tl_files']['palettes']['__selector__'] = array();
}

$GLOBALS['TL_DCA']['tl_files']['palettes']['__selector__'] = array_merge($GLOBALS['TL_DCA']['tl_files']['palettes']['__selector__'], array('activateSrcSet'));*/

$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] .= ';activateSrcSet,imageSrcSet';
//$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] .= ';activateSrcSet';

// Subpalettes
/*if (!isset($GLOBALS['TL_DCA']['tl_files']['subpalettes'])) {
	$GLOBALS['TL_DCA']['tl_files']['subpalettes'] = array();
}

$GLOBALS['TL_DCA']['tl_files']['subpalettes'] = array_merge($GLOBALS['TL_DCA']['tl_files']['subpalettes'], array('activateSrcSet' => 'imageSrcSet'));*/


// Fields
$fields = array
(
	'activateSrcSet' => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_files']['activateSrcSet'],
		'inputType' => 'checkbox',
		'eval'      => array(/*'submitOnChange' => true, */
							 'tl_class' => 'w50'
		),
		'sql'       => "char(1) NOT NULL default ''"
	),
	'imageSrcSet'    => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_files']['imageSrcSet'],
		'inputType' => 'multiColumnWizard',
		'eval'      => array
		(
			'tl_class'     => 'clr',
			'columnFields' => array
			(
				'attributeSrcSet'       => array
				(
					'label'     => &$GLOBALS['TL_LANG']['tl_files']['attributeSrcSet'],
					'inputType' => 'text',
					'eval'      => array('style' => 'width:180px'),
				),
				'imageForSrcSet'        => array
				(
					'label'     => &$GLOBALS['TL_LANG']['tl_files']['imageForSrcSet'],
					'inputType' => 'fileTree',
					'eval'      => array('filesOnly' => true, 'fieldType' => 'radio')
				),
				'imageForSrcSetDisable' => array
				(
					'label'     => &$GLOBALS['TL_LANG']['tl_files']['imageForSrcSetDisable'],
					'inputType' => 'checkbox'
				)
			),
		),
		'sql'       => 'blob NULL'
	)
);

$GLOBALS['TL_DCA']['tl_files']['fields'] = array_merge($GLOBALS['TL_DCA']['tl_files']['fields'], $fields);
