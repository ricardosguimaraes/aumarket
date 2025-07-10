<?php

namespace Tangibledesign\Framework\Core\Menu;

use Tangibledesign\Framework\Models\Post\PostModel;
use WP_Post;

class MenuElement extends PostModel {
	/**
	 * @var int
	 */
	protected $depth;

	/**
	 * @var int
	 */
	protected $counter;

	/**
	 * @var array
	 */
	private $args;

	/**
	 * @param WP_Post $post
	 * @param int $depth
	 * @param int $counter
	 * @param array $args
	 */
	public function __construct( WP_Post $post, int $depth = 0, int $counter = 1, array $args = [] ) {
		parent::__construct( $post );

		$this->depth = $depth;

		$this->counter = $counter;

		$this->args = $args;
	}

	public function getName(): string {
		if ( property_exists( $this->post, 'title' ) ) {
			return $this->post->title;
		}

		return $this->post->post_title;
	}

	/**
	 * @return false|mixed|string
	 * @noinspection PhpUndefinedFieldInspection
	 */
	public function getLink() {
		return $this->post->url;
	}

	public function getDepth(): int {
		return $this->depth;
	}

	public function getElementId(): string {
		return 'menu-item-' . $this->counter . '-' . $this->post->ID;
	}

	public function getClass(): string {
		$classes   = ! empty( $this->post->classes ) ? $this->post->classes : [];
		$classes[] = 'menu-item-' . $this->getId();

		if ( isset( $this->args['menu_element_class'] ) ) {
			$classes[] = $this->args['menu_element_class'];
		}

		if ( isset( $this->args['menu_element_depth_classes'] ) && is_array( $this->args['menu_element_depth_classes'] ) ) {
			foreach ( $this->args['menu_element_depth_classes'] as $class ) {
				$classes[] = $class . $this->getDepth();
			}
		}

		return implode(
			' ',
			apply_filters( 'nav_menu_css_class',
				array_filter( $classes ),
				$this->post,
				[],
				$this->depth
			)
		);
	}

	public function isTargetBlank(): bool {
		return $this->getMeta( '_menu_item_target' ) === '_blank';
	}
}