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
define( 'DB_NAME', 'jarkom_wp_db' );

/** MySQL database username */
define( 'DB_USER', 'jarkom_wp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'tubessjk' );

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
define( 'AUTH_KEY',         '7].OOP,^LJp^F4?O=)e}w.X _uK^WQ;K]9calJqJdc.8$Igz4dVCE#Heh7 2[~5G' );
define( 'SECURE_AUTH_KEY',  'rSJS:=3ev|M*SXS;T.f4S{)T@GT{Jr8&eRDekI?I&Sz]mUYFn~_Wi84y7tZ{cZQ:' );
define( 'LOGGED_IN_KEY',    'mMRg_rwm4#f%aze@bU$[*b_NM[pPQIGCi$wS<>0fUZ@~fKx7}1-7f.XP9!&R;Bi ' );
define( 'NONCE_KEY',        'CkX8UIQwG,P#N2w|q/bc`[j._o~DtjDZM?}2 vv-&fbq@h)GDaGevCxqMDVk_B={' );
define( 'AUTH_SALT',        'vS*Ma^^%dXIu B<SkLH$:KeBPK/CIZ(eMa3o1m>akc*,WS-HVg}GYV=[l/P:n/(6' );
define( 'SECURE_AUTH_SALT', '>A3]L%$F218I<}{dV.vg8(v;fW@Nth5UvsOWEbk1{>2hJ{#hPQA]H)+.KwZJ+zZ:' );
define( 'LOGGED_IN_SALT',   '7c*CfYKErV1v$^+3%FC7xS[@`XzCj0}@B,Fo*I1 0nyV.Vs>Od5ZQ&p8GG#^[wA}' );
define( 'NONCE_SALT',       'N^oDJ}RVSj(>cp*&%[>Xcr}tx#1/%1_w;xz`7dtUu iDWcha<d3rRoc@<lDL_[8s' );

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
