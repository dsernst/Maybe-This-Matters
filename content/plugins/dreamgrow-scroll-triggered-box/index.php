<?php
require (ABSPATH . WPINC . '/pluggable.php');
require ('stb_admin.php');
/*
Plugin Name: Scroll Triggered Box
Plugin URI: http://dreamgrow.com
Description: Scroll Triggered Box
Version: 1.3.1
Author: Dreamgrow Digital
Author URI: http://dreamgrow.com
License: GPL2
*/
class ScrollBox
{
    function __construct()
    {
        add_action('wp_footer', array($this, 'stb_footer_include'));
        add_action('wp_enqueue_scripts', array($this, 'stb_enqueue_scripts'));
        add_action('wp_ajax_stb_form_process', array($this, 'stb_form_process'));
        add_action('wp_ajax_nopriv_stb_form_process', array($this, 'stb_form_process'));
    }

    function stb_form_process()
    {
        $nonce = $_POST['stbNonce'];

        if (!wp_verify_nonce($nonce, 'stb-nonce'))
            die ('Busted!');

        if (isset($_POST['data']['submitted'])) {
            parse_str($_POST['data'], $data);
            if (trim($data['email']) === '') {
                $emailError = __('Please enter your email address.', 'stb');
                $hasError = true;
            } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($data['email']))) {
                $emailError = __('You entered an invalid email address.', 'stb');
                $hasError = true;
            } else {
                $email = trim($data['email']);
            }

            if (!isset($hasError)) {
                $emailTo = get_option('admin_email');
                $subject = __('Newsletter registration for ' . get_bloginfo('name'));
                $body = __('Email') . ': ' . $email;
                $headers = 'From: ' . $emailTo . "\r\n" . 'Reply-To: ' . $email;

                wp_mail($emailTo, $subject, $body, $headers);
                echo __('You are subscribed. Thank You!', 'stb');
                die();
            } else {
                echo $emailError;
                die();
            }
        }
    }

    function stb_visible()
    {
        $options = get_option('stb_settings');
        $frontpage_id = get_option('page_on_front');
        global $post;
        $postID = $post->ID;
        $current = get_post_type($postID);

        // Visible to admins only
        if ($options['show_admin']) {
            $current_user = wp_get_current_user();
            if ($current_user->user_level < 8)
                return false;
        }

        // Show on frontpage
        if ($frontpage_id == $postID && isset($options['show']['frontpage']))
            return true;

        // Visible at
        if (!isset($options['show'][$current]))
            return false;

        return true;
    }

    function stb_footer_include()
    {
        // Vars
        global $post;
        $options = get_option('stb_settings');
        $template = $options['theme'];

        $content = get_option('stb_html');
        $content = function_exists('icl_get_languages') ? $content[ICL_LANGUAGE_CODE] : $content[0];

        // Social buttons
        $socialJS = '';
        $socialHTML = '<ul class="stb_social">';

        if ($options['social']['facebook']) {
            $socialJS .= '//Facebook
                        if (typeof (FB) != "undefined") {
                            FB.init({ status: true, cookie: true, xfbml: true });
                        } else {
                            jQuery.getScript("http://connect.facebook.net/en_US/all.js#xfbml=1", function () {
                                FB.init({ status: true, cookie: true, xfbml: true });
                            });
                        }';
            $socialHTML .= '<li class="fb ' . $options['social']['facebook'] . '"><div class="fb-like" data-send="false" data-layout="' . $options['social']['facebook'] . '" data-width="200" data-show-faces="false"></div></li>';
        }
        if ($options['social']['twitter']) {
            $socialJS .= '//Twitter
                        if (typeof (twttr) != "undefined") {
                            twttr.widgets.load();
                        } else {
                            jQuery.getScript("http://platform.twitter.com/widgets.js");
                        }';
            $socialHTML .= '<li class="twitter ' . $options['social']['twitter'] . '"><a href="https://twitter.com/share" data-url="'.get_permalink($post->ID).'" data-text="'.$post->post_title.'" class="twitter-share-button" ';
            if ($options['social']['twitter'] == 'no-count')
                $socialHTML .= 'data-count="none"';
            if ($options['social']['twitter'] == 'vertical')
                $socialHTML .= 'data-count="vertical"';
            $socialHTML .= ' >Tweet</a></li>';
        }
        if ($options['social']['google']) {
            $socialJS .= '//Google - Note that the google button will not show if you are opening the page from disk - it needs to be http(s)
                        if (typeof (gapi) != "undefined") {
                            jQuery(".g-plusone").each(function () {
                                gapi.plusone.render($(this).get(0));
                            });
                        } else {
                            jQuery.getScript("https://apis.google.com/js/plusone.js");
                        }';
            $socialHTML .= '<li class="google ' . $options['social']['google'] . '"><div class="g-plusone" ';
            if ($options['social']['google'] == 'annotation')
                $socialHTML .= 'data-size="medium" data-annotation="none"';
            else
                $socialHTML .= 'data-size="' . $options['social']['google'] . '"';
            $socialHTML .= ' ></div></li>';
        }
        if ($options['social']['linkedin']) {
            $socialJS .= '//Linked-in
                        if (typeof (IN) != "undefined") {
                            IN.parse();
                        } else {
                            jQuery.getScript("http://platform.linkedin.com/in.js");
                        }';
            $socialHTML .= '<li class="linkedin ' . $options['social']['linkedin'] . '"><script type="IN/Share"';
            if ($options['social']['linkedin'] != 'none')
                $socialHTML .= ' data-counter="' . $options['social']['linkedin'] . '" ';
            $socialHTML .= '></script></li>';
        }
        if ($options['social']['stumbleupon']) {
            $socialJS .= '//Stumbleupon
                      jQuery.getScript("//platform.stumbleupon.com/1/widgets.js");';
            $socialHTML .= '<li class="stumbleupon s' . $options['social']['stumbleupon'] . '"><su:badge layout="' . $options['social']['stumbleupon'] . '"></su:badge></li>';
        }
        if ($options['social']['pinterest'] && has_post_thumbnail($post->ID)) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
            $socialJS .= '//Pinterest
                      jQuery.getScript("//platform.stumbleupon.com/1/widgets.js");';
            $socialHTML .= '<li class="pinterest ' . $options['social']['pinterest'] . '"><a href="http://pinterest.com/pin/create/button/?url=' . get_permalink() . '&media=' . $image[0] . '" class="pin-it-button" count-layout="' . $options['social']['pinterest'] . '"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></li>';
        }
        $socialHTML .= '</ul>';
        $closed = (isset($_COOKIE['nopopup'])) ? 'true' : 'false';

        // Add css
        if ($this->stb_visible()) {
            if ($options['include_css'] == 1) echo '<link rel="stylesheet" type="text/css" media="screen" href="' . plugin_dir_url(__FILE__) . 'templates/' . $template . '/style.css" />';

            // Box html
            $width = $options['width'];

            if ($options['position'] == 'middle') {
                $position = 'left:50%; margin-left:-' . $width / 2 . 'px';
            } else
                $position = $options['position'] . ': 10px;';

            echo '<div id="scrolltriggered" style="width: ' . $width . 'px;' . $position . '"><div id="inscroll">
                  <a href="#close" id="closebox">x</a>' .
                $content . $socialHTML .
                '</div></div>';

            // JS variables
            echo '<script type="text/javascript">
                    var stb = {
                        hascolsed: ' . $closed . ',
                        cookieLife: ' . $options['cookie_life'] . ',
                        triggerHeight: ' . $options['trigger_height'] . ',
                        stbElement: "' . $options['trigger_element'] . '"
                    }; ';
            if ($socialJS != '')
                echo 'jQuery(window).load(function () {
                        stb.social = function(){' . $socialJS . ' };
                        stb.social();
                      });';

            echo '</script >';
            if ($options['social']['facebook'])
                echo '<div id="fb-root"></div>';

        }
    }

    function stb_enqueue_scripts()
    {
        if ($this->stb_visible()) {
            wp_enqueue_script('jquery');
            wp_enqueue_script(
                'stb_script',
                plugin_dir_url(__FILE__) . 'stb_init . js',
                array('jquery', 'jquery_cookie'),
                '1.2',
                true
            );
            wp_enqueue_script(
                'jquery_cookie',
                plugin_dir_url(__FILE__) . 'jquery . cookie . js',
                array('jquery'),
                '1.3',
                true
            );
        }
        $data = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'stbNonce' => wp_create_nonce('stb-nonce')
        );
        wp_localize_script('stb_script', 'stbAjax', $data);
    }
}

$stb = new ScrollBox();
$stb_admin = new ScrollBox_admin();
?>