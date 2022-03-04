<?php
/**
 * Imager X plugin for Craft CMS
 *
 * Ninja powered image transforms.
 *
 * @link      https://www.spacecat.ninja
 * @copyright Copyright (c) 2020 André Elvan
 */

namespace spacecatninja\imagerx\effects;

use spacecatninja\imagerx\services\ImagerService;
use Imagine\Gd\Image as GdImage;
use Imagine\Imagick\Image as ImagickImage;

class GreyscaleEffect implements ImagerEffectsInterface
{

    /**
     * @param GdImage|ImagickImage        $imageInstance
     * @param array|string|int|float|null $params
     */
    public static function apply($imageInstance, $params)
    {
        if (ImagerService::$imageDriver === 'gd') {
            $imageInstance->effects()->grayscale();
        }
        
        if (ImagerService::$imageDriver === 'imagick') {
            /** @var ImagickImage $imageInstance */
            $imagickInstance = $imageInstance->getImagick();
            
            $hasTransparency = $imagickInstance->getImageAlphaChannel();
            $imagickInstance->setImageType(\Imagick::IMGTYPE_GRAYSCALE);

            if ($hasTransparency !== 0) {
                $imagickInstance->setImageAlphaChannel(\Imagick::ALPHACHANNEL_ACTIVATE);
                $imagickInstance->setBackgroundColor(new \ImagickPixel('transparent'));
            }
        }
    }
}
