<?php

namespace App\Services;

class TextManager
{
    public function parseWith ($str, $ch='*') {

        $rand = rand(0, strlen($str)-1);
        for ( $i=0; $i<strlen($str); $i++ ) {
            if ( $i === $rand ) $str[$i] = '*';
        }
        return utf8_encode($str);
    }
    public function parseFullName ($str, $ch='*') {

        $arrayName = explode( " ", $str );
        $arrayNameRes = [];
        foreach ( $arrayName as $name ) {
            $rand = rand(0, strlen($name)-1);
            for ( $i=0; $i<strlen($name); $i++ ) if ( $i === $rand ) $name[$i] = '*';
            $arrayNameRes[] = utf8_encode($name);
        }
        return implode( ' ', $arrayNameRes );
    }
}