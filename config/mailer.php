<?php defined('SYSPATH') or die('No direct script access.');

return array
(
    'default' => array 
    (
        'transport' => 'smtp',
        'options'   => array
            (
                'hostname'  => 'hostname',
                'username'  => 'username',
                'password'  => 'password',
                'port'      => 'port',
                'encryption'=> 'encryption'
            ),
    )
);

