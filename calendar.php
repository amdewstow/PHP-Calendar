<?php
    class calendar {
        public $days_full = null;
        public $df = 'd';
        public $dfo = 'm/d';
        public $alltags = array( );
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
            $cal_start   = $cal_start - ( date( 'w', $cal_start ) * 86400 );
            $cal_end     = $cal_end + ( ( 6 - date( 'w', $cal_end ) ) * 86400 );
            return range( $cal_start, $cal_end, 86400 );
        }
        public function get_dates_full( $day ) {
            $ps                   = strtotime( $day );
            $month_start          = @mktime( 0, 0, 0, date( "n", $ps ), 1, date( "Y", $ps ), false );
            $month_end            = @mktime( 0, 0, 0, date( "n", $ps ), date( "t", $ps ), date( "Y", $ps ), false );
            $cal_start            = $month_start;
            $cal_end              = $month_end;
            $cal_start            = $cal_start - ( date( 'w', $cal_start ) * 86400 );
            $cal_end              = $cal_end + ( ( 6 - date( 'w', $cal_end ) ) * 86400 );
            $out                  = array( );
            $out[ 'month_start' ] = $month_start;
            $out[ 'month_end' ]   = $month_end;
            $out[ 'cal_start' ]   = $cal_start;
            $out[ 'cal_end' ]     = $month_end;
            $out[ 'days' ]        = range( $cal_start, $cal_end, 86400 );
            $out[ 'weeks' ]       = array( );
            for ( $ii = 0; $ii < ( count( $out[ 'days' ] ) / 7 ); $ii++ ) {
                $out[ 'weeks' ][ ] = array_slice( $out[ 'days' ], ( $ii * 7 ), 7 );
            }
            $this->days_full = $out;
            return $out;
        }
        public function template( ) {
            $days = $this->days_full[ 'days' ];
            if ( $days == null ) {
                $this->get_dates_full( date( 'r' ) );
                $days = $this->days_full[ 'days' ];
            }
            $out = '';
            $out .= '<div class="cal">';
            $out .= '<span class="date_month">{date_month}</span>';
            $out .= '<table>';
            for ( $ii = 0; $ii < ( count( $days ) / 7 ); $ii++ ) {
                $week = array_slice( $days, ( $ii * 7 ), 7 );
                $out .= "\n<tr>";
                foreach ( $week as $kk ) {
                    $out .= "<td id='d" . $kk . "'>{date_" . $kk . "}</td>";
                }
                $out .= "</tr>";
            }
            $out .= '</table>';
            $out .= '</div>';
            return $out;
        }
        public function template_per_week( $per_week ) {
            $days = $this->days_full[ 'days' ];
            if ( $days == null ) {
                $this->get_dates_full( date( 'r' ) );
                $days = $this->days_full[ 'days' ];
            }
            $out = '';
            $out .= '<div class="cal">';
            $out .= '<span class="date_month">{date_month}</span>';
            $out .= '<table>';
            for ( $ii = 0; $ii < ( count( $days ) / 7 ); $ii++ ) {
                $week = array_slice( $days, ( $ii * 7 ), 7 );
                $out .= "\n<tr>";
                $out .= "<td id='n" . $ii . "'>-</td>";
                foreach ( $week as $kk ) {
                    $out .= "<td id='d" . $kk . "'>{date_" . $kk . "}</td>";
                }
                foreach ( $per_week as $nn => $kz ) {
                    $out .= "\n<tr>";
                    $out .= "<td id='n" . $nn . "'>{n_" . $nn . "}</td>";
                    $this->alltags[ "n_" . $nn ] = $kz;
                    foreach ( $week as $kk ) {
                        $out .= "<td id='d" . $nn . "_" . $kk . "'>{n_" . $nn . "_date_" . $kk . "}</td>";
                        $this->alltags[ "n_" . $nn . "_date_" . $kk ] = '';
                        ;
                    }
                    $out .= "</tr>";
                }
            }
            $out .= '</table>';
            $out .= '</div>';
            return $out;
        }
        public function template_format( $s ) {
            $fm = date( 'm', $this->days_full[ 'month_start' ] );
            $s  = str_replace( '{date_month}', date( 'F', $this->days_full[ 'month_start' ] ), $s );
            $ar = array( );
            foreach ( $this->days_full[ 'days' ] as $day ) {
                if ( date( 'm', $day ) == $fm ) {
                    $ar[ 'date_' . $day ] = date( $this->df, $day );
                } else {
                    $ar[ 'date_' . $day ] = date( $this->dfo, $day );
                }
            }
            $s = $this->st( $s, $ar );
            return $s;
        }
        public function st( $s, $a ) {
            foreach ( $a as $kk => $vv ) {
                $s = str_replace( '{' . $kk . '}', $vv, $s );
            }
            return $s;
        }
    }
?>