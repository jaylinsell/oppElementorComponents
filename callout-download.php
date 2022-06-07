<?php
namespace Elementor;

class CalloutDownloadBrochure extends Widget_Base {
  public function get_name() {
    return 'callout-download-brochure';
  }

  public function get_title() {
    return 'Callout - Download';
  }

  public function get_icon() {
    return ' eicon-download-kit';
  }

  public function get_categories() {
    return [ 'opp' ];
  }

  protected function _register_controls() {
    $this->start_controls_section(
      'section_title',
      [
        'label' => __( 'File', 'elementor' ),
      ]
    );

    $this->add_control(
      'label',
      [
        'label' => __( 'Label', 'elementor' ),
        'type' => Controls_Manager::TEXT,
        'placeholder' => __( 'Download the X Brochure', 'elementor' ),
      ]
    );

    $this->add_control(
			'file',
			[
				'label' => __( 'Choose PDF', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
        'media_type' => 'application/pdf'
			]
		);

    $this->end_controls_section();

    $this->start_controls_section(
      'additional_languages',
      [
        'label' => __( 'Additional Languages', 'elementor' )
      ]
    );

    $this->add_control(
      'content',
			[
				'label' => __( 'Content', 'elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
			'label',
			[
				'label' => __( 'Language', 'elementor' ),
				'type' => Controls_Manager::TEXT,
        'placeholder' => __('Arabic', 'elementor')
			]
		);

    $repeater->add_control(
			'file',
			[
				'label' => esc_html__( 'Choose PDF', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
        'media_type' => 'application/pdf'
			]
		);

    $this->add_control(
      'files',
      [
        'label' => __('Files', 'elementor'),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'title_field' => '{{{ label }}}'
      ]
    );

    $this->end_controls_section();
  }

  protected function render () {
    $settings = $this->get_settings_for_display();
    $label = $settings['label'];
    $file = $settings['file']['url'];

    $content = $settings['content'];

    echo '<article class="callout callout--dashed">
            <a class="btn btn--primary btn--download" href="' . $file . '" target="_blank" rel="noopener">
              ' . $label . '
              <svg aria-hidden="true" class="chevron chevron--down" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.4925 9.39996C12.6039 9.51706 12.6666 9.67592 12.6667 9.84163V10.1583C12.6649 10.3236 12.6025 10.4819 12.4925 10.6L8.42338 14.875C8.34906 14.9538 8.24788 14.9982 8.14234 14.9982C8.0368 14.9982 7.93562 14.9538 7.8613 14.875L7.29922 14.2833C7.22475 14.2065 7.18278 14.1014 7.18278 13.9916C7.18278 13.8819 7.22475 13.7768 7.29922 13.7L10.8221 9.99996L7.29922 6.29996C7.22428 6.22172 7.18213 6.11522 7.18213 6.00412C7.18213 5.89303 7.22428 5.78653 7.29922 5.70829L7.8613 5.12496C7.93562 5.04608 8.0368 5.00171 8.14234 5.00171C8.24788 5.00171 8.34906 5.04608 8.42338 5.12496L12.4925 9.39996Z" fill="white"/>
              </svg>
            </a>
            <div class="callout__content">'.$content.'</div>';

    if ( $settings['files'] ) {
      echo '<section class="links links--list links--grid links--grid-auto">';
        foreach (  $settings['files'] as $file ) {
            echo '<a href="' . $file['file']['url'] . '" class="link__item link--download">
                ' . $file['label'] . '
                  <svg aria-hidden="true" class="chevron chevron--down" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
