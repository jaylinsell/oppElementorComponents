<?php
namespace Elementor;

class OppDivider extends Widget_Base {
  public function get_name() {
    return 'opp-divider';
  }

  public function get_title() {
    return 'OPP Divider';
  }

  public function get_icon() {
    return 'eicon-divider-shape';
  }

  public function get_categories() {
    return [ 'opp' ];
  }


  protected function render () {
    echo '<div class="opp-divider"></div>';
  }

  protected function _content_template() {

  }
}
