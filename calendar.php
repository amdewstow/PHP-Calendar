<?php
    class calendar {
        public function __construct( ) {
        }
        public function __get( $name = null ) {
            return $this->self[ $name ];
        }
        public function get_dates( $day ) {
            $ps          = strtotime( $day );
            $month_start = @mktime( 0, 0, 0, date( "n", $ps ), 1, date( "Y", $ps ), false );
            $month_end   = @mktime( 0, 0, 0, date( "n", $ps ), date( "t", $ps ), date( "Y", $ps ), false );
            $cal_start   = $month_start;
            $cal_end     = $month_end;
            echo "<br>S" . date( 'r', $cal_start );
            $ll = 0;
            while ( !( ( date( 'w', $cal_start ) == 0 ) ) ) {
                $cal_start -= 86400;
                echo "<br>S" . date( 'r', $cal_start );
                if ( $ll > 60 ) {
                    die( 'date error' );
                }
                $ll++;
            }
            echo "<br>E" . date( 'r', $cal_start );
            $ll = 0;
            while ( !( ( date( 'w', $cal_end ) == 6 ) ) ) {
                $cal_end += 86400;
                echo "<br>E" . date( 'r', $cal_end );
                if ( $ll > 60 ) {
                    die( 'date error' );
                }
                $ll++;
            }
            return range( $cal_start, $cal_end, 86400 );
        }
    }
?>