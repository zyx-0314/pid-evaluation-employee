FROM node:18-alpine

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies (include devDependencies required for SvelteKit build)
RUN npm ci --include=dev --no-audit --no-fund

# Copy application files
COPY . .

# For local development we run the dev server (source is mounted by docker-compose)
EXPOSE 3000

# Start the development server and bind to all interfaces so it's reachable from the host
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--port", "3000"]
