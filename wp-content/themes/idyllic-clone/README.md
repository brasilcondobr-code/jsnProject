# Tema Idyllic Clone

Recriação visual (código **100% original**) do layout de referência *Idyllic Plus* (ThemeFreesia), construída como tema WordPress independente para o projeto JSN. Sem construtores de página, sem dependências de ACF; todo o conteúdo é editável pelo **Customizer**.

**Prefixo de código:** `jsn_idyllic_` • **Text domain:** `jsn-idyllic-clone` • **Versão:** 1.0.0

---

## 1. Ativação

```bash
make wp CMD="theme activate idyllic-clone"
```

ou em **Aparência → Temas → Idyllic Clone → Ativar**.

Para voltar do tema principal do projeto a qualquer momento:

```bash
make wp CMD="theme activate jsn"
```

> Se você ativar o clone e quiser que as páginas existentes voltem a usar o layout do `jsn`, os templates internos (páginas/posts) seguem a hierarquia padrão do WP — nada quebra. A home (front-page) sempre exibirá as seções do clone enquanto ele estiver ativo.

## 2. Conteúdo de demonstração ("clone pronto")

O tema vem com um seed que configura **todas as seções da front-page** + 3 posts de exemplo com imagem destacada, reproduzindo a estrutura do demo de referência com **conteúdo próprio em pt-BR** e **fotos abertas** (licenças Unsplash, incluídas em `assets/images/demo/`). Nada dos materiais da ThemeFreesia é copiado.

```bash
make demo-idyllic
```

O seed é idempotente (pode rodar mais de uma vez), ativa o tema automaticamente e configura via Customizer: top bar, 3 slides, features, serviços, CTA, sobre, contadores, equipe, depoimentos e blog. Para trocar qualquer foto/texto depois: **Aparência → Personalizar → Idyllic Clone — Página Inicial**. Arquivo: `inc/demo-seed.php`.

> **Nota sobre import oficial:** se você adquirir a licença do Idyllic Plus (ThemeFreesia), o pacote de demo content oficial deles pode ser importado com ferramentas como o One Click Demo Import. A importação verbatim do conteúdo do demo sem essa licença **não** é permitida (imagens/textos são material licenciado do vendor/stock).

## 3. Configuração pelo Customizer

Em **Aparência → Personalizar**:

| Painel/Seção | Opções |
|---|---|
| **Cores do Tema** | Cor primária (default `#46c5d4`), cor de destaque/CTA (`#ff4530`), no formato real do layout |
| **Idyllic Clone — Página Inicial** | Painel com todas as seções da home |
| Header | Sticky on/off |
| Top Bar | Endereço, telefone, e-mail + redes sociais (`Nome \| https://url`, uma por linha) ou menu na posição "social" |
| Hero Slider | 3 slides (linha de apoio, título, botão, link, imagem) + autoplay on/off |
| Features | 4 cards (título, texto, link, ícone) |
| Serviços | 4 cards (título, texto, ícone) |
| CTA Banner | Texto + botão |
| Sobre | Título, texto, lista de destaques (1 por linha), imagem, botão |
| Contadores | 4 contadores (número, rótulo) |
| Equipe | 4 membros (nome, cargo, foto opcional) |
| Depoimentos | 3 depoimentos (título, citação, autor, foto opcional) |
| Blog | Título + quantidade de posts (usa posts reais do WP) |

Toda seção tem checkbox **"Exibir esta seção"**; valores vazios usam defaults em pt-BR — nada de conteúdo final hardcode em inglês.

## 4. Estrutura do tema

```
idyllic-clone/
├── style.css                     # header + tokens (:root) + base tipográfica
├── functions.php                 # setup, menus, widgets, image sizes, requires
├── front-page.php                # orquestra as seções da home (via partes)
├── header.php                    # top bar + header sticky + busca + hero slot
├── footer.php                    # 4 colunas de widgets + copyright + social
├── index.php / archive.php / search.php / single.php / page.php / 404.php
├── sidebar.php / comments.php / searchform.php
├── inc/
│   ├── customizer.php            # painel completo + sanitização + CSS dinâmico
│   ├── custom-functions.php      # getters das seções (grafas defaults pt-BR)
│   ├── template-tags.php         # ícones SVG próprios, meta, social helper
│   └── enqueue.php               # assets + Google Fonts (preconnect/swap)
├── assets/
│   ├── css/{main,responsive}.css # componentes e media queries
│   ├── js/{main,slider,customizer}.js  # vanilla (menu, busca, sticky, sliders, contadores)
│   └── images/*.svg              # placeholders originais (hero/about/team/post)
├── template-parts/
│   ├── header/top-bar.php
│   └── frontpage/                # hero-slider, features, services, cta,
│                                 #   about, stats, team, testimonials, blog
├── STYLEGUIDE.md                 # design tokens extraídos do demo (fonte da verdade)
└── languages/jsn-idyllic-clone.pot
```

## 5. Ícones

O demo usa Font Awesome pagas; aqui usamos **SVG geométrico próprio** (função `jsn_idyllic_clone_get_icon`), sem CDN. Para trocar por outra biblioteca use o filtro:

```php
add_filter( 'jsn_idyllic_clone_icons', function ( $icons, $name ) {
	return $icons[name] ?? '<svg ...>...</svg>';
}, 10, 2 );
```

Se no futuro quiser Font Awesome Free (licença CC BY 4.0 na parte de ícones), basta enfileirar em `inc/enqueue.php` e ajustar os markup — a função centraliza tudo.

## 6. Boas práticas aplicadas

- Telefones/e-mails via `esc_attr`/`antispambot`; todas as saídas passam por `esc_*`/`wp_kses_post`;
- Imagens com dimensões explícitas e `loading="lazy"`; `the_post_thumbnail` nativo (srcset automático);
- ARIA (carousel, tabs dos dots, `aria-expanded` dos toggles), foco visível e skip-link;
- Contadores com `IntersectionObserver`; pausa do slider em hover; `prefers-reduced-motion` respeitado;
- Navegação por teclado nos submenus (`:focus-within`).

## 7. Compatibilidade

WordPress 6.x • PHP 8.x • WooCommerce/CF7/Breadcrumb NavXT/Polylang: o tema não depende deles, mas estilos de formulários/shortcode CF7 herdam os inputs do tema; polylang funciona via taxonomia padrão (nada travado).

## 8. Arquivos de documentação

- `STYLEGUIDE.md` — tokens extraídos do demo (cores, tipografia, espaçamentos, breakpoints);
- `RELATORIO-DECISOES.md` — decisões de arquitetura e build deste desenvolvimento.
