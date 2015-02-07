Contao Image Srcset
====================================

This module extends the file type image in file management, so you can save a picture source set for images.


System requirements
-------------------

 * Web server
 * PHP 5.3.2+ with GDlib, DOM, Phar and SOAP
 * MySQL 5.0.3+
 * contao-core >=3.2-dev,<4-dev
 * contao-community-alliance/composer-plugin
 * menatwork/contao-multicolumnwizard

Installation
------------

easy to install via Composer-Package-Management in Contao-CMS


Usage
------------

The image formats from the preferences in Contao are supported.

The images source set must be enabled in the corresponding page layout.
In the file management the adjustments at the main frame accordingly. The result is this html element.


```html
<img src="image.jpg" srcset="image_320.jpg 320w, image_600.jpg 600w, image_900.jpg 900w" alt="">
```

![alt text][preview_file]

[preview_file]: https://raw.githubusercontent.com/ContaoBlackforest/contao-image-srcset/master/blob/master/preview_file.jpg "Preview file edit view"
