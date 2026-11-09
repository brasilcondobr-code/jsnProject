# Guia de Estilo — idyllic-clone

Design tokens **extraídos do demo real** (Idyllic Plus — valores computados a partir do Customizer inline CSS e da tipografia do tema de referência). Este guia é a fonte da verdade para os estilos do tema. O código do clone é **100% original** — apenas valores de design e estrutura visual foram replicados.

## 1. Paleta de cores

| Token CSS | Valor real | Uso |
|---|---|---|
| `--id-primary` | `#46c5d4` | Top bar, hover de links, site-title, dots/ativo do slider, seleção de texto, ícones |
| `--id-accent` | `#ff4530` | Botões CTA ("vivid-red"), links de categoria/tag, hover de meta, divisores de contadores |
| `--id-text` | `#484848` | Corpo de texto, navegação, títulos de slide, widget-title |
| `--id-heading` | `#343434` | H1–H6, títulos de entrada, listas/widgets, conteúdo do footer |
| `--id-muted` | `#747474` | Descrição do site, submenus |
| `--id-bg-page` | `#ffffff` | Fundo geral |
| `--id-bg-about` | `#f8f8f8` | Seção About e bloco de texto do blog |
| `--id-bg-testimonials` | `#f4f4f4` | Fundo dos depoimentos (com imagem parallax + overlay) |
| `--id-bg-team` | `#fafafa` | Seção equipe |
| `--id-bg-input` | `#fafafa` | Inputs e textarea |
| `--id-bg-info` | `#eeeeee` | Barra de copyright |
| `--id-bg-stats` | `#aaaaaa` | Faixa de contadores (texto branco) |
| `--id-btn` | `#484848` | Botão padrão `.btn-default` |

Hover: link → `#46c5d4`; botão ganha triângulos translúcidos `rgba(255,255,255,.3)` deslocando nos cantos.

## 2. Tipografia (Google Fonts)

| Fonte | Uso |
|---|---|
| **Arimo** 400 (600 para categorias) | Corpo, títulos, navegação |
| **Lustria** 400 italic | Meta de posts (autor/data), 12px, letter-spacing .2px |

| Elemento | Tamanho real | Line-height real | Peso |
|---|---|---|---|
| `h1` | 30px | 1.233 | 400 |
| `h2` | 26px | 1.269 | 400 |
| `h3` | 24px | 1.292 | 400 |
| `h4` | 22px | 1.318 | 400 |
| `h5` | 20px | 1.350 | 400 |
| `h6` | 18px | 1.389 | 400 |
| body | 16px | 26px | 400 |
| base html | 14px equivalentes (0.875em) | 1.6 | — |
| `.btn-default` | 13px | — | 400 |
| `.box-title` (títulos de seção) | **32px / 38px** | margin-bottom 15px | 400 |
| Título do slide (hero) | **36px / 44px** | — | 400 |
| Meta de post | 12px italic (Lustria) | 1.583 | 400 |
| Links cat/tag | **11px** uppercase 600 | — | 600 |
| Copyright | 12–13px | — | 400 |

**Nota:** todos os headings usam **font-weight 400** (títulos "leves" do demo).

## 3. Layout / espaçamentos

| Token | Valor real |
|---|---|
| `.wrap` (container) | `max-width: 1170px`, margens auto |
| `.inner-wrap` | `max-width: 978px` |
| Padding de seção (ex.: features) | `80px 0 50px` |
| Gutter de colunas | parental `margin: 0 -10px`, coluna `padding: 0 10px` |
| `.wide-wrap` | margens laterais 40px |

## 4. Grid

- Features / serviços / equipe: **4 colunas** (≥ 992px), **2 colunas** (576–991px), **1 coluna** (< 576px);
- About e Latest-blog: **2 colunas** 50/50, colapsam para 1 em ≤ 767px;
- Header: logo à esquerda, nav à direita; top-bar com contato (float right do demo: contato à direita do wrap, social à esquerda).

## 5. Componentes

- **`.btn-default`**: fundo `#484848`, texto branco 13px, inline-block; hover: **triângulos** `rgba(255,255,255,.3)` de 36px deslocando a partir dos cantos (efeito visual marca do demo). Variação `.jsn-idyllic-accent` = `#ff4530`;
- **Hero slider**: imagem `min-height: 640px`, `cover`, centro; conteúdo `left: 10%`, `max-width: 70%`, alinhado à esquerda; título 36px/44px; subtítulo acima do título; botão `explore`;
- **Feature cards**: bloco de cor sólida (primária), ícone circular 144px, título + texto sobre a cor, link "Saiba mais";
- **Contadores (stats)**: faixa `#aaaaaa` com texto branco; divisores verticais finos; contagem animada;
- **Testimonials**: fundo parallax com overlay escuro translúcido; citação com foto redonda;
- **Border-radius: 0** — cantos retos em todo o tema; sombras quase ausentes (borda 1px #eee).

## 6. Breakpoints

| Breakpoint | Comportamento |
|---|---|
| ≤ 1200px | `.wrap` ganha padding lateral 15px |
| ≤ 991px | Navegação colapsa para menu dropdown/hambúrguer; features 2 col |
| ≤ 767px | About/blog 1 coluna; top-bar empilhado |
| ≤ 575px | Features 1 coluna; hero título reduzido |

## 7. Ícones

O demo usa Font Awesome pagas externas; o clone usa **SVG inline original** (pin, telefone, envelope, busca, chevrones, aspas e ícones de serviço) — sem CDN externo, melhor performance.
