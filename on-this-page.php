<?php
namespace Elementor;

/*
* I've purposely decoupled and duplicated the link list and button list to simplify the usability for those adding content, rather
* than having creating complex toggles for them to learn
*/
class OnThisPage extends Widget_Base {
  public function get_name() {
    return 'on-this-page';
  }

  public function get_title() {
    return 'On This Page';
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
        'label' => __( 'Content Sections', 'elementor' ),
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => __( 'Title', 'elementor' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'default' => __( 'On This Page', 'elementor' ),
      ]
    );

    $this->add_control(
      'toggle_bg',
      [
        'label' => __( 'Background Version', 'elementor' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __( 'On', 'your-plugin' ),
				'label_off' => __( 'Off', 'your-plugin' ),
        'return_value' => 'yes',
        'default_value' => 'no',
        'description' => __( 'Uses the alternate version where the widget utilises a light blue background.', 'elementor' ),
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
			'label',
			[
				'label' => __( 'Label', 'elementor' ),
				'type' => Controls_Manager::TEXT,
        'default' => __('Label', 'elementor')
			]
		);

    $repeater->add_control(
			'url',
			[
				'label' => __( 'Anchor / URL', 'elementor' ),
				'type' => Controls_Manager::TEXT,
        'placeholder' => __('#section', 'elementor'),
        'description' => __('The anchor is the "CSS ID" applied to the "Headings/Titles" of the peage. If you are unsure of the ID, click the heading you want to link to, go to the "Advanced Tab" and check the CSS ID.', 'elementor')
			]
		);

    $repeater->add_control(
			'is_child',
			[
				'label' => __( 'Indent as child link', 'elementor' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
        'return_value' => 'yes',
        'default_value' => 'no',
        'description' => __( 'Uses the alternate version where the widget utilises a light blue background.', 'elementor' ),
			]
		);

    $this->add_control(
      'anchors',
      [
        'label' => __('Anchors / Links', 'elementor'),
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
    $toggleBG = $settings['toggle_bg'];

    $alternateClass = $toggleBG ? ' anchor__block--alternate' : '';

    echo '<article class="anchor__block' . $alternateClass . '">
            <header class="anchor__header">
              <h2 class="anchor__title">' . $title . '</h2>
            </header>';

    if ( $settings['anchors'] ) {
      $parentAnchor = null;

      echo '<nav class="anchor__nav links links--list">';
        foreach (  $settings['anchors'] as $link ) {
            $label = $link['label'];
            $url = $link['url'];
            $child = $link['is_child'];

            if ($parentAnchor == null || $child !== 'yes') {
              $parentAnchor = $url;
            }

            $modifierClass = $child == 'yes' ? ' anchor__link--child' : ' anchor__link--parent';

            // because Elementor doesn't have nested repeaters,
            // I'm indenting with styles instead of nested UL's, and syncing accessibility ownership with aria-owns via JS
            echo '<a href="' . $link['url'] . '" class="anchor__link links__item ' . $modifierClass . '" data-anchor="' . $url . '" data-parent-anchor="' . $parentAnchor . '">
                ' . $label . '
                <svg aria-hidden="true" class="chevron" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.4925 9.39996C12.6039 9.51706 12.6666 9.67592 12.6667 9.84163V10.1583C12.6649 10.3236 12.6025 10.4819 12.4925 10.6L8.42338 14.875C8.34906 14.9538 8.24788 14.9982 8.14234 14.9982C8.0368 14.9982 7.93562 14.9538 7.8613 14.875L7.29922 14.2833C7.22475 14.2065 7.18278 14.1014 7.18278 13.9916C7.18278 13.8819 7.22475 13.7768 7.29922 13.7L10.8221 9.99996L7.29922 6.29996C7.22428 6.22172 7.18213 6.11522 7.18213 6.00412C7.18213 5.89303 7.22428 5.78653 7.29922 5.70829L7.8613 5.12496C7.93562 5.04608 8.0368 5.00171 8.14234 5.00171C8.24788 5.00171 8.34906 5.04608 8.42338 5.12496L12.4925 9.39996Z" fill="white"/>
                </svg>
              </a>';
        }
        echo '</nav>';
      echo '</article>';
    }
  }

  protected function _content_template() {

  }
}
