# Prompt Técnico — Criação de Template WordPress "Idyllic Plus"

**Papel:** Atue como **engenheiro de software sênior especializado em WordPress** (temas, PHP, HTML/CSS/JS, WordPress Customizer e boas práticas de desenvolvimento).

**Tarefa:** Criar um **novo template (tema WordPress) personalizado** que reproduza fielmente o layout, as seções, a identidade visual e o comportamento responsivo do tema de referência **Idyllic Plus**, da ThemeFreesia, disponível em:

`https://demo.themefreesia.com/idyllic-plus/`

O trabalho deve ser realizado **dentro do projeto WordPress existente** localizado em:

`/home/delll/Projects/jsnProject`

---

## 1. Objetivo

Construir um tema WordPress novo, limpo e autocontido que replique o demo do Idyllic Plus, sem depender de plugins premium de construtor de páginas. O resultado deve ser editável via **WordPress Customizer** e usar **conteúdo real do WordPress** (menus, posts, widgets), mantendo o máximo de fidelidade visual com a referência.

---

## 2. Ambiente de Trabalho (primeiro passo obrigatório)

Antes de escrever qualquer código, **inspecione o projeto** em `/home/delll/Projects/jsnProject` e registre:

1. Versão do **WordPress** e do **PHP**.
2. Estrutura atual: é uma instalação completa (com `wp-content/themes`)? Existe tema filho ativo?
3. Ferramentas de build disponíveis (Node, npm, Gulp, Webpack, etc.) ou se o desenvolvimento será em CSS/JS puro.
4. Banco de dados configurado e URL local (para testar o tema).

**Decisão de arquitetura:** crie o novo template como **tema independente** (ex.: pasta `idyllic-clone/` dentro de `wp-content/themes/`), **a menos que** já exista um tema filho ativo que deva ser reaproveitado — nesse caso, explique a decisão antes de prosseguir.

---

## 3. Análise de Referência (fidelidade visual)

Inspecione o demo `https://demo.themefreesia.com/idyllic-plus/` usando as ferramentas de desenvolvedor do navegador e extraia os **design tokens** exatos:

- **Paleta de cores** (cor primária, cor de destaque/CTA, cor de texto, fundos de seção, hover states).
- **Tipografia** (famílias do Google Fonts, pesos, tamanhos e line-height por hierarquia: H1–H6, corpo, menu).
- **Espaçamentos** (padding/margens por seção, gutters de colunas).
- **Border-radius, sombras, efeitos de hover**.
- **Ícones e imagens** usados (mapear para equivalentes gratuitos/licenciados).

**Regra:** não invente valores. Use os valores computados reais do demo. Registre tudo em um guia de estilo (arquivo de referência no projeto) antes de implementar.

---

## 4. Requisitos Técnicos do Tema

### 4.1 Estrutura de Arquivos

Crie a seguinte estrutura dentro do novo tema:

```
idyllic-clone/
├── style.css                 # cabeçalho do tema + estilos principais
├── functions.php             # setup, enqueue, menus, widgets, customizer
├── index.php                 # fallback geral (blog/arquivos)
├── header.php
├── footer.php
├── front-page.php            # página inicial com as seções do demo
├── page.php
├── single.php
├── archive.php
├── search.php
├── 404.php
├── comments.php
├── sidebar.php
├── searchform.php
├── inc/
│   ├── customizer.php        # opções de personalização
│   ├── template-tags.php     # funções auxiliares
│   ├── custom-functions.php  # seções da front-page (registro)
│   └── enqueue.php           # carregamento de assets
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   └── responsive.css
│   ├── js/
│   │   ├── main.js
│   │   └── slider.js
│   └── images/               # imagens padrão/fallback
├── template-parts/
│   ├── frontpage/
│   │   ├── hero-slider.php
│   │   ├── features.php
│   │   ├── services.php
│   │   ├── cta.php
│   │   ├── about.php
│   │   ├── stats.php
│   │   ├── team.php
│   │   ├── testimonials.php
│   │   └── blog.php
│   └── header/
└── languages/                # text domain para tradução
```

### 4.2 Funcionalidades Obrigatórias (functions.php)

- Registrar **menus de navegação** (menu principal, menu social).
- Registrar **áreas de widget** (sidebar, footer 1–4).
- Suporte a: `title-tag`, `post-thumbnails`, `custom-logo`, `custom-header`, `custom-background`, `html5`, `align-wide`, `responsive-embeds`, `editor-styles`.
- Enqueue correto de `style.css` e scripts (com `wp_enqueue_scripts`), respeitando dependências e versão (cache busting).
- **Text domain** configurado para tradução (`load_theme_textdomain`).
- **Customizer**: opções para cores (primária/CTA), logo, textos das seções, banner do slider, redes sociais, exibição/ocultação de cada seção da home.
- Registrar **post types/custom fields** se necessário, preferindo **Theme Customizer + Customizer API** (evitar dependência de ACF).

### 4.3 Sistema de Design

- Implementar os design tokens extraídos na seção 3 como **variáveis CSS** (`:root`).
- Tipografia via **Google Fonts** enfileirada corretamente (com `preconnect` e `swap`).
- Cores aplicáveis pelo Customizer sem quebrar contraste.
- Componentes: botões, cards, títulos de seção, listas, links, formulário de busca.

### 4.4 Responsividade

- Layout **mobile-first**, com breakpoints consistentes (ex.: 576px, 768px, 992px, 1200px).
- Menu mobile (hambúrguer) funcional e acessível.
- Imagens com `srcset`/`sizes` e `loading="lazy"`.
- Grids que colapsam para 1 coluna no mobile.

### 4.5 Performance, SEO e Acessibilidade

- HTML **semântico** (`header`, `nav`, `main`, `section`, `article`, `footer`, `h1–h6` corretos).
- `aria-label`, `role`, navegação por teclado, foco visível.
- CSS/JS **minificados** e sem bloqueio de renderização quando possível.
- Sem jQuery desnecessário — use JS vanilla.
- Imagens otimizadas (WebP quando suportado) e dimensões explícitas.

### 4.6 Compatibilidade

- Compatível com **WordPress 6.x** e **PHP 8.x**.
- Compatível com plugins citados pelo tema original quando relevante: **WooCommerce**, **Contact Form 7**, **Breadcrumb NavXT**, **WP-PageNavi**, **Polylang** (sem ser obrigatório).
- Sem erros de PHP (modo `WP_DEBUG` limpo), sem warnings de depreciação.

---

## 5. Seções da Página Inicial (especificação detalhada)

Replique na `front-page.php`, nesta ordem, as seções do demo:

1. **Top Bar** — endereço, telefone e e-mail à esquerda; ícones sociais à direita.
2. **Header** — logo à esquerda, menu de navegação à direita, ícone de busca, botão/busca expansível. Sticky opcional.
3. **Hero Slider** — slider de banner com título, subtítulo, botão de CTA e controles (setas/dots). Usar imagens de destaque ou conteúdo do Customizer.
4. **Features** — grade de 4 cards ("Design And Build", "Easy Customizable", "Full Documentation", "Global certified"), com ícone, título, texto e link "Explore More".
5. **Services** — seção com título e grade de serviços ("Business Consulting", "Financial Advice", "Stock Market", "Consumer Products"), cada um com ícone, título e descrição.
6. **CTA Banner** — faixa de chamada com fundo em cor de destaque e botão.
7. **About** — seção em duas colunas: imagem + texto ("Build your perfect website with our creative Theme"), com lista de itens de destaque e botão.
8. **Stats/Contadores** — faixa com números (contadores animados) se presente no demo.
9. **Team / Professional Staff** — grade de membros com foto, nome e cargo.
10. **Testimonials** — carrossel ou grade de depoimentos com aspas, texto e autor.
11. **Blog / Latest Posts** — grid dos últimos posts (thumbnail, data, título, resumo).
12. **Footer** — colunas de widgets (sobre, links úteis, contato, newsletter), seguido de rodapé de copyright.

> **Nota:** adapte os nomes/textos para **conteúdo de exemplo em português (pt-BR)** ou mantenha estrutura vazia editável pelo Customizer, mas nunca hard-code conteúdo final em inglês sem permitir edição.

---

## 6. Critérios de Aceite

- [ ] Tema instalado e ativável em `/home/delll/Projects/jsnProject` sem erros.
- [ ] Página inicial renderiza todas as seções listadas, fiel ao demo.
- [ ] Design tokens (cores/tipografia/espaçamento) correspondem aos valores extraídos do demo.
- [ ] Layout responsivo funciona em mobile, tablet e desktop.
- [ ] Menu mobile, slider e interações funcionam sem console de erros.
- [ ] Customizer permite alterar logo, cores, textos das seções e ativar/desativar seções.
- [ ] Widgets de footer e sidebar funcionam.
- [ ] `WP_DEBUG` sem avisos/erros de PHP.
- [ ] Validação HTML válida e acessibilidade básica (contraste, semântica, teclado).
- [ ] Performance aceitável (sem dependências desnecessárias, assets otimizados).

---

## 7. Etapas de Execução (sugeridas)

1. Inspecionar ambiente do projeto e versões (WP/PHP).
2. Extrair design tokens do demo e montar guia de estilo.
3. Criar estrutura de pastas e arquivos base do tema.
4. Implementar `header.php`, `footer.php`, `functions.php` e enqueue.
5. Implementar as seções da `front-page.php` via `template-parts`.
6. Implementar templates internos (page, single, archive, search, 404).
7. Configurar Customizer, menus e widgets.
8. Aplicar responsividade e acessibilidade.
9. Testar com `WP_DEBUG`, validar e documentar.

---

## 8. Restrições e Boas Práticas

- **Não** copiar o código proprietário do Idyllic Plus; apenas reproduzir o resultado visual.
- **Não** usar construtores de página (Elementor, etc.) como base.
- **Não** hard-code conteúdo que deveria vir do banco/Customizer.
- Usar **prefixo único** em funções, handles e constantes (ex.: `jsn_idyllic_`).
- Sanitizar/escapar todas as saídas (`esc_html`, `esc_attr`, `wp_kses`).
- Seguir o **WordPress Coding Standards** (PHPCS) e a hierarquia de templates oficial.

---

## 9. Entregáveis Finais

1. Tema funcional em `/home/delll/Projects/jsnProject/wp-content/themes/idyllic-clone/`.
2. Guia de estilo com os design tokens extraídos do demo.
3. README com instruções de ativação, configuração do Customizer e estrutura do tema.
4. Relatório das decisões técnicas tomadas (arquitetura, build, compatibilidade).