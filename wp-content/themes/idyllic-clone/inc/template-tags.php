<?php
/**
 * Idyllic Clone — funções auxiliares de template.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'jsn_idyllic_clone_icon' ) ) {
	/**
	 * Imprime um ícone SVG inline (biblioteca própria, sem CDN).
	 *
	 * @param string $name Nome do ícone.
	 * @return void
	 */
	function jsn_idyllic_clone_icon( $name ) {
		echo jsn_idyllic_clone_get_icon( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- conteúdo estático interno.
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_icon' ) ) {
	/**
	 * Retorna um ícone SVG inline.
	 *
	 * @param string $name Nome do ícone.
	 * @return string
	 */
	function jsn_idyllic_clone_get_icon( $name ) {
		$svg = '<svg class="idyllic-icon" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/></svg>';

		/**
		 * Biblioteca de ícones própria (formas geométricas simples e originais).
		 * Substituível por qualquer biblioteca licenciada via filtro abaixo.
		 */
		$icons = array(
			'map-marker'    => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 4.5 4.4 10.6 6.6 11.8a1 1 0 0 0 1.5 0C14.6 19.6 19 13.5 19 9a7 7 0 0 0-7-7z" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="9" r="2.4" fill="currentColor"/></svg>',
			'phone'         => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><rect x="6" y="2" width="12" height="20" rx="2.5" fill="none" stroke="currentColor" stroke-width="2"/><line x1="10" y1="19" x2="14" y2="19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
			'envelope'      => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><rect x="2.5" y="5" width="19" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="m3.5 6.5 8.5 6.5 8.5-6.5" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
			'search'        => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="currentColor" stroke-width="2.4"/><line x1="15.5" y1="15.5" x2="21" y2="21" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>',
			'chevron-up'    => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><polyline points="4,15 12,7 20,15" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
			'chevron-left'  => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><polyline points="15,4 7,12 15,20" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
			'chevron-right' => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><polyline points="9,4 17,12 9,20" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
			'briefcase'     => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><rect x="3" y="7.5" width="18" height="12.5" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M9 7.5V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2.5" fill="none" stroke="currentColor" stroke-width="2"/><line x1="3" y1="12.5" x2="21" y2="12.5" stroke="currentColor" stroke-width="2"/></svg>',
			'chart'         => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><rect x="3" y="12" width="4" height="9" rx="1" fill="currentColor"/><rect x="10" y="7" width="4" height="14" rx="1" fill="currentColor"/><rect x="17" y="3" width="4" height="18" rx="1" fill="currentColor"/></svg>',
			'trending'      => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><polyline points="3,17 9,11 13,15 21,6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/><polyline points="15,6 21,6 21,12" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
			'box'           => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><path d="M12 3 3 7.5v9L12 21l9-4.5v-9z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M3 7.5 12 12l9-4.5M12 12v9" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
			'cog'           => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><circle cx="12" cy="12" r="4.2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 2.8v3M12 18.2v3M21.2 12h-3M5.8 12h-3M18.5 5.5l-2.1 2.1M7.6 16.4l-2.1 2.1M18.5 18.5l-2.1-2.1M7.6 7.6 5.5 5.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
			'wrench'        => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><path d="M14.7 4.5a5 5 0 0 0-6.6 6.6L4 15.2a2.4 2.4 0 0 0 3.4 3.4l4-4a5 5 0 0 0 6.7-6.6l-2.8 2.8-2.5-2.5z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
			'shield'        => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><path d="M12 2.5 4.5 5v6c0 5 3.2 9 7.5 10.5 4.3-1.5 7.5-5.5 7.5-10.5V5z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><polyline points="8.6,11.4 11,13.8 15.4,8.8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
			'star'          => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="38" height="38" aria-hidden="true"><polygon points="12,2.6 15,8.8 22,9.7 17,14.4 18.3,21.3 12,17.9 5.7,21.3 7,14.4 2,9.7 9,8.8" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
			'quote'         => '<svg class="idyllic-icon" viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><path d="M5 13v2a4 4 0 0 0 4 4V11H5zm10 0v2a4 4 0 0 0 4 4V11h-4z" fill="currentColor"/></svg>',
		);

		/**
		 * Permite adicionar/substituir ícones.
		 *
		 * @param array<string,string> $icons Mapa slug => svg.
		 */
		$icons = apply_filters( 'jsn_idyllic_clone_icons', $icons, $name );

		return isset( $icons[ $name ] ) ? $icons[ $name ] : $svg;
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_post_meta' ) ) {
	/**
	 * Meta do post (autor e data) no padrão do layout.
	 *
	 * @return void
	 */
	function jsn_idyllic_clone_post_meta() {
		?>
		<div class="entry-meta">
			<span class="author vcard">
				<?php esc_html_e( 'Postado por', 'jsn-idyllic-clone' ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
			</span>
			<span class="posted-on">
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_date() ); ?></a>
			</span>
		</div>
		<?php
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_entry_header' ) ) {
	/**
	 * Cabeçalho de listagem (categorias + título).
	 *
	 * @return void
	 */
	function jsn_idyllic_clone_entry_header() {
		?>
		<header class="entry-header">
			<div class="entry-meta">
				<?php
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
					echo '<span class="cat-links"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" rel="category tag">' . esc_html( $categories[0]->name ) . '</a></span>';
				}
				?>
			</div>
			<h2 class="entry-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
			<?php jsn_idyllic_clone_post_meta(); ?>
		</header>
		<?php
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_social_links' ) ) {
	/**
	 * Menu de redes sociais (usa posição "social" com fallback para links do Customizer).
	 *
	 * @return void
	 */
	function jsn_idyllic_clone_social_links() {
		if ( has_nav_menu( 'social' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'social',
				'menu_class'     => 'menu',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => false,
			) );
			return;
		}

		$raw_links = get_theme_mod( 'jsn_idyllic_topbar_social', '' );

		if ( '' === trim( (string) $raw_links ) ) {
			return;
		}

		echo '<ul class="menu">';
		foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw_links ) as $line ) {
			$line = trim( $line );

			if ( '' === $line ) {
				continue;
			}

			$parts = array_map( 'trim', explode( '|', $line, 3 ) );
			$label = $parts[0];
			$url   = isset( $parts[1] ) ? $parts[1] : '';

			if ( '' === $url ) {
				continue;
			}

			printf(
				'<li><a href="%1$s"%3$s><span class="screen-reader-text">%2$s</span>%2$s</a></li>',
				esc_url( $url ),
				esc_html( $label ),
				'https' === wp_parse_url( $url, PHP_URL_SCHEME ) ? ' target="_blank" rel="noopener"' : ''
			);
		}
		echo '</ul>';
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_viewport_placeholder' ) ) {
	/**
	 * Placeholder estático (SVG grid) para imagens via Customizer.
	 *
	 * @return string URL.
	 */
	function jsn_idyllic_clone_placeholder() {
		return JSN_IDYLLIC_CLONE_URI . '/assets/images/placeholder.svg';
	}
}
