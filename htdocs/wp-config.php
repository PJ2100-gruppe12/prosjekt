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
// Use these settings on the local server
if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) ) {
  include( dirname( __FILE__ ) . '/wp-config-local.php' );
  
// Otherwise use the below settings (on live server)
} else {

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'nesconsult_no');

/** MySQL database username */
define('DB_USER', 'nesconsult_no');

/** MySQL database password */
define('DB_PASSWORD', '68Z6g2Gj');

/** MySQL hostname */
define('DB_HOST', 'nesconsult.no.mysql');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
}
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'i),H>a5r^+b;m1ZAeQ]ib%m)%@8H<lQXcG(q|kY7Lm38.#7L?Cv1CJf3%4MmE.W|');
define('SECURE_AUTH_KEY',  'Pmw?+`?;.,T^S`O{pnP=B;obvE+7 SJb{Be;-Wa?wGj0fV++K2YpGa)TccUu=j]#');
define('LOGGED_IN_KEY',    '=dE7mxW>,E2rD++jj8R>F1.p)LUe_I{2~i-7TB?-M#+kr=F]zD{CDZ_jMyt3!s%M');
define('NONCE_KEY',        '%Zx`isM9m})y8C!#U3MfXhP%L/1qgL)$|Q<FO&&+t5Uz0k@7(wZF_(WgJ_:7HP]T');
define('AUTH_SALT',        'a%dq<@E4xo[K!@pF(R4 ~3&yqt@MT/L0] &m9g-_&T:5Rk}[H^IJ*E{9>Qy}mT_g');
define('SECURE_AUTH_SALT', 'ALuayViUry-|-.E>piBE^;}:v1Hs%VA&w&sDDw+^,|4:-V+au35?}!Vip/~`HNX.');
define('LOGGED_IN_SALT',   'e%T.MHp}M,Auwq?)4+`sA}gFX+u@#b^WZKGYmMsEaS>Z+1rVtAA<G/O=a#w7UV0N');
define('NONCE_SALT',       'zC$r;VWoBO!^+r*e+jHlTh=@/b[DoPbEQ*aKg}C~LgFv5|Bn<aCx-X-Lp`[!@mT}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pj_';

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
