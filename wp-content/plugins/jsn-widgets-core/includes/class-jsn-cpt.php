<?php
/**
 * CPTs e taxonomias do projeto JSN.
 *
 * @package JSN_Widgets_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra os tipos de conteúdo de dados.
 */
final class JSN_CPT {

	/**
	 * Registra CPTs e taxonomias.
	 *
	 * @return void
	 */
	public function register() {
		$this->register_servicos();
		$this->register_noticias();
	}

	/**
	 * CPT de serviços.
	 *
	 * @return void
	 */
	private function register_servicos() {
		register_post_type(
			'servico',
			array(
				'labels'       => array(
					'name'          => __( 'Serviços', 'jsn-widgets-core' ),
					'singular_name' => __( 'Serviço', 'jsn-widgets-core' ),
					'add_new_item'  => __( 'Adicionar serviço', 'jsn-widgets-core' ),
					'edit_item'     => __( 'Editar serviço', 'jsn-widgets-core' ),
					'view_item'     => __( 'Ver serviço', 'jsn-widgets-core' ),
					'search_items'  => __( 'Pesquisar serviços', 'jsn-widgets-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-admin-tools',
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
				'rewrite'      => array( 'slug' => 'servicos' ),
			)
		);

		register_taxonomy(
			'categoria_servico',
			array( 'servico' ),
			array(
				'labels'       => array(
					'name'          => __( 'Categorias de serviços', 'jsn-widgets-core' ),
					'singular_name' => __( 'Categoria de serviço', 'jsn-widgets-core' ),
				),
				'public'       => true,
				'hierarchical' => true,
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * CPT de notícias do condomínio.
	 *
	 * @return void
	 */
	private function register_noticias() {
		register_post_type(
			'noticia_condominio',
			array(
				'labels'       => array(
					'name'          => __( 'Notícias do condomínio', 'jsn-widgets-core' ),
					'singular_name' => __( 'Notícia do condomínio', 'jsn-widgets-core' ),
					'add_new_item'  => __( 'Adicionar notícia', 'jsn-widgets-core' ),
					'edit_item'     => __( 'Editar notícia', 'jsn-widgets-core' ),
					'view_item'     => __( 'Ver notícia', 'jsn-widgets-core' ),
					'search_items'  => __( 'Pesquisar notícias', 'jsn-widgets-core' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-megaphone',
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
				'rewrite'      => array( 'slug' => 'noticias' ),
			)
		);

		register_taxonomy(
			'categoria_noticia',
			array( 'noticia_condominio' ),
			array(
				'labels'       => array(
					'name'          => __( 'Categorias de notícias', 'jsn-widgets-core' ),
					'singular_name' => __( 'Categoria de notícia', 'jsn-widgets-core' ),
				),
				'public'       => true,
				'hierarchical' => true,
				'show_in_rest' => true,
			)
		);
	}
}
