<?php
  // DB Params
  define("DB_HOST", "localhost");
  define("DB_USER", "root");
  define("DB_PASS", "");
  define("DB_NAME", "treble_api_rid");
  define("DB_PORT", 3307);

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  define('URLROOT', 'http://localhost/E-commerce_API');
  define('SITENAME', 'TREBLE');


  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Methods: GET, POST");
  


