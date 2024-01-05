<?php
include(dirname(__DIR__) . '/language/L0/common.lang.zh_CN.php');
include(dirname(__DIR__) . '/language/L0/downtime.lang.zh_CN.php');
include(dirname(__DIR__) . '/language/L0/mode.lang.zh_CN.php');
include(dirname(__DIR__) . '/language/L0/tabletitle.lang.zh_CN.php');
include(dirname(__DIR__) . '/language/L0/startstop.lang.zh_CN.php');
include(dirname(__DIR__) . '/language/L0/errorlog.lang.zh_CN.php');
include(dirname(__DIR__) . '/language/L0/temp.lang.zh_CN.php');
// $_lang = array();
$_lang = array_merge($zh_lang_common, $zh_lang_downtime, $zh_lang_model, $zh_lang_tableTitle, $zh_lang_startstop, $zh_lang_errorlog, $zh_lang_temp);
// $_lang = array();
// $_lang = array_merge_recursive($zh_lang_common, $zh_lang_downtime, $zh_lang_model, $zh_lang_tableTitle, $zh_lang_StartStopLog);
// echo "<pre>";
// print_r($_lang);
foreach ($_lang as $key => $value) {
    echo '"' . $key . '" => "' . $value . '",<br>';
}
