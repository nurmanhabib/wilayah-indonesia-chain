<?php

if (!function_exists('safe_array_access')) {
    function safe_array_access($ar){
        $numargs        = func_num_args();
        $arg_list       = func_get_args();
        $aritterator    = $ar;
        
        for ($i = 1; $i < $numargs; $i++) {
            if (isset($aritterator[$arg_list[$i]]) || array_key_exists($arg_list[$i], $aritterator)) {
                $aritterator = $aritterator[$arg_list[$i]];
            } else {
                return false;
            }
        }

        return $aritterator;
    }
}