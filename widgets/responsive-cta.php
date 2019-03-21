<?php

namespace S4LPluginLibrary\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly.

class Responsive_CTA extends Widget_Base {

		/**
	 * Get widget name.
	 *
	 * Retrieve HTML widget name.
	 *
	 * @since 0.4
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'responsive-cta';
	}

		/**
	 * Get widget title.
	 *
	 * Retrieve HTML widget title.
	 *
	 * @since 0.4
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Responsive CTA',	's4l-plugin-library' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve HTML widget icon.
	 *
	 * @since 0.4
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-coding';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 0.4
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 's4l-main' ];
	}

	/**
	 * Get button sizes.
	 *
	 * Retrieve an array of button sizes for the button widget.
	 *
	 * @since 0.4
	 * @access public
	 * @static
	 *
	 * @return array An array containing button sizes.
	 */
	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'elementor' ),
			'sm' => __( 'Small', 'elementor' ),
			'md' => __( 'Medium', 'elementor' ),
			'lg' => __( 'Large', 'elementor' ),
			'xl' => __( 'Extra Large', 'elementor' ),
		];
	}

	/**
	 * Register the HTML widget controls
	 * A
	 * Adds all the input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 0.4
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 's4l-plugin-library' ),
			]
			);

			$this->add_control(
				'text',
				[
					'label' => __( 'Text', 's4l-plugin-library' ),
					'type'  => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => __( 'Click Here', 's4l-plugin_library'),
					'placeholder' => __( 'Click Here', 's4l-plugin-library' )
				]
			);

			$this->add_control(
				'link',
				[
					'label' => __( 'Link', 's4l-plugin-library' ),
					'type' => Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'https://your-link.com', 's4l-plugin-library' ),
					'default' => [
						'url' => '#',
					],
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 's4l-plugin-library' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
							'title' => __( 'Left', 's4l-plugin-library' ),
							'icon' => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 's4l-plugin-library' ),
							'icon' => 'fa fa-align-center',
						],
						'right' => [
							'title' => __( 'Right', 's4l-plugin-library' ),
							'icon' => 'fa fa-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 's4l-plugin-library' ),
							'icon' => 'fa fa-align-justify',
						],
					],
					'prefix_class' => 's4l-plugin-library%s-align-',
					'default' => '',
				]
			);

			$this->add_control(
				'size',
				[
					'label' => __( 'Size', 's4l-plugin-library' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => self::get_button_sizes(),
					'style_transfer' => true,
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => __( 'Icon', 's4l-plugin-library' ),
					'type' => Controls_Manager::ICON,
					'label_block' => true,
					'default' => '',
				]
			);

			$this->add_control(
				'icon_align',
				[
					'label' => __( 'Icon Position', 's4l-plugin-library' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'left',
					'options' => [
						'left' => __( 'Before', 's4l-plugin-library' ),
						'right' => __( 'After', 's4l-plugin-library' ),
					],
					'condition' => [
						'icon!' => '',
					],
				]
			);

			$this->add_control(
				'icon_indent',
				[
					'label' => __( 'Icon Spacing', 's4l-plugin-library' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'condition' => [
						'icon!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .s4l-plugin-library-button .s4l-plugin-library-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .s4l-plugin-library-button .s4l-plugin-library-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'view',
				[
					'label' => __( 'View', 's4l-plugin-library' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => 'traditional',
				]
			);

			$this->add_control(
				'button_css_id',
				[
					'label' => __( 'Button ID', 's4l-plugin-library' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
					'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 's4l-plugin-library' ),
					'label_block' => false,
					'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 's4l-plugin-library' ),
					'separator' => 'before',

				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_style',
				[
					'label' => __( 'Button', 's4l-plugin-library' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography',
					'scheme' => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} a.s4l-plugin-library-button, {{WRAPPER}} .s4l-plugin-library-button',
				]
			);

			$this->start_controls_tabs( 'tabs_button_style' );

			$this->start_controls_tab(
				'tab_button_normal',
				[
					'label' => __( 'Normal', 's4l-plugin-library' ),
				]
			);

			$this->add_control(
				'button_text_color',
				[
					'label' => __( 'Text Color', 's4l-plugin-library' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} a.s4l-plugin-library-button, {{WRAPPER}} .s4l-plugin-library-button' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'background_color',
				[
					'label' => __( 'Background Color', 's4l-plugin-library' ),
					'type' => Controls_Manager::COLOR,
					'scheme' => [
						'type' => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} a.s4l-plugin-library-button, {{WRAPPER}} .s4l-plugin-library-button' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_button_hover',
				[
					'label' => __( 'Hover', 's4l-plugin-library' ),
				]
			);

			$this->add_control(
				'hover_color',
				[
					'label' => __( 'Text Color', 's4l-plugin-library' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.s4l-plugin-library-button:hover, {{WRAPPER}} .s4l-plugin-library-button:hover, {{WRAPPER}} a.s4l-plugin-library-button:focus, {{WRAPPER}} .s4l-plugin-library-button:focus' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_background_hover_color',
				[
					'label' => __( 'Background Color', 's4l-plugin-library' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.s4l-plugin-library-button:hover, {{WRAPPER}} .s4l-plugin-library-button:hover, {{WRAPPER}} a.s4l-plugin-library-button:focus, {{WRAPPER}} .s4l-plugin-library-button:focus' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_hover_border_color',
				[
					'label' => __( 'Border Color', 's4l-plugin-library' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'border_border!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} a.s4l-plugin-library-button:hover, {{WRAPPER}} .s4l-plugin-library-button:hover, {{WRAPPER}} a.s4l-plugin-library-button:focus, {{WRAPPER}} .s4l-plugin-library-button:focus' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'hover_animation',
				[
					'label' => __( 'Hover Animation', 's4l-plugin-library' ),
					'type' => Controls_Manager::HOVER_ANIMATION,
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'selector' => '{{WRAPPER}} .s4l-plugin-library-button',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'border_radius',
				[
					'label' => __( 'Border Radius', 's4l-plugin-library' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} a.s4l-plugin-library-button, {{WRAPPER}} .s4l-plugin-library-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'button_box_shadow',
					'selector' => '{{WRAPPER}} .s4l-plugin-library-button',
				]
			);

			$this->add_responsive_control(
				'text_padding',
				[
					'label' => __( 'Padding', 's4l-plugin-library' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} a.s4l-plugin-library-button, {{WRAPPER}} .s4l-plugin-library-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);

			$this->end_controls_section();
		}

		/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.4
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 's4l-plugin-library-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
			$this->add_render_attribute( 'button', 'class', 's4l-plugin-library-button-link' );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}

		$this->add_render_attribute( 'button', 'class', 's4l-plugin-library-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 's4l-plugin-library-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 's4l-plugin-library-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render button widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 0.4
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		view.addRenderAttribute( 'text', 'class', 's4l-plugin-library-button-text' );

		view.addInlineEditingAttributes( 'text', 'none' );
		#>
		<div class="s4l-plugin-library-button-wrapper">
			<a id="{{ settings.button_css_id }}" class="s4l-plugin-library-button s4l-plugin-library-size-{{ settings.size }} s4l-plugin-library-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}" role="button">
				<span class="s4l-plugin-library-button-content-wrapper">
					<# if ( settings.icon ) { #>
					<span class="s4l-plugin-library-button-icon s4l-plugin-library-align-icon-{{ settings.icon_align }}">
						<i class="{{ settings.icon }}" aria-hidden="true"></i>
					</span>
					<# } #>
					<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
				</span>
			</a>
		</div>
		<?php
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since 0.4
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 's4l-plugin-library-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					's4l-plugin-library-button-icon',
					's4l-plugin-library-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 's4l-plugin-library-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
		</span>
		<?php
	}
}