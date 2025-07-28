#!/bin/bash

echo "🚀 Building optimized Docker containers..."

# Stop existing containers
docker-compose down

# Remove old images to ensure fresh build
docker system prune -f

# Build with BuildKit for better performance
export DOCKER_BUILDKIT=1
export COMPOSE_DOCKER_CLI_BUILD=1

# Build and start containers with optimized settings
docker-compose up --build -d

echo "✅ Docker containers built and started!"
echo "🌐 Access the application at: http://localhost:8001"
echo ""
echo "📊 Container status:"
docker-compose ps
echo ""
echo "📝 To view logs: docker-compose logs -f"
echo "🛑 To stop containers: docker-compose down"
echo "🧹 To clean up: docker system prune -f" 