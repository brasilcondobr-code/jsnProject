SHELL := /bin/bash

ifneq (,$(wildcard .env))
include .env
export
endif

COMPOSE ?= docker compose
WP_RUN := $(COMPOSE) run --rm wpcli
WP_PORT ?= 8080
WP_URL ?= http://localhost:$(WP_PORT)
DUMP_FILE := db/jsn-$(shell date +%Y%m%d-%H%M%S).sql

.PHONY: help up down restart build logs shell wp wait install seed fresh db-dump permissions config ps

help:
	@echo "JSN Project — comandos disponíveis:"
	@echo "  make up          Sobe o stack (build + containers)"
	@echo "  make down        Para o stack"
	@echo "  make fresh       Recria tudo do zero e instala o WordPress"
	@echo "  make install     Instala/atualiza WordPress, tema, plugins e seeds"
	@echo "  make seed        Recria páginas, menus e conteúdo de exemplo"
	@echo "  make wp CMD=...  Executa um comando WP-CLI"
	@echo "  make logs        Acompanha logs"
	@echo "  make shell       Shell no container WordPress"
	@echo "  make db-dump     Exporta o banco para ./db/"
	@echo "  make config      Valida o docker-compose.yml"

up: permissions
	$(COMPOSE) up -d --build
	@echo "WordPress:  $(WP_URL)"
	@echo "phpMyAdmin: http://localhost:$${PMA_PORT:-8081}"
	@echo "Mailpit:    http://localhost:$${MAILPIT_UI_PORT:-8025}"

down:
	$(COMPOSE) down

restart:
	$(COMPOSE) restart

build:
	$(COMPOSE) build --pull

logs:
	$(COMPOSE) logs -f --tail=100

shell:
	$(COMPOSE) exec wordpress sh

wp:
	@$(WP_RUN) $(CMD)

wait:
	@echo "Aguardando WordPress e banco de dados..."
	@for i in $$(seq 1 90); do \
		if $(COMPOSE) exec -T wordpress php -r 'exit(file_exists("/var/www/html/wp-config.php") && @fsockopen("db", 3306) ? 0 : 1);' >/dev/null 2>&1; then \
			echo "WordPress e banco prontos."; \
			exit 0; \
		fi; \
		sleep 2; \
	done; \
	echo "Timeout aguardando WordPress."; \
	$(COMPOSE) logs --tail=80 wordpress db; \
	exit 1

install: wait
	@if ! $(WP_RUN) core is-installed >/dev/null 2>&1; then \
		echo "Instalando WordPress..."; \
		$(WP_RUN) core install \
			--url="$(WP_URL)" \
			--title="$(WP_TITLE)" \
			--admin_user="$(WP_ADMIN_USER)" \
			--admin_password="$(WP_ADMIN_PASSWORD)" \
			--admin_email="$(WP_ADMIN_EMAIL)" \
			--skip-email; \
	else \
		echo "WordPress já instalado."; \
	fi
	$(WP_RUN) theme activate jsn
	$(WP_RUN) plugin activate jsn-widgets-core
	@for plugin in wp-mail-smtp wp-better-search-replace theme-check query-monitor; do \
		echo "Instalando plugin: $$plugin"; \
		$(WP_RUN) plugin install $$plugin --activate || echo "Aviso: $$plugin não pôde ser instalado (siga sem ele)."; \
	done
	$(WP_RUN) eval-file /scripts/seed.php

seed: wait
	$(WP_RUN) eval-file /scripts/seed.php

fresh: down permissions
	$(COMPOSE) up -d --build
	$(MAKE) install
	@echo ""
	@echo "Ambiente recriado com sucesso."
	@echo "WordPress:  $(WP_URL)"
	@echo "Admin:      $(WP_ADMIN_USER) / $(WP_ADMIN_PASSWORD)"
	@echo "phpMyAdmin: http://localhost:$${PMA_PORT:-8081}"
	@echo "Mailpit:    http://localhost:$${MAILPIT_UI_PORT:-8025}"

db-dump:
	@mkdir -p db
	$(COMPOSE) exec -T db sh -c 'exec mariadb-dump -u root -p"$$MARIADB_ROOT_PASSWORD" "$$MARIADB_DATABASE"' > "$(DUMP_FILE)"
	@echo "Dump salvo em $(DUMP_FILE)"

permissions:
	@chmod -R a+rwX wp-content 2>/dev/null || true
	@chmod -R a+rwX scripts 2>/dev/null || true

config:
	$(COMPOSE) config --quiet && echo "docker-compose.yml válido."

ps:
	$(COMPOSE) ps
