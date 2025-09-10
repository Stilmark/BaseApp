#!/bin/bash

# Define base directory relative to this script
BASE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"

# Create the logs directory
mkdir -p "$BASE_DIR/logs"

touch "$BASE_DIR/logs/access.log"
touch "$BASE_DIR/logs/error.log"

# Create DB user and set privileges
sudo mysql < "$BASE_DIR/.dist/sql/init/user-database.sql"

# Update dependencies
cd "$BASE_DIR"
composer update

# Build routes
php "$BASE_DIR/.dist/bin/build-routes.php"