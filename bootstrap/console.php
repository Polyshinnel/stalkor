<?php

use App\Jobs\ParseCategory;
use App\Jobs\ParseProducts;
use App\Jobs\TestJob;

return [
    'console' => [
        'commands' => [
            'ParseCategory' => ParseCategory::class,
            'ParseProducts' => ParseProducts::class
        ]
    ]
];