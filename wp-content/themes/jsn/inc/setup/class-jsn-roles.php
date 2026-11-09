<?php
/**
 * Papéis customizados do portal JSN.
 *
 * Nesta fase apenas registramos os papéis (specs). As capacidades são
 * intencionalmente vazias e podem ser definidas na fase 2 via filtro.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra os papéis do projeto.
 */
final class JSN_Roles {

	/**
	 * Especificação dos papéis.
	 *
	 * @var array<string,string>
	 */
	public const ROLE_SPECS = array(
		'jsn_sindico'    => 'Síndico',
		'jsn_consultor'  => 'Consultor',
		'jsn_consolidado' => 'Consolidado',
	);

	/**
	 * Cria os papéis se ainda não existirem.
	 *
	 * @return void
	 */
	public static function register() {
		$specs = (array) apply_filters( 'jsn_role_specs', self::ROLE_SPECS );

		foreach ( $specs as $role => $label ) {
			if ( get_role( $role ) ) {
				continue;
			}

			$capabilities = (array) apply_filters( 'jsn_role_capabilities', array(), $role );
			add_role( $role, $label, $capabilities );
		}
	}
}
