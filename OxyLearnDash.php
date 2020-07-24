<?php 

if (class_exists('OxyLearnDash')) {
    return;
}

Class OxyLearnDash{

    function __construct() {

        $this->load_files();
        $this->setup_options();

        // Register +Add LearnDash section
        add_action('oxygen_add_plus_sections', array($this, 'register_add_plus_section'));

        // Register +Add LearnDash subsections
        // oxygen_add_plus_{$id}_section_content
        add_action('oxygen_add_plus_dash_section_content', array($this, 'register_add_plus_subsections'));

        // Dash Global Styles UI
        add_action('oxygen_vsb_global_styles_tabs',     array($this, 'global_settings_tab'));
        add_action('oxygen_vsb_settings_content',       array($this, 'global_settings'));

        // Global styles CSS
        add_filter('oxy_global_settings_defaults',      array($this, 'filter_global_settings_defaults'));
        add_filter('oxy_elements_api_page_css_output',  array($this, 'filter_global_settings'));
        add_filter('oxygen_builder_options',            array($this, 'builder_global_styles_css'));
        add_filter('oxygen_header_font_families',       array($this, 'header_font_families'));
        add_action('oxygen_default_classes_output',     array($this, 'global_styles_universal_css'));

        add_action('wp_footer',  array($this, 'flexslider_fix'));
        add_action('init',       array($this, 'init_callback'));
    }


    function setup_options() {

        // Buttons
        $this->buttons_settings = array(
            "--primary-cta"             => __("Primary CTA"),
            "--primary-cta-hover"       => __("Primary CTA Hover"),
            "--primary-cta-text"        => __("Primary CTA Text"),
            "--secondary-cta"           => __("Secondary CTA"),
            "--secondary-cta-hover"     => __("Secondary CTA Hover"),
            "--secondary-cta-text"      => __("Secondary CTA Text"),
            "--tertiary-cta"            => __("Tertiary CTA"),
            "--tertiary-cta-hover"      => __("Tertiary CTA Hover"),
            "--tertiary-cta-background" => __("Tertiary CTA Background"),
            "--disabled-button"         => __("Disabled Button"),
            "--button-radius"           => __("Button Radius"),
        );

        $this->buttons_settings_defaults = array(
            "--primary-cta"             => "#65bec2",
            "--primary-cta-hover"       => "#6799b2",
            "--primary-cta-text"        => "#ffffff",
            "--secondary-cta"           => "#666666",
            "--secondary-cta-hover"     => "#999999",
            "--secondary-cta-text"      => "#ffffff",
            "--tertiary-cta"            => "#65bec2",
            "--tertiary-cta-hover"      => "#6799b2",
            "--tertiary-cta-background" => "#ffffff",
            "--disabled-button"         => "#cccccc",
            "--button-radius"           => "4",
            "--button-radius-unit"      => "px",
        );


        // Links
        $this->links_settings = array(
            "--standard-link"           => __("Standard Link"),
            "--standard-link-hover"     => __("Standard Link Hover"),
        );

        $this->links_settings_defaults = array(
            "--standard-link"           => "#6799b2",
            "--standard-link-hover"     => "#65bec2"
        );
    

        // Inputs
        $this->inputs_settings = array(
            "--input-border"            => __("Input Border"),
            "--input-focus-border"      => __("Input Focus Border"),
            "--input-placeholder-text"  => __("Input Placeholder Text"),
            "--input-background"        => __("Input Background"),
            "--input-radius"            => __("Input Radius"),
        );

        $this->inputs_settings_defaults = array(
            "--input-border"            => "#d3ced2",
            "--input-focus-border"      => "#65bec2",
            "--input-placeholder-text"  => "#d3ced2",
            "--input-background"        => "#ffffff",
            "--input-radius"            => "4",
            "--input-radius-unit"       => "px",
        );


        // Text
        $this->text_settings = array(
            "--text-normal"             => __("Text Normal"),
            "--text-strong"             => __("Text Strong"),
        );

        $this->text_settings_defaults = array(
            "--text-normal"             => "#666666",
            "--text-strong"             => "#000000",
        );

        // Notifications
        $this->notifications_settings = array(
            "--info-color" => __("Info Color"),
            "--error-color" => __("Error Color"),
            "--message-color" => __("Message Color"),
        );

        $this->notifications_settings_defaults = array(
            "--info-color" => "#00adef",
            "--error-color" => "#e96199",
            "--message-color" => "#65bec2",
        );
        
        // Misc
        $this->misc_settings = array(
            "--sale-badge-color"        => __("Sale Badge Color"),
            "--star-rating-primary"     => __("Star Rating Primary"),
            "--star-rating-greyed"      => __("Star Rating Greyed"),
            "--border-normal"           => __("Border Normal"),
            "--border-image"            => __("Border Image"),
            "--box-background"          => __("Box Background"),
        );

        $this->misc_settings_defaults = array(
            "--sale-badge-color"        => "#65bec2",
            "--star-rating-primary"     => "#65bec2",
            "--star-rating-greyed"      => "#d3d3d3",
            "--border-normal"           => "#d3ced2",
            "--border-image"            => "#d3ced2",
            "--box-background"          => "#ffffff",
        );

        // Misc
        $this->widget_settings = array(
            "--widget-title-font-size"      => __("Widget Title Font Size"),
            "--widget-title-font-weight"    => __("Widget Title Font Weight"),
            "--widget-title-font-family"    => __("Widget Title Font Family"),
        );

        $this->widget_settings_defaults = array(
            "--widget-title-font-size"      => "",
            "--widget-title-font-size-unit" => "px",
            "--widget-title-font-weight"    => "",
            "--widget-title-font-family"    => "",
        );
        
    }


    function load_files() {

        // Single Course
        include_once "elements/course-overview.php";

        // auto include new elements
        $element_filenames = glob(plugin_dir_path(__FILE__)."elements/*.php");
        foreach ($element_filenames as $filename) {
            include_once $filename;
        }
    }


    function register_add_plus_section() {

        CT_Toolbar::oxygen_add_plus_accordion_section("dash",__("LearnDash"));
    }


    function register_add_plus_subsections() { ?>
        
        <h2><?php _e("Single Course", "oxygen");?></h2>
        <?php do_action("oxygen_add_plus_dash_single"); ?>
    
    <?php }


    function global_settings_tab() {
  
        global $oxygen_toolbar;
        $oxygen_toolbar->settings_tab(__("LearnDash", "oxygen"), "woo", "panelsection-icons/styles.svg");
    }

    
    function global_settings() { ?>

        <div ng-if="isShowTab('settings','dash')">
            <?php include_once "settings/global-settings.view.php"; ?>
        </div>  

    <?php }

    
    function filter_global_settings_defaults( $defaults ) {

        $defaults['dash'] = array();

        $defaults['dash'] = array_merge($defaults['dash'], $this->buttons_settings_defaults);
        $defaults['dash'] = array_merge($defaults['dash'], $this->links_settings_defaults);
        $defaults['dash'] = array_merge($defaults['dash'], $this->inputs_settings_defaults);
        $defaults['dash'] = array_merge($defaults['dash'], $this->text_settings_defaults);
        $defaults['dash'] = array_merge($defaults['dash'], $this->notifications_settings_defaults);
        $defaults['dash'] = array_merge($defaults['dash'], $this->misc_settings_defaults);
        $defaults['dash'] = array_merge($defaults['dash'], $this->widget_settings_defaults);

        return $defaults;

    }


    function filter_global_settings( $css ) {

        // remove variables definitions
        $css = preg_replace('%\/\*STRIP START\*\/(.*?)\/\*STRIP END\*\/%s', '', $css);

        $global_settings = ct_get_global_settings();

        if (isset($global_settings['dash'])){

            // units
            foreach ($global_settings['dash'] as $key => $value) {
                if (isset($global_settings['dash'][$key."-unit"])) {
                    $global_settings['dash'][$key] = $value.$global_settings['woo'][$key."-unit"];
                }
            }
        
            $options = array_keys  ($global_settings['dash']);
            $values  = array_values($global_settings['dash']);

            $options = array_map(function($value){
                return "var($value)";
            }, $options);

            // global colors
            $values = array_map(function($value){
                return oxygen_vsb_get_global_color_value($value);
            }, $values);
            
            $css = str_replace($options, $values, $css);
        }
      
        return $css;

    }


    function builder_global_styles_css($options) {

        $options["dashGlobalStyles"] = file_get_contents(__DIR__.'/elements/dash-global-styler.css');
        $options["dashAssetsPath"] = OXY_DASH_ASSETS_PATH;

        return $options;
    }


    function header_font_families($fonts) {

        $global_settings = ct_get_global_settings();

        foreach ($global_settings['dash'] as $key => $value) {
            if (strpos($key, "font-family") !== false) {
                $fonts[] = $value;
            }
        }

        return $fonts;
    }

    
    function global_styles_universal_css() {

        $global_css = file_get_contents(__DIR__.'/elements/dash-global-styler.css');
        $global_css = str_replace("%%ASSETS_PATH%%", OXY_DASH_ASSETS_PATH, $global_css);
        $global_css = $this->filter_global_settings($global_css);

        echo $global_css;
    }

    function flexslider_fix() {

        if (!defined("SHOW_CT_BUILDER") || !defined("OXYGEN_IFRAME")) {
            return;
        }

        ?><script type="text/javascript">
            document.addEventListener('oxygen-ajax-element-loaded', function (e) { 
                setTimeout(function() {

                    jQuery(".learndash-coruse-gallery").each(function(){
                        var gallery = jQuery(this);

                        var viewport = gallery.find('.flex-viewport');
                        if (viewport.length > 1){
                            viewport.first().remove();
                        }
                        var thumbs = gallery.find('.flex-control-nav');
                        if (thumbs.length > 1){
                            thumbs.first().remove();
                        }
                        var icon = gallery.find('.learndash-course-gallery__trigger');
                        if (icon.length > 1){
                            icon.first().remove();
                        }

                        var flexSlider = gallery.data('flexslider');
                        if (flexSlider) {
                            flexSlider.update();
                            flexSlider.doMath();
                        }
                    });

                }, 100);
            }, false);
        </script><?php

    }

    function init_callback() {

        // we don't want learndash redirects to work when builder is loading
        if ( defined("SHOW_CT_BUILDER") || defined("OXYGEN_IFRAME") ) {
            remove_action( 'template_redirect', 'ld_template_redirect' );
        }

    }

}
