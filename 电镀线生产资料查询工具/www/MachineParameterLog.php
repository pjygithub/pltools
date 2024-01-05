<?php
// 关闭报错
include(dirname(__DIR__) . '/www/function/close_debuger.php');
// 载入公共配置
include(dirname(__DIR__) . '/www/config/common_config.php');
// 机台号预处理
include(dirname(__DIR__) . '/www/function/using_machine.php');
// 输出机台选择信息
// echo '<pre>';
// print_r($machines_arr[$index]);
// echo '</pre>';
// 判断机台是否存在某个文件夹
if ($machines_arr[$index]['type'] == "RSA") {
    $dirname = 'ParameterLog/Machine';
} else {
    $dirname = 'ParameterLog/Machine';
}
include(dirname(__DIR__) . '/www/function/isexistDIR.php');
// 列出选定的日期、月份、年份
include(dirname(__DIR__) . '/www/function/Dates.php');
$Dates = Dates('Y');
// echo '<pre>';
// print_r($Dates);
// echo '<pre>';

// 打开并返回数据流 $data
$format_normal = '';
$format_rsa = '';
include(dirname(__DIR__) . '/www/function/get_data.php');
$data = get_data_lines($Dates, $dirname, $format_normal, $format_rsa);
// echo '<pre>';
// print_r($data);

// 定义显示的数据源(表头)
$tbheader = array(
    "RecordDateTime",
    "﻿Date1",
    "﻿Date",
    "Date1",
    "Date",
    "Time",
    "ToTime",
    "TankNo",
    "TankName",
    "Parameter",
    "From",
    "To",
    "Remark",
    "Remarks",
    "Remarks2",
    "Remarks3",
    "Reason",
    "Reason1",
    "Reason2",
    "Reason3",
    "L1 Status",
    "L2 Status",
    "L1 Status",
    "L2 Status",
    "L1Status",
    "L2Status",
    "File Name",
    "File Name",
);
$used_ = array_merge($tbheader);
$arr_used = array();
for ($i = 0; $i < count($data[0]); $i++) {
    if (!array_search($data[0][$i], $used_, TRUE)) {
        array_push($arr_used, $data[0][$i]);
    }
}
if (isset($_COOKIE['model']) and $_COOKIE['model'] == 'debuger') {
    $tbheader = $arr_used;
}
$cols = array();
// 根据表头获取$data索引
for ($i = 0; $i < count($data[0]); $i++) {
    for ($j = 0; $j < count($tbheader); $j++) {
        $r = array_search($tbheader[$j], $data[0], true);
        if (is_int($r)) {
            array_push($cols, $r);
        }
    }
}
// 表头数组消重
$cols = array_unique($cols);
$cols = array_values($cols);
// echo "<pre>";
// var_dump($data);
// echo "</pre>";
// die;

// 按需加载
if ($usezh_cn == 1) {
    if (isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'en') {
        include(dirname(__DIR__) . '/www/language/lang.en.php');
    } else {
        include(dirname(__DIR__) . '/www/language/lang.zh_CN.php');
    }
} else {
    if (isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'zh') {
        include(dirname(__DIR__) . '/www/language/lang.zh_CN.php');
    } else {
        include(dirname(__DIR__) . '/www/language/lang.en.php');
    }
}
// 按需加载
if (isset($_COOKIE['show']) and $_COOKIE['show'] == "table" or $_COOKIE['model'] == 'zh_help') {
    include(dirname(__DIR__) . '/www/viewer/table_' . $tableType . '.php');
} elseif (!isset($_COOKIE['model']) or $_COOKIE['model'] != 'debuger') {
    include(dirname(__DIR__) . '/www/viewer/table_' . $tableType . '.php');
} else {
    include(dirname(__DIR__) . '/www/viewer/echart.php');
}
