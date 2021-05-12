<?php 
return [
    'captcha' => [
        'site_key' => env('INVISIBLE_RECAPTCHA_SITEKEY', ''),
        'secret_key' => env('INVISIBLE_RECAPTCHA_SECRETKEY', ''),
    ],
    'types' => [
        'docx' => [
            'to' => [
                'pdf',
                'jpg'
            ],
            'rules' => 'mimes:doc,docx',
            'mimes' => 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document' 
        ],
    ],
    'content' => [
        'docx-to-pdf' => [
            'title' => 'Title for docx-to-pdf',
            'footer' => 'Footer text for docx-to-pdf'
        ],
        'docx-to-jpg' => [
            'title' => 'Title for docx-to-jpg',
            'footer' => 'Footer text for docx-to-jpg'
        ]
    ]
];