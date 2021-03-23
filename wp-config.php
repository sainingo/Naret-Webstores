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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wp-admin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Wp-admin@1408' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'U_-@Oq9`@rgvH[I[g{NJ)j(%iM+C-!KV,q6-`e$O9)sb0R )(w/}vKqG%X9?>!DR' );
define( 'SECURE_AUTH_KEY',  'rAY|&ps`Bf!Vr7q,Je Kwti}=sTg{%*|ci2QTjK]*m,KD%DY;/F:3}?/@eo@|5yy' );
define( 'LOGGED_IN_KEY',    'j}NNWOJL}Ti_Tw)kDp`*g7SIR3bPJ*JvL9$DM,AQJ?DkOcV#~-,xiK.y<LR]DH%m' );
define( 'NONCE_KEY',        '#X;ZR$gAQPSPV1H|K(~3}rX&ICnRSn?Kga84(*(]h8`,y}hf#O7U/0eWauh_GD+R' );
define( 'AUTH_SALT',        '(Z}5s$8U+zshTpOu0*Uq1:a5q3j(*MP2=skvkR_sAAixc/TpW^ThELTo333oq.uB' );
define( 'SECURE_AUTH_SALT', 'eXpusU{Ate$W6I`JJb4J4B*HuY{k8(m~CJ7ejjH*kI<9TgE|<p~wM)#u%Mp#:2dh' );
define( 'LOGGED_IN_SALT',   '^dG1+!XdE72 %3tO3KFl.!!D+wocws}4q8aw!!)KM?=B--gjVfxD99gpI4Soi_e.' );
define( 'NONCE_SALT',       'jTVA}YI~60cN*J9J&nNmNYRVdx=ZT1U$o5Fn l2FiHXR!B~6,E?Ie6a!{}-)Bw(y' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'FS_METHOD', 'direct');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

