<?php

namespace Oxygen\DashElements;

class CourseList extends \OxyDashEl {

    function name() {
        return 'Course List';
    }

    function dashTemplate() {
        return 'learnsdash_template_course_list';
    }

    function dash_button_place() {
        return "single";
    }

    function icon() {
        return plugin_dir_url(__FILE__) . 'assets/'.basename(__FILE__, '.php').'.svg';
    }

    function controls() {

        $this->typographySection('Color & Typography', '.course, .learndash-Course-list, .course del');

    }

    function defaultCSS() {

        return file_get_contents(__DIR__.'/'.basename(__FILE__, '.php').'.css');
        
    }

}

new CourseList();
