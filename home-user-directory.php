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

    // $this->add_control(
    //   'directory_icon',
    //   [
    //     'label' => __( 'Directory Title', 'elementor' ),
    //     'label_block' => true,
    //     'type' => Controls_Manager::TEXT,
    //     'default' => __( 'Directory', 'elementor' ),
    //   ]
    // );


    $this->add_control(
      'directory_title',
      [
        'label' => __( 'Directory Title', 'elementor' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Are you a...', 'elementor' ),
      ]
    );

    $this->add_control(
      'directory_description',
      [
        'label' => __( 'Directory Description', 'elementor' ),
        'type' => Controls_Manager::TEXTAREA,
        'default' => __( 'This is a directory of all the users that have signed up for the site.', 'elementor' ),
      ]
    );

    $this->end_controls_section();
  }

  protected function render () {
    $settings = $this->get_settings_for_display();
    $title = $settings['directory_title'];
    $description = $settings['directory_description'];

    echo '<article class="card card--directory">
            <header class="card__header">
              <figure class="card__icon">
                <img src="" alt="">
              </figure>

              <h2 class="card__title">' . $title . '</h2>
            </header>
            <section class="card__summary">
              <p>' . $description . '</p>
            </section>
            <section class="card__links">
              <a href="#" class="btn btn--primary card__link">
                Link
                <svg class="chevron" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.4925 9.39996C12.6039 9.51706 12.6666 9.67592 12.6667 9.84163V10.1583C12.6649 10.3236 12.6025 10.4819 12.4925 10.6L8.42338 14.875C8.34906 14.9538 8.24788 14.9982 8.14234 14.9982C8.0368 14.9982 7.93562 14.9538 7.8613 14.875L7.29922 14.2833C7.22475 14.2065 7.18278 14.1014 7.18278 13.9916C7.18278 13.8819 7.22475 13.7768 7.29922 13.7L10.8221 9.99996L7.29922 6.29996C7.22428 6.22172 7.18213 6.11522 7.18213 6.00412C7.18213 5.89303 7.22428 5.78653 7.29922 5.70829L7.8613 5.12496C7.93562 5.04608 8.0368 5.00171 8.14234 5.00171C8.24788 5.00171 8.34906 5.04608 8.42338 5.12496L12.4925 9.39996Z" fill="white"/>
                </svg>
              </a>
            </section>
          </article>';
  }

  protected function _content_template() {

  }
}
