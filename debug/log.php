
<?php
function gt_log($message) {
    $backtrace = debug_backtrace();
    error_log( explode('gt-hyper-asides/',$backtrace[0]['file'])[1] . ' >> ' . 
               $backtrace[1]['function'] . '(' . $backtrace[0]['line'] . ")\n\t\t\t   :: " . 
               $message . "\n " );
} 