<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
    include( dirname( __FILE__ ) . '/local-config.php' );
	define( 'WP_LOCAL_DEV', true ); /** Use local dev settings **/
} else {
	define('DB_NAME', 'bitnami_wordpress'); /** The name of the database for WordPress */
	define('DB_USER', 'bn_wordpress'); /** MySQL database username */
	define('DB_PASSWORD', '4a7ede006b'); /** MySQL database password */
	define('DB_HOST', 'localhost:3306'); /** MySQL hostname */
}


define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/wordpress');
define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME']);

define('WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/content');
define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/content');



/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
/* Substitution already done */
define('AUTH_KEY', 'ca2c4f1d1ec9b7fd2811eba456cb5c4063ad8f9fc357134c90de2fa14d8454a7');
define('SECURE_AUTH_KEY', '6f3254f476cdffab36e1e36a630ca68660135a0fac9dbdccbc8841c89d0a629e');
define('LOGGED_IN_KEY', 'eadfd3e9a5364c71eb391f4242dbdeb3f37cb65b80f09ebeec2c383ba1089023');
define('NONCE_KEY', 'fb5e2c9a6f1329a75021f7abccd2f6b248fa204987415d9709d859750ccd3432');
define('AUTH_SALT', 'b3d0b773833b1c5ace6a6a5046e601d5fea26c27bfa44003e274cd0ddddde3a5');
define('SECURE_AUTH_SALT', '36974a6a919202ad47c45a7346b2941efd6fb3693b9edc61df2d6124cef56f21');
define('LOGGED_IN_SALT', 'b2d20a1ee54acf9a72e659db5c28d7b38a2fd396c49cac6ff2158e18d3de4368');
define('NONCE_SALT', 'db7192d3010753b0921a0cc3d54a9f443da5799be180ffd36b25dad92c03c29d');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('FS_METHOD', 'ftpext');
define('FTP_BASE', '/opt/bitnami/apps/wordpress/htdocs/');
define('FTP_USER', 'bitnami');
define('FTP_PASS', 'tsa9PLd1QLel6XE9Z9wIbGaEUTnVC6B8rUCPmMeieNkquTXEW2');
define('FTP_HOST', '127.0.0.1');
define('FTP_SSL', false);

