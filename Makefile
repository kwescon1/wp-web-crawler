# Define a symbol for recursively expanding variables (used for better performance)
.ONESHELL:

# Define the default target
help: ## Print help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-10s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

# Define targets
setup: modify_permission build up ## Setup project

kill_composer: ## Remove composer container
	@docker-compose rm composer

modify_permission: ## Change file entrypoint permissions
	chmod +x docker-files/composer/entrypoint.sh

create-env: ## Copy .env.example to .env
	@if [ ! -f ".env" ]; then \
		echo "Creating .env file."; \
		cp .env.example .env; \
	fi

up: ## Start containers in detached mode
	@docker-compose up -d

build: create-env ## Build defined images
	@docker-compose build --no-cache

force_start: ## Force a restart of defined services
	@docker-compose up -d --force-recreate

fresh: modify_permission build force_start ## A fresh recreate of all containers

ps: ## Show containers
	@docker-compose ps

teardown: ## Tear down containers and remove volumes
	docker-compose down -v

shell: ## Access the shell of the wp-web-crawler container
	docker exec -it -u ubuntu wp-web-crawler /bin/bash

test: ## Run tests inside the container
	@docker exec -it -u ubuntu wp-web-crawler /bin/bash -c " vendor/bin/phpunit"
