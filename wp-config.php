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
define('AUTH_KEY',         'oi@-Ao3&606PQq$_X>ekxtgr[wa*zTmLGBFf.?BG;cK[>-(JeE%7<?r)J{E`]]z4');
define('SECURE_AUTH_KEY',  '1o(Q{DPPex4Lax)x[dL[[1d;Isg, GL8Dw@U)g./l^fP`P:rEUsfY@IKMFS?m3;3');
define('LOGGED_IN_KEY',    '=} )n}jw><fqop*vP:-q-ZYQ`=Q.[[a%`+yL-;8$-ckbLa`49#ds}L*j{J&83tt2');
define('NONCE_KEY',        'O>BIAh_h!G?8GSSp}6x0R}gZnO?E. JMY]l{Ly+%&*R30KeFq=/ui-(/*NuhAx(3');
define('AUTH_SALT',        ',h`,uxyS7y}3bZ59cYzNmbEUZz[ax2RW>IVd&=xCy|L9=VycEL*E.O?sYsu`zmI@');
define('SECURE_AUTH_SALT', 'o~I.[p<Eqyx~%!BeSRz&QnGFx#+(KDq*Qw 3m9=$r&JjGb&@5zj>2m8-U?j:.sS.');
define('LOGGED_IN_SALT',   'r5YY*f=}>TMi$OERe]_TbjyglEFP.8Z*U!eL^Eo:e3/:F{EL9(%)qahpmsQypTC9');
define('NONCE_SALT',       'V5-{%lwbXWoPFkNP9a?qKEJ@$P49(&7JdHNmKs*C{Es;<{joYBZl*.RH1)#B<jbh');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
