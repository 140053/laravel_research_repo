#!/bin/bash

echo "Building Docker containers with assets..."

# Stop existing containers
docker-compose down

# Build the Vite container first to generate assets
echo "Building Vite assets..."
docker-compose up vite --build

# Wait for Vite build to complete
echo "Waiting for Vite build to complete..."
docker-compose logs -f vite &
VITE_PID=$!

# Wait for the build to finish
while docker-compose ps vite | grep -q "Up"; do
    sleep 2
done

# Kill the log watcher
kill $VITE_PID 2>/dev/null

# Build the main application
echo "Building main application..."
docker-compose build app

# Start all services
echo "Starting all services..."
docker-compose up -d

echo "Docker containers are ready!"
echo "Access the application at: http://localhost:8001" 