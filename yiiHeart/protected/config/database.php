<?php
// This is the database connection configuration.
return array(
    /* 'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db', */
    // uncomment the following lines to use a MySQL database
    
      'connectionString' => 'mysql:host=localhost;dbname=localdb',
      'emulatePrepare' => true,
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
     
    // uncomment the following lines to use a Postgres database
   /* 'class' => 'DBConnection',
    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=localdb',
    'emulatePrepare' => true,
    'username' => 'postgres',
    'password' => 'postgres',
    'charset' => 'utf8',
    'defaultSchema' => 'test_shema',
    'enableProfiling' => true,*/
);
