<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=anaconda',
    'username' => 'anaconda',
    'password' => 'anaconda',
    'charset' => 'utf8',
    'schemaMap' =>  [
        'pgsql' => [
          'class' => 'yii\db\pgsql\Schema',
          'defaultSchema' => 'public'
        ]
    ]
];
