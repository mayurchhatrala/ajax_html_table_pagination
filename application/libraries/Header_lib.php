<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of header_lib
 * @author Admin
 * 
 * IF YOU WANT TO CHANGE IN THE FILE CONTENT SO CHANGE WHERE 
 * >> 'CHANGE-IT' PLACED IN THE COMMENT...
 */
class Header_lib {

    private $doc_type, $doc_type_value;
    private $meta_tag, $content_meta_tag_value, $http_meta_tag_value;
    private $title;
    private $css, $css_value;
    private $js, $js_value;
    private $favicon;

    public function __construct() {
        $this->_loadFields();
    }

    /*
     * TO GET THE LIST OF FIELDS...
     */

    public function data() {
        return array(
            'doctype' => $this->doc_type,
            'title' => $this->title,
            'metatag' => $this->meta_tag,
            'css' => $this->css,
            'js' => $this->js,
            'favicon' => $this->favicon,
        );
    }

    /*
     * TO LOAD ALL THE FIELDS...
     */

    private function _loadFields() {
        $this->title = PROJ_TITLE;
        $this->_setDocType();
        $this->_setMetaTags();
        $this->_setCSS();
        $this->_setJS();
        $this->_setFaviconIcon();
    }

    /*
     * TO SET DOC TYPE
     * 
     * CHANGE-IT
     */

    private function _setDocType() {
        if (@$this->doc_type_value != '') {
            switch ($this->doc_type_value) {
                case 'Strict':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"' . "\n" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";
                    break;

                case 'Transitional':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"' . "\n" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";
                    break;

                case 'Frameset':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"' . "\n" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";

                case 'XHTML':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"' . "\n" . '"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";

                case 'XHTML1.0':
                    $this->doc_type = '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";

                case 'XHTML1.1':
                    $this->doc_type = '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\n";
            }
        }
    }

    /*
     * TO SET THE META TAGS
     */

    private function _setMetaTags() {
        $this->_setMetaTagsValue();

        foreach ($this->http_meta_tag_value as $key => $val)
            $this->meta_tag .= '<meta http-equiv="' . $key . '" content="' . $val . '"/>' . PHP_EOL;

        foreach ($this->content_meta_tag_value as $key => $val)
            $this->meta_tag .= '<meta http-equiv="' . $key . '" content="' . $val . '"/>' . PHP_EOL;
    }

    /*
     * TO SET THE META TAG VALUES
     * 
     * CHANGE-IT
     */

    private function _setMetaTagsValue() {
        $this->http_meta_tag_value = array();
        $this->content_meta_tag_value = array(
            'apple-mobile-web-app-capable' => 'yes',
            'apple-mobile-web-app-status-bar-style' => 'black',
            'viewport' => 'width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no'
        );
    }

    /*
     * TO SET THE CSS
     */

    private function _setCSS() {
        $this->_setCSSValue();
        foreach ($this->css_value as $key => $val)
            $this->css .= '<link rel="stylesheet" id="' . $key . '" href="' . $val . '" type="text/css" media="all" />' . PHP_EOL;
    }

    /*
     * TO SET THE CSS VALUE
     * 
     * CHANGE-IT
     */

    private function _setCSSValue() {
        $this->css_value = array(
            'bootstrap' => COMP_URL . 'bootstrap/dist/css/bootstrap.min.css',
            'Jdatatables' => COMP_URL . 'jsDatatable/jquery.dataTables.min.css',
            
            'fancy' => COMP_URL . 'plugins/fancy/lightbox.min.css',
            'animate' => COMP_URL . 'animate.css/animate.min.css',
            'font-awesome' => COMP_URL . 'font-awesome/css/font-awesome.min.css',
            
            'sweetcss' => COMP_URL . 'sweet-alert/css/sweet-alert.min.css', 
            'font' => CSS_URL . 'font.min.css',
            'app' => CSS_URL . 'app.min.css',
            
            // 'normal_datepickers' => CSS_URL . 'datepicker.min.css',
            'bt_datepickers' => COMP_URL . 'datepicker/bootstrap-datetimepicker.min.css', 
            'custom' => CSS_URL . 'jquery-ui-1.8.23.custom.min.css',
            'chosen' => COMP_URL . 'chosen/chosen.css',
            'stylecss' => CSS_URL . 'style.min.css'
        );
    }

    /*
     * TO SET THE JS
     */

    private function _setJS() {
        $this->_setJSValue();
        $this->js .= '<script type="text/javascript">var BASEURL = "' . BASE_URL . '"; </script>' . PHP_EOL;
        $this->js .= '<script type="text/javascript"  >var IMAGE_URL = "' . IMAGE_URL . '"; </script>' . PHP_EOL;
        $this->js .= '<script type="text/javascript"  >var ACCESS_URL = "' . ACCESS_URL . '"; </script>' . PHP_EOL;
        $this->js .= '<script type="text/javascript">var JS_CNTRL = BASEURL + "/application/js/controllers/"; </script>' . PHP_EOL;
        foreach ($this->js_value as $key => $val)
            $this->js .= '<script src="' . $val . '" type="text/javascript" charset="utf-8"></script>' . PHP_EOL;
    }

    /*
     * TO SET THE JS VALUE
     * 
     * CHANGE-IT
     */

    private function _setJSValue() {
        
        $this->js_value = array(
            "jquery" => COMP_URL . "jquery/dist/jquery.min.js",
            'validateJs' => JS_URL. 'jquery.validate.min.js',
            "bootstrap" => COMP_URL . "bootstrap/dist/js/bootstrap.min.js",

            'Jdatatables' => COMP_URL . 'jsDatatable/jquery.dataTables.min.js',
            "JdatatablesButton2" => COMP_URL . 'jsDatatable/dataTables.buttons.min.js',
            "JdatatablesButton3" => COMP_URL . 'jsDatatable/jszip.min.js',
            "JdatatablesButton4" => COMP_URL . 'jsDatatable/pdfmake.min.js',
            "JdatatablesButton6" => COMP_URL . 'jsDatatable/vfs_fonts.js',
            "JdatatablesButton5" => COMP_URL . 'jsDatatable/buttons.html5.min.js',

            'sweetjs' => COMP_URL . 'sweet-alert/js/sweet-alert.min.js', 
            "ui-load" => JS_URL . "ui-load.min.js",
            "config" => JS_URL . "ui-jp.config.min.js",
            "jp" => JS_URL . "ui-jp.min.js",
            "nav" => JS_URL . "ui-nav.min.js",
            "toggle" =>JS_URL . "ui-toggle.min.js",

            // 'normal_datepickers' => JS_URL . 'datepicker.min.js',
            'bt_datepickers' => COMP_URL . 'datepicker/bootstrap-datetimepicker.min.js', 
            "cms.app" => JS_URL ."cms.app.js",
            'fancy' => COMP_URL . 'plugins/fancy/lightbox.min.js',
            // "texteditor" => ACCESS_URL . "ckeditor/ckeditor.js",
            "AdditionalV" => "//jqueryvalidation.org/files/dist/additional-methods.min.js",

            /*new1*/
            'google' => 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC55A_bYiYRMWF8oDVP0ic7C13xmz3M70o&libraries=places',
            
            'location' => COMP_URL . 'map/locationpicker.jquery.js',
            /* Location Auto complete */
            'geocomplete' => COMP_URL . 'map/jquery.geocomplete.min.js',

            /* chosen */
            'chosen' => COMP_URL . 'chosen/chosen.jquery.js',
            'chosen.proto' => COMP_URL . 'chosen/chosen.proto.js'
        );
    }

    /*
     * TO SET FAVICON ICON
     * 
     * CHANGE-IT
     */

    private function _setFaviconIcon() {
        $icon_path = IMAGE_URL . 'images/common/logo.ico';
        $this->favicon = '<link rel="shortcut icon" type="image/x-icon"  href="' . $icon_path . '" />';
    }

}