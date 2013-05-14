<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
    'media_bucket' => 'BUCKETNAME',
    'video_bucket' => 'BUCKETNAME',
    'image_sizes' => array(
        'tiny' => 50,
        'tiny_square' => 50,
        'tiny_wide' => 50,
        'small' => 250,
        'small_square' => 200,
        'small_wide' => 250,
        'medium' => 500,
        'medium_square' => 400,
        'medium_wide' => 500,
        'large' => 800,
        'raw' => null
    ),
    'credentials' => array (
        'development' => array(
            'key' => 'AWSKEY',
            'secret' => 'AWSSECRET',
            'default_cache_config' => '',
            'certificate_authority' => false
        ),
        '@default' => 'development'
    )
);
