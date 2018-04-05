# Branch dev from git
set :current_stage, "dev"

# Directory on the server
set :deploy_to, "/var/www/dev.cryptobox.tech"

# Symfony env
set :symfony_env_prod, "dev"

# Remove --no-dev from composer options
set :composer_options, '--no-interaction --optimize-autoloader --no-progress'

# Keep app_dev.php
set :clear_controllers, false