<?php

return [
    'roles'       => [
        'admin'  => [
            'inherits' => ['writer', 'editor'],
        ],
        'writer' => [
            'permissions' => ['book.write', 'book.author'],
        ],
        'editor' => [
            'permissions' => ['book.read'],
        ],
    ],
    'permissions' => [
        'book.write'   => ['resource' => 'book'],
        'book.read'    => ['resource' => 'book'],
        'book.author'  => [
            'resource' => 'book',
            'rules'    => ['AuthorRule'],
        ],
        'article.read' => ['resource' => 'article'],
    ],
    'assignments' => [
        '1' => [
            'subject_name' => 'user',
            'roles'        => ['admin'],
        ],
    ],
];
