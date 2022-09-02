<?php

use App\Jobs\ParseCategory;
use App\Jobs\TestJob;

return [
    'console' => [
        'commands' => [
            'Название комманды' => TestJob::class,
            'ParseCategory' => ParseCategory::class
        ]
    ]
];