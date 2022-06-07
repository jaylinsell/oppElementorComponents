<?php
namespace Elementor;

class ButtonList extends Widget_Base {
  public function get_name() {
    return 'button-list';
  }

  public function get_title() {
    return 'Button List';
  }

  public function get_icon() {
    return 'eicon-apps';
  }

  public function get_categories() {
    return [ 'opp' ];
  }

  protected function _register_controls() {
    $this->start_controls_section(
      'section_title',
      [
        'label' => __( 'Links', 'elementor' ),
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => __( 'Title', 'elementor' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'placeholder' => __( 'Recommended Links', 'elementor' ),
      ]
    );

    $this->add_control(
      'content',
			[
				'label' => __( 'Content', 'elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'description' => __( 'Leave blank if not required.', 'elementor' ),
			]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);

    $repeater->add_control(
			'label',
			[
				'label' => __( 'Button Label', 'elementor' ),
				'type' => Controls_Manager::TEXT,
        'default' => __('Label', 'elementor')
			]
		);

    $repeater->add_control(
			'url',
			[
				'label' => __( 'Button URL', 'elementor' ),
				'type' => Controls_Manager::TEXT,
        'placeholder' => __('https://opp.vic.gov.au/', 'elementor'),
			]
		);

    $this->add_control(
      'links',
      [
        'label' => __('Links', 'elementor'),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          'label' => __('Label', 'elementor')
        ],
        'title_field' => '{{{ label }}}'
      ]
    );

    $this->end_controls_section();
  }

  protected function render () {
    $settings = $this->get_settings_for_display();
    $title = $settings['title'];
    $content = $settings['content'];

    echo '<section class="section section-links links">
            <article class="section__content content">
              <h2 class="section__title">' . $title . '</h2>
              ' . $content . '
            </article>';

    if ( $settings['links'] ) {
      echo '<div class="links links--grid">';
        foreach (  $settings['links'] as $button ) {
            $icon = $button['icon']['value'];

            if (is_array($icon)) {
              $iconURL = $icon['url'];
              $iconElement = '<img src="' . $iconURL . '" alt="Icon ' . $icon . '" />';
            } else {
              $iconElement = '<i class="' . $icon . '" aria-label="Icon"></i>';
            }

            echo '<a href="' . $button['url'] . '" class="btn btn--large btn--secondary">
                <figure class="btn__icon">' . $iconElement . '
                  </figure>
                ' . $button['label'] . '
                <svg aria-hidden="true" class="chevron" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.4925 9.39996C12.6039 9.51706 12.6666 9.67592 12.6667 9.84163V10.1583C12.6649 10.3236 12.6025 10.4819 12.4925 10.6L8.42338 14.875C8.34906 14.9538 8.24788 14.9982 8.14234 14.9982C8.0368 14.9982 7.93562 14.9538 7.8613 14.875L7.29922 14.2833C7.22475 14.2065 7.18278 14.1014 7.18278 13.9916C7.18278 13.8819 7.22475 13.7768 7.29922 13.7L10.8221 9.99996L7.29922 6.29996C7.22428 6.22172 7.18213 6.11522 7.18213 6.00412C7.18213 5.89303 7.22428 5.78653 7.29922 5.70829L7.8613 5.12496C7.93562 5.04608 8.0368 5.00171 8.14234 5.00171C8.24788 5.00171 8.34906 5.04608 8.42338 5.12496L12.4925 9.39996Z" fill="white"/>
                </svg>
              </a>';
        }
        echo '</div>';
      echo '</section>';
    }
  }

  protected function _content_template() {

  }
}
