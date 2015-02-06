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


namespace ContaoBlackforest\Frontend\Image;


/**
 * Class ImageSectionSet
 *
 * @package ContaoBlackforest\Frontend\Image
 */
class ImageSectionSet extends \FrontendTemplate
{

	/**
	 * image cache
	 *
	 * @var $images
	 */
	protected static $images;


	/**
	 * cache the images to static::$images
	 *
	 * @param $template
	 *
	 * @throws \Exception
	 */
	public function cachedImages($template)
	{
		if (TL_MODE === 'FE') {
			/** @var \PageModel $objPage */
			global $objPage;

			$layout = $objPage->getRelated('layout');

			if ($layout->activateImageSecSet && $template->singelSRC || $template->multiSRC) {
				$template->size = deserialize($template->size);

				if ($template->size[0] || $template->size[1]) {
					if ($image = $template->singleSRC) {
						$images = array($image);
					}

					if ($images = $template->multiSRC) {
						if (!is_array($images)) {
							$images = deserialize($images);
						}
					}

					if (is_array($images)) {
						foreach ($images as $image) {
							$file = \FilesModel::findByUuid($image);

							$path = \Image::get($file->path, $template->size[0], $template->size[1], $template->size[2]);

							$buffer = array
							(
								'path' => $file->path
							);

							if (!isset(static::$images[$path])) {
								static::$images[$path] = $buffer;
							}
						}
					}
				}
			}
		}
	}


	/**
	 * init the method to modify the tag
	 *
	 * @param $buffer
	 * @param $template
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function replaceImageTags($buffer, $template)
	{
		if (TL_MODE === 'FE') {
			/** @var \PageModel $objPage */
			global $objPage;

			$layout = $objPage->getRelated('layout');

			if (!$layout->activateImageSecSet) {
				return $buffer;
			}

			return $this->setSectionSet($buffer);
		}

		return $buffer;
	}


	/**
	 * search img tag of source code
	 *
	 * @param $buffer
	 *
	 * @return string
	 */
	protected function setSectionSet($buffer)
	{
		$buffer = explode('<img ', $buffer);

		foreach ($buffer as $row => $value) {
			$value = explode('>', $value);

			$value[0] = $this->modifyImageTag($value[0]);

			$buffer[$row] = implode('>', $value);
		}

		return implode('<img ', $buffer);
	}


	/**
	 * modify the img tag with srcset attribute
	 *
	 * @param $img
	 *
	 * @return mixed|string
	 */
	protected function modifyImageTag($img)
	{
		if (stristr($img, 'src="') && !stristr($img, 'srcset="')) {
			$path    = explode('"', explode('src="', $img)[1])[0];
			$oriPath = $path;

			if (isset(static::$images[$path])) {
				$path = static::$images[$path]['path'];
			}

			$file = \FilesModel::findMultipleByPaths(array($path));

			if ($file && $file->next() && $file->activateSrcSet && $file->imageSrcSet) {
				$file->imageSrcSet = deserialize($file->imageSrcSet);

				if (is_array($file->imageSrcSet)) {

					$srcSet = '';

					foreach ($file->imageSrcSet as $set) {
						if (!$set['imageForSrcSetDisable']) {
							if ($srcSet) {
								$srcSet .= ', ';
							}

							if (!$set['imageForSrcSet']) {
								$srcSet .= $oriPath;
							}

							if ($set['imageForSrcSet']) {
								$fileSet = \FilesModel::findByUuid($set['imageForSrcSet']);

								if ($fileSet) {
									$srcSet .= $fileSet->path;
								}
							}

							if ($srcSet) {
								$srcSet .= ' ' . $set['attributeSrcSet'];
							}
						}
					}

					if ($srcSet) {
						$attributes = array('width', 'height');

						foreach ($attributes as $attribute) {
							if ($value = $this->getAttribute($img, $attribute)) {
								$img = str_replace(' ' . $value, '', $img);
							}
						}

						if ($value = $this->getAttribute($img, 'alt')) {
							$img = str_replace($value, ' srcset="' . $srcSet . '" ' . $value, $img);
						}
						else {
							$img .= ' srcset="' . $srcSet . '"';
						}
					}
				}
			}
		}

		return $img;
	}


	/**
	 * return an attribute from tag
	 *
	 * @param $tag
	 * @param $type
	 *
	 * @return string
	 */
	protected function getAttribute($tag, $type)
	{
		$value = explode('"', explode($type . '="', $tag)[1])[0];

		return $type . '="' . $value . '"';
	}
}