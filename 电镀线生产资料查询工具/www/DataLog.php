<?php
// 关闭报错
include(dirname(__DIR__) . '/www/function/close_debuger.php');
// 载入公共配置
include(dirname(__DIR__) . '/www/config/common_config.php');
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
// 机台号预处理
include(dirname(__DIR__) . '/www/function/using_machine.php');
// 输出机台选择信息
// echo '<pre>';
// print_r($machines_arr[$index]);
// 判断机台是否存在某个文件夹
if ($machines_arr[$index]['type'] == 'RSA') {
    $dirname = 'Rsa';
} else {
    $dirname = 'DataLog';
}
include(dirname(__DIR__) . '/www/function/isexistDIR.php');
// 列出选定的日期、月份、年份
include(dirname(__DIR__) . '/www/function/Dates.php');
$Dates = Dates('Y-m-d');
// echo '<pre>';
// print_r($Dates);

// 打开并返回数据流 $data
$format_normal = '_data';
$format_rsa = 'Rsa_';
include(dirname(__DIR__) . '/www/function/get_data.php');
$data = get_data_lines($Dates, $dirname, $format_normal, $format_rsa);
// echo '<pre>';
// print_r($data);


// 定义显示的数据源(表头)
(!isset($_COOKIE['type']) or $_COOKIE['type'] == '') && $_COOKIE['type'] = "main";
include(dirname(__DIR__) . '/www/tbheader/DataLog_used.php');
$arr_unused = array();
$count_data = count($data[0]);
for ($i = 0; $i < $count_data; $i++) {
    if (!array_search($data[0][$i], $used_all, TRUE)) {
        array_push($arr_unused, $data[0][$i]);
    }
}
switch ($_COOKIE['type']) {
    case 'mainPlatingTankCurr':
        include(dirname(__DIR__) . '/www/tbheader/DataLog_mainPlatingTankCurr.php');
        $tbheader = array_merge($DataLog_mainPlatingTankCurr);
        break;
    case 'otherCurrents':
        include(dirname(__DIR__) . '/www/tbheader/DataLog_otherCurrents.php');
        $tbheader = array_merge($DataLog_otherCurrents);
        // echo '<pre>';
        // print_r($tbheader);
        break;
    case 'L1CurrRunSpeed':
        include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Current.php');
        include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Speed.php');
        $tbheader = array_merge($DataLog_L1_Current, $DataLog_L1_Speed);
        break;
    case 'L1Voltage':
        include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Voltage.php');
        $tbheader = array_merge($DataLog_L1_Voltage);
        break;
    case 'L2CurrRunSpeed':
        include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Current.php');
        include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Speed.php');
        $tbheader = array_merge($DataLog_L2_Current, $DataLog_L2_Speed);
        break;
    case 'L2Voltage':
        include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Voltage.php');
        $tbheader = array_merge($DataLog_L2_Voltage);
        break;
    case 'L3CurrRunSpeed':
        include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Current.php');
        include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Speed.php');
        $tbheader = array_merge($DataLog_L3_Current, $DataLog_L3_Speed);
        break;
    case 'L3Voltage':
        include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Voltage.php');
        $tbheader = array_merge($DataLog_L3_Voltage);
        break;
    case 'L4CurrRunSpeed':
        include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Current.php');
        include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Speed.php');
        $tbheader = array_merge($DataLog_L4_Current, $DataLog_L4_Speed);
        break;
    case 'L4Voltage':
        include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Voltage.php');
        $tbheader = array_merge($DataLog_L4_Voltage);
        break;
    case 'Temperatures':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_Temperature.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Temperature.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Temperature.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Temperature.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Temperature.php');
            $tbheader = array_merge($DataLog_L0_Temperature, $DataLog_L1_Temperature, $DataLog_L2_Temperature, $DataLog_L3_Temperature, $DataLog_L4_Temperature);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Temperature.php');
                }
            }
        }
        break;
    case 'Current':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_Current.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Current.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Current.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Current.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Current.php');
            $tbheader = array_merge($DataLog_L0_Current, $DataLog_L1_Current, $DataLog_L2_Current, $DataLog_L3_Current, $DataLog_L4_Current);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Current.php');
                }
            }
        }
        break;
    case 'Voltage':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_Voltage.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Voltage.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Voltage.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Voltage.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Voltage.php');
            $tbheader = array_merge($DataLog_L0_Voltage, $DataLog_L1_Voltage, $DataLog_L2_Voltage, $DataLog_L3_Voltage, $DataLog_L4_Voltage);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Voltage.php');
                }
            }
        }
        break;
    case 'Speed':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_Speed.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Speed.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Speed.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Speed.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Speed.php');
            $tbheader = array_merge($DataLog_L0_Speed, $DataLog_L1_Speed, $DataLog_L2_Speed, $DataLog_L3_Speed, $DataLog_L4_Speed);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Speed.php');
                }
            }
        }
        break;
    case 'Temperature':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Temperature.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Temperature.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Temperature.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Temperature.php');
            $tbheader = array_merge($DataLog_L0_Temperature, $DataLog_L1_Temperature, $DataLog_L2_Temperature, $DataLog_L3_Temperature, $DataLog_L4_Temperature);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Temperature.php');
                }
            }
        }
        break;
    case 'FlowRate':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_FlowRate.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_FlowRate.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_FlowRate.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_FlowRate.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_FlowRate.php');
            $tbheader = array_merge($DataLog_L0_FlowRate, $DataLog_L1_FlowRate, $DataLog_L2_FlowRate, $DataLog_L3_FlowRate, $DataLog_L4_FlowRate);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_FlowRate.php');
                }
            }
        }
        break;
    case 'Conductivity':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Conductivity.php');
            $tbheader = array_merge($DataLog_L0_Conductivity, $DataLog_L1_Conductivity, $DataLog_L2_Conductivity, $DataLog_L3_Conductivity, $DataLog_L4_Conductivity);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Conductivity.php');
                }
            }
        }
        break;
    case 'EBOtime':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Conductivity.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Conductivity.php');
            $tbheader = array_merge($DataLog_L0_Conductivity, $DataLog_L1_Conductivity, $DataLog_L2_Conductivity, $DataLog_L3_Conductivity, $DataLog_L4_Conductivity);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Conductivity.php');
                }
            }
        }
        break;
    case 'Pressure':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_Pressure.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_Pressure.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_Pressure.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_Pressure.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_Pressure.php');
            $tbheader = array_merge($DataLog_L0_Pressure, $DataLog_L1_Pressure, $DataLog_L2_Pressure, $DataLog_L3_Pressure, $DataLog_L4_Pressure);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_Pressure.php');
                }
            }
        }
        break;
    case 'AmpMin':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_AmpMin.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_AmpMin.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_AmpMin.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_AmpMin.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_AmpMin.php');
            $tbheader = array_merge($DataLog_L0_AmpMin, $DataLog_L1_AmpMin, $DataLog_L2_AmpMin, $DataLog_L3_AmpMin, $DataLog_L4_AmpMin);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_AmpMin.php');
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_AmpMin.php');
                }
            }
        }
        break;
    case 'OnOffPumpSpeed':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_OnOffPumpSpeed.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_OnOffPumpSpeed.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_OnOffPumpSpeed.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_OnOffPumpSpeed.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_OnOffPumpSpeed.php');
            $tbheader = array_merge($DataLog_L0_OnOffPumpSpeed, $DataLog_L1_OnOffPumpSpeed, $DataLog_L2_OnOffPumpSpeed, $DataLog_L3_OnOffPumpSpeed, $DataLog_L4_OnOffPumpSpeed);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_OnOffPumpSpeed.php');
                }
            }
        }
        break;
    case 'other':
        if (!isset($_COOKIE['line']) || $_COOKIE['line'] == 'lineall') {
            include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_other.php');
            include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_other.php');
            include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_other.php');
            include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_other.php');
            include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_other.php');
            $tbheader = array_merge($DataLog_L0_other, $DataLog_L1_other, $DataLog_L2_other, $DataLog_L3_other, $DataLog_L4_other);
        } else {
            for ($i = 0; $i < 5; $i++) {
                if ($_COOKIE['line'] == 'line' . $i) {
                    include(dirname(__DIR__) . '/www/tbheader/L' . $i . '/DataLog_L' . $i . '_other.php');
                }
            }
        }
        break;
    case 'unUsed':
        $tbheader = $arr_unused;
        break;
    case 'DIY':
        if ($_COOKIE['model'] != 'debuger' or $_COOKIE['model'] != 'zh_help' && $_COOKIE['type'] == 'DataLog') {
            include(dirname(__DIR__) . '/www/function/DIY.php');
        }
        break;
    default:
        include(dirname(__DIR__) . '/www/tbheader/L0/DataLog_L0_default.php');
        include(dirname(__DIR__) . '/www/tbheader/L1/DataLog_L1_default.php');
        include(dirname(__DIR__) . '/www/tbheader/L2/DataLog_L2_default.php');
        include(dirname(__DIR__) . '/www/tbheader/L3/DataLog_L3_default.php');
        include(dirname(__DIR__) . '/www/tbheader/L4/DataLog_L4_default.php');
        $tbheader = array_merge($DataLog_L0_default, $DataLog_L1_default, $DataLog_L2_default, $DataLog_L3_default, $DataLog_L4_default);
        break;
}
// 去重复
$tbheader = array_unique($tbheader);
$tbheader = array_values($tbheader);
$tbheader = array_filter($tbheader);
// $extraInfo = array(
//     "L1 Lot ID",
//     "L1 Lot ID",
//     "L2 Lot ID",
//     "L2 Lot ID",
//     "L3 Lot ID",
//     "L3 Lot ID",
//     "L4 Lot ID",
//     "L1 Device",
//     "L1 Product Name",
//     "L1 Product Name",
//     "L1PartNumber",
//     "L2 Device",
//     "L2 Product Name",
//     "L2 Product Name",
//     "L2PartNumber",
//     "L3 Device",
//     "L3 Product Name",
//     "L3 Product Name",
//     "L4 Product Name",
//     "Strand 1 Device Name",
//     "Strand 2 Device Name",
//     "Strand 1 Device Name",
//     "Strand 2 Device Name",
// );
if (isset($_COOKIE['model']) and $_COOKIE['model'] == 'debuger') {

    $tbheader = $arr_unused;
}
$cols = array();
$extraCols = array();
// 根据表头获取$data索引
$count_cols = count($data[0]);
for ($i = 0; $i < $count_cols; $i++) {
    for ($j = 0; $j < count($tbheader); $j++) {
        $r = array_search($tbheader[$j], $data[0], true);
        if (is_int($r)) {
            array_push($cols, $r);
        }
    }
}
for ($i = 0; $i < $count_cols; $i++) {
    for ($j = 0; $j < count($extraInfo); $j++) {
        $r = array_search($extraInfo[$j], $data[0], true);
        if (is_int($r)) {
            array_push($extraCols, $r);
        }
    }
}
// 表头数组消重
$cols = array_unique($cols);
$cols = array_values($cols);
// print_r($cols);

// 按需加载
if ($_COOKIE['show'] == "table"  or $_COOKIE['model'] == 'zh_help') {
    include(dirname(__DIR__) . '/www/viewer/table_' . $tableType . '.php');
} elseif ($_COOKIE['type'] == 'EBOtime') {
    include(dirname(__DIR__) . '/www/viewer/ebotime.php');
} else {
    include(dirname(__DIR__) . '/www/viewer/echart.php');
}
