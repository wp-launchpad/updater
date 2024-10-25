<?php
return [
    'onFirstInstallShouldFireInstallAction' => [
        'config' => [
            'old_version' => null,
        ],
        'expected' => [
            'install' => 1,
            'update' => 0,
        ]
    ],
    'onAlreadyInstalledShouldFireUpdateAction' => [
        'config' => [
            'old_version' => '3.15',
        ],
        'expected' => [
            'install' => 0,
            'update' => 1,
        ]
    ],
    'onAlreadyInstalledSameVersionShouldDoNothing' => [
        'config' => [
            'old_version' => '3.16',
        ],
        'expected' => [
            'install' => 0,
            'update' => 0,
        ]
    ]

];
