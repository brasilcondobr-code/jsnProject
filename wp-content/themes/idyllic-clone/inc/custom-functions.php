<?php
/**
 * Idyllic Clone — dados das seções da front-page (Customizer com defaults pt-BR).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'jsn_idyllic_clone_get_setting' ) ) {
	/**
	 * Atalho para get_theme_mod com default.
	 *
	 * @param string $key     Chave (sem prefixo).
	 * @param mixed  $default Default.
	 * @return mixed
	 */
	function jsn_idyllic_clone_get_setting( $key, $default = '' ) {
		return get_theme_mod( 'jsn_idyllic_' . $key, $default );
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_is_active' ) ) {
	/**
	 * Seção ativa? (checkbox do Customizer; padrão: ativa)
	 *
	 * Serviços, CTA e contadores não fazem parte do layout do demo de
	 * referência, então o padrão delas é desativado.
	 *
	 * @param string $key Chave da seção.
	 * @return bool
	 */
	function jsn_idyllic_clone_is_active( $key ) {
		$defaults = array(
			'services' => false,
			'cta'      => false,
			'stats'    => false,
		);

		$default = isset( $defaults[ $key ] ) ? $defaults[ $key ] : true;
		$value   = get_theme_mod( 'jsn_idyllic_show_' . $key, $default );
		return (bool) $value;
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_repeat_items' ) ) {
	/**
	 * Retorna N itens repedidos de um padrão de chaves do Customizer.
	 * Ex.: padrão ['%1$s_title', '%1$s_text'] com base 'features' e n=4,
	 * retorna itens com as chaves resolvidas por índice.
	 *
	 * @param string   $base    Base do nome.
	 * @param string[] $keys    Chaves no formato '%1$s_xxx'.
	 * @param int      $count   Quantidade.
	 * @param array<string,array<string,mixed>> $defaults Defaults (índice-chave).
	 * @return array<int,array<string,mixed>>
	 */
	function jsn_idyllic_clone_get_repeat_items( $base, $keys, $count, $defaults = array() ) {
		$items = array();

		for ( $i = 1; $i <= $count; $i++ ) {
			$item = array( '_index' => $i );

			foreach ( $keys as $field => $key_mask ) {
				$item[ $field ] = jsn_idyllic_clone_get_setting( sprintf( $key_mask, $base, $i ), isset( $defaults[ $i ][ $field ] ) ? $defaults[ $i ][ $field ] : '' );
			}

			$empty = true;
			foreach ( $item as $k => $v ) {
				if ( '_index' === $k ) {
					continue;
				}
				if ( ! empty( $v ) ) {
					$empty = false;
				}
			}

			if ( ! $empty ) {
				$items[] = $item;
			}
		}

		return $items;
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_slides' ) ) {
	/**
	 * Slides do hero.
	 *
	 * @return array<int,array<string,mixed>>
	 */
	function jsn_idyllic_clone_get_slides() {
		return jsn_idyllic_clone_get_repeat_items(
			'hero',
			array(
				'title'     => '%1$s%2$d_title',
				'subtitle'  => '%1$s%2$d_subtitle',
				'button'    => '%1$s%2$d_button_text',
				'url'       => '%1$s%2$d_button_url',
				'image'     => '%1$s%2$d_image',
			),
			3,
			array(
				1 => array(
					'subtitle'  => __( 'Soluções para o seu negócio', 'jsn-idyllic-clone' ),
					'title'     => __( 'Resultados com você!', 'jsn-idyllic-clone' ),
					'button'    => __( 'Saiba mais', 'jsn-idyllic-clone' ),
					'image'     => JSN_IDYLLIC_CLONE_URI . '/assets/images/hero-1.svg',
				),
				2 => array(
					'subtitle'  => __( 'Serviços inovadores', 'jsn-idyllic-clone' ),
					'title'     => __( 'Layouts e seções flexíveis', 'jsn-idyllic-clone' ),
					'button'    => __( 'Saiba mais', 'jsn-idyllic-clone' ),
					'image'     => JSN_IDYLLIC_CLONE_URI . '/assets/images/hero-2.svg',
				),
				3 => array(
					'subtitle'  => __( 'Criando momentos com tecnologia', 'jsn-idyllic-clone' ),
					'title'     => __( 'Site completo e editável', 'jsn-idyllic-clone' ),
					'button'    => __( 'Saiba mais', 'jsn-idyllic-clone' ),
					'image'     => JSN_IDYLLIC_CLONE_URI . '/assets/images/hero-3.svg',
				),
			)
		);
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_features' ) ) {
	/**
	 * Cards da seção Features.
	 *
	 * @return array<int,array>
	 */
	function jsn_idyllic_clone_get_features() {
		return jsn_idyllic_clone_get_repeat_items(
			'features',
			array(
				'title' => '%1$s%2$d_title',
				'text'  => '%1$s%2$d_text',
				'link'  => '%1$s%2$d_link',
				'icon'  => '%1$s%2$d_icon',
			),
			8,
			array(
				1 => array(
					'title' => __( 'Design e Construção', 'jsn-idyllic-clone' ),
					'text'  => __( 'Layouts modernos e responsivos, prontos para o seu conteúdo.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'briefcase',
				),
				2 => array(
					'title' => __( 'Fácil Customização', 'jsn-idyllic-clone' ),
					'text'  => __( 'Cores, textos e seções editáveis pelo Customizer do WordPress.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'cog',
				),
				3 => array(
					'title' => __( 'Documentação Completa', 'jsn-idyllic-clone' ),
					'text'  => __( 'Guia de estilo e README explicando tokens e configurações.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'shield',
				),
				4 => array(
					'title' => __( 'Padrões Certificados', 'jsn-idyllic-clone' ),
					'text'  => __( 'Código seguindo os padrões de desenvolvimento do WordPress.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'star',
				),
				5 => array(
					'title' => __( 'Suporte Dedicado', 'jsn-idyllic-clone' ),
					'text'  => __( 'Equipe disponível para auxiliar em cada etapa do projeto.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'wrench',
				),
				6 => array(
					'title' => __( 'Estrutura Modular', 'jsn-idyllic-clone' ),
					'text'  => __( 'Seções independentes que você reordena ou desativa à vontade.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'box',
				),
				7 => array(
					'title' => __( 'Pronto para Tradução', 'jsn-idyllic-clone' ),
					'text'  => __( 'Strings preparadas para internacionalização do conteúdo.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'trending',
				),
				8 => array(
					'title' => __( 'Contato Facilitado', 'jsn-idyllic-clone' ),
					'text'  => __( 'Formulários e canais de atendimento integrados ao tema.', 'jsn-idyllic-clone' ),
					'link'  => '#',
					'icon'  => 'envelope',
				),
			)
		);
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_services' ) ) {
	/**
	 * Cards da seção Services.
	 *
	 * @return array<int,array>
	 */
	function jsn_idyllic_clone_get_services() {
		return jsn_idyllic_clone_get_repeat_items(
			'services',
			array(
				'title' => '%1$s%2$d_title',
				'text'  => '%1$s%2$d_text',
				'icon'  => '%1$s%2$d_icon',
			),
			4,
			array(
				1 => array(
					'title' => __( 'Consultoria Empresarial', 'jsn-idyllic-clone' ),
					'text'  => __( 'Diagnóstico e orientação estratégica para negócios em crescimento.', 'jsn-idyllic-clone' ),
					'icon'  => 'briefcase',
				),
				2 => array(
					'title' => __( 'Aconselhamento Financeiro', 'jsn-idyllic-clone' ),
					'text'  => __( 'Planejamento orçamentário e visibilidade das suas finanças.', 'jsn-idyllic-clone' ),
					'icon'  => 'chart',
				),
				3 => array(
					'title' => __( 'Mercado e Inovação', 'jsn-idyllic-clone' ),
					'text'  => __( 'Acompanhamento de tendências e oportunidades do setor.', 'jsn-idyllic-clone' ),
					'icon'  => 'trending',
				),
				4 => array(
					'title' => __( 'Produtos e Serviços', 'jsn-idyllic-clone' ),
					'text'  => __( 'Suporte dedicado para a operação do seu dia a dia.', 'jsn-idyllic-clone' ),
					'icon'  => 'box',
				),
			)
		);
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_stats' ) ) {
	/**
	 * Contadores do stats.
	 *
	 * @return array<int,array>
	 */
	function jsn_idyllic_clone_get_stats() {
		return jsn_idyllic_clone_get_repeat_items(
			'stats',
			array(
				'number'     => '%1$s%2$d_number',
				'label'      => '%1$s%2$d_label',
			),
			4,
			array(
				1 => array( 'number' => 120, 'label' => __( 'Clientes atendidos', 'jsn-idyllic-clone' ) ),
				2 => array( 'number' => 340, 'label' => __( 'Projetos entregues', 'jsn-idyllic-clone' ) ),
				3 => array( 'number' => 15, 'label' => __( 'Anos de experiência', 'jsn-idyllic-clone' ) ),
				4 => array( 'number' => 98, 'label' => __( 'Satisfação (%)', 'jsn-idyllic-clone' ) ),
			)
		);
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_team' ) ) {
	/**
	 * Membros da equipe.
	 *
	 * @return array<int,array>
	 */
	function jsn_idyllic_clone_get_team() {
		return jsn_idyllic_clone_get_repeat_items(
			'team',
			array(
				'name'  => '%1$s%2$d_name',
				'role'  => '%1$s%2$d_role',
				'image' => '%1$s%2$d_image',
			),
			4,
			array(
				1 => array( 'name' => __( 'Ana Martins', 'jsn-idyllic-clone' ), 'role' => __( 'Diretora Executiva', 'jsn-idyllic-clone' ) ),
				2 => array( 'name' => __( 'Carlos Andrade', 'jsn-idyllic-clone' ), 'role' => __( 'Consultor Sênior', 'jsn-idyllic-clone' ) ),
				3 => array( 'name' => __( 'Beatriz Souza', 'jsn-idyllic-clone' ), 'role' => __( 'Gestora de Projetos', 'jsn-idyllic-clone' ) ),
				4 => array( 'name' => __( 'Rafael Lima', 'jsn-idyllic-clone' ), 'role' => __( 'Analista Financeiro', 'jsn-idyllic-clone' ) ),
			)
		);
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_testimonials' ) ) {
	/**
	 * Depoimentos.
	 *
	 * @return array<int,array>
	 */
	function jsn_idyllic_clone_get_testimonials() {
		return jsn_idyllic_clone_get_repeat_items(
			'testimonials',
			array(
				'title'  => '%1$s%2$d_title',
				'quote'  => '%1$s%2$d_quote',
				'author' => '%1$s%2$d_author',
				'image'  => '%1$s%2$d_image',
			),
			3,
			array(
				1 => array(
					'title'  => __( 'Profissionalismo em cada entrega.', 'jsn-idyllic-clone' ),
					'quote'  => __( '"Equipe comprometida, prazos cumpridos e um atendimento que faz a diferença."', 'jsn-idyllic-clone' ),
					'author' => __( 'Marcos Oliveira, Construtora Horizonte', 'jsn-idyllic-clone' ),
				),
				2 => array(
					'title'  => __( 'Organização e clareza.', 'jsn-idyllic-clone' ),
					'quote'  => __( '"A consultoria trouxe transparência para toda a operação financeira do condomínio."', 'jsn-idyllic-clone' ),
					'author' => __( 'Helena Duarte, Condomínio Verde', 'jsn-idyllic-clone' ),
				),
				3 => array(
					'title'  => __( 'Recomendo sem dúvidas.', 'jsn-idyllic-clone' ),
					'quote'  => __( '"Processos simples, resultados consistentes e suporte sempre disponível."', 'jsn-idyllic-clone' ),
					'author' => __( 'Pedro Almeida, Industrias Norte', 'jsn-idyllic-clone' ),
				),
			)
		);
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_about_data' ) ) {
	/**
	 * Dados da seção About.
	 *
	 * @return array<string,mixed>
	 */
	function jsn_idyllic_clone_get_about_data() {
		return array(
			'title'   => jsn_idyllic_clone_get_setting( 'about_title', __( 'Sobre nós', 'jsn-idyllic-clone' ) ),
			'sub'     => jsn_idyllic_clone_get_setting( 'about_sub', '' ),
			'heading' => jsn_idyllic_clone_get_setting( 'about_heading', __( 'Construa seu site perfeito com nosso tema criativo.', 'jsn-idyllic-clone' ) ),
			'content' => jsn_idyllic_clone_get_setting( 'about_content', __( 'Somos especialistas em gestão administrativa com processos claros, comunicação objetiva e foco em resultados. Nosso time cuida de cada detalhe para você focar no que realmente importa.', 'jsn-idyllic-clone' ) ),
			'items'   => jsn_idyllic_clone_get_setting( 'about_items', __( "Gestão transparente\nComunicação objetiva\nAtendimento próximo\nTecnologia aplicada", 'jsn-idyllic-clone' ) ),
			'image'   => jsn_idyllic_clone_get_setting( 'about_image', JSN_IDYLLIC_CLONE_URI . '/assets/images/about.svg' ),
			'link'    => jsn_idyllic_clone_get_setting( 'about_button_url', '#' ),
			'button'  => jsn_idyllic_clone_get_setting( 'about_button_text', __( 'Saiba mais', 'jsn-idyllic-clone' ) ),
		);
	}
}

if ( ! function_exists( 'jsn_idyllic_clone_get_topbar' ) ) {
	/**
	 * Dados do top bar.
	 *
	 * @return array<string,string>
	 */
	function jsn_idyllic_clone_get_topbar() {
		return array(
			'address' => jsn_idyllic_clone_get_setting( 'topbar_address', __( 'Endereço: Av. Paulista, 1000, São Paulo — SP', 'jsn-idyllic-clone' ) ),
			'phone'   => jsn_idyllic_clone_get_setting( 'topbar_phone', '' ),
			'email'   => jsn_idyllic_clone_get_setting( 'topbar_email', '' ),
		);
	}
}
