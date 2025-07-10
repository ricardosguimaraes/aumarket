<?php

namespace Tangibledesign\Framework\Core\Menu;

use Walker_Nav_Menu;
use WP_Post;

class MenuWalker extends Walker_Nav_Menu {
	/**
	 * @var int
	 */
	public static $counter = 0;

	/**
	 * @var array
	 */
	private $args;

	public function __construct( array $args = [] ) {
		self::$counter ++;

		$this->args = $args;
	}

	/**
	 * @param string $output
	 * @param WP_Post $item
	 * @param int $depth
	 * @param array $args
	 * @param int $id
	 *
	 * @noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ): void {
		global ${tdf_short_prefix() . 'MenuElement'};
		${tdf_short_prefix() . 'MenuElement'} = new MenuElement( $item, $depth, self::$counter, $this->args );
		ob_start();
		get_template_part( $this->getTemplatePath() . 'item', 'start' );
		$output .= ob_get_clean();
	}

	/**
	 * @param string $output
	 * @param WP_Post $item
	 * @param int $depth
	 * @param array $args
	 *
	 * @noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function end_el( &$output, $item, $depth = 0, $args = [] ): void {
		global ${tdf_short_prefix() . 'MenuElement'};
		${tdf_short_prefix() . 'MenuElement'} = new MenuElement( $item, $depth, self::$counter, $this->args );
		ob_start();
		get_template_part( $this->getTemplatePath() . 'item', 'end' );
		$output .= ob_get_clean();
	}

	/**
	 * @param string $output
	 * @param int $depth
	 * @param array $args
	 */
	public function start_lvl( &$output, $depth = 0, $args = [] ): void {
		global ${tdf_short_prefix() . 'MenuLevel'};
		${tdf_short_prefix() . 'MenuLevel'} = new MenuLevel( $depth, $this->args );
		ob_start();
		get_template_part( $this->getTemplatePath() . 'level', 'start' );
		$output .= ob_get_clean();
	}

	/**
	 * @param string $output
	 * @param int $depth
	 * @param array $args
	 */
	public function end_lvl( &$output, $depth = 0, $args = [] ): void {
		global ${tdf_short_prefix() . 'MenuLevel'};
		${tdf_short_prefix() . 'MenuLevel'} = new MenuLevel( $depth, $this->args );
		ob_start();
		get_template_part( $this->getTemplatePath() . 'level', 'end' );
		$output .= ob_get_clean();
	}

	private function getTemplatePath(): string {
		return $this->args['template_path'] ?? 'templates/widgets/general/menu/';
	}
}