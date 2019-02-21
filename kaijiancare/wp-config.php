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
define('DB_NAME', 'kaijiancare');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'QD(xMrFgp[F OjYrOd/qUsr:s-1}H9t@DM%.K!$gWH&UtuO%8aij{V1 RHIkP>4T');
define('SECURE_AUTH_KEY',  '>jr|_CS2lkvzj%/epFGiqg+>3doGFbx{}2Y60Lr`Bj{k2;RY`5?|?69Mi>IU WY ');
define('LOGGED_IN_KEY',    'E;.pMFQ(fVjIIJbPenhWXp1Y9$9jkHS[U~O|UX1J^;SHRa/scOj,EF- z_BJs(-0');
define('NONCE_KEY',        '7QHv;8Fp1ke<M=}*E;26{F>hpdA-2<;jMStwX*+cd)Zbq-i|2j*qfYfZb)%l7Bh@');
define('AUTH_SALT',        '`I97`{~}W=eq`RdxV2}&j{+io_/w_N9ZiBDhWG*.H_y pecR$um#@Ns)VQ#SXNf9');
define('SECURE_AUTH_SALT', '7,RPV F3wI<80|/)?k`NocOgwHyuqF_%@Z?EHqH!%0>L(C5*ELKGH0R]=xG#[z~[');
define('LOGGED_IN_SALT',   'BV?u$-Z9|@sd(EE_OzAM04r[5wsr+s[D~J_+HK=cuMqe--*)n<{_]Z0blvH:Eg`R');
define('NONCE_SALT',       '/a0Y]q8vaW*FAKN=j1rBCm#iip<u3pp_|6g*ev6&Cqarr3YvM!(s3rNjv#dY_DB,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpnp_';

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

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'www.biao.com');
define('PATH_CURRENT_SITE', '/kaijiancare/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/** 关闭WordPress自动更新升级 */
define('AUTOMATIC_UPDATER_DISABLED',true);

