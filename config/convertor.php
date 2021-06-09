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
                'jpg',
            ],
            'rules' => 'mimes:doc,docx',
            'mimes' => 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ],
        'odt' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:odt',
            'mimes' => 'application/vnd.oasis.opendocument.text',
        ],
        'rtf' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:rtf',
            'mimes' => 'application/rtf',
        ],
        'ppt' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:ppt',
            'mimes' => 'application/vnd.ms-powerpoint',
        ],
        'pptx' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:pptx',
            'mimes' => 'pplication/vnd.openxmlformats-officedocument.presentationml.presentation',
        ],
        'ods' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:ods',
            'mimes' => 'application/vnd.oasis.opendocument.spreadsheet',
        ],
        'epub' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:epub',
            'mimes' => 'application/epub+zip',
        ],
        'jpg' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:jpg,jpeg',
            'mimes' => 'image/jpeg',
        ],
        'pdfs' => [
            'to' => [
                'pdf',
            ],
            'rules' => 'mimes:pdf',
            'mimes' => 'application/pdf',
        ],
    ],
    'content' => [
        'docx-to-pdf' => [
            'title' => 'Title for docx-to-pdf',
            'footer' => file_get_contents(__DIR__ . '/../texts/docx-to-pdf.txt'),
        ],
        'docx-to-jpg' => [
            'title' => 'Title for docx-to-jpg',
            'footer' => 'Footer text for docx-to-jpg'
        ],

        'odt-to-pdf' => [
            'title' => 'Title for odt-to-pdf',
            'footer' => 'Footer text for odt-to-pdf'
        ],
        'rtf-to-pdf' => [
            'title' => 'Title for rtf-to-pdf',
            'footer' => 'Footer text for rtf-to-pdf'
        ],
        'ppt-to-pdf' => [
            'title' => 'Title for ppt-to-pdf',
            'footer' => 'Footer text for ppt-to-pdf'
        ],
        'pptx-to-pdf' => [
            'title' => 'Title for pptx-to-pdf',
            'footer' => 'Footer text for pptx-to-pdf'
        ],
        'ods-to-pdf' => [
            'title' => 'Title for ods-to-pdf',
            'footer' => 'Footer text for docx-to-pdf'
        ],
        'epub-to-pdf' => [
            'title' => 'Title for epub-to-pdf',
            'footer' => 'Footer text for epub-to-pdf'
        ],
        'jpg-to-pdf' => [
            'title' => 'Title for jpg-to-pdf',
            'footer' => 'Footer text for jpg-to-pdf'
        ],
        'pdfs-to-pdf' => [
            'title' => 'Title for pdfs-to-pdf',
            'footer' => 'Footer text for pdfs-to-pdf'
        ],
    ]
];
