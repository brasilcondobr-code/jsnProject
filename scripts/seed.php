<?php
/**
 * Seed idempotente do site JSN.
 *
 * Executado por `make install` / `make seed` via:
 * wp eval-file /scripts/seed.php
 *
 * @package JSN
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Este script precisa ser executado pelo WP-CLI.\n" );
	exit( 1 );
}

/**
 * Log amigável no WP-CLI ou fallback para stdout.
 *
 * @param string $message Mensagem.
 */
function jsn_seed_log( $message ) {
	if ( class_exists( 'WP_CLI' ) ) {
		WP_CLI::log( $message );
		return;
	}

	echo $message . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Cria/atualiza uma página e devolve o ID.
 *
 * @param string $slug     Slug.
 * @param string $title    Título.
 * @param string $template Template de página.
 * @param string $content  Conteúdo.
 * @return int
 */
function jsn_seed_page( $slug, $title, $template = '', $content = '' ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	$data = array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_content' => $content,
	);

	if ( $page instanceof WP_Post ) {
		$data['ID'] = $page->ID;
		$page_id    = wp_update_post( $data, true );
	} else {
		$page_id = wp_insert_post( $data, true );
	}

	if ( is_wp_error( $page_id ) ) {
		jsn_seed_log( 'Erro ao criar página ' . $title . ': ' . $page_id->get_error_message() );
		return 0;
	}

	if ( '' !== $template ) {
		update_post_meta( $page_id, '_wp_page_template', $template );
	}

	return (int) $page_id;
}

/**
 * Cria/atualiza um post de um CPT.
 *
 * @param string $post_type Post type.
 * @param string $title     Título.
 * @param string $content   Conteúdo.
 * @param string $excerpt   Resumo.
 * @return int
 */
function jsn_seed_post( $post_type, $title, $content, $excerpt = '' ) {
	$existing = get_page_by_path( sanitize_title( $title ), OBJECT, $post_type );
	$data     = array(
		'post_title'   => $title,
		'post_name'    => sanitize_title( $title ),
		'post_type'    => $post_type,
		'post_status'  => 'publish',
		'post_content' => $content,
		'post_excerpt' => $excerpt,
	);

	if ( $existing instanceof WP_Post ) {
		$data['ID'] = $existing->ID;
		$post_id    = wp_update_post( $data, true );
	} else {
		$post_id = wp_insert_post( $data, true );
	}

	if ( is_wp_error( $post_id ) ) {
		jsn_seed_log( 'Erro ao criar ' . $post_type . ' ' . $title . ': ' . $post_id->get_error_message() );
		return 0;
	}

	return (int) $post_id;
}

/**
 * Recria um menu com os itens informados.
 *
 * @param string $name  Nome do menu.
 * @param array  $items Itens (title, id).
 * @return int
 */
function jsn_seed_menu( $name, $items ) {
	$menu    = wp_get_nav_menu_object( $name );
	$menu_id = 0;

	if ( $menu instanceof WP_Term ) {
		$menu_id = (int) $menu->term_id;
		$current = wp_get_nav_menu_items( $menu_id );
		foreach ( (array) $current as $item ) {
			wp_delete_post( $item->ID, true );
		}
	} else {
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			jsn_seed_log( 'Erro ao criar menu ' . $name . ': ' . $menu_id->get_error_message() );
			return 0;
		}
	}

	foreach ( $items as $item ) {
		if ( empty( $item['id'] ) ) {
			continue;
		}

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $item['title'],
				'menu-item-object-id' => (int) $item['id'],
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	return (int) $menu_id;
}

$home_content = <<<'HTML'
<!-- wp:paragraph -->
<p>A JSN Negócios Administrativos cuida da rotina do seu condomínio com transparência, tecnologia e atendimento próximo.</p>
<!-- /wp:paragraph -->
HTML;

$about_content = <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">Quem somos</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Somos especialistas em gestão administrativa de condomínios, com processos claros, comunicação objetiva e foco em resultados para síndicos, conselheiros e condôminos.</p>
<!-- /wp:paragraph -->
HTML;

$services_content = <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">Serviços para o seu condomínio</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Assessoria administrativa, gestão financeira, rotinas de pessoal e suporte à tomada de decisão — tudo em um só lugar.</p>
<!-- /wp:paragraph -->
[jsn_widget id="cards-servicos"]
HTML;

$contact_content = <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">Fale com a JSN</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Conte o que o seu condomínio precisa. Responderemos com o próximo passo.</p>
<!-- /wp:paragraph -->
[jsn_widget id="cta-contato"]
HTML;

$restricted_content = <<<'HTML'
<!-- wp:paragraph -->
<p>Área exclusiva para síndicos, conselheiros, condôminos e equipe JSN. Use o menu restrito para acessar os recursos do portal.</p>
<!-- /wp:paragraph -->
HTML;

$home_id       = jsn_seed_page( 'home', 'Home', 'templates/front-page.php', $home_content );
$about_id      = jsn_seed_page( 'sobre', 'Sobre', '', $about_content );
$services_id   = jsn_seed_page( 'servicos', 'Serviços', '', $services_content );
$contact_id    = jsn_seed_page( 'contato', 'Contato', '', $contact_content );
$restricted_id = jsn_seed_page( 'area-restrita', 'Área Restrita', 'templates/page-restrita.php', $restricted_content );
$dashboard_id  = jsn_seed_page( 'dashboard-condominio', 'Dashboard Condomínio', 'page-templates/dashboard-condominio.php', '' );

if ( $restricted_id ) {
	update_post_meta( $restricted_id, '_jsn_is_restricted', '1' );
}
if ( $dashboard_id ) {
	update_post_meta( $dashboard_id, '_jsn_is_restricted', '1' );
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );
update_option( 'page_for_posts', 0 );
update_option( 'permalink_structure', '/%postname%/' );
update_option( 'blogname', 'JSN Negócios Administrativos' );
update_option( 'blogdescription', 'Gestão e serviços administrativos para condomínios' );
update_option( 'timezone_string', 'America/Sao_Paulo' );
update_option( 'date_format', 'd/m/Y' );
update_option( 'time_format', 'H:i' );
update_option( 'start_of_week', 0 );
update_option( 'default_comment_status', 'closed' );
update_option( 'default_ping_status', 'closed' );
update_option( 'users_can_register', 0 );

$primary_menu = jsn_seed_menu(
	'Menu Principal',
	array(
		array( 'title' => 'Home', 'id' => $home_id ),
		array( 'title' => 'Sobre', 'id' => $about_id ),
		array( 'title' => 'Serviços', 'id' => $services_id ),
		array( 'title' => 'Contato', 'id' => $contact_id ),
		array( 'title' => 'Área Restrita', 'id' => $restricted_id ),
	)
);

$restricted_menu = jsn_seed_menu(
	'Menu Restrito',
	array(
		array( 'title' => 'Área Restrita', 'id' => $restricted_id ),
		array( 'title' => 'Dashboard Condomínio', 'id' => $dashboard_id ),
	)
);

$footer_menu = jsn_seed_menu(
	'Menu Rodapé',
	array(
		array( 'title' => 'Sobre', 'id' => $about_id ),
		array( 'title' => 'Serviços', 'id' => $services_id ),
		array( 'title' => 'Contato', 'id' => $contact_id ),
		array( 'title' => 'Área Restrita', 'id' => $restricted_id ),
	)
);

$locations = array(
	'primary'    => $primary_menu,
	'footer'     => $footer_menu,
	'restricted' => $restricted_menu,
);
set_theme_mod( 'nav_menu_locations', $locations );

$services = array(
	array(
		'title'   => 'Assessoria administrativa',
		'content' => '<p>Rotinas de secretaria, documentos, atas e comunicados com organização e rastreabilidade.</p>',
		'excerpt' => 'Rotinas administrativas, documentos, atas e comunicados.',
	),
	array(
		'title'   => 'Gestão financeira',
		'content' => '<p>Controle de receitas e despesas, conciliação, prestação de contas e apoio ao planejamento orçamentário.</p>',
		'excerpt' => 'Controle financeiro, conciliação e prestação de contas.',
	),
	array(
		'title'   => 'Gestão de pessoas',
		'content' => '<p>Apoio à rotina de colaboradores do condomínio, escalas, orientação e organização documental.</p>',
		'excerpt' => 'Apoio à equipe do condomínio e à organização documental.',
	),
);

foreach ( $services as $service ) {
	jsn_seed_post( 'servico', $service['title'], $service['content'], $service['excerpt'] );
}

jsn_seed_post(
	'noticia_condominio',
	'Boas práticas para uma assembleia tranquila',
	'<p>Planejamento da pauta, comunicação prévia e registro claro das decisões ajudam a tornar a assembleia mais produtiva.</p>',
	'Dicas para organizar assembleias mais objetivas.'
);

flush_rewrite_rules();

jsn_seed_log( 'Páginas, menus, opções e conteúdo de exemplo configurados.' );

if ( class_exists( 'WP_CLI' ) ) {
	WP_CLI::success( 'Seed JSN concluído.' );
}
