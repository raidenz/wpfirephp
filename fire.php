<?php
/*
Plugin Name: BWD FirePHP Debugger
Description: FirePHP PHP Debugger for WordPress
Author: R.B. Gottier
Version: 1.0
Author URI: http://brianswebdesign.com
*/

// include_once 'fb.php';
include_once plugin_dir_path( __FILE__ ).'fb.php';

ob_start();

class firephp_debugger {

  public function __construct()
  {
    // On activation
    register_activation_hook(
      __FILE__,
      array( $this, 'on_activation' )
    );

    // On update
    add_filter(
      'pre_update_option_active_plugins',
      array( $this,'on_update' )
    );
  }

  public function on_activation()
  {
    $file_name = plugin_basename( __FILE__ );

    $plugins = get_option('active_plugins');

    update_option(
      'active_plugins',
      $this->process( $file_name, $plugins )
    );
  }

  public function on_update( $plugins )
  {
    $file_name = plugin_basename( __FILE__ );

    if( ! in_array( $file_name, $plugins ) )
    {
      return $plugins;
    }

    return $this->process( $file_name, $plugins );
  }

  public function process( $file_name, $plugins )
  {
    $new = array();

    array_push( $new, $file_name );

    foreach( $plugins as $plugin )
    {
      if( $plugin != $file_name )
      {
        $new[] = $plugin;
      }
    }

    return $new;
  }

}

$firephp_debugger = new firephp_debugger;

//use http://blog.skunkbad.com/php/debugging-php-w-firephp
//FB::log($arr);
//FB::info('Info message');
// FB::warn('Warn message');
// FB::error('Error message');