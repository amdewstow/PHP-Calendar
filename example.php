<?php
    include( 'calendar.php' );
    $cal = new calendar();
    $cal->get_dates_full( '9/8/2014' );
    $template = $cal->template();
    echo $cal->template_format( $template );
    $workers                               = array( );
    $workers[ ]                            = 'Bob';
    $workers[ ]                            = 'Bobby';
    $workers[ ]                            = 'Joe';
    $template_per_week                     = $cal->template_per_week( $workers );
    $cal->alltags[ 'n_0_date_1409612400' ] = 'blah';
    //  echo "\n\n<hr>\n\n".$template_per_week;
    echo "\n\n<hr>\n\n" . $cal->st( $cal->template_format( $template_per_week ), $cal->alltags );
    printr( $cal->alltags );
    function printr( $r ) {
        echo "<pre>" . print_r( $r, true ) . "</pre>";
    }
?>