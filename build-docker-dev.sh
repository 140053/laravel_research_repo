#!/bin/bash

echo "🔧 Building development Docker containers..."

# Stop existing containers
docker-compose -f docker-compose.dev.yml down

# Build with BuildKit for better performance
export DOCKER_BUILDKIT=1
export COMPOSE_DOCKER_CLI_BUILD=1

# Build and start development containers
docker-compose -f docker-compose.dev.yml up --build -d

echo "✅ Development containers built and started!"
echo "🌐 Access the application at: http://localhost:8001"
echo ""
echo "📊 Container status:"
docker-compose -f docker-compose.dev.yml ps
echo ""
echo "📝 To view logs: docker-compose -f docker-compose.dev.yml logs -f"
echo "🛑 To stop containers: docker-compose -f docker-compose.dev.yml down"
echo "🚀 For production build: ./build-docker-optimized.sh" 