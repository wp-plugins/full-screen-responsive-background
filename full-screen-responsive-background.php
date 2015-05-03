<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       Full Screen Responsive Background
 * Plugin URI:        http://webs-spider.com/
 * Description:       Add Full Screen Responsive Background to your website easily, compatible with all browsers and with iPhone, iPad, and all phone and tablets.
 * Version:           1.2.1
 * Author:            Qassim Hassan
 * Author URI:        http://www.mbjtechnolabs.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function fsr_payment_gateway_for_woocommerce_standard_parameters($paypal_args) {
    $paypal_args['bn'] = 'mbjtechnolabs_SP';
    return $paypal_args;
}

function fsr_background_settings() {
    ?>
    <div class="wrap">
        <h2>Full Screen Responsive Background Settings</h2>
        <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) { ?>
            <div id="setting-error-settings_updated" class="updated settings-error"> 
                <p><strong>Settings saved.</strong></p>
            </div>
        <?php } ?>

        <form method="post" action="options.php">
            <?php settings_fields('setting_ibmu'); ?>
            <?php
            $background_image_url_value = wp_filter_kses(get_option('ibmu'));
            ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="ibmu">Background Link</label></th>
                        <td>
                            <input class="regular-text" name="ibmu" type="text" id="ibmu" placeholder="enter background image url" value="<?php echo esc_attr($background_image_url_value); ?>">
                            <?php
                            if (is_ssl()) {
                                echo '<p><a href="' . admin_url('media-new.php', 'https') . '" target="_blank">upload media</a></p>';
                            } else {
                                echo '<p><a href="' . admin_url('media-new.php', 'http') . '" target="_blank">upload media</a></p>';
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit"><input id="submit" class="button button-primary" type="submit" name="submit" value="Save Changes"></p>
        </form>
        <div class="clear"></div>
        <?php
    }

    function fsr_background() {
        add_theme_page('Full Screen Responsive Background Settings', 'Full Screen Responsive Background', 'edit_theme_options', 'fsr_background', 'fsr_background_settings');
    }

    function fsr_background_css() {

        // http://stackoverflow.com/questions/16548338/full-screen-responsive-background-image

        if (get_option('ibmu')) :
            ?>
            <style type="text/css">

                body{
                    -webkit-background-size:100% 100% !important;
                    -moz-background-size:100% 100% !important;
                    -ms-background-size:100% 100% !important;
                    background-image:none !important;
                    background:url(<?php echo esc_attr(wp_filter_kses(get_option('ibmu'))); ?>) fixed no-repeat !important;
                    background-size:100% 100% !important;
                    -o-background-size:100% 100% !important;
                }
                html{
                    background:none !important;
                    background-image:none !important;

                }


            </style>
            <?php
        endif;
    }

    function rfb_register_setting() {
        register_setting('setting_ibmu', 'ibmu');
    }

    if (is_admin()) {
        add_action('admin_menu', 'fsr_background');
        add_action('admin_init', 'rfb_register_setting');
    }
    add_filter('woocommerce_paypal_args', 'fsr_payment_gateway_for_woocommerce_standard_parameters', 99, 1);
    add_action('wp_head', 'fsr_background_css', 999);
    ?>