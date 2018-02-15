<?php
if (!function_exists('gt_log')) {
    function gt_log($message) {
        
        if (gettype($message) == 'array' || gettype($message) == 'object' ) {
            $message =  var_export($message, true);
        }

        $backtrace = debug_backtrace();
        $exploded_path = explode('gt-hyper-asides/',$backtrace[0]['file']);
        $file_name = $exploded_path[count($exploded_path) - 1];
        
        error_log( $file_name . ' >> ' . 
                   $backtrace[1]['function'] . '(' . $backtrace[0]['line'] . ")\n\t\t\t   :: " . $message . "\n " );
                   
    } 
}