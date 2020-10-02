<?php

class OxyDashEl extends OxyEl {

    function init() {
        
        $this->El->useAJAXControls();
        $this->setAssetsPath( OXY_DASH_ASSETS_PATH );
    }

    function render($options, $defaults, $content) {

        if (method_exists($this, 'dashTemplate')) {

            /*(global $product;
            $product = wc_get_product();

            if ($product != false) {
                call_user_func($this->wooTemplate());
            }*/

        }
        
    }

    function class_names() {
        return array('oxy-dash-element');
    }

    function dash_button_place() {
        return "other";
    }

    function button_place() {
        
        $dash_button_place = $this->dash_button_place();
        
        if ($dash_button_place) {
            return "dash::".$dash_button_place;
        }

        return "";
    }

}
