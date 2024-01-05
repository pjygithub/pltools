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
if ($machines_arr[$index]['type'] == 'RSA') {
    $dirname = 'Alarm';
} else {
    $dirname = 'ErrorLog';
}
include(dirname(__DIR__) . '/www/function/isexistDIR.php');
// 列出选定的日期、月份、年份
include(dirname(__DIR__) . '/www/function/Dates.php');
if ($machines_arr[$index]['id'] == '34') {
    $Dates = Dates('Y-m-d');
} else {
    $Dates = Dates('Y-m');
}

// echo '<pre>';
// print_r($Dates);
// echo '<pre>';

// 打开并返回数据流 $data
$format_normal = '_error';
$format_rsa = 'Alarm_';
include(dirname(__DIR__) . '/www/function/get_data.php');
$data = get_data_lines($Dates, $dirname, $format_normal, $format_rsa);
// echo '<pre>';
// print_r($data);

// 定义显示的数据源(表头)
$tbheader = array(
    "Time",
    "AlarmDateTime",
    "Error Code",
    "ErrorCode",
    "error code",
    "AlarmCode",
    "Error Code",
    "error code",
    "line",
    "Line",
    "Product",
    "Device",
    "AlarmNote",
    "AlarmNoteEn",
    "description",
    "Description",
    "ErrDesc",
    "err desc",
    "Err Desc",
    "err desc",
    "errdesc",
    "Err Desc",
    "Remark",
    "Remark1",
    "Remark2",
    "Remark3",
    "Remarks",
    "Remarks1",
    "Remarks2",
    "Remarks3",
    "Reason",
    "Reason1",
    "Reason2",
    "Reason3",
    "Mode",
    "StopNormal",
    "StopMotion",
    "Machine",
);
$used_ = array_merge($tbheader);
$arr_used = array();
$count_data0 = count($data[0]);
for ($i = 0; $i < $count_data0; $i++) {
    if (!array_search($data[0][$i], $used_, TRUE)) {
        array_push($arr_used, $data[0][$i]);
    }
}
if (isset($_COOKIE['model']) and $_COOKIE['model'] == 'debuger') {
    $tbheader = $arr_used;
}
$cols = array();
// 根据表头获取$data索引
for ($i = 0; $i < $count_data0; $i++) {
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
// print_r($data);
// echo "</pre>";
// die;
// 线体筛选
$tbheader_line = array(
    "line",
    "Line",
);
$cols_line = array();
// 根据表头获取$data索引
for ($i = 0; $i < $count_data0; $i++) {
    for ($j = 0; $j < count($tbheader_line); $j++) {
        $r = array_search($tbheader_line[$j], $data[0], true);
        if (is_int($r)) {
            array_push($cols_line, $r);
        }
    }
}
// cols_line数组消重
$cols_line = array_unique($cols_line);
$cols_line = array_values($cols_line);
$data_tmp = $data;
$count_data_tmp = count($data_tmp);
$data = array();
array_push($data, $data_tmp[0]);
for ($i = 1; $i < $count_data_tmp; $i++) {
    if (isset($_COOKIE['line']) and $_COOKIE['line'] != 'lineall') {
        $line = str_replace('line', '', $_COOKIE['line']);
        for ($j = 0; $j < count($cols_line); $j++) {
            if ($data_tmp[$i][$cols_line[$j]] == $line) {
                array_push($data, $data_tmp[$i]);
            }
        }
    } else {
        array_push($data, $data_tmp[$i]);
    }
}

$count_data = count($data);
if ($count_data == 1) {
    array_push($data, array('',));
}
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
