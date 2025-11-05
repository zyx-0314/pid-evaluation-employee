# Setup Guide

This guide will help you set up the PID Employee Evaluation System on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed:

1. **Docker** (version 20.10 or higher)
   - Download: https://www.docker.com/get-started
   - Verify: `docker --version`

2. **Docker Compose** (version 2.0 or higher)
   - Usually included with Docker Desktop
   - Verify: `docker-compose --version`

3. **Git**
   - Download: https://git-scm.com/downloads
   - Verify: `git --version`

## Step-by-Step Setup

### 1. Clone the Repository

```bash
git clone https://github.com/zyx-0314/pid-evaluation-employee.git
cd pid-evaluation-employee
```

### 2. Build and Start the Services

```bash
# Build all containers
docker-compose build

# Start all services
docker-compose up
```

This will start:
- MySQL database (port 3306)
- LocalStack for AWS simulation (port 4566)
- YII2 backend (port 8080)
- SvelteKit frontend (port 3000)

**Note:** First time setup may take 5-10 minutes to download images and install dependencies.

### 3. Verify Services are Running

```bash
# Check running containers
docker-compose ps

# You should see all services as "Up"
```

### 4. Access the Applications

Open your browser and navigate to:

- **User Portal (SvelteKit)**: http://localhost:3000
- **Admin Panel (YII2)**: http://localhost:8080

### 5. Test the Setup

#### Login to Admin Panel

1. Go to http://localhost:8080
2. Click "Login"
3. Use credentials:
   - Username: `admin`
   - Password: `password123`
4. You should see the admin dashboard

#### Test Database Connection

```bash
# Access the backend container
docker-compose exec backend bash

# Run functional tests
cd /var/www/html
./vendor/bin/phpunit --testsuite functional

# You should see green checkmarks indicating successful tests
```

## Common Issues and Solutions

### Issue 1: Port Already in Use

**Error:** `Bind for 0.0.0.0:3306 failed: port is already allocated`

**Solution:** Stop the conflicting service or change the port in `docker-compose.yml`

```bash
# Find what's using the port
lsof -i :3306  # On Mac/Linux
netstat -ano | findstr :3306  # On Windows

# Stop MySQL if running locally
sudo service mysql stop  # Linux
brew services stop mysql  # Mac
```

### Issue 2: Docker Build Fails

**Error:** Various build errors

**Solution:**

```bash
# Clean up Docker
docker-compose down -v
docker system prune -a

# Rebuild
docker-compose build --no-cache
docker-compose up
```

### Issue 3: Backend Composer Dependencies Fail

**Error:** Composer install fails

**Solution:**

```bash
# Remove composer lock and vendor
docker-compose exec backend rm -rf vendor composer.lock

# Reinstall dependencies
docker-compose exec backend composer install
```

### Issue 4: Database Not Initialized

**Error:** Tables don't exist

**Solution:**

```bash
# Recreate the database
docker-compose down -v
docker-compose up

# The init script will run automatically
```

## Development Workflow

### Making Backend Changes

1. Edit files in `backend/` directory
2. Changes are reflected immediately (volume mounted)
3. For model/config changes, restart the backend:
   ```bash
   docker-compose restart backend
   ```

### Making Frontend Changes

1. Edit files in `frontend/src/` directory
2. Changes hot-reload automatically
3. If not updating, restart:
   ```bash
   docker-compose restart frontend
   ```

### Running Tests

```bash
# All tests
docker-compose exec backend composer test

# Functional tests only
docker-compose exec backend composer test-functional

# Unit tests only
docker-compose exec backend composer test-unit

# Acceptance tests only
docker-compose exec backend composer test-acceptance
```

### Viewing Logs

```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f backend
docker-compose logs -f frontend
docker-compose logs -f mysql
docker-compose logs -f localstack
```

### Accessing Containers

```bash
# Backend (YII2)
docker-compose exec backend bash

# Frontend (SvelteKit)
docker-compose exec frontend sh

# MySQL
docker-compose exec mysql mysql -u pid_user -ppid_password pid_evaluation
```

## Stopping the Application

```bash
# Stop services (keeps data)
docker-compose stop

# Stop and remove containers (keeps volumes)
docker-compose down

# Stop and remove everything including data
docker-compose down -v
```

## Resetting the Application

If you want to start fresh:

```bash
# Remove everything
docker-compose down -v

# Remove downloaded images
docker-compose down --rmi all

# Start fresh
docker-compose up --build
```

## Production Deployment

**Note:** This setup is for development only. For production:

1. Use proper environment variables
2. Change default passwords
3. Use real AWS services instead of LocalStack
4. Enable HTTPS
5. Set up proper logging and monitoring
6. Use production-grade database backups

## Next Steps

After successful setup:

1. Read the [Learning Notes](docs/LEARNING_NOTES.md) to understand the architecture
2. Explore the codebase
3. Try running the tests
4. Make some changes and see them in action!

## Getting Help

- Check the [README.md](README.md) for architecture overview
- Read [Learning Notes](docs/LEARNING_NOTES.md) for concepts
- Check Docker logs for error messages
- Verify all services are running with `docker-compose ps`

## Troubleshooting Checklist

Before asking for help, check:

- [ ] Docker is running: `docker ps`
- [ ] All services are up: `docker-compose ps`
- [ ] No port conflicts: Check ports 3000, 3306, 4566, 8080
- [ ] Logs don't show errors: `docker-compose logs`
- [ ] Containers have enough memory (at least 4GB recommended)
- [ ] You're in the correct directory: `pwd` should show project root

---

Happy coding! 🚀
