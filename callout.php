<?php
namespace Elementor;

class CalloutGeneric extends Widget_Base {
  public function get_name() {
    return 'callout-generic';
  }

  public function get_title() {
    return 'Callout';
  }

  public function get_icon() {
    return 'eicon-info-circle-o';
  }

  public function get_categories() {
    return [ 'opp' ];
  }

  protected function _register_controls() {
    $this->start_controls_section(
      'section_title',
      [
        'label' => __( 'Content', 'elementor' ),
      ]
    );

    $this->add_control(
			'type',
			[
				'label' => __( 'Border Style', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'dashed'  => __( 'Dashed Border / General Info', 'elementor' ),
					'success' => __( 'Success / Green', 'elementor' ),
					'warning' => __( 'Warning / Yellow', 'elementor' ),
					'danger' => __( 'Danger / Red', 'elementor' ),
					'grey' => __( 'Grey', 'elementor' ),
				],
			]
		);

    $this->add_control(
      'content',
			[
				'label' => __( 'Content', 'elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
    );

    $this->end_controls_section();
  }

  protected function render () {
    $settings = $this->get_settings_for_display();
    $label = $settings['type'];
    $content = $settings['content'];
    $type = $settings['type'];

    $class = 'callout callout--' . $type;

    echo '<article class="'. $class . '">
            '.$content.'
          </article>';
  }

  protected function _content_template() {

  }
}
