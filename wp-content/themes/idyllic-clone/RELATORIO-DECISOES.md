# Relatório de Decisões Técnicas — idyllic-clone

## 1. Ambiente inspecionado (etapa 2 do prompt)

| Item | Levantamento |
|---|---|
| WordPress | 6.8.3 (container `wordpress:6.8-php8.3-fpm-alpine`) |
| PHP | 8.3.28 (container) / 8.3 (host) |
| Estrutura | Instalação WP em Docker com core efêmero + `wp-content` no bind mount; **não existe tema filho** ativo — tema ativo do projeto é `jsn` |
| Build tools | Node 24 disponível no host; **decisão: CSS/JS vanilla** sem build (escopo do tema é leve; sem dependências rodando como `npm` no container) |
| Banco/URL | MariaDB 11.4 + `http://localhost:8080` (compose do projeto) |

## 2. Arquitetura

- **Tema independente** em `wp-content/themes/idyllic-clone/` — decisão alinhada ao prompt (não havia tema filho para reaproveitar). O tema `jsn` do projeto permanece mantido e ativável.
- **Sem CPTs/taxonomias**: a front-page inteira é orientada ao **Customizer** (sessão de post types seria overkill para conteúdo estático de home; o Blog usa `WP_Query` de posts reais). Os textes/membros/depoimentos são *theme_mods* com defaults pt-BR em `inc/custom-functions.php`.
- **Sem ACF**: conforme exigido; todos os campos são Customizer (`inc/customizer.php`) com `sanitize_*` individuais.
- **Filtro de seções** `jsn_idyllic_clone_front_page_sections` permite reordenar/adicionar seções sem tocar o template.

## 3. Build

HTML/CSS/JS puro, **sem minificador** nesta fase (arquivos já concisos; automação de build/minificação fica para Fase 5 do projeto maior — Vite). JS vanilla sem jQuery (zero libs runtime); Google Fonts é a única dependência externa (Arimo + Lustria, com preconnect + `display=swap`).

## 4. Referência e propriedade intelectual

- Não foi copiado nenhum código proprietário do tema original; Todo o PHP/CSS/JS/imagens são originais.
- foram extraídos apenas **design tokens** (cores, tamanhos de fonte, espaçamentos, breakpoints — valores objetivamente mensuráveis) e a ordem/estrutura das seções;
- Conteúdo do demo (locações em inglês/placeholder) foi substituído por conteúdo exemplo em **português** editável no Customizer;
- Ícones: biblioteca SVG geométrica própria, sem reprodução de sets comerciais.

## 5. Validações

- `php -l` em todos os arquivos PHP do tema;
- Ativação temporária via WP-CLI para checagem em runtime (WP_DEBUG log + front/home/single/search/404 renderizados), depois **restaurado o tema `jsn`** como ativo do projeto;
- Console do browser sem erros (slider/menu/contadores vanilla).

## 6. Ajustes identificados durante a execução

- Ajuste de `<div class="main-hero">` aberto no header (fechamento corrigido);
- Callback de sanitize do loop de grupos corrigido (`jsn_idyllic_clone_sanitize_by_type`);
- Ícones reescritos para formas geométricas simples garantindo renderização correta.

## 7. Limitações conhecidas / próximos passos

- Parallax do testimonials usa `background-attachment: fixed` (desativado automaticamente em iOS pelo próprio browser);
- Minificação/automatização front-end (Fase 5 do roadmap do projeto);
- O tema não substitui o seed do projeto: para conteúdo de exemplo dos posts, o `make seed` do tema `jsn` já cria posts possíveis de consumo no Blog deste tema.
