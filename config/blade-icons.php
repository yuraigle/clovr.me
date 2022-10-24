<?php

return [
    'sets' => [
        'default' => [
            'path' => 'resources/svg',
            'prefix' => 'icon',
            'attributes' => [
                 'width' => 24,
                 'height' => 24,
            ],
        ],
        'mini' => [
            'path' => 'resources/svg',
            'prefix' => 'mini',
            'attributes' => [
                'width' => 16,
                'height' => 16,
            ],
        ],
    ],

    'class' => '',
    'attributes' => [],
    'fallback' => '',

    'components' => [
        'disabled' => true,
        'default' => 'icon',
    ],
];
