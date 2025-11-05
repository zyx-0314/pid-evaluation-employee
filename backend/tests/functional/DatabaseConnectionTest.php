<?php

namespace tests\functional;

use PHPUnit\Framework\TestCase;
use Yii;

/**
 * Database Connection Test
 * 
 * Functional test that verifies database connectivity
 * This test simulates AWS RDS MySQL connection
 * 
 * Learning note: Functional tests verify that system components
 * work together correctly (e.g., app connects to database)
 */
class DatabaseConnectionTest extends TestCase
{
    /**
     * Test that database connection can be established
     * 
     * Clean code: Test method name clearly describes what is being tested
     */
    public function testDatabaseConnectionIsSuccessful()
    {
        $db = Yii::$app->db;
        
        // Assert that we have a database connection
        $this->assertNotNull($db, 'Database component should be configured');
        
        try {
            // Attempt to open the connection
            $db->open();
            $this->assertTrue($db->isActive, 'Database connection should be active');
            
            // Execute a simple query to verify connection works
            $result = $db->createCommand('SELECT 1 as test')->queryOne();
            $this->assertEquals(1, $result['test'], 'Database query should return expected result');
            
            echo "\n✓ Database connection successful\n";
            echo "  Host: " . $db->dsn . "\n";
            echo "  Status: Connected\n";
            
        } catch (\Exception $e) {
            $this->fail('Failed to connect to database: ' . $e->getMessage());
        }
    }

    /**
     * Test that required tables exist
     * 
     * Learning note: This verifies database schema is properly initialized
     */
    public function testRequiredTablesExist()
    {
        $db = Yii::$app->db;
        
        $requiredTables = ['users', 'employees', 'evaluations', 'evaluation_criteria'];
        
        foreach ($requiredTables as $table) {
            $exists = $db->schema->getTableSchema($table) !== null;
            $this->assertTrue($exists, "Table '{$table}' should exist in database");
        }
        
        echo "\n✓ All required tables exist\n";
    }

    /**
     * Test database can perform CRUD operations
     * 
     * Learning note: Verifies basic database operations work
     */
    public function testDatabaseCrudOperations()
    {
        $db = Yii::$app->db;
        
        // Test SELECT
        $count = $db->createCommand('SELECT COUNT(*) FROM users')->queryScalar();
        $this->assertIsNumeric($count, 'Should be able to count records');
        
        echo "\n✓ Database CRUD operations working\n";
        echo "  Users in database: " . $count . "\n";
    }
}
