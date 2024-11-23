<?php

function registrar_widgets_personalizados_elementor()
{

	\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new class extends \Elementor\Widget_Base
	{
		public function get_name()
		{
			return 'widget-form-home';
		}

		public function get_title()
		{
			return __('Form Home', 'my-plugin');
		}

		public function render()
		{
			require_once('widget-form-home.php');
		}
		public function get_categories()
		{
			return ['basic'];
		}
	});

}

add_action('elementor/widgets/widgets_registered', 'registrar_widgets_personalizados_elementor');