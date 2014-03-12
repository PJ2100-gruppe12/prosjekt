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

// ** MySQL settings - You can get this info from your web host ** //
/** Local Database */
define('DB_NAME', 'westerdals');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
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
define('AUTH_KEY',         '+7i:@h9^eoI(6S#=B?bKS`+4@BD,8q-Fx)g,GME8f%%b*xhQ<|-w<Sq!| ,#oHxj');
define('SECURE_AUTH_KEY',  'tf^NiG)xcO)sr-F+>>u38*p6$*s &@ :o%V%B8^|b9:2s(`A-Q(-Ku[.G|1Xu`e=');
define('LOGGED_IN_KEY',    'lChX;biZbr2|~r+^^Rfgfit[,2}oiK 3jlW|TH-(rGqG#I;4$E)vMmk+9dW}Uw8r');
define('NONCE_KEY',        'y?SZt.6BrZrjYkI-IP1&tZh6Tf8? E*<:`pcR 7vAhHI#gpReJZ]w`rK7VN`a&JQ');
define('AUTH_SALT',        'L-Xaa<6xqkxn1TQ|QCyrKQgW4#QvxS3dJ8wBC&iy1*0<+q%zR2?gj7jx+|TkSxD%');
define('SECURE_AUTH_SALT', '3LeRh.hUy=;83P7N1>E4rsd5H3Fh38AvUvBBfRIG8c@u RIlni2qnpuCq^j+5)6o');
define('LOGGED_IN_SALT',   '|N0aE^nxKG;>:33))=kVG:%7:s0^TKhi7k!BvhO!]:c9|n&_|BEKcXT*-n3(=KP(');
define('NONCE_SALT',       'b/EE-ZR6;E8VuA`~Gz^Gz;z!?F#+||K,7Z,wWw%|sdz,8p=F$V]>XSW{PSv<i7~ ');

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
