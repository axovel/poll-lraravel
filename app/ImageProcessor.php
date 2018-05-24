<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class ImageProcessor extends Model
{
    public $tempPath;

    public $adsImagePath;

    public $adImageWidthSmall;
    public $adImageWidthMedium;
    public $adImageWidthVerySmall;


    /**
     * ImageProcessor constructor.
     */
    public function __construct()
    {
        $this->adImageWidthVerySmall = config('image.ad_image_width_verysmall');
        $this->adImageWidthSmall     = config('image.ad_image_width_small');
        $this->adImageWidthMedium    = config('image.ad_image_width_medium');
        $this->tempPath              = config('image.temp_image_path');
        $this->adsImagePath          = config('image.ad_image_path');
    }

    /**
     * @param $fileName
     */
    public function generateThumbnail($fileName)
    {
        $this->generateMediumImage($fileName);
        $this->generateSmallImage($fileName);
        $this->generateVerySmallImage($fileName);
    }

    /**
     * @param $fileName
     */
    public function generateSmallImage($fileName)
    {
        list($fileWidth, $fileHeight) = getimagesize($this->tempPath.$fileName);
        $height                       = floor($fileHeight * ($this->adImageWidthSmall / $fileWidth));

        Image::make($this->tempPath.$fileName)
            ->resize($this->adImageWidthSmall, $height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->resizeCanvas($this->adImageWidthSmall, $height, 'center', false, [0, 0, 0, 0])
            ->save($this->adsImagePath.'small/'.$fileName);
    }

    /**
     * @param $fileName
     */
    public function generateVerySmallImage($fileName)
    {
        list($fileWidth, $fileHeight) = getimagesize($this->tempPath.$fileName);
        $height                       = floor($fileHeight * ($this->adImageWidthVerySmall / $fileWidth));

        Image::make($this->tempPath.$fileName)
            ->resize($this->adImageWidthVerySmall, $height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->resizeCanvas($this->adImageWidthVerySmall, $height, 'center', false, [0, 0, 0, 0])
            ->save($this->adsImagePath.'verysmall/'.$fileName);
    }

    /**
     * @param $fileName
     */
    public function generateMediumImage($fileName)
    {
        list($fileWidth, $fileHeight) = getimagesize($this->tempPath.$fileName);
        $height                       = floor($fileHeight * ($this->adImageWidthMedium / $fileWidth));

        Image::make($this->tempPath.$fileName)
            ->resize($this->adImageWidthMedium, $height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->resizeCanvas($this->adImageWidthMedium, $height, 'center', false, [0, 0, 0, 0])
            ->save($this->adsImagePath.'medium/'.$fileName);
    }
}
