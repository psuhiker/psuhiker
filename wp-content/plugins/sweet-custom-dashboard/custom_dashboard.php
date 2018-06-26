<?php
/**
 * Our custom dashboard page
 */

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/admin.php' );
require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<?php include (TEMPLATEPATH . '/custom-dashboard.php' ); ?>

<?php include( ABSPATH . 'wp-admin/admin-footer.php' );