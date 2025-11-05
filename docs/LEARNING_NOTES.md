# Learning Notes for PID Employee Evaluation System

This document provides learning notes and explanations for developers working on this project.

## 🎓 Core Concepts

### 1. Clean Code Principles

#### What is Clean Code?
Clean code is code that is easy to read, understand, and modify. It follows best practices that make software maintainable and scalable.

**Key Principles Applied in This Project:**

1. **Meaningful Names**
   - Variables and functions have descriptive names
   - Example: `getFullName()` instead of `gfn()`
   - Example: `$employee->first_name` instead of `$e->fn`

2. **Single Responsibility Principle (SRP)**
   - Each class/function does one thing well
   - `User` model: Handles user authentication
   - `Employee` model: Handles employee data
   - `S3Service`: Handles file storage operations

3. **Small Functions**
   - Functions are short and focused
   - Each function has a clear, single purpose
   - Example: `validatePassword()`, `hasRole()`, `getFullName()`

4. **DRY (Don't Repeat Yourself)**
   - Avoid code duplication
   - Use components and services for reusable logic
   - Configuration is centralized

### 2. KISS (Keep It Simple, Stupid)

**Philosophy:** The simpler the solution, the better.

**Examples in This Project:**

1. **Simple Configuration**
   ```php
   // config/db.php - Simple and readable
   return [
       'dsn' => 'mysql:host=localhost;dbname=pid_evaluation',
       'username' => 'pid_user',
       'password' => 'pid_password',
   ];
   ```

2. **Simple Methods**
   ```php
   // Employee model - Simple getFullName method
   public function getFullName() {
       return $this->first_name . ' ' . $this->last_name;
   }
   ```

3. **Avoiding Over-Engineering**
   - No unnecessary abstractions
   - No premature optimization
   - Start simple, add complexity only when needed

## 🧪 Testing Philosophy

### Test Pyramid

```
        /\
       /  \
      / E2E \ (Acceptance Tests)
     /------\
    /        \
   / Integration \ (Functional Tests)
  /------------\
 /              \
/  Unit Tests    \
------------------
```

**Bottom Layer - Unit Tests (Most tests)**
- Fast to run
- Test individual functions
- Easy to maintain
- Example: `testPasswordHashingAndValidation()`

**Middle Layer - Functional Tests**
- Test integration between components
- Test database connections
- Verify services work together
- Example: `testDatabaseConnectionIsSuccessful()`

**Top Layer - Acceptance Tests (Fewest tests)**
- Slow to run
- Test complete user scenarios
- Verify business requirements
- Example: `testCompleteLoginLogoutScenario()`

### Why This Structure?

1. **Fast Feedback**: Unit tests run quickly, giving immediate feedback
2. **Reliable**: Less complex tests are more reliable
3. **Maintainable**: Small tests are easier to update
4. **Clear**: Each test has a specific purpose

### Test Categories Explained

#### 1. Functional Tests (`tests/functional/`)

**Purpose:** Test that different parts of the system work together.

**Example Scenario:**
- Does the application connect to the database?
- Can the S3 service upload files?
- Does the API return correct data?

**Learning Note:**
> Functional tests verify integration points. If a functional test fails, 
> it means components aren't working together properly, even if they work 
> individually.

**Real Example:**
```php
public function testDatabaseConnectionIsSuccessful()
{
    $db = Yii::$app->db;
    $db->open();
    $this->assertTrue($db->isActive);
}
```

#### 2. Unit Tests (`tests/unit/`)

**Purpose:** Test individual functions in isolation.

**Example Scenario:**
- Does password hashing work correctly?
- Does email validation work?
- Does `getFullName()` concatenate names properly?

**Learning Note:**
> Unit tests focus on ONE thing. If you need to test multiple things, 
> write multiple test methods. This makes it clear what failed when a test breaks.

**Real Example:**
```php
public function testPasswordHashingAndValidation()
{
    $user = new User();
    $user->setPassword('testPassword123');
    $this->assertTrue($user->validatePassword('testPassword123'));
    $this->assertFalse($user->validatePassword('wrongPassword'));
}
```

#### 3. Acceptance Tests (`tests/acceptance/`)

**Purpose:** Test complete user scenarios from start to finish (E2E - End-to-End).

**Example Scenario:**
- LILO (Login/Logout): User logs in, does something, logs out
- Create evaluation: Manager creates an evaluation for an employee
- Submit feedback: Employee submits self-evaluation

**Learning Note:**
> Acceptance tests tell a story. They verify that the system works from 
> the user's perspective, not just technical functionality.

**Real Example:**
```php
public function testCompleteLoginLogoutScenario()
{
    // Step 1: User is not logged in
    $this->assertTrue(Yii::$app->user->isGuest);
    
    // Step 2: User logs in
    $user = User::findByUsername('admin');
    Yii::$app->user->login($user);
    $this->assertFalse(Yii::$app->user->isGuest);
    
    // Step 3: User logs out
    Yii::$app->user->logout();
    $this->assertTrue(Yii::$app->user->isGuest);
}
```

## 🏗️ Microservices Architecture

### What are Microservices?

Traditional (Monolithic):
```
┌─────────────────────────┐
│   One Big Application   │
│  ┌──────────────────┐   │
│  │ Frontend         │   │
│  │ Backend          │   │
│  │ Database         │   │
│  └──────────────────┘   │
└─────────────────────────┘
```

Microservices:
```
┌──────────┐  ┌──────────┐  ┌──────────┐
│ Frontend │  │ Backend  │  │ Database │
│ Service  │─▶│ Service  │─▶│ Service  │
└──────────┘  └──────────┘  └──────────┘
     │             │              │
     └─────────────┴──────────────┘
            Docker Network
```

### Benefits

1. **Independent Deployment**: Update frontend without touching backend
2. **Technology Flexibility**: Use different tech stacks for different services
3. **Scalability**: Scale services independently
4. **Isolation**: Problems in one service don't crash others

### In This Project

- **Frontend Service**: SvelteKit on port 3000
- **Backend Service**: YII2 on port 8080
- **Database Service**: MySQL on port 3306
- **Storage Service**: LocalStack (S3) on port 4566

## ☁️ AWS Simulation with LocalStack

### Why LocalStack?

**Problem:** AWS services cost money and require internet connection.

**Solution:** LocalStack simulates AWS services locally.

### Services Simulated

1. **S3 (Simple Storage Service)**
   - File storage for documents, images, reports
   - In production: Real AWS S3
   - In development: LocalStack S3

2. **RDS (Relational Database Service)**
   - In production: AWS RDS MySQL
   - In development: Docker MySQL container (functionally identical)

### Benefits

✅ Free to use
✅ Works offline
✅ Faster (no network latency)
✅ Same code works in production (just change endpoint)

### Code Example

```php
// S3Service works with both LocalStack and real AWS S3
// Only the endpoint changes!

// Development (LocalStack)
$endpoint = 'http://localstack:4566';

// Production (Real AWS)
$endpoint = null; // Uses default AWS endpoints

$s3->upload('bucket-name', 'file-key', $fileContent);
```

## 🐳 Docker & Containerization

### What is Docker?

Docker packages your application with all its dependencies into a "container" that runs anywhere.

### Why Docker?

**Without Docker:**
```
Dev: "It works on my machine!"
Ops: "But it doesn't work on the server!"
```

**With Docker:**
```
Dev: "It works in this container!"
Ops: "Great! This container works on the server too!"
```

### Docker Compose

Manages multiple containers as one application:

```yaml
services:
  backend:    # YII2 PHP application
  frontend:   # SvelteKit application  
  mysql:      # Database
  localstack: # AWS simulation
```

One command runs everything: `docker-compose up`

## 💡 Best Practices Applied

### 1. Environment Variables

**Bad:**
```php
$db = new Database('localhost', 'root', 'password123');
```

**Good:**
```php
$db = new Database(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD')
);
```

**Why?** Different environments (dev, staging, production) have different configurations.

### 2. Error Handling

**Bad:**
```php
$result = $db->query($sql);
// What if query fails?
```

**Good:**
```php
try {
    $result = $db->query($sql);
} catch (Exception $e) {
    Yii::error("Query failed: " . $e->getMessage());
    return ['success' => false, 'error' => $e->getMessage()];
}
```

### 3. Validation

**Bad:**
```php
// Save without validation
$user->save();
```

**Good:**
```php
if ($user->validate()) {
    $user->save();
} else {
    // Handle validation errors
    return $user->errors;
}
```

## 📖 Further Reading

1. **Clean Code** by Robert C. Martin
2. **The Pragmatic Programmer** by Hunt & Thomas
3. **Test Driven Development** by Kent Beck
4. **YII2 Documentation**: https://www.yiiframework.com/doc/guide/2.0/en
5. **SvelteKit Documentation**: https://kit.svelte.dev/docs
6. **Docker Documentation**: https://docs.docker.com/
7. **LocalStack Documentation**: https://docs.localstack.cloud/

## 🎯 Key Takeaways

1. **Write code for humans first, computers second**
2. **Test your code - all three types of tests are important**
3. **Keep it simple - don't over-engineer**
4. **Use meaningful names - be descriptive**
5. **One function, one purpose - SRP**
6. **Fail fast and clearly - good error messages**
7. **Document your learning - help future developers**

## ❓ Common Questions

**Q: When should I write a unit test vs. functional test?**
A: Unit test for single functions, functional test for component integration.

**Q: Why not just test manually?**
A: Automated tests run fast, catch regressions, and serve as documentation.

**Q: Is KISS always the answer?**
A: Yes, start simple. Add complexity only when you need it, not when you might need it.

**Q: How do I know if my code is "clean"?**
A: If another developer can understand it in 5 minutes, it's probably clean.

**Q: Should I write tests first or code first?**
A: Either works! TDD (tests first) is great, but tests after code is also valuable.

---

Remember: The goal is **working, maintainable software**. Clean code and good tests help you achieve that goal.
