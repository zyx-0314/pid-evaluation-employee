# PID Employee Evaluation System

A comprehensive employee evaluation system built with modern web technologies and microservices architecture.

## 🏗️ Architecture

### Tech Stack

- **Backend (Admin Panel)**: YII2 PHP Framework
- **Frontend (User Portal)**: SvelteKit with JavaScript
- **Styling**: Tailwind CSS (used in both applications)
- **Database**: MySQL 8.0 (simulating AWS RDS)
- **File Storage**: LocalStack S3 (simulating AWS S3)
- **Containerization**: Docker & Docker Compose

### Microservices Architecture

The system follows a microservices approach with:
- Separate frontend and backend services
- Containerized deployment
- Service-to-service communication via Docker network
- Local AWS simulation using LocalStack

## 🚀 Quick Start

### Prerequisites

- Docker and Docker Compose
- Git

### Running the Application

1. Clone the repository:
```bash
git clone <repository-url>
cd pid-evaluation-employee
```

2. Start all services:
```bash
docker-compose up --build
```

3. Access the applications:
   - **Admin Panel (YII2)**: http://localhost:8080
   - **User Portal (SvelteKit)**: http://localhost:3000
   - **MySQL Database**: localhost:3306
   - **LocalStack (S3)**: http://localhost:4566

### Default Test Credentials

- **Admin User**: 
  - Username: `admin`
  - Password: `password123`

- **Employee User**: 
  - Username: `john.doe`
  - Password: `password123`

## 🧪 Testing

The project includes comprehensive testing following industry best practices:

### Test Categories

1. **Functional Tests** (`tests/functional/`)
   - Database connection tests
   - Integration tests between components
   - Located in: `backend/tests/functional/`

2. **Unit Tests** (`tests/unit/`)
   - Individual function/method tests
   - Model validation tests
   - Located in: `backend/tests/unit/`

3. **Acceptance Tests** (`tests/acceptance/`)
   - End-to-end scenario tests
   - LILO (Login/Logout) scenarios
   - Located in: `backend/tests/acceptance/`

### Running Tests

Inside the backend container or locally with Composer installed:

```bash
# Run all tests
composer test

# Run specific test suites
composer test-functional  # Database connection tests
composer test-unit        # Unit tests
composer test-acceptance  # E2E tests
```

Or directly with PHPUnit:

```bash
cd backend
./vendor/bin/phpunit --testsuite functional
./vendor/bin/phpunit --testsuite unit
./vendor/bin/phpunit --testsuite acceptance
```

## 📚 Learning Notes

### Clean Code Principles Applied

1. **Single Responsibility Principle (SRP)**
   - Each class/function has one clear purpose
   - Models handle data, controllers handle requests, services handle business logic

2. **KISS (Keep It Simple, Stupid)**
   - Simple, readable code structure
   - Avoid over-engineering
   - Clear naming conventions

3. **DRY (Don't Repeat Yourself)**
   - Reusable components and services
   - Configuration externalized to environment variables

### Key Concepts

#### Functional Tests
- Test integration between system components
- Example: Database connection test verifies the app can connect to MySQL
- Focus: "Do these parts work together?"

#### Unit Tests
- Test individual functions in isolation
- Example: Password hashing and validation in User model
- Focus: "Does this specific function work correctly?"

#### Acceptance Tests
- Test complete user scenarios end-to-end
- Example: LILO (Login/Logout) test verifies entire authentication flow
- Focus: "Does the system work from the user's perspective?"

### AWS Simulation

LocalStack provides local AWS service simulation:

- **S3**: File storage for documents and reports
- **RDS**: Simulated by actual MySQL container
- **API Gateway**: Could be configured if needed

Benefits:
- Develop and test without AWS costs
- Faster feedback loops
- Works offline

## 📂 Project Structure

```
pid-evaluation-employee/
├── backend/                 # YII2 admin backend
│   ├── components/         # Reusable components (S3Service, etc.)
│   ├── config/            # Application configuration
│   ├── controllers/       # Request handlers
│   ├── models/            # Data models
│   ├── views/             # Templates with Tailwind CSS
│   ├── web/               # Public web directory
│   └── tests/             # PHPUnit tests
│       ├── functional/    # Integration tests
│       ├── unit/          # Unit tests
│       └── acceptance/    # E2E tests
├── frontend/              # SvelteKit user frontend
│   ├── src/
│   │   ├── routes/       # SvelteKit pages
│   │   └── lib/          # Reusable components
│   └── static/           # Static assets
├── docker/                # Docker configuration
│   ├── mysql/init/       # Database initialization
│   └── localstack/       # AWS simulation setup
└── docker-compose.yml    # Service orchestration
```

## 🔧 Configuration

### Environment Variables

Backend (YII2):
- `DB_HOST`: MySQL host (default: mysql)
- `DB_NAME`: Database name (default: pid_evaluation)
- `DB_USER`: Database user
- `DB_PASSWORD`: Database password
- `AWS_ENDPOINT`: LocalStack endpoint
- `AWS_ACCESS_KEY_ID`: AWS credentials (use 'test' for LocalStack)
- `AWS_SECRET_ACCESS_KEY`: AWS credentials (use 'test' for LocalStack)

Frontend (SvelteKit):
- `API_URL`: Backend API URL
- `PUBLIC_API_URL`: Public-facing API URL

### Database Schema

The system includes the following tables:
- `users`: User authentication and roles
- `employees`: Employee information
- `evaluations`: Performance evaluations
- `evaluation_criteria`: Detailed evaluation criteria

## 🛠️ Development

### Adding New Features

1. **Backend (YII2)**:
   - Models: `backend/models/`
   - Controllers: `backend/controllers/`
   - Views: `backend/views/`

2. **Frontend (SvelteKit)**:
   - Pages: `frontend/src/routes/`
   - Components: `frontend/src/lib/`

### Coding Standards

- Follow PSR-12 for PHP code
- Use ESLint/Prettier for JavaScript
- Write tests for new features
- Keep functions small and focused
- Use meaningful variable names

## 📝 API Endpoints

### Backend API (Admin)

- `GET /api/employees` - List employees
- `GET /api/employees/:id` - Get employee details
- `GET /api/evaluations` - List evaluations
- `GET /api/evaluations/:id` - Get evaluation details

### Authentication

- `POST /site/login` - User login
- `GET /site/logout` - User logout

## 🔒 Security

- Password hashing using bcrypt
- CSRF protection enabled
- SQL injection prevention via prepared statements
- Input validation on all forms

## 📊 Monitoring & Debugging

- YII2 Debug Toolbar (development mode)
- Docker logs: `docker-compose logs -f [service_name]`
- MySQL logs available in container
- LocalStack dashboard at http://localhost:4566

## 🤝 Contributing

1. Follow clean code principles
2. Write tests for new features
3. Keep commits focused and atomic
4. Update documentation as needed

## 📄 License

This is a learning project for demonstration purposes.