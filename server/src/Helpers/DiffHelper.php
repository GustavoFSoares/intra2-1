<?php
namespace Helper;

class DiffHelper {
    public static function diff( $ary_1, $ary_2 ) {
        $diff = array();

        foreach ( $ary_1 as $v1 ) {
            $flag = 0;
            foreach ( $ary_2 as $v2 ) {
            $flag |= ( $v1 == $v2 );
            if ( $flag ) break;
            }
            if ( !$flag ) array_push( $diff, $v1 );
        }

        foreach ( $ary_2 as $v2 ) {
            $flag = 0;
            foreach ( $ary_1 as $v1 ) {
                $flag |= ( $v1 == $v2 );
                if ( $flag ) break;
            }
            if (!$flag && !in_array( $v2, $diff )) array_push( $diff, $v2 );
        }

        return $diff;
    }
}
