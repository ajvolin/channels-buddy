<?php

const MAX_GUIDE_DURATION = 86400*14;
const MAX_BACKEND_CHUNK_SIZE = 86400*14;

return [

    'channelSources' => [
        'pluto' => [
            'displayName' => 'Pluto TV',
            'guideChunkSize' => 21600,
            'guideDuration' => 86400
        ],
        'stirr' => [
            'displayName'  => 'Stirr TV',
            'guideChunkSize' => null,
            'guideDuration' => null,
            'stationLineups'  => [
                'national'
            ]
        ]
    ],

    // maximum number of seconds total of guide data that can be requested
    'guideDuration' => min(
        env('CHANNELS_GUIDE_DURATION', MAX_GUIDE_DURATION),
        MAX_GUIDE_DURATION,
    ),

    // maximum number of seconds of guide data that
    //      can be requested from the backend at one time
    'backendChunkSize' => min(
        env('CHANNELS_BACKEND_CHUNK_SIZE', MAX_BACKEND_CHUNK_SIZE),
        MAX_BACKEND_CHUNK_SIZE
    ),

];
