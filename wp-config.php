<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'educationsite' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'VQ?[GsvG*{JqZ2<9a#!W~B,?kwzG6 .g4}k^i7X!0?-Hkm0sX<C.$D7rg>#B{&Tm' );
define( 'SECURE_AUTH_KEY',  'B%G,hUtVKxB#{<N>(dQMR,O$^pPfaWzQ,@&T%+tZ3/KNEc3cQ!3f&c2YaBtDCmCW' );
define( 'LOGGED_IN_KEY',    '@)^SM;svCKNcHrD/eZ=I}.q4zZG-9{p9R+1y3x}6=<4mnMJ&027T2gA>Z,6<:nS,' );
define( 'NONCE_KEY',        '+klCC=Cv& cxD.bP]+xiCN|`Ae&L_{3TXG[ 8ng2nx={DBVku/-p/^h3C2O>{vA=' );
define( 'AUTH_SALT',        'LP]fFO#&kH!yx(M2=[T1!3@NdzHui%sq ?Y?DlDR%evCXrk?b~oRJj$Q_k=:*jB.' );
define( 'SECURE_AUTH_SALT', '2t/`>9] yk$qL.?67O3_qw$[-)R oBdCqT+u!1gysQZL;ft+DA`(Kz8?_f.p%+3B' );
define( 'LOGGED_IN_SALT',   '0y* 3VYG?M q`3XnCFcj|zi4cYtfKUBtF0bt j^0uQF-[{x8~ibSK:D249~Z%eJv' );
define( 'NONCE_SALT',       'vBgzGEkvl$J-/l}}~xkdq6uLerz/k9;[+U2k`V%d/n3$eJLU ih!VqE?R3qUJ|LV' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
