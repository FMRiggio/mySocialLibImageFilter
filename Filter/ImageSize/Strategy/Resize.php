<?php

/**
 * @see Zend_Filter_ImageSize_Strategy_Interface 
 */
require_once 'MySocialLib/Filter/ImageSize/Strategy/Interface.php';

/**
 * Strategy for resizing the image by fitting the content into the given 
 * dimensions.
 */
class MySocialLib_Filter_Imagesize_Strategy_Resize 
    implements MySocialLib_Filter_ImageSize_Strategy_Interface
{
    /**
     * Return canvas resized according to the given dimensions.
     * @param resource $image GD image resource
     * @param int $width Output width
     * @param int $height Output height
     * @return resource GD image resource
     */
    public function resize($image, $width, $height)
    {
        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

		$final = imagecreatetruecolor($width, $height);

		$w = $width;
		$h = $height;

		if ($origWidth >= $origHeight) {
			$h = $origHeight * $w / $origWidth;
		} else {
			$w = $origWidth * $h / $origHeight;
		}
		$partial = imagecreatetruecolor($w, $h);

		imagecopyresampled($partial, $image, 0, 0, 0, 0, $w, $h, $origWidth, $origHeight);

		$x = round(($width - $w)/2, 0);
		$y = round(($height - $h)/2, 0);

		imagecopyresampled($final, $partial, 0, 0, $x, $y, $width, $height, $w, $h);

        return $final;
    }
}