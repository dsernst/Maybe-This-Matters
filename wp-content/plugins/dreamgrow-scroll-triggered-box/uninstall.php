<?php
    if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
        exit();
    function uninstall(){
        delete_option( 'stb_settings' );
        delete_option( 'stb_html' );
    }
    uninstall();
?>