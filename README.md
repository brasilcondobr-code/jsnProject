# jsnProject — Site JSN Negócios Administrativos

Website institucional + **Área Restrita** para condomínios, construído em WordPress com arquitetura orientada a **widgets independentes**, orquestrado por Docker Compose.

## Stack

| Camada | Tecnologia |
|---|---|
| Orquestração | Docker Compose v2 (sem `version:` no YAML) |
| Web server | nginx:alpine (proxy → PHP-FPM 9000) |
| Aplicação | wordpress:6.x-php8.3-fpm-alpine (core efêmero em volume) |
| Banco | MariaDB 11.4 (volume nomeado, **sem exposição ao host**) |
| Admin DB | phpMyAdmin |
| E-mails dev | Mailpit (SMTP 1025 / UI 8025) |
| CLI | WP-CLI (serviço dedicado `wpcli`) |

## Endpoints locais

| Serviço | URL |
|---|---|
| WordPress | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| Mailpit (UI) | http://localhost:8025 |
| Mailpit (SMTP) | localhost:1025 |

Credenciais padrão do `make fresh` (definidas em `.env`): `admin` / `admin`.

---

## Uso rápido

```bash
make config      # valida o docker-compose.yml
make up          # sobe todo o stack (build + containers)
make fresh       # derruba, recria do zero e instala o WP + seeds  ⭐
make down        # para tudo
make logs        # tail dos logs de todos os serviços
make shell       # shell no container WordPress
make wp CMD="post list --post-type=page"   # qualquer comando WP-CLI
make db-dump     # exporta SQL para ./db/
make ps          # status dos containers
```

### O que o `make fresh` faz

1. `docker compose down` + recria containers e volumes;
2. Instala o WordPress via WP-CLI (`--url=http://localhost:8080`, título, admin, `--skip-email`);
3. Ativa o tema `jsn` e o plugin `jsn-widgets-core`;
4. Instala e ativa plugins essenciais: `wp-mail-smtp`, `wp-better-search-replace`, `theme-check`, `query-monitor`;
5. Cria as páginas **Home, Sobre, Serviços, Contato, Área Restrita** (+ *Dashboard Condomínio*);
6. Seed de menus (público / restrito / rodapé) e conteúdo de exemplo (CPTs `servico` e `noticia_condominio`);
7. Configura permalinks `/%postname%/` e Home estática.

> `make fresh` é idempotente no conteúdo: reexecutar atualiza páginas/menus/seeds em vez de duplicar.

---

## Estrutura de diretórios

```
jsnProject/
├── docker-compose.yml          # db, wordpress, nginx, wpcli, phpmyadmin, mailpit
├── .env / .env.example         # credenciais e portas (12-Factor — nada hardcoded)
├── Makefile                    # orquestração DX
├── docker/
│   ├── nginx/default.conf      # vhost proxy → php-fpm, uploads servidos pelo nginx
│   └── php/                    # Dockerfile (xdebug opcional), uploads.ini
├── db/                         # dumps SQL (make db-dump)
├── scripts/seed.php            # seed idempotente executado via wp eval-file
└── wp-content/                 # ⭐ ÚNICO código versionado do WP
    ├── mu-plugins/jsn-mailpit.php     # captura de e-mails no Mailpit
    ├── plugins/jsn-widgets-core/      # plugin de dados: CPTs, taxonomias, REST, patterns
    └── themes/jsn/                    # tema custom (ver abaixo)
```

**Regra de ouro:** o core do WordPress vive em volume (efêmero/substituível); só `wp-content` é bind-mount do host e versionado no Git.

---

## Tema `jsn` — arquitetura de widgets independentes

```
themes/jsn/
├── style.css                    # header do tema
├── functions.php                # bootstrap (autoload das classes)
├── inc/
│   ├── class-jsn-theme.php      # singleton: setup, assets, guard de páginas restritas, login rebrandado
│   ├── class-jsn-widget-registry.php  # discovery automático de widgets
│   ├── setup/                   # theme supports, menus, block styles, roles
│   └── api/                     # endpoints REST internos
├── templates/front-page.php     # home pública
├── page-templates/dashboard-condominio.php  # portal logado (prova de conceito)
└── widgets/                     # ⭐ um diretório autocontido por widget
    ├── hero/
    ├── cards-servicos/
    ├── cta-contato/
    ├── beneficios-condominio/
    └── faq/
```

### Contrato de widget

Todo widget é um diretório autocontido com:

| Arquivo | Papel |
|---|---|
| `class-widget-{slug}.php` | classe com método estático `registers()` (patterns/Gutenberg) |
| `template.php` | render isolado (dados injetados, sanitizados com `esc_*` / `wp_kses_post`) |
| `assets/{style.css,script.js}` | enfileirados **somente** quando o widget está presente na página |
| `widget.json` | metadados + `defaults` (usados como atributos do shortcode) |

### Criar um novo widget em 3 passos

1. **Copie uma pasta** existente em `wp-content/themes/jsn/widgets/` e renomeie o diretório (ex.: `prazos`) — ajuste também os nomes do arquivo da classe e da classe (`JSN_Widget_Prazos::registers()`).
2. **Ajuste o `widget.json`** (título, descrição, `defaults`) e edite `template.php` + assets conforme o conteúdo.
3. **Use o shortcode** `[jsn_widget id="prazos"]` em qualquer página/bloco — ou como block pattern, que já é registrado automaticamente.

Nenhum registro manual é necessário: o `JSN_Widget_Registry` descobre widgets por glob em `widgets/*/` no hook `init`. Assets são enfileirados apenas se o widget aparecer na página corrente.

### Área Restrita

- Páginas com post meta `_jsn_is_restricted = 1` (ou template `page-templates/dashboard-condominio.php`) exigem login: guard em `template_redirect` com redirect para `wp-login.php?redirect_to=` e retorno à página original;
- Tela de login rebrandada JSN (CSS inlined, logo → home);
- Hook `jsn_before_dashboard` preparado para acoplar widgets restritos na Fase 2 (boletos, assembleias, prazos);
- Papéis custom criados pelo tema: `jsn_sindico`, `jsn_consultor`, `jsn_consolidado`.

---

## Plugin `jsn-widgets-core`

Funcionalidades de **dados** (o tema fica lean, só apresentação):

- CPTs e taxonomias: `servico`, `noticia_condominio`;
- Endpoints REST `/wp-json/jsn/v1/*` para consumo front-end;
- Central global de habilitação/bloqueio de widgets;
- Patterns Gutenberg para composição de páginas.

---

## Configuração & segurança

- Toda configuração via `.env` (copie `.env.example`); `.env` está no `.gitignore`;
- `WP_DEBUG=true`, `WP_DEBUG_LOG=true`, `WP_DEBUG_DISPLAY=false`, `WP_ENVIRONMENT_TYPE=local` — erros vão para `wp-content/debug.log`, nunca para a tela;
- MariaDB **não** exposto ao host (rede interna `jsn_net`);
- `3306` interno; portas públicas: 8080 (WP), 8081 (phpMyAdmin), 8025/1025 (Mailpit);
- Sanitização/escaping obrigatória nos widgets; nonces em qualquer formulário;
- Versões iniciais: tema `0.1.0`, plugin `0.1.0` (semver).

### Xdebug (opcional)

Defina `ENABLE_XDEBUG=1` no `.env` e rode `make up --build` (ou `make build`). A imagem compila e habilita o Xdebug.

---

## Roadmap

1. **Fase 2 — Portal Restrito**: dashboard do condômino (boletos, ocorrências, assembleias, comunicados);
2. **Fase 3 — Widgets avançados**: simulação de taxa de condomínio, agenda de prazos, integração ERP;
3. **Fase 4 — Staging/Produção**: CI/CD, deploy de imagens, CDN, WAF, backups;
4. **Fase 5 — Build front-end**: Vite + Tailwind + code-splitting por widget.

## Padrões

- WordPress Coding Standards (WPCS/PHPCS, `--standard=WordPress`);
- Licença do repositório: ver `LICENSE`.
