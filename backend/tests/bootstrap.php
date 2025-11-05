<?php

/**
 * Test bootstrap file
 * 
 * Sets up the test environment
 */

define('YII_DEBUG', true);
define('YII_ENV', 'test');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// Set test application configuration
$config = require __DIR__ . '/../config/web.php';
new yii\web\Application($config);
