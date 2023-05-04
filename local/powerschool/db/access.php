<?php
$capabilities = [
    // 'local/powerschool:viewpages' => [
    //     'riskbitmask' => RISK_SPAM,
    //     'captype' => 'read',
    //     'contextlevel' => CONTEXT_SYSTEM,
    //     'archetypes' => [
    //         'manager' => CAP_ALLOW,
    //     ],
    // ],

    'local/powerschool:managepages' => [
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];
