<?php
/**
 * Contact-Form-Light plugin basic configurations
 */

return [
    'ContactFormLight' => [
        'default' => [
            'validation' => [
                'messages' => [
                    'notEmpty' => 'This field cannot be left empty',
                    'isRequired' => 'This field is required',
                    'tooLong' => 'The provided value is too long',
                    'invalidFormat' => 'The provided value is invalid',
                    'invalidTelFormat' => 'The provided value is invalid',
                    'invalidEmailFormat' => 'The provided value is invalid',
                    'notSameEmail' => 'This field must be same as "E-mail"',
                ]
            ],
            'subjects' => [
                1 => 'About us',
                2 => 'About our products',
                3 => 'Other',
            ]
        ]
    ],
];
