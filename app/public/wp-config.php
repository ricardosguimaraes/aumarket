<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          ')xLh,{=k)yd9o<6P<9dirSPTtuGO}lgc4U^W858Ha*aq8K4^eP.8X+bhzHajL}I%' );
define( 'SECURE_AUTH_KEY',   '5-l~~:L*m^Cp.YNb*VNm,IZi,^aCesL5BsY$CA/N7KsbJ,JbzZYq*!)Vcj{yVVe@' );
define( 'LOGGED_IN_KEY',     'ejq0zEN!ln17 ;*]!L,^QOE.L^zI4d;BM{v_!h|?My^2%TL;`+*6#y*6%#~sIWVN' );
define( 'NONCE_KEY',         'vQCl@h07:lD]iS:wBGmRZ,n|=FG|[c)u}Xft}3pUH_+^cbW6(0 Z7SujEL/s}4Bb' );
define( 'AUTH_SALT',         'XAb0rApLV`LgN<a1=eB9[2Y!?]bkJ;z1vo#*Qp@~z8jSjov2KAeL|0@Y ,qQ*dG^' );
define( 'SECURE_AUTH_SALT',  '^Z|#q|e:**R~iTaMb!AdrNGKBkH=;5~w~nUP1~_FjzgwF8+K,)/#+*dGABj&>vyh' );
define( 'LOGGED_IN_SALT',    'yl,7^zA6]9#gf-QA=?dM_}fA35{8Nfk,>h[ZJKK]gH_lGtAz49euTAT)mwIXftd2' );
define( 'NONCE_SALT',        'BB.~$_?1BrFeX}!W#Q/c.XGrR&u/4h|kv?#HP!JX1z<eC!IHuj=8i&3[5#eKqmz}' );
define( 'WP_CACHE_KEY_SALT', ';]aHB7:QcDJC78.H=D:?2DZb/lq7sxp00F&,$#s@-6U#4:aow&/KpjDy%+ATh^xG' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
