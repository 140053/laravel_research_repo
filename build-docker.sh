#!/bin/bash

echo "Building and starting Docker containers..."

# Stop existing containers
docker-compose down

# Build and start containers
docker-compose up --build -d

echo "Docker containers are ready!"
echo "Access the application at: http://localhost:8001"
echo ""
echo "To view logs: docker-compose logs -f"
echo "To stop containers: docker-compose down" 