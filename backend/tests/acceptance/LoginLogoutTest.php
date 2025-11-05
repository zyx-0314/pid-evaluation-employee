<?php

namespace tests\acceptance;

use PHPUnit\Framework\TestCase;
use Yii;
use app\models\User;

/**
 * Login/Logout (LILO) Acceptance Test
 * 
 * E2E test for the complete login and logout scenario
 * 
 * Learning note: Acceptance tests verify complete user scenarios
 * work from start to finish (end-to-end testing)
 */
class LoginLogoutTest extends TestCase
{
    /**
     * Test complete LILO (Login/Logout) scenario
     * 
     * This tests the entire user journey:
     * 1. User is not logged in
     * 2. User logs in with credentials
     * 3. User is authenticated
     * 4. User logs out
     * 5. User is no longer authenticated
     */
    public function testCompleteLoginLogoutScenario()
    {
        // Clean code: Step-by-step scenario testing
        
        // Step 1: Verify user is not logged in initially
        $this->assertTrue(Yii::$app->user->isGuest, 'User should be guest initially');
        echo "\n✓ Step 1: User is not logged in\n";
        
        // Step 2: Find a test user
        $user = User::findByUsername('admin');
        $this->assertNotNull($user, 'Test user should exist');
        echo "✓ Step 2: Test user found\n";
        
        // Step 3: Perform login
        $loginSuccess = Yii::$app->user->login($user);
        $this->assertTrue($loginSuccess, 'Login should succeed');
        $this->assertFalse(Yii::$app->user->isGuest, 'User should not be guest after login');
        $this->assertEquals($user->id, Yii::$app->user->id, 'Logged in user ID should match');
        echo "✓ Step 3: User logged in successfully\n";
        
        // Step 4: Verify user identity
        $identity = Yii::$app->user->identity;
        $this->assertNotNull($identity, 'User identity should be available');
        $this->assertEquals('admin', $identity->username, 'Username should match');
        echo "✓ Step 4: User identity verified\n";
        
        // Step 5: Perform logout
        Yii::$app->user->logout();
        $this->assertTrue(Yii::$app->user->isGuest, 'User should be guest after logout');
        $this->assertNull(Yii::$app->user->identity, 'User identity should be null after logout');
        echo "✓ Step 5: User logged out successfully\n";
        
        echo "\n✓ Complete LILO scenario passed\n";
    }

    /**
     * Test login with invalid credentials
     * 
     * Learning note: Test negative scenarios too
     */
    public function testLoginWithInvalidCredentials()
    {
        $user = User::findByUsername('admin');
        $this->assertNotNull($user, 'Test user should exist');
        
        // Try to validate with wrong password
        $isValid = $user->validatePassword('wrongPassword');
        $this->assertFalse($isValid, 'Wrong password should not validate');
        
        echo "\n✓ Invalid credentials rejected correctly\n";
    }

    /**
     * Test login with non-existent user
     */
    public function testLoginWithNonExistentUser()
    {
        $user = User::findByUsername('nonexistentuser');
        $this->assertNull($user, 'Non-existent user should return null');
        
        echo "\n✓ Non-existent user handled correctly\n";
    }
}
