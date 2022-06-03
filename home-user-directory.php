<?php
namespace Elementor;

class HomeUserDirectory extends Widget_Base {
  public function get_name() {
    return 'home-user-directory';
  }

  public function get_title() {
    return 'Home User Directory';
  }

  public function get_icon() {
    return 'eicon-archive';
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

    /*
     * Elementor still doesn't support nested repeaters,
     * so unfortunately we need to create these blocks as individual components, with a repeated button area,
     * and train OPP to utilise the "inner section" components to use them.
     * */

    $this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

    $this->add_control(
      'directory_title',
      [
        'label' => __( 'Directory Title', 'elementor' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'placeholder' => __( 'Are you a...', 'elementor' ),
        'description' => __( 'To force titles onto a new line, use <br />. Ie, "Are you \<br />a Police Officer"', 'elementor' ),
      ]
    );

    $this->add_control(
      'alternate_bg',
      [
        'label' => __( 'Alternate BG', 'elementor' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __( 'On', 'your-plugin' ),
				'label_off' => __( 'Off', 'your-plugin' ),
        'return_value' => 'yes',
        'default_value' => 'no',
        'description' => __( 'Alternates the background colours. Only applies to desktop due to stacking orders on mobile.', 'elementor' ),
      ]
    );

    $this->add_control(
      'directory_description',
			[
				'label' => __( 'Directory Description', 'elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'description' => __( 'Leave blank for no description', 'elementor' ),
			]
    );

    $repeater = new \Elementor\Repeater();

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
    $title = $settings['directory_title'];
    $description = $settings['directory_description'];
    $alternateBG = $settings['alternate_bg'];

    // Icons can be rendered as a font-awesome icon or an svg icon, so check for both
    $icon = $settings['icon']['value'];

    if (is_array($icon)) {
      $iconURL = $icon['url'];
      $iconElement = '<img src="' . $iconURL . '" alt="Icon ' . $icon . '" />';
    } else {
      $iconElement = '<i class="' . $icon . '" aria-label="Icon"></i>';
    }

    echo '<article class="card card--directory ';
    if ( 'yes' === $alternateBG ) {
      echo ' card--alternate';
    }
    echo '">
            <header class="card__header">
              <figure class="card__icon">
                ' . $iconElement . '
              </figure>

              <h2 class="card__title">' . $title . '</h2>
            </header>
            <section class="card__summary">
              ' . $description . '
            </section>';

    if ( $settings['links'] ) {
      echo '<section class="card__links">';
        foreach (  $settings['links'] as $button ) {
            echo '<a href="' . $button['url'] . '" class="btn btn--large btn--primary card__link">
                ' . $button['label'] . '
                <svg aria-hidden="true" class="chevron" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.4925 9.39996C12.6039 9.51706 12.6666 9.67592 12.6667 9.84163V10.1583C12.6649 10.3236 12.6025 10.4819 12.4925 10.6L8.42338 14.875C8.34906 14.9538 8.24788 14.9982 8.14234 14.9982C8.0368 14.9982 7.93562 14.9538 7.8613 14.875L7.29922 14.2833C7.22475 14.2065 7.18278 14.1014 7.18278 13.9916C7.18278 13.8819 7.22475 13.7768 7.29922 13.7L10.8221 9.99996L7.29922 6.29996C7.22428 6.22172 7.18213 6.11522 7.18213 6.00412C7.18213 5.89303 7.22428 5.78653 7.29922 5.70829L7.8613 5.12496C7.93562 5.04608 8.0368 5.00171 8.14234 5.00171C8.24788 5.00171 8.34906 5.04608 8.42338 5.12496L12.4925 9.39996Z" fill="white"/>
                </svg>
              </a>';
        }
        echo '</section>';
      echo '</article>';
    }
  }

  protected function _content_template() {

  }
}
