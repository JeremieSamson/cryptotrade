set :current_stage, "dev"
set :deploy_to, "/var/www/dev.cryptobox.tech"
set :symfony_env_prod, "dev"
set :composer_options, '--no-interaction --optimize-autoloader --no-progress'