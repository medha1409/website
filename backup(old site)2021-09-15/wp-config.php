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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'laughiu3_958' );

/** MySQL database username */
define( 'DB_USER', 'laughiu3_958' );

/** MySQL database password */
define( 'DB_PASSWORD', 'E36A1CDFc805fgd4mqt9h2' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'fy:?kBvVc/EI+|yiXQ-$-Sh( Pztb4v8p[<C-@F5;cHzOO>=vq;m2a6CY7F-jk|X');
define('SECURE_AUTH_KEY',  'VGr}dR|k4t^<2jk-xi8Ssr/;1_Le.5,g$6o2UJ]J/A*t`AoP4lBd$!PQz^,n0<~z');
define('LOGGED_IN_KEY',    'x_P`{l+V1Lul+s]J`]?W`*Kyj$!i]LcgZzYGFKuCskXDZZ_+-.Qp?zAFqs`+d $O');
define('NONCE_KEY',        'b]8r?Y6zJ@@<~K@1oB+Rl[d(sRd^Q/.8IOmk+]_)[x!>6+#U|E_Srg2iqB~-wwzJ');
define('AUTH_SALT',        '9=P[<lJCtk/h(1|5Ck$H$7-lv-]I#$zSP@Um^[#xrH0tWn- *O(9vdr|aF~X=XC=');
define('SECURE_AUTH_SALT', 'CZQhg`AS/--O/f-f$?K8/K*~(j&A1xUQvjSh$WUM3BJ0JGQ$7_EZuh$jL$@F}beC');
define('LOGGED_IN_SALT',   'W;nu2a6cZbFgAp=[J^g0%5MYyk=O> M8Xc|!5Zjagj#zFQ$E-1-3,;Tbf9>|%|eh');
define('NONCE_SALT',       '9M6-JLvp+6% Jn>QwewtSImGT[ ux.y%+KFkd#tMij[I>]!jb]n(Q#5-2Ea[n2c}');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '958_';



define( 'AUTOSAVE_INTERVAL',    300  );
define( 'WP_POST_REVISIONS',    5    );
define( 'EMPTY_TRASH_DAYS',     7    );
define( 'WP_AUTO_UPDATE_CORE',  true );
define( 'WP_CRON_LOCK_TIMEOUT', 120  );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
