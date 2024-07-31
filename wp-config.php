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
define( 'DB_NAME', 'dacphatland' );

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
define( 'AUTH_KEY',         'P!ObKJM+v&r7j86^6q*M;1+W?|g~~K0:p4KKM_kJB~&h}j^xV1|1f4JB}EWI-uh@' );
define( 'SECURE_AUTH_KEY',  'Z.|t~5~n%SJ_A[ 2w5{*?2.}#Nc:ohJe!}yrWLOEJ/;JH1EEp`TH7`zph<q8dqIA' );
define( 'LOGGED_IN_KEY',    'Y+oodU43 1EH8yz8]p(UW^N4WoUh&c+= yZR/(daq%iF}+e4~c+umMG}XAQ7|09b' );
define( 'NONCE_KEY',        '~}7SV4RoR&tg+e|jHk8z&~0D=pS^u>XgSTcm>=m@lt/HCR.6]Zhh, z-rO?^uLGA' );
define( 'AUTH_SALT',        '9K em> R~4Iav&>K9PJ0<K64AOQa6=RV7QA04JVa0t6wAsZNZ*M,>q,)`Dc<p85,' );
define( 'SECURE_AUTH_SALT', '8Aiq7&0X~0v aw5 ai@RLW.]q3)!UfPIQh+I5]mG`Sz!GPKj/D~,_>z6MxsH=Kd3' );
define( 'LOGGED_IN_SALT',   '/:zmDWzQF/)@t3_PJ!|f3O9E|s{C#5P]?I)PEb=J6W;HV(.4|dvyFJOuJ{5~W$8&' );
define( 'NONCE_SALT',       '^yd{tg.ZS(mlOJVwr#/]diu40SfRncb1?Pq(B!tHEkT3r}Y.2XW+8!0Vk@f,@x>e' );

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
