#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

echo "--- Installing required packages ---"

# Use the non-interactive mode for apt-get to prevent prompts
export DEBIAN_FRONTEND=noninteractive

# Update the package list
sudo apt-get update

# Install PHP and Composer. We are using PHP 8.3 as a good starting point.
# You may need to change this version to match your local development environment.
sudo apt-get install -y php8.3 php8.3-cli php8.3-mbstring php8.3-xml php8.3-curl unzip

# Install Composer
echo "--- Installing Composer ---"
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Now that the environment is set up, install your PHP dependencies
echo "--- Installing Composer dependencies ---"
composer install --no-interaction --prefer-dist

# Check if npm is needed for your Vue.js part of the app
if [ -f "package.json" ]; then
    echo "--- Installing Node.js and npm ---"
    sudo apt-get install -y nodejs npm

    echo "--- Installing npm dependencies ---"
    npm install
fi

echo "--- Environment setup complete! ---"
