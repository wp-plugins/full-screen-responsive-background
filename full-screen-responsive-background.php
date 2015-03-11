<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       Full Screen Responsive Background
 * Plugin URI:        http://www.mbjtechnolabs.com
 * Description:       Add Full Screen Responsive Background to your website easily, compatible with all browsers and with iPhone, iPad, and all phone and tablets.
 * Version:           1.0.0
 * Author:            phpwebcreators
 * Author URI:        http://www.mbjtechnolabs.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}


if (is_admin()) {


    function full_screen_responsive_background() {
        add_theme_page('Full Screen Responsive Background Settings', 'Full Screen Responsive Background', 'edit_theme_options', 'full_screen_responsive_background', 'full_screen_responsive_background_settings');
    }

    add_action('admin_menu', 'full_screen_responsive_background');

    function rfb_register_setting() {
        register_setting('setting_field_background_image_url', 'field_background_image_url');
    }

    add_action('admin_init', 'rfb_register_setting');

    function full_screen_responsive_background_settings() {
        ?>
        <div class="wrap">
            <h2>Full Screen Responsive Background Settings</h2>
            <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) { ?>
                <div id="setting-error-settings_updated" class="updated settings-error"> 
                    <p><strong>Settings saved.</strong></p>
                </div>
            <?php } ?>

            <form method="post" action="options.php">
                <?php settings_fields('setting_field_background_image_url'); ?>
                <?php
                $background_image_url_value = wp_filter_kses(get_option('field_background_image_url'));
                ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><label for="field_background_image_url">Background Link</label></th>
                            <td>
                                <input class="regular-text" name="field_background_image_url" type="text" id="field_background_image_url" placeholder="enter background image url" value="<?php echo esc_attr($background_image_url_value); ?>">
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

    }

    function full_screen_responsive_background_css() {
        ?>

        <?php if (get_option('field_background_image_url')) : ?>

            <style type="text/css">

                html{
                    background-image:none !important;
                    background:none !important;
                }

                body{
                    background-image:none !important;
                    background:url(<?php echo esc_attr(wp_filter_kses(get_option('field_background_image_url'))); ?>) fixed no-repeat !important;
                    background-size:100% 100% !important;
                    -webkit-background-size:100% 100% !important;
                    -moz-background-size:100% 100% !important;
                    -ms-background-size:100% 100% !important;
                    -o-background-size:100% 100% !important;
                }
            </style>
        <?php endif; ?>

        <?php
    }

    add_action('wp_head', 'full_screen_responsive_background_css', 999);
    ?>