<?php

/**
 * Database Configuration
 * 
 * Simulates AWS RDS MySQL connection
 * Following clean code: Configuration is externalized via environment variables
 */

return [
    'class' => 'yii\db\Connection',
    'dsn' => sprintf(
        'mysql:host=%s;dbname=%s',
        getenv('DB_HOST') ?: 'localhost',
        getenv('DB_NAME') ?: 'pid_evaluation'
    ),
    'username' => getenv('DB_USER') ?: 'pid_user',
    'password' => getenv('DB_PASSWORD') ?: 'pid_password',
    'charset' => 'utf8mb4',
    
    // Enable schema caching for better performance
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];
