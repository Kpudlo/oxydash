<?php

/*
Plugin Name: Oxygen Elements for LearnDash
Author: Luxibay
Author URI: https://luxibay.com
Description: Adds LearnDash Elements for Oxygen.
Version: 0.1
*/

add_action('plugins_loaded', 'oxygen_learndash_init');

oxygen_learndash_init () {
  
  // check if LearnDash is installed and active
  
  // check if Oxygen is installed and active
  if (!class_exists('OxygenElement')) {
      return;
  }
 
  define("OXY_DASH_ASSETS_PATH", plugins_url("elements/assets", __FILE__));

  require_once('OxyDashEl.php');
  require_once('OxyLearnDash.php');

  $OxyLearnDash = new OxyLearnDash();
}
