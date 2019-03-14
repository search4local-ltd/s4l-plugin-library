<?php
namespace S4LPluginLibrary\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Copyright_Text extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve HTML widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'copyright-text';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve HTML widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Copyright Text',	's4l-plugin-library' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve HTML widget icon.
	 *
	 * @since 1.0.0
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
	 * @since 1.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 's4l-main' ];
	}

	/**
	 * Register HTML widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 's4l-plugin-library' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Color control for the standard text in the widget
		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 's4l-plugin-library' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'.all' => 'color: {{VALUE}}',
				],
			]
		);

		// Color control for the links in widget
		$this->add_control(
			'link_color',
			[
				'label' => __( 'Link Color', 's4l-plugin-library' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'.link' => 'color: {{VALUE}}',
				],
			]
		);

		// Text control for Company Name
		$this->add_control(
			'company',
			[
				'label' => __( 'Company Name', 's4l-plugin-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter company name', 's4l-plugin-library' ),
				'default' => __( 'Search 4 Local', 's4l-plugin-library' ),
			]
		);

		// Text control for company area
		$this->add_control(
			'area',
			[
				'label' => __( 'Company Area', 's4l-plugin-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your title', 's4l-plugin-library' ),
				'default' => __( 'Exeter', 's4l-plugin-library' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_type',
			[
				'label' 	=> __( 'Typography', 's4l-plugin-library' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
		);

		// Group control for the Typography for the whole widget
			$this->add_group_control(
			Group_Control_Typography::get_type(),
				[
					'name' 		=> 'typography',
					'scheme' 	=> Scheme_Typography::TYPOGRAPHY_1,
					'selector' 	=> '{{WRAPPER}} .text',
				]
			);

		$this->end_controls_section();
	}

		/**
		 * Render HTML widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<span id="footer-copy" class="all text" style="color:<?php echo $settings['text_color']?>;"> ©
			<span id="copy-date" class="text"></span> ·
			<a href="/" class="link text" style="color:<?php echo $settings['link_color']?>;">
				<span <?php echo $this->get_render_attribute_string( 'company' ); ?>> <?php echo $settings['company']; ?></span>
			</a>
			-
			<a class="link text" style="color:<?php echo $settings['link_color']?>;" href="https://www.search4local.co.uk/website-design" target="_blank" rel="noopener">
				<span class="all text" <?php echo $this->get_render_attribute_string( 'area' ); ?>> <?php echo $settings['area']; ?></span> Web Design by Search4Local
			</a>
			<span style="float:right;text-align:right">
				<a href="/cookie-privacy-policy"  class="link text" style="color:<?php echo $settings['link_color']?>;">
					Cookie &amp; Privacy Policy
				</a>
				-
				<a href="/sitemap_index.xml"  class="link text" style="color:<?php echo $settings['link_color']?>;">
					Sitemap
				</a>
			</span>
		<script>
			var date = new Date().getFullYear();
			document.getElementById("copy-date").innerHTML = date;
		</script>
		</span>
		<?php
	}

		/**
	 * Render HTML widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		view.addInlineEditingAttributes( 'company', 'none' );
		view.addInlineEditingAttributes( 'area', 'none' );
		#>
		<span id="footer-copy" class="all" style="color:{{ settings.text_color}};font-family:sans-serif;font-size:14px"> ©
			<span id="copy-date"></span> ·
			<a href="/"  class="link" style="color:{{ settings.link_color}};text-decoration:none">
				<span {{{ view.getRenderAttributeString( 'company' ) }}}>{{{ settings.company }}}</span>
			</a>
			 -
			<a  class="link" style="color:{{ settings.link_color}};text-decoration:none" href="https://www.search4local.co.uk/website-design" target="_blank" rel="noopener">
				<span {{{ view.getRenderAttributeString( 'area' ) }}}>{{{ settings.area }}}</span> Web Design by Search4Local
			</a>
			<span style="float:right;text-align:right">
				<a href="/cookie-privacy-policy"  class="link" style="color:{{ settings.link_color}};text-decoration:none">
					Cookie &amp; Privacy Policy
				</a>
				-
				<a href="/sitemap_index.xml"  class="link" style="color:{{ settings.link_color}};text-decoration:none">
					Sitemap
				</a>
			</span>
		<script>
			var date = new Date().getFullYear();
			document.getElementById("copy-date").innerHTML = date;
		</script>
		</span>

		<?php
	}
}