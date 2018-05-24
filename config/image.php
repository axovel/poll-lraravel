<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'ad_image_path' => public_path().'/media/images/ads/',

    'temp_image_path' => public_path().'/media/images/temp/',

    'ad_image_width_small' => 250,

    'ad_image_width_medium' => 500,

    'ad_image_width_verysmall' => 150,

);
