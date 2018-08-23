<?php
//Common Functions
function mssql_escape_string($string) {
        if ( !isset($string) or empty($string) ) return '';
        if ( is_numeric($string) ) return $string;

// replace common unicode characters with their ASCII equivalents
    $string = preg_replace("/\xC2\x80/", "\x80", $string);
    $string = preg_replace("/\xC2\x81/", "\x81", $string);
    $string = preg_replace("/\xC2\x82/", "\x82", $string);
    $string = preg_replace("/\xC2\x83/", "\x83", $string);
    $string = preg_replace("/\xC2\x84/", "\x84", $string);
    $string = preg_replace("/\xC2\x85/", "\x85", $string);
    $string = preg_replace("/\xC2\x86/", "\x86", $string);
    $string = preg_replace("/\xC2\x87/", "\x87", $string);
    $string = preg_replace("/\xC2\x88/", "\x88", $string);
    $string = preg_replace("/\xC2\x89/", "\x89", $string);
    $string = preg_replace("/\xC2\x8A/", "\x8A", $string);
    $string = preg_replace("/\xC2\x8B/", "\x8B", $string);
    $string = preg_replace("/\xC2\x8C/", "\x8C", $string);
    $string = preg_replace("/\xC2\x8D/", "\x8D", $string);
    $string = preg_replace("/\xC2\x8E/", "\x8E", $string);
    $string = preg_replace("/\xC2\x8F/", "\x8F", $string);
    $string = preg_replace("/\xC2\x90/", "\x90", $string);
    $string = preg_replace("/\xC2\x91/", "\x91", $string);
    $string = preg_replace("/\xC2\x92/", "\x92", $string);
    $string = preg_replace("/\xC2\x93/", "\x93", $string);
    $string = preg_replace("/\xC2\x94/", "\x94", $string);
    $string = preg_replace("/\xC2\x95/", "\x95", $string);
    $string = preg_replace("/\xC2\x96/", "\x96", $string);
    $string = preg_replace("/\xC2\x97/", "\x97", $string);
    $string = preg_replace("/\xC2\x98/", "\x98", $string);
    $string = preg_replace("/\xC2\x99/", "\x99", $string);
    $string = preg_replace("/\xC2\x9A/", "\x9A", $string);
    $string = preg_replace("/\xC2\x9B/", "\x9B", $string);
    $string = preg_replace("/\xC2\x9C/", "\x9C", $string);
    $string = preg_replace("/\xC2\x9D/", "\x9D", $string);
    $string = preg_replace("/\xC2\x9E/", "\x9E", $string);
    $string = preg_replace("/\xC2\x9F/", "\x9F", $string);
    $string = preg_replace("/\xC2\xA0/", "\xA0", $string);
    $string = preg_replace("/\xC2\xA1/", "\xA1", $string);
    $string = preg_replace("/\xC2\xA2/", "\xA2", $string);
    $string = preg_replace("/\xC2\xA3/", "\xA3", $string);
    $string = preg_replace("/\xC2\xA4/", "\xA4", $string);
    $string = preg_replace("/\xC2\xA5/", "\xA5", $string);
    $string = preg_replace("/\xC2\xA6/", "\xA6", $string);
    $string = preg_replace("/\xC2\xA7/", "\xA7", $string);
    $string = preg_replace("/\xC2\xA8/", "\xA8", $string);
    $string = preg_replace("/\xC2\xA9/", "\xA9", $string);
    $string = preg_replace("/\xC2\xAA/", "\xAA", $string);
    $string = preg_replace("/\xC2\xAB/", "\xAB", $string);
    $string = preg_replace("/\xC2\xAC/", "\xAC", $string);
    $string = preg_replace("/\xC2\xAD/", "\xAD", $string);
    $string = preg_replace("/\xC2\xAE/", "\xAE", $string);
    $string = preg_replace("/\xC2\xAF/", "\xAF", $string);
    $string = preg_replace("/\xC2\xB0/", "\xB0", $string);
    $string = preg_replace("/\xC2\xB1/", "\xB1", $string);
    $string = preg_replace("/\xC2\xB2/", "\xB2", $string);
    $string = preg_replace("/\xC2\xB3/", "\xB3", $string);
    $string = preg_replace("/\xC2\xB4/", "\xB4", $string);
    $string = preg_replace("/\xC2\xB5/", "\xB5", $string);
    $string = preg_replace("/\xC2\xB6/", "\xB6", $string);
    $string = preg_replace("/\xC2\xB7/", "\xB7", $string);
    $string = preg_replace("/\xC2\xB8/", "\xB8", $string);
    $string = preg_replace("/\xC2\xB9/", "\xB9", $string);
    $string = preg_replace("/\xC2\xBA/", "\xBA", $string);
    $string = preg_replace("/\xC2\xBB/", "\xBB", $string);
    $string = preg_replace("/\xC2\xBC/", "\xBC", $string);
    $string = preg_replace("/\xC2\xBD/", "\xBD", $string);
    $string = preg_replace("/\xC2\xBE/", "\xBE", $string);
    $string = preg_replace("/\xC2\xBF/", "\xBF", $string);
    $string = preg_replace("/\xC3\x80/", "\xC0", $string);
    $string = preg_replace("/\xC3\x81/", "\xC1", $string);
    $string = preg_replace("/\xC3\x82/", "\xC2", $string);
    $string = preg_replace("/\xC3\x83/", "\xC3", $string);
    $string = preg_replace("/\xC3\x84/", "\xC4", $string);
    $string = preg_replace("/\xC3\x85/", "\xC5", $string);
    $string = preg_replace("/\xC3\x86/", "\xC6", $string);
    $string = preg_replace("/\xC3\x87/", "\xC7", $string);
    $string = preg_replace("/\xC3\x88/", "\xC8", $string);
    $string = preg_replace("/\xC3\x89/", "\xC9", $string);
    $string = preg_replace("/\xC3\x8A/", "\xCA", $string);
    $string = preg_replace("/\xC3\x8B/", "\xCB", $string);
    $string = preg_replace("/\xC3\x8C/", "\xCC", $string);
    $string = preg_replace("/\xC3\x8D/", "\xCD", $string);
    $string = preg_replace("/\xC3\x8E/", "\xCE", $string);
    $string = preg_replace("/\xC3\x8F/", "\xCF", $string);
    $string = preg_replace("/\xC3\x90/", "\xD0", $string);
    $string = preg_replace("/\xC3\x91/", "\xD1", $string);
    $string = preg_replace("/\xC3\x92/", "\xD2", $string);
    $string = preg_replace("/\xC3\x93/", "\xD3", $string);
    $string = preg_replace("/\xC3\x94/", "\xD4", $string);
    $string = preg_replace("/\xC3\x95/", "\xD5", $string);
    $string = preg_replace("/\xC3\x96/", "\xD6", $string);
    $string = preg_replace("/\xC3\x97/", "\xD7", $string);
    $string = preg_replace("/\xC3\x98/", "\xD8", $string);
    $string = preg_replace("/\xC3\x99/", "\xD9", $string);
    $string = preg_replace("/\xC3\x9A/", "\xDA", $string);
    $string = preg_replace("/\xC3\x9B/", "\xDB", $string);
    $string = preg_replace("/\xC3\x9C/", "\xDC", $string);
    $string = preg_replace("/\xC3\x9D/", "\xDD", $string);
    $string = preg_replace("/\xC3\x9E/", "\xDE", $string);
    $string = preg_replace("/\xC3\x9F/", "\xDF", $string);
    $string = preg_replace("/\xC3\xA0/", "\xE0", $string);
    $string = preg_replace("/\xC3\xA1/", "\xE1", $string);
    $string = preg_replace("/\xC3\xA2/", "\xE2", $string);
    $string = preg_replace("/\xC3\xA3/", "\xE3", $string);
    $string = preg_replace("/\xC3\xA4/", "\xE4", $string);
    $string = preg_replace("/\xC3\xA5/", "\xE5", $string);
    $string = preg_replace("/\xC3\xA6/", "\xE6", $string);
    $string = preg_replace("/\xC3\xA7/", "\xE7", $string);
    $string = preg_replace("/\xC3\xA8/", "\xE8", $string);
    $string = preg_replace("/\xC3\xA9/", "\xE9", $string);
    $string = preg_replace("/\xC3\xAA/", "\xEA", $string);
    $string = preg_replace("/\xC3\xAB/", "\xEB", $string);
    $string = preg_replace("/\xC3\xAC/", "\xEC", $string);
    $string = preg_replace("/\xC3\xAD/", "\xED", $string);
    $string = preg_replace("/\xC3\xAE/", "\xEE", $string);
    $string = preg_replace("/\xC3\xAF/", "\xEF", $string);
    $string = preg_replace("/\xC3\xB0/", "\xF0", $string);
    $string = preg_replace("/\xC3\xB1/", "\xF1", $string);
    $string = preg_replace("/\xC3\xB2/", "\xF2", $string);
    $string = preg_replace("/\xC3\xB3/", "\xF3", $string);
    $string = preg_replace("/\xC3\xB4/", "\xF4", $string);
    $string = preg_replace("/\xC3\xB5/", "\xF5", $string);
    $string = preg_replace("/\xC3\xB6/", "\xF6", $string);
    $string = preg_replace("/\xC3\xB7/", "\xF7", $string);
    $string = preg_replace("/\xC3\xB8/", "\xF8", $string);
    $string = preg_replace("/\xC3\xB9/", "\xF9", $string);
    $string = preg_replace("/\xC3\xBA/", "\xFA", $string);
    $string = preg_replace("/\xC3\xBB/", "\xFB", $string);
    $string = preg_replace("/\xC3\xBC/", "\xFC", $string);
    $string = preg_replace("/\xC3\xBD/", "\xFD", $string);
    $string = preg_replace("/\xC3\xBE/", "\xFE", $string);
    $string = preg_replace("/\xC3\xBF/", "\xFF", $string);
 
    // remove all control characters
    $string = str_replace(chr(0), '', $string);
    $string = preg_replace("/[\x01-\x08]/", "", $string);
    $string = preg_replace("/[\x0E-\x1F]/", "", $string);
    $string = preg_replace("/\x7F/", "", $string);
    $string = preg_replace("/\x81/", "", $string);
    $string = preg_replace("/\x8D/", "", $string);
    $string = preg_replace("/\x8F/", "", $string);
    $string = preg_replace("/\x90/", "", $string);
    $string = preg_replace("/\x9D/", "", $string);
 
    // convert special characters
    $string = preg_replace("/\x91/", "'", $string);
    $string = preg_replace("/\x92/", "'", $string);
    $string = preg_replace("/\x93/", '"', $string);
    $string = preg_replace("/\x94/", '"', $string);
    $string = preg_replace("/\x96/", '-', $string);
    $string = preg_replace("/\x97/", '-', $string);
    $string = preg_replace("/\xA0/", " ", $string);
 
    // double quote any single quotes
    $string = str_replace("'", "''", $string );

    // finally, remove any leading/trailing whitespace
    $string = trim($string);

        return $string;
    }
?>