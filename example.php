<?php
    include( 'calendar.php' );
    $cal   = new calendar();
    $dates = $cal->get_dates( '10/8/2014' );
    printr( $dates );
    function printr( $r ) {
        echo "<pre>" . print_r( $r, true ) . "</pre>";
    }
?>