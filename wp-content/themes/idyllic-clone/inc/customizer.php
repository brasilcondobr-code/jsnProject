<?php
/**
 * Idyllic Clone — Customizer.
 *
 * Painel da front-page com: cores, top bar, hero slider, features, services,
 * CTA, about, stats, team, testimonials e blog + ativo/desativo por seção.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'jsn_idyllic_clone_customize_register' ) ) {
	/**
	 * Registra painéis, seções, settings e controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Manager.
	 * @return void
	 */
	function jsn_idyllic_clone_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		/* ---------------------------------------------------------------
		 * Painel principal
		 * --------------------------------------------------------------- */
		$wp_customize->add_panel( 'jsn_idyllic_front', array(
			'title'       => __( 'Idyllic Clone — Página Inicial', 'jsn-idyllic-clone' ),
			'priority'    => 30,
			'description' => __( 'Conteúdo e exibição das seções da página inicial.', 'jsn-idyllic-clone' ),
		) );

		/* ---------------------------------------------------------------
		 * Cores
		 * --------------------------------------------------------------- */
		$wp_customize->add_section( 'jsn_idyllic_colors', array(
			'title'    => __( 'Cores do Tema', 'jsn-idyllic-clone' ),
			'priority' => 20,
		) );

		$wp_customize->add_setting( 'jsn_idyllic_color_primary', array(
			'default'           => '#46c5d4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'jsn_idyllic_color_primary', array(
			'label'   => __( 'Cor primária', 'jsn-idyllic-clone' ),
			'section' => 'jsn_idyllic_colors',
		) ) );

		$wp_customize->add_setting( 'jsn_idyllic_color_accent', array(
			'default'           => '#ff4530',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'jsn_idyllic_color_accent', array(
			'label'   => __( 'Cor de destaque (CTA)', 'jsn-idyllic-clone' ),
			'section' => 'jsn_idyllic_colors',
		) ) );

		/* ---------------------------------------------------------------
		 * Comportamento do header
		 * --------------------------------------------------------------- */
		$wp_customize->add_section( 'jsn_idyllic_header', array(
			'title'    => __( 'Header', 'jsn-idyllic-clone' ),
			'panel'    => 'jsn_idyllic_front',
		) );

		$wp_customize->add_setting( 'jsn_idyllic_header_sticky', array(
			'default'           => true,
			'sanitize_callback' => 'jsn_idyllic_clone_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'jsn_idyllic_header_sticky', array(
			'label'   => __( 'Header fixo (sticky) ao rolar', 'jsn-idyllic-clone' ),
			'type'    => 'checkbox',
			'section' => 'jsn_idyllic_header',
		) );

		/* ---------------------------------------------------------------
		 * Top bar
		 * --------------------------------------------------------------- */
		$wp_customize->add_section( 'jsn_idyllic_topbar', array(
			'title' => __( 'Top Bar (contato e redes)', 'jsn-idyllic-clone' ),
			'panel' => 'jsn_idyllic_front',
		) );

		$wp_customize->add_setting( 'jsn_idyllic_show_topbar', array(
			'default'           => true,
			'sanitize_callback' => 'jsn_idyllic_clone_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'jsn_idyllic_show_topbar', array(
			'label'   => __( 'Exibir top bar', 'jsn-idyllic-clone' ),
			'type'    => 'checkbox',
			'section' => 'jsn_idyllic_topbar',
		) );

		$topbar_fields = array(
			'topbar_address' => array( __( 'Endereço', 'jsn-idyllic-clone' ), 'text' ),
			'topbar_phone'   => array( __( 'Telefone (ex.: (11) 99999-9999)', 'jsn-idyllic-clone' ), 'text' ),
			'topbar_email'   => array( __( 'E-mail', 'jsn-idyllic-clone' ), 'email' ),
			'topbar_social'  => array(
				/* translators: %s: separador */
				sprintf( __( 'Redes sociais — uma por linha, formato%sNome | https://url', 'jsn-idyllic-clone' ), ' ' ),
				'textarea',
			),
		);

		foreach ( $topbar_fields as $key => $data ) {
			list( $label, $type ) = $data;

			$wp_customize->add_setting( 'jsn_idyllic_' . $key, array(
				'default'           => '',
				'sanitize_callback' => 'textarea' === $type ? 'jsn_idyllic_clone_sanitize_social' : 'sanitize_text_field',
			) );

			$wp_customize->add_control( 'jsn_idyllic_' . $key, array(
				'label'   => $label,
				'type'    => $type,
				'section' => 'jsn_idyllic_topbar',
			) );
		}

		/* ---------------------------------------------------------------
		 * Hero slider (3 slides)
		 * --------------------------------------------------------------- */
		$wp_customize->add_section( 'jsn_idyllic_hero', array(
			'title' => __( 'Hero Slider', 'jsn-idyllic-clone' ),
			'panel' => 'jsn_idyllic_front',
		) );

		$wp_customize->add_setting( 'jsn_idyllic_show_hero', array(
			'default'           => true,
			'sanitize_callback' => 'jsn_idyllic_clone_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'jsn_idyllic_show_hero', array(
			'label'       => __( 'Exibir hero slider', 'jsn-idyllic-clone' ),
			'type'        => 'checkbox',
			'section'     => 'jsn_idyllic_hero',
		) );

		$wp_customize->add_setting( 'jsn_idyllic_hero_autoplay', array(
			'default'           => true,
			'sanitize_callback' => 'jsn_idyllic_clone_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'jsn_idyllic_hero_autoplay', array(
			'label'   => __( 'Slides em rotação automática', 'jsn-idyllic-clone' ),
			'type'    => 'checkbox',
			'section' => 'jsn_idyllic_hero',
		) );

		for ( $i = 1; $i <= 3; $i++ ) {
			$slide_fields = array(
				sprintf( 'hero%1$d_subtitle', $i ) => array( sprintf( __( 'Slide %1$d — Linha de apoio', 'jsn-idyllic-clone' ), $i ), 'text' ),
				sprintf( 'hero%1$d_title', $i )    => array( sprintf( __( 'Slide %1$d — Título', 'jsn-idyllic-clone' ), $i ), 'text' ),
				sprintf( 'hero%1$d_button_text', $i ) => array( sprintf( __( 'Slide %1$d — Texto do botão', 'jsn-idyllic-clone' ), $i ), 'text' ),
				sprintf( 'hero%1$d_button_url', $i )  => array( sprintf( __( 'Slide %1$d — Link do botão', 'jsn-idyllic-clone' ), $i ), 'url' ),
				sprintf( 'hero%1$d_image', $i )    => array( sprintf( __( 'Slide %1$d — Imagem de fundo (URL)', 'jsn-idyllic-clone' ), $i ), 'url' ),
			);

			foreach ( $slide_fields as $key => $data ) {
				$wp_customize->add_setting( 'jsn_idyllic_' . $key, array(
					'default'           => '',
					'sanitize_callback' => 'url' === $data[1] ? 'esc_url_raw' : 'sanitize_text_field',
				) );

				$wp_customize->add_control( 'jsn_idyllic_' . $key, array(
					'label'   => $data[0],
					'type'    => 'url' === $data[1] ? 'url' : 'text',
					'section' => 'jsn_idyllic_hero',
				) );
			}
		}

		/* ---------------------------------------------------------------
		 * Seções simples com toggle + campos repedidos
		 * --------------------------------------------------------------- */
		$sections = array(
			'features'     => __( 'Features (8 cards)', 'jsn-idyllic-clone' ),
			'services'     => __( 'Serviços (4 cards) — opcional', 'jsn-idyllic-clone' ),
			'cta'          => __( 'CTA Banner — opcional', 'jsn-idyllic-clone' ),
			'about'        => __( 'Sobre (About)', 'jsn-idyllic-clone' ),
			'stats'        => __( 'Contadores (Stats) — opcional', 'jsn-idyllic-clone' ),
			'team'         => __( 'Equipe', 'jsn-idyllic-clone' ),
			'testimonials' => __( 'Depoimentos', 'jsn-idyllic-clone' ),
			'blog'         => __( 'Blog — Útimos posts', 'jsn-idyllic-clone' ),
		);

		/* Seções fora do layout do demo de referência: desligadas por padrão. */
		$section_defaults = array(
			'services' => false,
			'cta'      => false,
			'stats'    => false,
		);

		foreach ( $sections as $section_key => $section_label ) {
			$wp_customize->add_section( 'jsn_idyllic_' . $section_key, array(
				'title' => $section_label,
				'panel' => 'jsn_idyllic_front',
			) );

			$wp_customize->add_setting( 'jsn_idyllic_show_' . $section_key, array(
				'default'           => isset( $section_defaults[ $section_key ] ) ? $section_defaults[ $section_key ] : true,
				'sanitize_callback' => 'jsn_idyllic_clone_sanitize_checkbox',
			) );
			$wp_customize->add_control( 'jsn_idyllic_show_' . $section_key, array(
				'label'   => __( 'Exibir esta seção', 'jsn-idyllic-clone' ),
				'type'    => 'checkbox',
				'section' => 'jsn_idyllic_' . $section_key,
			) );
		}

		// Título comum às seções listadas.
		foreach ( array( 'features', 'services', 'team', 'testimonials', 'blog' ) as $section_key ) {
			$wp_customize->add_setting( 'jsn_idyllic_' . $section_key . '_title', array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'jsn_idyllic_' . $section_key . '_title', array(
				'label'       => __( 'Título da seção', 'jsn-idyllic-clone' ),
				'type'        => 'text',
				'description' => __( 'Deixe vazio para usar o padrão em português.', 'jsn-idyllic-clone' ),
				'section'     => 'jsn_idyllic_' . $section_key,
			) );
		}

		$wp_customize->add_setting( 'jsn_idyllic_blog_count', array(
			'default'           => 6,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'jsn_idyllic_blog_count', array(
			'label'       => __( 'Quantidade de posts', 'jsn-idyllic-clone' ),
			'type'        => 'number',
			'section'     => 'jsn_idyllic_blog',
			'input_attrs' => array( 'min' => 1, 'max' => 12 ),
		) );

		/* Subtítulos por seção (box-sub-title). */
		foreach ( array( 'blog' => 'jsn_idyllic_blog', 'team' => 'jsn_idyllic_team' ) as $sub_key => $section ) {
			$wp_customize->add_setting( 'jsn_idyllic_' . $sub_key . '_sub', array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'jsn_idyllic_' . $sub_key . '_sub', array(
				'label'   => __( 'Subtítulo da seção', 'jsn-idyllic-clone' ),
				'type'    => 'text',
				'section' => $section,
			) );
		}

		// CTA.
		$cta_fields = array(
			'cta_title'       => array( __( 'Texto principal', 'jsn-idyllic-clone' ), 'text' ),
			'cta_button_text' => array( __( 'Texto do botão', 'jsn-idyllic-clone' ), 'text' ),
			'cta_button_url'  => array( __( 'Link do botão', 'jsn-idyllic-clone' ), 'url' ),
		);
		foreach ( $cta_fields as $key => $data ) {
			$wp_customize->add_setting( 'jsn_idyllic_' . $key, array(
				'default'           => '',
				'sanitize_callback' => 'url' === $data[1] ? 'esc_url_raw' : 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'jsn_idyllic_' . $key, array(
				'label'   => $data[0],
				'type'    => $data[1],
				'section' => 'jsn_idyllic_cta',
			) );
		}

		// About.
		$about_fields = array(
			'about_title'       => array( __( 'Título da seção (box-title)', 'jsn-idyllic-clone' ), 'text' ),
			'about_sub'         => array( __( 'Subtítulo da seção', 'jsn-idyllic-clone' ), 'text' ),
			'about_heading'     => array( __( 'Título', 'jsn-idyllic-clone' ), 'text' ),
			'about_content'     => array( __( 'Texto', 'jsn-idyllic-clone' ), 'textarea' ),
			'about_items'       => array( __( 'Lista de destaques — um por linha', 'jsn-idyllic-clone' ), 'textarea' ),
			'about_image'       => array( __( 'Imagem (URL)', 'jsn-idyllic-clone' ), 'url' ),
			'about_button_text' => array( __( 'Texto do botão', 'jsn-idyllic-clone' ), 'text' ),
			'about_button_url'  => array( __( 'Link do botão', 'jsn-idyllic-clone' ), 'url' ),
		);
		foreach ( $about_fields as $key => $data ) {
			$wp_customize->add_setting( 'jsn_idyllic_' . $key, array(
				'default'           => '',
				'sanitize_callback' => ( 'url' === $data[1] ) ? 'esc_url_raw' : 'jsn_idyllic_clone_sanitize_textarea_wp_kses',
			) );
			$wp_customize->add_control( 'jsn_idyllic_' . $key, array(
				'label'   => $data[0],
				'type'    => ( 'url' === $data[1] ) ? 'url' : ( ( 'textarea' === $data[1] ) ? 'textarea' : 'text' ),
				'section' => 'jsn_idyllic_about',
			) );
		}

		// Grupos repetidos (features 4, services 4, stats 4, team 4, testimonials 3).
		$groups = array(
			'features'     => array(
				'count' => 8,
				'fields'=> array(
					'title' => array( __( 'Título', 'jsn-idyllic-clone' ), 'text' ),
					'text'  => array( __( 'Texto', 'jsn-idyllic-clone' ), 'textarea' ),
					'link'  => array( __( 'Link do card', 'jsn-idyllic-clone' ), 'url' ),
					'icon'  => array( __( 'Ícone (briefcase, cog, shield, star, chart, trending, box, wrench)', 'jsn-idyllic-clone' ), 'text' ),
				),
			),
			'services'     => array(
				'count' => 4,
				'fields'=> array(
					'title' => array( __( 'Título', 'jsn-idyllic-clone' ), 'text' ),
					'text'  => array( __( 'Texto', 'jsn-idyllic-clone' ), 'textarea' ),
					'icon'  => array( __( 'Ícone (briefcase, chart, trending, box, wrench, cog)', 'jsn-idyllic-clone' ), 'text' ),
				),
			),
			'stats'        => array(
				'count' => 4,
				'fields'=> array(
					'number' => array( __( 'Número (contagem final)', 'jsn-idyllic-clone' ), 'number' ),
					'label'  => array( __( 'Rótulo', 'jsn-idyllic-clone' ), 'text' ),
				),
			),
			'team'         => array(
				'count' => 4,
				'fields'=> array(
					'name'  => array( __( 'Nome', 'jsn-idyllic-clone' ), 'text' ),
					'role'  => array( __( 'Cargo', 'jsn-idyllic-clone' ), 'text' ),
					'image' => array( __( 'Foto (URL) opcional', 'jsn-idyllic-clone' ), 'url' ),
				),
			),
			'testimonials' => array(
				'count' => 3,
				'fields'=> array(
					'title'  => array( __( 'Título curto', 'jsn-idyllic-clone' ), 'text' ),
					'quote'  => array( __( 'Depoimento', 'jsn-idyllic-clone' ), 'textarea' ),
					'author' => array( __( 'Autor (Nome, Empresa)', 'jsn-idyllic-clone' ), 'text' ),
					'image'  => array( __( 'Foto (URL) opcional', 'jsn-idyllic-clone' ), 'url' ),
				),
			),
		);

		foreach ( $groups as $group_key => $group ) {
			for ( $i = 1; $i <= $group['count']; $i++ ) {
				foreach ( $group['fields'] as $field => $field_data ) {
					$setting_key = sprintf( '%1$s%2$d_%3$s', $group_key, $i, $field );

					$wp_customize->add_setting( 'jsn_idyllic_' . $setting_key, array(
						'default'           => '',
						'sanitize_callback' => jsn_idyllic_clone_sanitize_by_type( $field_data[1] ),
					) );

					$wp_customize->add_control( 'jsn_idyllic_' . $setting_key, array(
						'label'   => sprintf( '[%1$d] %2$s', $i, $field_data[0] ),
						'type'    => jsn_idyllic_clone_sanitize_type_to_input( $field_data[1] ),
						'section' => 'jsn_idyllic_' . $group_key,
					) );
				}
			}
		}
	}
}
add_action( 'customize_register', 'jsn_idyllic_clone_customize_register' );

/* ==============================
 * Sanitização
 * ============================== */

/**
 * Checkbox booleano.
 *
 * @param mixed $value Valor.
 * @return bool
 */
function jsn_idyllic_clone_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Textarea simples (linhas de texto).
 *
 * @param string $value Valor.
 * @return string
 */
function jsn_idyllic_clone_sanitize_textarea_wp_kses( $value ) {
	return wp_kses_post( (string) $value );
}

/**
 * Lista social: mantém formato "Label | URL".
 *
 * @param string $value Valor.
 * @return string
 */
function jsn_idyllic_clone_sanitize_social( $value ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $value );
	$clean = array();

	foreach ( (array) $lines as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 3 ) );
		$label = sanitize_text_field( $parts[0] );
		$url   = isset( $parts[1] ) ? esc_url_raw( $parts[1] ) : '';

		if ( '' !== $label && '' !== $url ) {
			$clean[] = $label . ' | ' . $url;
		}
	}

	return implode( "\n", $clean );
}

/**
 * Classe estática de sanitização por tipo (usada em loop de grupos).
 */
final class JSN_Idyllic_Clone_Sanitize {

	/**
	 * Retorna callback de sanitize por tipo declarado.
	 *
	 * @param string $type text|textarea|url|number.
	 * @return callable|string
	 */
	public static function callback( $type ) {
		switch ( $type ) {
			case 'url':
				return 'esc_url_raw';
			case 'number':
				return 'absint';
			case 'textarea':
				return 'wp_kses_post';
			default:
				return 'sanitize_text_field';
		}
	}
}

/**
 * Atalho compatível com o loop acima.
 *
 * @param string $type Tipo.
 * @return callable|string
 */
function jsn_idyllic_clone_sanitize_by_type( $type ) {
	return JSN_Idyllic_Clone_Sanitize::callback( $type );
}

/**
 * Converte tipo declarado em input do Customizer.
 *
 * @param string $type Tipo.
 * @return string
 */
function jsn_idyllic_clone_sanitize_type_to_input( $type ) {
	switch ( $type ) {
		case 'url':
			return 'url';
		case 'number':
			return 'number';
		case 'textarea':
			return 'textarea';
		default:
			return 'text';
	}
}

/* ==============================
 * Cores dinâmicas (CSS inline)
 * ============================== */

/**
 * Aplica cores do Customizer em :root.
 *
 * @return void
 */
function jsn_idyllic_clone_inline_css() {
	$primary = sanitize_hex_color( get_theme_mod( 'jsn_idyllic_color_primary', '#46c5d4' ) );
	$accent  = sanitize_hex_color( get_theme_mod( 'jsn_idyllic_color_accent', '#ff4530' ) );

	$css = '';

	if ( $primary && '#46c5d4' !== $primary ) {
		$css .= sprintf( ':root{--id-primary:%s;}', $primary );
	}

	if ( $accent && '#ff4530' !== $accent ) {
		$css .= sprintf( ':root{--id-accent:%s;}', $accent );
	}

	if ( $css ) {
		wp_register_style( 'jsn-idyllic-clone-dynamic', false, array(), JSN_IDYLLIC_CLONE_VERSION );
		wp_enqueue_style( 'jsn-idyllic-clone-dynamic' );
		wp_add_inline_style( 'jsn-idyllic-clone-dynamic', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'jsn_idyllic_clone_inline_css', 20 );

/**
 * Preview seletivo no Customizer.
 *
 * @return void
 */
function jsn_idyllic_clone_customize_preview_js() {
	wp_enqueue_script(
		'jsn-idyllic-clone-customizer',
		JSN_IDYLLIC_CLONE_URI . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		JSN_IDYLLIC_CLONE_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'jsn_idyllic_clone_customize_preview_js' );
