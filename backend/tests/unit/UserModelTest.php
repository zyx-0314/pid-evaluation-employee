<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;
use app\models\User;

/**
 * User Model Unit Test
 * 
 * Unit test for individual User model functions
 * 
 * Learning note: Unit tests verify individual functions/methods work correctly
 * in isolation from other system components
 */
class UserModelTest extends TestCase
{
    /**
     * Test password hashing and validation
     * 
     * Clean code: Test one thing at a time
     */
    public function testPasswordHashingAndValidation()
    {
        $user = new User();
        $password = 'testPassword123';
        
        // Test password setting
        $user->setPassword($password);
        $this->assertNotEmpty($user->password_hash, 'Password hash should not be empty');
        $this->assertNotEquals($password, $user->password_hash, 'Password should be hashed');
        
        // Test password validation
        $this->assertTrue($user->validatePassword($password), 'Correct password should validate');
        $this->assertFalse($user->validatePassword('wrongPassword'), 'Wrong password should not validate');
        
        echo "\n✓ Password hashing and validation works correctly\n";
    }

    /**
     * Test role checking
     * 
     * KISS: Simple test for simple functionality
     */
    public function testRoleChecking()
    {
        $user = new User();
        $user->role = 'admin';
        
        $this->assertTrue($user->hasRole('admin'), 'Should have admin role');
        $this->assertFalse($user->hasRole('manager'), 'Should not have manager role');
        
        echo "\n✓ Role checking works correctly\n";
    }

    /**
     * Test validation rules
     */
    public function testValidationRules()
    {
        $user = new User();
        
        // Empty user should not be valid
        $this->assertFalse($user->validate(), 'Empty user should not be valid');
        
        // Set required fields
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->password_hash = 'hash';
        
        $this->assertTrue($user->validate(), 'User with required fields should be valid');
        
        // Test invalid email
        $user->email = 'invalid-email';
        $this->assertFalse($user->validate(), 'Invalid email should fail validation');
        
        echo "\n✓ Validation rules work correctly\n";
    }
}
