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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'growgoal' );

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
define( 'AUTH_KEY',         '?5]}Gf6pf8t`tr8P0tq!>*eJ%S [Kt`@%Uv*tR1A$~fqYo2u0LQlkRzHK_[z]0M_' );
define( 'SECURE_AUTH_KEY',  '=]e2qFoQg6nmieE!pn$|c]x7,vZaF:p|%1i$[o.Cn6VJ  c,;MoC~.RN$7-%~9`q' );
define( 'LOGGED_IN_KEY',    'D7 XFD(< Q6lW[R`p@2W6dN6aot~?u1t`<ueo~T[j2H[0O6lVy1e.A(_V:u{B}{o' );
define( 'NONCE_KEY',        '2D >xm%b8O-]+hcJkOiZ?H3M0fuL53;#Zzn*/5!=`&`zj`MIu?Z?Dw0xL00{88NX' );
define( 'AUTH_SALT',        '+*Q re^b0*4QS3_pp<1MqZY.K!Ehk{!q7C>b<_$ETtfxq=I-sJUH<J~U]p@S=7,8' );
define( 'SECURE_AUTH_SALT', 'D|6; dVIY#6ri:e&_T;C3.xWorO<to([vz 5,xyMx66WR*x/W}U4kUB%:5xmz,0@' );
define( 'LOGGED_IN_SALT',   ':yaT~MtVJd8PD.KASU`V9k.Ua:-CE4:kq|GT>D Y3Hf^x#q;*.`T+KWZerp>*VXw' );
define( 'NONCE_SALT',       '0=4I2DdmzddYqqKB( dAxpd`i9J^(y[<0m[X^&8)ktW}jO5v=~3FY[mOpSDP[R%9' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
