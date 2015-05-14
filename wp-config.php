<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'a3=dDXC4KW;)}x`!PU_R-Xu@l5x|ucMCp&>Eh$i8|[*p78Dj}zN9bJ%IS;nenEL@');
define('SECURE_AUTH_KEY',  'sa?#&;$]v-Eb4VBiI<`TzjmL+?4|8&jK C;S+!i6|z*6+=sIN?E{Is@o7FBmp&|6');
define('LOGGED_IN_KEY',    '&S;5:q:!KOXIt40cXPK4|<n<m<A8R#zhBF:_Y?+Ny]3h0rYn6p.CU-3Wdu9TssP:');
define('NONCE_KEY',        'G-Ku%k$eHye?|=yf{^PY4nFqa0{MFx}n[*wDVTE.I1/^7`qR1J9Jn6+ptd|3#1L{');
define('AUTH_SALT',        '^`50poiPUCa)&-iNh .dditWq|2:tqg$am@2mrM6>|C{P<%aFXn3$-Z|Q/,cMA/]');
define('SECURE_AUTH_SALT', '#)h?%?BZ!ahS2U+aPNDq;=!iX_(Ks(t6J0k`9[L1]IjymM5_{1uT*BB-h$Yhc?!V');
define('LOGGED_IN_SALT',   '*~UW8cc.U sh)`}A|+|U@YbP4_IQ5:xCF|`)HIP:M_!L-y|g2{bA8+Cr {L:.?kp');
define('NONCE_SALT',       '9oP~{wBh&-U.ic~o(nPRS,}c&a^ A+_OZ|Y#d+!_`I@1GsoIw-;<xnEf,+_vC<OC');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
