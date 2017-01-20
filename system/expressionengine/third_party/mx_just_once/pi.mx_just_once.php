<?php

/**
 *  MX Just Once Class for ExpressionEngine2
 *
 * @package  ExpressionEngine
 * @subpackage Plugins
 * @category Plugins
 * @author    Max Lazar <max@eec.ms>
 */



$plugin_info = array(
    'pi_name' => 'MX Just Once',
    'pi_version' => '1.0.0',
    'pi_author' => 'Max Lazar',
    'pi_author_url' => 'http://eec.ms/',
    'pi_description' => 'MX Just Once helps you to show repeated text only once.',
    'pi_usage' => Mx_just_once::usage()
);


if ( ! function_exists( 'ee' ) ) {
    function ee() {
        static $EE;
        if ( ! $EE ) $EE = get_instance();
        return $EE;
    }
}


class Mx_just_once {
    var $return_data = "";
    var $cache = "";

    /**
     * [__construct description]
     *
     * @param boolean $settings [description]
     */
    public function __construct( $settings=FALSE ) {
        $name    = ee()->TMPL->fetch_param( 'name' );
        $value   = ee()->TMPL->fetch_param( 'value' );
        $pattern = ee()->TMPL->fetch_param( 'pattern', FALSE );
        $this->return_data = '';

        $this->cache =& ee()->session->cache[__CLASS__];

        if ( !isset( $this->cache[$name] ) ) {
            $this->cache[$name] = "";
        }

        if ( $this->cache[$name] != $value ) {
            $this->return_data  = ( ( $pattern ) ? str_replace( "%v", $value, $pattern ) : $value );
            $this->cache[$name] = $value;
        }

        return $this->return_data;
    }

    // ----------------------------------------
    //  Plugin Usage
    // ----------------------------------------

    // This function describes how the plugin is used.
    //  Make sure and use output buffering

    static function usage() {
        ob_start();
?>

Tags:
{exp:mx_just_once name="title" value="category_1" pattern="<h5>%v</h5>" random}
{exp:mx_just_once name="title" value="category_1" pattern="<h5>%v</h5>" random}
{exp:mx_just_once name="title" value="category_2" pattern="<h5>%v</h5>" random}
{exp:mx_just_once name="title" value="category_2" pattern="<h5>%v</h5>" random}
{exp:mx_just_once name="title" value="category_3" pattern="<h5>%v</h5>" random}

output:
<h5>category_1</h5>
<h5>category_2</h5>
<h5>category_3</h5>

<?php
        $buffer = ob_get_contents();

        ob_end_clean();

        return $buffer;
    }
    /* END */

}

/* End of file pi.mx_just_once.php */
/* Location: ./system/expressionengine/third_party/mx_just_once/pi.mx_just_once.php */
