<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('elementor/widgets/widgets_registered', function () {
	if (!is_user_logged_in()) {
		return;
	}
	
	class Adv_Vis_Ele_Elementor_Shortcode extends \Elementor\Widget_Base {
		
		public function get_name() {
			return 'adv-vis-ele-select-shortcode';
		}
		
		public function get_title() {
			return __('AVE Shortcode', 'wp-ave');
		}
		
		public function get_icon() {
			return 'eicon-ai';
		}
		
		public function get_categories() {
			return ['general'];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'adv-vis-ele-section_select_shortcodes',
				[
					'label' => __('AVE Shortcodes', 'wp-ave')
				]
			);
			
			$ave_shortcodes = get_posts(['post_type' => 'adv-vis-element', 'post_status' => 'any', 'numberposts' => -1]);
			
			$options = [];
			
			if (!empty($ave_shortcodes)) {
				foreach ($ave_shortcodes as $shortcode) {
					if ($shortcode->post_status !== 'publish') {
						$options[$shortcode->ID] = $shortcode->post_title . ' (draft)';
					} else {
						$options[$shortcode->ID] = $shortcode->post_title;
					}
				}
			}
			
			$args = [
				'label' => __('Select', 'wp-ave'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false
			];
			
			if (!empty($options)) {
				$args['options'] = $options;
				
				$args['description'] = __('Please select an Advanced Visual Elements shortcode to be displayed.', 'wp-ave');
			} else {
				$args['description'] = __("You don't have any AVE shortcodes created. Head over to Admin dashboard > Advanced Visual Elements Library to create one.", 'wp-ave');
			}
			
			$this->add_control('adv-vis-ele-shortcode-id', $args);
			
			$this->add_control(
				'alignment',
				[
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label' => esc_html__('Alignment', 'wp-ave'),
					'options' => [
						'left' => [
							'title' => esc_html__('Left', 'wp-ave'),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__('Center', 'wp-ave'),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__('Right', 'wp-ave'),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'selectors' => [
						'{{WRAPPER}} .adv-vis-ele-elementor-container' => 'text-align: {{VALUE}};',
					],
				]
			);
			
			$this->end_controls_section();
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			
			if (!empty($settings['adv-vis-ele-shortcode-id'])) {
				echo '<div class="adv-vis-ele-elementor-container">';
				echo do_shortcode('[ave-element id="' . (int)$settings['adv-vis-ele-shortcode-id'] . '"]');
				echo '</div>';
			}
		}
	}
	
	\Elementor\Plugin::instance()->widgets_manager->register(new Adv_Vis_Ele_Elementor_Shortcode());
});