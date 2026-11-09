<?php
/**
 * Idyllic Clone — Seed de conteúdo de demonstração ("clone pronto").
 *
 * Execução (a partir da raiz do projeto):
 *   make wp CMD='eval-file wp-content/themes/idyllic-clone/inc/demo-seed.php'
 *
 * O que faz:
 *  - Ativa o tema idyllic-clone;
 *  - Configura TODOS os theme_mods das seções da front-page
 *    (top bar, 3 slides, features, services, CTA, about, stats,
 *    team, testimonials e blog) com conteúdo em pt-BR;
 *  - Usa apenas imagens abertas (licenças Unsplash, via picsum.org)
 *    incluídas em assets/images/demo/;
 *  - Cria 3 posts de exemplo com imagem destacada;
 *  - Atribui o menu "Menu Principal" à posição primary.
 *
 * Idempotente: pode ser executado mais de uma vez sem duplicar conteúdo
 * (posts são procurados por slug antes de criados).
 *
 * IMPORTANTE: o conteúdo é original (project-owned). Nada do demo oficial
 * da ThemeFreesia é copiado — para o import oficial, adquira a licença do
 * Idyllic Plus e use o arquivo de demonstração deles.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

/* Ativa o tema (o seed configura theme_mods do ativo). */
if ( 'idyllic-clone' !== get_stylesheet() ) {
	switch_theme( 'idyllic-clone' );
	WP_CLI::log( 'Tema idyllic-clone ativado.' );
}

$uri = get_stylesheet_directory_uri() . '/assets/images/demo';

/**
 * Define um theme_mod composto por grupo/índice/campo.
 *
 * @param string $key   Sem prefixo (ex.: features1_title).
 * @param string $value Valor.
 * @return void
 */
function idyllic_seed_set( $key, $value ) {
	set_theme_mod( 'jsn_idyllic_' . $key, $value );
}

WP_CLI::log( 'Configurando Top Bar…' );
idyllic_seed_set( 'topbar_address', 'Av. Bandeirantes, 3833 — Ribeirão Preto/SP' );
idyllic_seed_set( 'topbar_phone', '(16) 3610-5000' );
idyllic_seed_set( 'topbar_email', 'contato@jsnnegocios.com.br' );
idyllic_seed_set( 'topbar_social', "Facebook | https://facebook.com/\nInstagram | https://instagram.com/\nLinkedIn | https://linkedin.com/" );

WP_CLI::log( 'Configurando Hero Slider…' );
$hero = array(
	1 => array(
		'subtitle'    => 'Gestão e serviços administrativos',
		'title'       => 'Seu condomínio organizado, com transparência total',
		'button_text' => 'Conheça a empresa',
		'button_url'  => '/sobre/',
		'image'       => $uri . '/hero-1.jpg',
	),
	2 => array(
		'subtitle'    => 'Solidez administrativa e financeira',
		'title'       => 'Prestação de contas clara em cada fase da gestão',
		'button_text' => 'Nossos serviços',
		'button_url'  => '/servicos/',
		'image'       => $uri . '/hero-2.jpg',
	),
	3 => array(
		'subtitle'    => 'Tecnologia aplicada ao dia a dia',
		'title'       => 'Área do condômino com tudo em um só lugar',
		'button_text' => 'Acesse a área restrita',
		'button_url'  => '/area-restrita/',
		'image'       => $uri . '/hero-3.jpg',
	),
);
foreach ( $hero as $i => $data ) {
	foreach ( $data as $field => $value ) {
		idyllic_seed_set( sprintf( 'hero%1$d_%2$s', $i, $field ), $value );
	}
}

WP_CLI::log( 'Configurando Features…' );
idyllic_seed_set( 'features_title', '' );
$features = array(
	1 => array(
		'title' => 'Gestão Condominial',
		'text'  => 'Administração completa: assembleias, contratos, manutenções e rotinas do condomínio sob controle profissional.',
		'link'  => '/servicos/',
		'icon'  => 'briefcase',
	),
	2 => array(
		'title' => 'Prestação de Contas',
		'text'  => 'Demonstrativos mensais de receitas e despesas com total transparência para o corpo diretivo.',
		'link'  => '/servicos/',
		'icon'  => 'chart',
	),
	3 => array(
		'title' => 'Área do Condômino',
		'text'  => 'Portal restrito com boletos, comunicados, ocorrências e documentos em poucos cliques.',
		'link'  => '/area-restrita/',
		'icon'  => 'shield',
	),
	4 => array(
		'title' => 'Atendimento Dedicado',
		'text'  => 'Canal direto com a equipe: resposta ágil por telefone, e-mail e atendimento presencial.',
		'link'  => '/contato/',
		'icon'  => 'star',
	),
	5 => array(
		'title' => 'Suporte Dedicado',
		'text'  => 'Equipe disponível para auxiliar em cada etapa da gestão do condomínio.',
		'link'  => '/contato/',
		'icon'  => 'wrench',
	),
	6 => array(
		'title' => 'Estrutura Modular',
		'text'  => 'Seções independentes que você reordena ou desativa à vontade.',
		'link'  => '/',
		'icon'  => 'box',
	),
	7 => array(
		'title' => 'Pronto para Tradução',
		'text'  => 'Strings preparadas para internacionalização do conteúdo.',
		'link'  => '/',
		'icon'  => 'trending',
	),
	8 => array(
		'title' => 'Contato Facilitado',
		'text'  => 'Formulários e canais de atendimento integrados ao tema.',
		'link'  => '/contato/',
		'icon'  => 'envelope',
	),
);
foreach ( $features as $i => $data ) {
	foreach ( $data as $field => $value ) {
		idyllic_seed_set( 'features' . $i . '_' . $field, $value );
	}
}

WP_CLI::log( 'Configurando Services…' );
$services = array(
	1 => array(
		'title' => 'Administração Financeira',
		'text'  => 'Orçamento anual, rateio, cobrança e controle de inadimplência com relatórios transparentes.',
		'icon'  => 'chart',
	),
	2 => array(
		'title' => 'Manutenção Preventiva',
		'text'  => 'Programa de manutenção das áreas comuns com cronograma e registro fotográfico.',
		'icon'  => 'wrench',
	),
	3 => array(
		'title' => 'Recursos Humanos',
		'text'  => 'Gestão de colaboradores do condomínio: folha, férias, encargos e treinamentos.',
		'icon'  => 'briefcase',
	),
	4 => array(
		'title' => 'Assessoria Jurídica',
		'text'  => 'Orientação em convenção, regimento interno e cobrança amigável de devedores.',
		'icon'  => 'shield',
	),
);
foreach ( $services as $i => $data ) {
	foreach ( $data as $field => $value ) {
		idyllic_seed_set( 'services' . $i . '_' . $field, $value );
	}
}

WP_CLI::log( 'Configurando CTA…' );
idyllic_seed_set( 'cta_title', 'Quer uma proposta de gestão para o seu condomínio?' );
idyllic_seed_set( 'cta_button_text', 'Fale com um consultor' );
idyllic_seed_set( 'cta_button_url', '/contato/' );

WP_CLI::log( 'Configurando About…' );
idyllic_seed_set( 'about_title', 'Sobre nós' );
idyllic_seed_set( 'about_sub', 'Maecenas sit amet suscipit orci, sit amet blandit felis.' );
idyllic_seed_set( 'about_heading', 'Gestão que une organização, tecnologia e respeito ao condômino.' );
idyllic_seed_set( 'about_content', "A JSN Negócios Administrativos trabalha com condomínios residenciais e comerciais com um time sênior e processos claros. Cuidamos da rotina administrativa, financeira e de pessoas para que síndicos e conselhos foquem nas decisões.\n\nNosso compromisso é simples: informação no tempo certo, contas que fecham e atendimento que o morador reconhece." );
idyllic_seed_set( 'about_items', "Gestão transparente\nComunicação objetiva\nAtendimento próximo\nTecnologia aplicada" );
idyllic_seed_set( 'about_image', $uri . '/about.jpg' );
idyllic_seed_set( 'about_button_text', 'Saiba mais sobre nós' );
idyllic_seed_set( 'about_button_url', '/sobre/' );

WP_CLI::log( 'Configurando Stats…' );
$stats = array(
	1 => array( 'number' => 32, 'label' => 'Condominios geridos' ),
	2 => array( 'number' => 12000, 'label' => 'Unidades atendidas' ),
	3 => array( 'number' => 15, 'label' => 'Anos de experiencia' ),
	4 => array( 'number' => 98, 'label' => 'Satisfacao (%)' ),
);
foreach ( $stats as $i => $data ) {
	idyllic_seed_set( 'stats' . $i . '_number', $data['number'] );
	idyllic_seed_set( 'stats' . $i . '_label', $data['label'] );
}

WP_CLI::log( 'Configurando Team…' );
$team = array(
	1 => array( 'name' => 'Ana Martins', 'role' => 'Diretora Executiva' ),
	2 => array( 'name' => 'Carlos Andrade', 'role' => 'Gerente de Condomínios' ),
	3 => array( 'name' => 'Beatriz Souza', 'role' => 'Coordenadora Financeira' ),
	4 => array( 'name' => 'Rafael Lima', 'role' => 'Analista de Suporte' ),
);
foreach ( $team as $i => $data ) {
	idyllic_seed_set( 'team' . $i . '_name', $data['name'] );
	idyllic_seed_set( 'team' . $i . '_role', $data['role'] );
	idyllic_seed_set( 'team' . $i . '_image', $uri . '/team-' . $i . '.jpg' );
}
idyllic_seed_set( 'team_title', 'Nossa equipe' );
idyllic_seed_set( 'team_sub', 'Profissionais dedicados ao seu condomínio.' );

WP_CLI::log( 'Configurando Testimonials…' );
idyllic_seed_set( 'testimonials_title', '' );
$testimonials = array(
	1 => array(
		'title'  => 'Prestação de contas impecável.',
		'quote'  => '“Desde que contratamos a JSN, as assembleias ficaram objetivas e os números fecham mês a mês. Recomendo a gestão deles sem recordar dos problemas anteriores.”',
		'author' => 'Marcos Oliveira — Síndico, Residencial Horizonte',
		'image'  => $uri . '/avatar-1.jpg',
	),
	2 => array(
		'title'  => 'Atendimento que faz diferença.',
		'quote'  => '“O canal com a equipe é ágil: ocorrências do morador chegam ao correto e sempre temos retorno no mesmo dia.”',
		'author' => 'Helena Duarte — Conselheira, Edifício Verde',
		'image'  => $uri . '/avatar-2.jpg',
	),
	3 => array(
		'title'  => 'Tecnologia ao lado do morador.',
		'quote'  => '“Com a área do condômino, boletos e comunicados ficaram no celular de todo mundo. A adesão dos moradores foi imediata.”',
		'author' => 'Pedro Almeida — Síndico, Comercial Norte',
		'image'  => $uri . '/avatar-3.jpg',
	),
);
foreach ( $testimonials as $i => $data ) {
	foreach ( $data as $field => $value ) {
		idyllic_seed_set( 'testimonials' . $i . '_' . $field, $value );
	}
}
/* Fundo parallax dos depoimentos. */
set_theme_mod( 'jsn_idyllic_testimonials_bg', $uri . '/testimonial-bg.jpg' );

WP_CLI::log( 'Configurando Blog…' );
idyllic_seed_set( 'blog_title', 'Novidades e dicas de gestão' );
idyllic_seed_set( 'blog_sub', 'Dicas e novidades sobre gestão de condomínios.' );
idyllic_seed_set( 'blog_count', 6 );

/* Desativa seções fora do layout do demo de referência. */
idyllic_seed_set( 'show_services', 0 );
idyllic_seed_set( 'show_cta', 0 );
idyllic_seed_set( 'show_stats', 0 );

/* ---------------------------------------------------------------
 * Posts de exemplo (idempotente por slug).
 * --------------------------------------------------------------- */
$demo_posts = array(
	'assembleia-transparente-5-render' => array(
		'title'   => 'Assembleias transparentes: 5 práticas que aproximam o condômino',
		'content' => "Assembleias eficazes dependem de informação que chega antes da reunião. Neste post, reunimos cinco práticas usadas nos condomínios que administramos:\n\n1. Edital com pauta completa e documentos antecipados;\n2. Relatório financeiro simplificado, no formato que o morador entende;\n3. Votação registrada em ata publicada na área restrita;\n4. Espaço para perguntas enviadas antes do dia da assembleia;\n5. Oficina de suplentes para formar novos conselheiros.\n\nCom fluxo de informação sólido, quórum deixa de ser problema e decisões ficam mais rápidas — e documentadas.",
		'image'   => 'blog-1.jpg',
		'cat'     => 'Gestão',
	),
	'orcamento-anual-sem-surpresa' => array(
		'title'   => 'Orçamento anual sem surpresas: como planejar as despesas do condomínio',
		'content' => "O orçamento anual é o contrato de expectativa entre gestão e condôminos. A prática que recomendamos divide o orçamento em três blocos: rotinas fixas, manutenção programada e reserva para emergências.\n\nA partir daí, cada rateio é justificado com base em dados dos anos anteriores e nos laudos técnicos — nada de estimativa sem lastro. Na prática, isso reduz reajustes retroativos e discussões em assembleia.",
		'image'   => 'blog-2.jpg',
		'cat'     => 'Financeiro',
	),
	'area-comum-bem-cuidada' => array(
		'title'   => 'Área comum bem cuidada: o programa de manutenção que valoriza o condomínio',
		'content' => "Piscina, fachada, portaria, jardim: tudo que é comum precisa de um programa de manutenção com responsável, cronograma e registro fotográfico.\n\nNos condomínios assistidos, cada item de manutenção tem checklist mensal e histórico consultável na área do condômino — a transparência na conservação é a que mais gera elogio no retorno dos moradores.",
		'image'   => 'blog-3.jpg',
		'cat'     => 'Manutenção',
	),
	'portaria-digital-eficiencia' => array(
		'title'   => 'Portaria digital: eficiência e segurança na entrada do condomínio',
		'content' => "A portaria digital reduz custos com vigilância presencial sem abrir mão da segurança. O morador libera visitantes pelo app, o síndico acompanha em tempo real e a portaria fica registrada em log.\n\nPara condomínios de médio porte, a economia chega a 40% do custo operacional em 12 meses, com ganho de conforto para o morador.",
		'image'   => 'blog-4.jpg',
		'cat'     => 'Tecnologia',
	),
	'assembleia-online-quorum' => array(
		'title'   => 'Assembleia online: como garantir quórum e segurança jurídica',
		'content' => "Assembleias virtuais ampliaram o quórum nos condomínios que administramos. A chave está em edital claro, plataforma homologada e ata assinada digitalmente.\n\nNeste guia reunimos os passos legais e as boas práticas para que a assembleia online tenha o mesmo peso da presencial.",
		'image'   => 'blog-5.jpg',
		'cat'     => 'Gestão',
	),
	'orcamento-reserva-emergencia' => array(
		'title'   => 'Reserva para emergências: quanto o condomínio deve guardar por mês',
		'content' => "A reserva de emergências é o colchão que impede rateios extras quando um elevador quebra ou a fachada precisa de reparo. Recomendamos entre 5% e 10% da receita mensual, revisado a cada orçamento anual.\n\nCom fundo provisionado, o condomínio ganha previsibilidade e evita discussões em assembleia.",
		'image'   => 'blog-6.jpg',
		'cat'     => 'Financeiro',
	),
);

foreach ( $demo_posts as $slug => $data ) {
	$existing = get_page_by_path( $slug, OBJECT, 'post' );

	if ( $existing instanceof WP_Post ) {
		$post_id = $existing->ID;
		WP_CLI::log( 'Post já existe (slug ' . $slug . '): ' . $post_id );
	} else {
		$cat_ids = array();
		$cat     = get_term_by( 'name', $data['cat'], 'category' );

		if ( ! $cat ) {
			$created = wp_insert_term( $data['cat'], 'category' );
			$cat_ids = is_wp_error( $created ) ? array() : array( (int) $created['term_id'] );
		} else {
			$cat_ids = array( (int) $cat->term_id );
		}

		$post_id = wp_insert_post( array(
			'post_title'    => $data['title'],
			'post_name'     => $slug,
			'post_content'  => $data['content'],
			'post_status'   => 'publish',
			'post_category' => $cat_ids,
			'post_author'   => 1,
		), true );

		if ( is_wp_error( $post_id ) ) {
			WP_CLI::warning( 'Falha ao criar post ' . $slug . ': ' . $post_id->get_error_message() );
			continue;
		}

		WP_CLI::log( 'Post criado: ' . $data['title'] . ' (#' . $post_id . ')' );
	}

	/* Anexa imagem destacada se ainda não houver. */
	if ( ! has_post_thumbnail( $post_id ) ) {
		$local = get_stylesheet_directory() . '/assets/images/demo/' . $data['image'];

		if ( file_exists( $local ) ) {
			if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
			}

			$filetype   = wp_check_filetype( $local );
			$upload_dir = wp_upload_dir();
			$dest_name  = 'idyllic-demo-' . $slug . '-' . $data['image'];

			/* Garante que o diretório de upload existe (esse era o erro na primeira execução). */
			if ( ! wp_mkdir_p( $upload_dir['path'] ) ) {
				WP_CLI::warning( 'Não foi possível criar ' . $upload_dir['path'] );
				continue;
			}

			/* Copia para a biblioteca de mídia evitando nome duplicado. */
			$dest = wp_unique_filename( $upload_dir['path'], $dest_name );
			$dest_path = trailingslashit( $upload_dir['path'] ) . $dest;

			if ( ! @copy( $local, $dest_path ) ) {
				WP_CLI::warning( 'Falha ao copiar ' . $local . ' -> ' . $dest_path );
				continue;
			}

			$attachment = array(
				'post_mime_type' => 'image/jpeg' === $filetype['type'] ? 'image/jpeg' : $filetype['type'],
				'post_title'     => $data['title'],
				'post_status'    => 'inherit',
			);

			$att_id = wp_insert_attachment( $attachment, $dest_path, $post_id );

			if ( ! is_wp_error( $att_id ) && $att_id > 0 ) {
				wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $dest_path ) );
				set_post_thumbnail( $post_id, $att_id );
				WP_CLI::log( '  imagem destacada anexada: ' . $dest );
			}
		}
	}
}

WP_CLI::success( 'Seed do idyllic-clone aplicado com sucesso.' );
