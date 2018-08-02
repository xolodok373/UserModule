<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '<action:(login|logout)>' => 'user/security/<action>',
        '<action:(register)>' => 'user/registration/<action>',
        '<action:(profile)>' => 'user/settings/<action>',
    ],
];