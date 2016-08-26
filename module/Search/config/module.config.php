<?php

namespace Search;

use Song\Model\SongCommandInterface;

return [
    'service_manager' => [
        'delegators' => [
            SongCommandInterface::class => [
                Delegator\SongCommandDelegatorFactory::class
            ]
        ],
    ],
];
