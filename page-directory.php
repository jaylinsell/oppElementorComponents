<?php
namespace Elementor;

class PageDirectory extends Widget_Base {
  public function get_name() {
    return 'page-directory';
  }

  public function get_title() {
    return 'Page Directory';
  }

  public function get_icon() {
    return 'eicon-table-of-contents';
  }

  public function get_categories() {
    return [ 'opp' ];
  }

  protected function _register_controls() {
    $this->start_controls_section(
      'section_title',
      [
        'label' => __( 'Block', 'elementor' ),
      ]
    );

    $this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-balance-scale',
				],
			]
		);

    $this->add_control(
      'title',
      [
        'label' => __( 'Page Title', 'elementor' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'placeholder' => __( 'Page Title', 'elementor' ),
        'description' => __( 'This is the page you are referencing the contents for', 'elementor' ),
      ]
    );

    // Not using the URL component simply because these components should not be linking to external resourcses.
    $this->add_control(
      'url',
      [
        'label' => __( 'Page url', 'elementor' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'placeholder' => __( 'Page URL', 'elementor' ),
        'description' => __( 'Link to the over-arching page of the below contents', 'elementor' ),
      ]
    );

    $this->add_control(
      'description',
			[
				'label' => __( 'Page Description', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'description' => __( 'Leave blank for no description', 'elementor' ),
			]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
			'label',
			[
				'label' => __( 'Section', 'elementor' ),
				'type' => Controls_Manager::TEXT,
        'description' => __('Section of the page you want to link to', 'elementor'),
			]
		);

    $repeater->add_control(
			'url',
			[
				'label' => __( 'Anchor Link', 'elementor' ),
				'type' => Controls_Manager::TEXT,
        'placeholder' => __('https://opp.vic.gov.au/victims-and-witnesses/#anchor', 'elementor'),
        'description' => __('Format: "https://pageurl.com/#section-id". <br />The "section-id" will be relative to the ID you give on the content blocks within the page.<br />Example: http://opp.vic.gov.au/victims-and-witnesses/#victims-of-crime<br />You can link to other pages directly if needed.', 'elementor')
			]
		);

    $this->add_control(
      'links',
      [
        'label' => __('Page Sections', 'elementor'),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          'label' => __('Victims of Crime', 'elementor'),
          'url' => __('https://opp.vic.gov.au/victims-and-witnesses/#victims-of-crime', 'elementor'),
        ],
        'title_field' => '{{{ label }}}'
      ]
    );

    $this->end_controls_section();
  }

  protected function render () {
    $settings = $this->get_settings_for_display();
    $title = $settings['title'];
    $url = $settings['url'];
    $description = $settings['description'];

    // Icons can be rendered as a font-awesome icon or an svg icon, so check for both
    $icon = $settings['icon']['value'];

    if (is_array($icon)) {
      $iconURL = $icon['url'];
      $iconElement = '<figure class="card__icon" style="--image-url: url(' . $iconURL . '); --c-psuedo-opacity: 1;">
                        <img src="' . $iconURL . '" alt="Icon ' . $icon . '" />
                      </figure>';
    } else {
      $iconElement = '<figure class="card__icon">
                        <i class="' . $icon . '" aria-label="Icon"></i>
                      </figure>';
    }

    echo '<article class="card card--page-directory">
            <header class="card__header">
              <a href="' . $url . '">
                ' . $iconElement . '
                <h2 class="card__title">' . $title . '</h2>

                <svg aria-hidden="true" class="chevron" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.4925 9.39996C12.6039 9.51706 12.6666 9.67592 12.6667 9.84163V10.1583C12.6649 10.3236 12.6025 10.4819 12.4925 10.6L8.42338 14.875C8.34906 14.9538 8.24788 14.9982 8.14234 14.9982C8.0368 14.9982 7.93562 14.9538 7.8613 14.875L7.29922 14.2833C7.22475 14.2065 7.18278 14.1014 7.18278 13.9916C7.18278 13.8819 7.22475 13.7768 7.29922 13.7L10.8221 9.99996L7.29922 6.29996C7.22428 6.22172 7.18213 6.11522 7.18213 6.00412C7.18213 5.89303 7.22428 5.78653 7.29922 5.70829L7.8613 5.12496C7.93562 5.04608 8.0368 5.00171 8.14234 5.00171C8.24788 5.00171 8.34906 5.04608 8.42338 5.12496L12.4925 9.39996Z" fill="white"/>
                </svg>
              </a>

              <section class="card__summary">
                ' . $description . '
              </section>
            </header>';

    if ( $settings['links'] ) {
      echo '<section class="card__links">';
        foreach (  $settings['links'] as $link ) {
            echo '<a href="' . $link['url'] . '" class="links__item card__link">
                ' . $link['label'] . '

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
