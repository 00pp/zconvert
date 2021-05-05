<?php 
return [
    'types' => [
        'docx' => [
            'to' => [
                'pdf',
                'jpg'
            ],
            'rules' => 'mimes:doc,docx',
            'mimes' => 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document' 
        ],
    ]
];