# PROMPT TÉCNICO — jsnProject
## Website Institucional + Área Restrita para Condomínios | WordPress em Docker

> **Papel do Agente:** Atue como **Engenheiro de Software Sênior**, especialista em WordPress moderno, PHP 8.x, Docker e arquitetura orientada a componentes/widgets. Execute as etapas abaixo na íntegra, na pasta `/home/delll/Projects/jsnProject`.

---

## 1. CONTEXTO DO PROJETO

**Cliente:** JSN Negócios Administrativos
**Segmento:** Gestão e serviços administrativos para **condomínios** (B2B/B2C comercial de serviços online).
**Produto digital:** Website moderno, interativo e modular, dividido em **duas áreas**:

| Área | Público | Acesso |
|---|---|---|
| **Site Público** | Qualquer visitante (institucional, comercial, captação de leads) | Aberto |
| **Área Restrita** | Usuários autenticados (síndicos, conselheiros, condôminos, equipe JSN) | Login e senha |

**Requisito estrutural chave:** Arquitetura capaz de comportar **dezenas de Widgets independentes**, plugáveis e reutilizáveis, sem acoplamento entre eles. O tema deve ser construído sob o paradigma de **modularidade por componente**.

---

## 2. RESULTADO ESPERADO (DELIVERABLE)

Um ambiente de **locação/desenvolvimento local completo e funcional**, subido via Docker Compose, com:

1. WordPress disponível em `http://localhost:8080`;
2. Banco de dados MariaDB persistente em volume Docker;
3. phpMyAdmin em `http://localhost:8081`;
4. Captura de e-mails de dev via Mailpit em `http://localhost:8025`;
5. Estrutura de código versionável (`wp-content` fora do core do WP);
6. Tema custom `"jsn"` com arquitetura de widgets independentes;
7. Suporte a **WP-CLI** para automação (instalação do WP, plugins, seeds);
8. Um `Makefile` / scripts para orquestrar tudo com comandos simples.

---

## 3. STACK TÉCNICA (PADRÕES ATUAIS)

| Camada | Escolha | Justificativa |
|---|---|---|
| Orquestração | **Docker Compose v2** (spec renovada, sem `version:` no YAML) | Padrão de mercado em 2025/2026 |
| Servidor web | **nginx:alpine** | Performance superior ao Apache embutido |
| Aplicação | **wordpress:6.x-php8.3-fpm-alpine** | PHP-FPM separado do webserver = arquitetura limpa |
| Banco | **mariadb:11.x** | Compatível com WP, baixo consumo |
| Admin DB | **phpmyadmin** | Operação rapidinha em dev |
| E-mails dev | **mailpit** | Captura SMTP local, UI moderna |
| CLI | **wp-cli** (serviço dedicado) | Automação da instalação e configuração |
| Toda configuração | Variáveis de ambiente (`.env`) — **nunca hardcode** | Portabilidade / 12-Factor |

### Portas
- `8080` → nginx (WordPress)
- `8081` → phpMyAdmin
- `8025` → Mailpit UI
- `1025` → Mailpit SMTP
- `3306` não exposto ao host (rede interna Docker apenas)

---

## 4. ESTRUTURA DE DIRETÓRIOS (GERAR EXATAMENTE)

```
/home/delll/Projects/jsnProject/
├── docker-compose.yml
├── .env                        # credenciais e portas (local only)
├── .env.example                # template versionável
├── .gitignore                  # wp core, volumes, .env, node_modules
├── Makefile                    # up, down, logs, wp, fresh, shell, etc.
├── README.md                   # documentação de uso
├── docker/
│   ├── nginx/
│   │   └── default.conf        # vhost proxy → php-fpm (9000)
│   └── php/
│       ├── uploads.ini         # memory_limit, upload_max_filesize, etc.
│       └── docker-php-ext-xdebug.ini (opcional)
├── db/                         # dumps SQL iniciais (se houver)
└── wp-content/                 # ÚNICO código versionado do WP
    ├── themes/
    │   └── jsn/                # Tema custom (ver seção 6)
    ├── plugins/                # plugins premium/custom versionados
    │   └── jsn-widgets-core/   # plugin-mãe dos widgets (ver seção 7)
    └── uploads/
```

**Regra de ouro:** o core do WordPress fica 100% no container/volume (efêmero e substituível); apenas `wp-content` vive no.bind mount do host.

---

## 5. DOCKER COMPOSE — REQUISITOS TÉCNICOS

O `docker-compose.yml` deve conter os serviços `db`, `phpmyadmin`, `wordpress`, `nginx`, `mailpit` e `wpcli`, respeitando:

1. **Rede interna exclusiva** (e.g. `jsn_net`), sem exposição do MariaDB ao host;
2. **Volumes nomeados** para `db_data`, `wp_core`, `wp_uploads` + bind mount de `wp-content` (temas/plugins) e `db/`;
3. **Healthchecks** no MariaDB (`mysqladmin ping`) e dependência `condition: service_healthy` nos demais;
4. `restart: unless-stopped` em todos os serviços;
5. PHP customizado via `uploads.ini`: `memory_limit=512M`, `upload_max_filesize=64M`, `post_max_size=64M`, `max_execution_time=300`;
6. `wpcli` com `depends_on` aguardando WP saudável, `entrypoint: wp` e `user: www-data`;
7. Config tag `enable_xdebug` (flag de build/if) para debug opcional — ativável por `.env`;
8. Mailpit já configurado no `wp-config` via envs (`MAILPIT_HOST`, `MAILPIT_PORT`);
9. Nginx roteando `/_static/` (uploads) direto para o volume, estilo performance-oriented.

---

## 6. TEMA CUSTOM `"jsn"` — MODERNIDADE + MODULARIDADE

Gerar o skeleton do tema `wp-content/themes/jsn/` seguindo **WordPress Coding Standards** (PHPCS/WPCS):

```
jsn/
├── style.css                 # header do tema
├── functions.php             # bootstrap: autoload das classes
├── inc/
│   ├── class-jsn-theme.php   # singleton bootstrap
│   ├── class-jsn-widget-registry.php   # registro central de widgets
│   ├── setup/                # theme supports, menus, block styles
│   ├── api/                  # endpoints REST internos
│   └── acf-fields/           # grupos de campos (se ACF ativado)
├── widgets/                  # ⭐ Widgets independentes
│   ├── hero/
│   │   ├── class-widget-hero.php      # classe :: registers()
│   │   ├── template.php               # render isolado
│   │   ├── assets/{style.css,script.js}
│   │   └── widget.json                # metadados + defaults
│   └── ...                   # (hero, cards-servicos, cta,
│                             #  contato, depoimentos, calculadora
│                             # -taxa-condominio, prazos,
│                             #  beneficios, faq...)
├── templates/                # front-page.php, page-restrita.php, etc.
├── page-templates/           # template para portal restrito
├── assets/
│   ├── src/                  # JS/SCSS originais (build Vite opcional)
│   └── dist/                 # buildados
└── i18n/                     # strings pt-BR
```

### Contrato de Widget independente (obrigatório implementar)
Todo widget deve:
1. Ser um diretório autocontido (`class-widget-X.php` + `template.php` + `assets/` + `widget.json`);
2. Possuir método estático `registers()` auto-registrado via **Widget Registry** (descoberta automática por glob em `widgets/*/`);
3. Renderizar ser isulado: template próprio, assets enfileirados **somente quando o widget está presente na página** (${return scoping});
4. Expor defaults legíveis em `widget.json` (permitindo edit de conteúdo via Customizer/Gutenberg/ACF);
5. Não depender de estado global — só de projeto de dados injetados;
6. Poder ser instanciado em qualquer página (shortcode dinâmico `[jsn_widget id="hero"]`) ou como área de bloco tipo Gutenberg pattern.

Escopo inicial MÍNIMO do tema (front público): estrutura `header/footer/front-page` + os widgets `hero`, `cards-servicos`, `cta-contato`, `beneficios-condominio`, `faq` + **template `page-restrita.php`** para a área logada.

### Área Restrita (public↔private bridge)
No tema, implementar:
- `template directory redirect`: páginas com `post_meta _jsn_is_restricted = 1` exigem login (guard em `template_redirect`);
- Redirect automático para `wp-login.php?redirect_to=` com retorno à página original;
- Personalização visual do login (tela WordPress rebrandada JSN);
- Placeholder de "Dashboard Condomínio" (`page-templates/dashboard-condominio.php`) como prova de conceito do portal logado;
- Hook `jsn_before_dashboard` para acoplar widgets restritos no ecossistema (ex.: boletos, assembleias, prazos) — **preparado, não implementado** (fase 2 do portal);
- Papéis custom `jsn_sindico`, `jsn_consultor`, `jsn_consolidado` via WP roles (só criar specs, sem hardcode de capacidades por enquanto).

---

## 7. PLUGIN `jsn-widgets-core`

Criar plugin ativa-visualizado `wp-content/plugins/jsn-widgets-core/`:
- Custom Post Types & taxonomias se aplicáveis (e.g. `servico`, `noticia_condominio`);
- Endpoints REST para consumo por widgets front-end (`/wp-json/jsn/v1/*`);
- Central de bloqueio/unblock de widgets (index global para o tema);
- Ativação de padrões (patterns) Gutenberg para composição de páginas;
- Obrigatoriedade de manter o tema lean: funcionalidades de dados no plugin, apresentação no tema.

---

## 8. ORQUESTRAÇÃO / DX (DEVELOPER EXPERIENCE)

`Makefile` obrigatório com no mínimo:
```make
make up        # sobe tudo (docker compose up -d --build)
make down      # para tudo
make fresh     # down -v + up + install WP do zero via wp-cli
make wp CMD="..."   # atalho para wp-cli no container
make logs      # tail de todos os logs
make shell     # bash no container WordPress
make db-dump   # export SQL para ./db/
```

Fluxo `make fresh` deve (via wp-cli):
1. `wp core install --url=http://localhost:8080 --title="JSN Negócios Administrativos" --admin_user=admin --admin_password=admin --admin_email=dev@jsn.local --skip-email`;
2. Ativar tema `jsn` e plugin `jsn-widgets-core`;
3. Instalar e ativar plugins essenciais: `wp-mail-smtp` (ou deixar Mailpit), `wp-better-search-replace`, `theme-check`, `query-monitor` (dev);
4. Criar páginas: **Home**, **Sobre**, **Serviços**, **Contato**, **Área Restrita** (com `page-restrita.php`);
5. Seed de menus navegação (público / restrito);
6. Configurar permalinks `/%postname%/`.

---

## 9. QUALIDADE, SEGURANÇA E PADRÕES

- WPCS/PHPCS `--standard=WordPress` em todo o tema e plugin;
- `wp-config-debug`: `WP_DEBUG=true`, `WP_DEBUG_LOG=true`, `WP_DEBUG_DISPLAY=false`, `WP_ENVIRONMENT_TYPE=local` — nunca exibir erros em tela;
- `.env` presente no `.gitignore`; fornecer `.env.example`;
- Sanitização/escaping obrigatória: todos os dados de widget passam por `esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`;
- **Nonces** e `wp_verify_nonce` em qualquer formulário de widget;
- Nenhuma credencial hardcoded — tudo por env vars;
- Semantic versioning: tema 0.1.0, plugin 0.1.0 na fase de setup;
- `README.md` explicar como subir, derrubar, resetar, e como **criar um novo widget em 3 passos** (copiar pasta, ajustar widget.json, usar o shortcode).

---

## 10. CRITÉRIOS DE ACEITAÇÃO (CHECKLIST FINAL)

- [ ] `make up` sobe todo o stack sem erros, WordPress instalável/instalado em `http://localhost:8080`;
- [ ] `make fresh` entrega um WordPress 100% operacional e configurado, linha de comando única;
- [ ] Tema `jsn` ativo e renderizando Home + Área Restrita com o template específico;
- [ ] Acesso a página restrito sem login → redireciona para login → volta após autenticar;
- [ ] phpMyAdmin e Mailpit acessíveis nas portas definidas;
- [ ] Widget Registry funciona: um widget novo, ao ser colocado em `widgets/`, é descoberto automaticamente (zero registro manual);
- [ ] WP-CLI funcional dentro do container;
- [ ] `docker-compose.yml` validado (`docker compose config` sem warnings);
- [ ] README completo e `.env.example` versionado;
- [ ] Estrutura de pastas idêntica à seção 4.

---

## 11. PRÓXIMAS FASES (ROADMAP — NÃO IMPLEMENTAR AGORA)

1. **Fase 2 — Portal Restrito** (dashboard do condômino: boletos, ocorrências, assembleias, comunicados);
2. **Fase 3 — Widgets avançados**: simulação de taxa de condomínio, agenda de prazos, integração com ERP;
3. **Fase 4 — Staging/Produção**: pipelines CI/CD, deploy das imagens, CDN, WAF, backups automatizados;
4. **Fase 5 — Build pipeline front-end** (Vite + Tailwind + code-splitting por widget).

**Comece agora pela etapa orchestrator:** gerar todos os arquivos da estrutura acima, validar `docker compose config`, subir o ambiente e entregar o `make fresh` funcional.
