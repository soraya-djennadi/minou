<?php

/*
 * function de debug
 *  affichera un text a charque appel
 */

global $debug;
$debug = true;

function debug($text) {
    global $debug;
    if ($debug) {
        echo "<br>\n $text \n<br>";
    }
}
