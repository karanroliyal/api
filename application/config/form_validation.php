<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
    'user_master' => [
        [
            'field' => 'user_name',
            'label' => 'Name',
            'rules' => 'required|min_length[3]|max_length[40]'
        ],
        [
            'field' => 'user_email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        ],
        [
            'field' => 'phone_no',
            'label' => 'Phone number',
            'rules' => 'required|exact_length[10]|numeric'
        ],
    ],
    'languages' => [
        [
            'field' => 'language_code',
            'label' => 'Language code',
            'rules' => 'required|min_length[2]|max_length[5]'
        ],
        [
            'field' => 'language_name',
            'label' => 'Language name',
            'rules' => 'required|max_length[40]'
        ]
    ]
];
