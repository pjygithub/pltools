<?php
/*
 * Author: Jones Pon
 * Version: 0.2.1
 * Release date: 2023/03/18
 */
function lang($str)
{
    $_lang = array();
    // array_search($str, $_arr);
    if (isset($_lang[$str]) and $_lang[$str] != "") {
        return $_lang[$str];
    } else {
        return $str;
    }
}

// echo lang("L1 Conductivity");
