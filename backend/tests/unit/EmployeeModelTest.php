<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;
use app\models\Employee;

/**
 * Employee Model Unit Test
 * 
 * Tests individual functions in the Employee model
 */
class EmployeeModelTest extends TestCase
{
    /**
     * Test getFullName method
     * 
     * Clean code: Simple, readable test
     */
    public function testGetFullName()
    {
        $employee = new Employee();
        $employee->first_name = 'John';
        $employee->last_name = 'Doe';
        
        $this->assertEquals('John Doe', $employee->getFullName(), 'Full name should be concatenated correctly');
        
        echo "\n✓ getFullName() works correctly\n";
    }

    /**
     * Test validation rules
     */
    public function testValidationRules()
    {
        $employee = new Employee();
        
        // Empty employee should not be valid
        $this->assertFalse($employee->validate(), 'Empty employee should not be valid');
        
        // Set required fields
        $employee->employee_id = 'EMP999';
        $employee->first_name = 'Test';
        $employee->last_name = 'User';
        $employee->email = 'test@example.com';
        
        $this->assertTrue($employee->validate(), 'Employee with required fields should be valid');
        
        echo "\n✓ Employee validation works correctly\n";
    }
}
