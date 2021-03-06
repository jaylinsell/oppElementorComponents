<?php
  class OPPComponents {
    // to prevent re-initiating the instance, i'm using a singleton pattern
    protected static $instance = null;

    public static function get_instance() {
      if ( null == static::$instance ) {
        static::$instance = new static;
      }
      return static::$instance;
    }

    // register individual components within the directory
    protected function __construct () {
      require_once('home-user-directory.php');
      require_once('page-directory.php');
      require_once('button-list.php');
      require_once('logo-buttons.php');
      require_once('link-list.php');
      require_once('on-this-page.php');
      require_once('callout.php');
      require_once('callout-download.php');
      require_once('opp-divider.php');

      add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets'));
    }

    public function register_widgets() {
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\HomeUserDirectory() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PageDirectory() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\ButtonList() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\LogoButtons() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\LinkList() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\OnThisPage() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\CalloutGeneric() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\CalloutDownloadBrochure() );
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\OPPDivider() );
    }
  }

  // Create the OPP Category
  add_action( 'elementor/elements/categories_registered', 'add_new_category' );

  function add_new_category( $elements_manager ) {
    // new categories...
    $categories = [];
    $categories['opp'] =
      [
        'title' => 'Custom OPP Widgets',
        'icon'  => 'fa fa-plug'
      ];

    // old categories, I'll be appending them so the OPP category sits up top
    $old_categories = $elements_manager->get_categories();
    $categories = array_merge($categories, $old_categories);

    $set_categories = function ( $categories ) {
      $this->categories = $categories;
    };

    $set_categories->call( $elements_manager, $categories );
  }

  // init custom components
  add_action( 'init', 'opp_components_init' );

  function opp_components_init() {
    OPPComponents::get_instance();
  }
