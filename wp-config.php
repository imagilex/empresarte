<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'empresarte');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         ',T[ d4lGrt-ZGsHy?f$jm`kE3;N+C@tb6vXRn;JIZQf]eH;A#wY7WM>v8]D8m:o/');
define('SECURE_AUTH_KEY',  '_Cl=9~vW4Ml60,#{&sn@Co)tw|**{}W?,BD0- t4m*8i.8<#w bFk#uHMO>xBbx+');
define('LOGGED_IN_KEY',    '6}i^uCCAo/`S:oHcq8le%.).<+P*j_iGiItcL$>O)<j=5w(}j?S)LC%iat5<~pA1');
define('NONCE_KEY',        'Df/tiz[-x(z&a8&XoE6YwRC$$l&&B(i+ZU2LBgszDJcQl;PX<YoDh;)7=-0QY, s');
define('AUTH_SALT',        '8`DVmeFB:z#`_-/T]|%_c=_M+_v?WI?F_6K.(W9[4h#gPO.15CL:Wf1=#zCQXK,;');
define('SECURE_AUTH_SALT', 'QO.{UMMyUE;59d7OY03;|?)j_XHGbF`2 ;}VZpeW}cS/}kOeOhtoLvwEI!|osP-6');
define('LOGGED_IN_SALT',   'B h5km%)N[65{&loT4U{m4ruOfDG6$QrF/b=nHHvrW_I;luu7@Dd9a;+t_{0Dw5R');
define('NONCE_SALT',       ')8z0,=.|v(..`_5YK*d]=A_wj_xI9|Z|G(4TDDJqAR`]@][D!8%9[iW6hWRS4q<&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'local_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
