<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="javascript:window.history.go(-1);">点此返回</a>
    <pre>
<?php
// var_dump($_P/OST);
echo ("写入/更新信息如下（为空正常，其他可能有异常。<span style='color:red'>如果是第一次保存设置，可能有较多错误输出！请“点此返回”后再次保存设置，重复步骤直到输出<br>array(0) {<br>}<br></span><br>");
function isValueInArray($array, $value)
{
    foreach ($array as $subArray) {
        if (in_array($value, array_column($array, 'tbheader'))) {
            return true;
        }
    }
    return false;
}
(!isset($_POST['tbheaderID']) or empty($_POST['tbheaderID'])) ? ($arr_hiddenID = array()) : ($arr_hiddenID = $_POST['tbheaderID']);
(!isset($_POST['tbheader_type']) or empty($_POST['tbheader_type'])) ? ($_POST['tbheader_type'] = array()) : ($_POST['tbheader_type'] = $_POST['tbheader_type']);
(!isset($_POST['tbheader_L0']) or empty($_POST['tbheader_L0'])) ? ($_POST['tbheader_L0'] = array()) : ($_POST['tbheader_L0'] = $_POST['tbheader_L0']);
(!isset($_POST['tbheader_L1']) or empty($_POST['tbheader_L1'])) ? ($_POST['tbheader_L1'] = array()) : ($_POST['tbheader_L1'] = $_POST['tbheader_L1']);
(!isset($_POST['tbheader_L2']) or empty($_POST['tbheader_L2'])) ? ($_POST['tbheader_L2'] = array()) : ($_POST['tbheader_L2'] = $_POST['tbheader_L2']);
(!isset($_POST['tbheader_L3']) or empty($_POST['tbheader_L3'])) ? ($_POST['tbheader_L3'] = array()) : ($_POST['tbheader_L3'] = $_POST['tbheader_L3']);
(!isset($_POST['tbheader_L4']) or empty($_POST['tbheader_L4'])) ? ($_POST['tbheader_L4'] = array()) : ($_POST['tbheader_L4'] = $_POST['tbheader_L4']);
(!isset($_POST['tbheader_main']) or empty($_POST['tbheader_main'])) ? ($_POST['tbheader_main'] = array()) : ($_POST['tbheader_main'] = $_POST['tbheader_main']);
(!isset($_POST['tbheader_isNum']) or empty($_POST['tbheader_isNum'])) ? ($_POST['tbheader_isNum'] = array()) : ($_POST['tbheader_isNum'] = $_POST['tbheader_isNum']);
$db_file = dirname(__DIR__) . "/config/db_datalog_table_pltool.sqlite3";
$db_handle = new SQLite3($db_file);
// 检测连接是否成功
if (!$db_handle) {
    die("数据库连接失败: " . $db_handle->lastErrorMsg());
}
// 执行SQL语句
$arr_tbheader = array();
$results_tbheader = $db_handle->query('SELECT * FROM `tb_tbheader`');
while ($row = $results_tbheader->fetchArray()) {
    $ID = $row["ID"];
    $tbheader = $row["tbheader"];
    $type = $row["type"];
    $L0 = $row["L0"];
    $L1 = $row["L1"];
    $L2 = $row["L2"];
    $L3 = $row["L3"];
    $L4 = $row["L4"];
    $default = $row["default"];
    $main = $row["main"];
    $isNum = $row["isNum"];
    $res = compact("ID", "tbheader", "type", "L0", "L1", "L2", "L3", "L4", "default", "main", "isNum");
    array_push($arr_tbheader, $res);
}
// var_dump($arr_tbheader);
// die;
$e = array();
$count_tbheader = count($arr_tbheader);
$count_tbheaderID = count($arr_hiddenID);
// 处理tbheader_type
for ($i = 0; $i < $count_tbheaderID; $i++) {
    $a_tbheaderID = $arr_hiddenID[$i];
    $b_type = $_POST['tbheader_type'][$i];
    if (isValueInArray($arr_tbheader, $a_tbheaderID) == true) {
        // 已存在，更新
        $sql = 'UPDATE `tb_tbheader` SET `type`="' . $b_type . '" WHERE `tbheader`="' . $a_tbheaderID . '";COMMIT;';
    } else {
        // 不存在，插入
        $sql = 'INSERT INTO `tb_tbheader` (`tbheader`,`type`) VALUES  ("' . $a_tbheaderID . '","' . $b_type . '");COMMIT;';
    }
    // var_dump($sql);
    $results = $db_handle->query($sql);
    // 检测SQL执行是否成功
    if (!$results) {
        array_push($e, $db_handle->lastErrorMsg());
    }
}
$db_handle->close();
sleep(3);
function querySQL($arr_L, $col_L)
{
    $db_file = dirname(__DIR__) . "/config/db_datalog_table_pltool.sqlite3";
    $db_handle = new SQLite3($db_file);
    // 检测连接是否成功
    if (!$db_handle) {
        die("数据库连接失败: " . $db_handle->lastErrorMsg());
    }
    // 处理tbheader_L*
    global $arr_tbheader;
    global $e;
    global $arr_hiddenID;
    if (!empty($arr_L)) {
        foreach ($arr_hiddenID as $key => $value) {
            if (in_array($value, $arr_L) == true) {
                if (isValueInArray($arr_tbheader, $value) == true) {
                    $sql2 = 'UPDATE `tb_tbheader` SET `' . $col_L . '`="1" WHERE `tbheader`="' . $value . '"';
                } else {
                    $sql2 = 'INSERT INTO `tb_tbheader` (`tbheader`,`' . $col_L . '`) VALUES  ("' . $value . '","1");';
                }
            } else {
                if (isValueInArray($arr_tbheader, $value) == true) {
                    $sql2 = 'UPDATE `tb_tbheader` SET `' . $col_L . '`="0" WHERE `tbheader`="' . $value . '"';
                } else {
                    $sql2 = 'INSERT INTO `tb_tbheader` (`tbheader`,`' . $col_L . '`) VALUES  ("' . $value . '","0");';
                }
            }
            // var_dump($sql2);
            $results2 = $db_handle->query($sql2);
            // 检测SQL执行是否成功
            if (!$results2) {
                array_push($e, $db_handle->lastErrorMsg());
            }
        }
    } else {
        foreach ($arr_hiddenID as $key => $value2) {
            if (isValueInArray($arr_tbheader, $value2) == true) {
                $sql2 = 'UPDATE `tb_tbheader` SET `' . $col_L . '`="0" WHERE `tbheader`="' . $value2 . '"';
            } else {
                $sql2 = 'INSERT INTO `tb_tbheader` (`tbheader`,`' . $col_L . '`) VALUES  ("' . $value2 . '","0");';
            }
            // var_dump($sql2);
            $results2 = $db_handle->query($sql2);
            // 检测SQL执行是否成功
            if (!$results2) {
                array_push($e, $db_handle->lastErrorMsg());
            }
        }
    }
    $db_handle->close();
    return $e;
}
$e1 = querySQL($_POST['tbheader_L0'], 'L0');
$e2 = querySQL($_POST['tbheader_L1'], 'L1');
$e3 = querySQL($_POST['tbheader_L2'], 'L2');
$e4 = querySQL($_POST['tbheader_L3'], 'L3');
$e5 = querySQL($_POST['tbheader_L4'], 'L4');
$e6 = querySQL($_POST['tbheader_main'], 'main');
$e7 = querySQL($_POST['tbheader_isNum'], 'isNum');
$e = array_merge($e1, $e2, $e3, $e4, $e5, $e6, $e7);

var_dump($e);
?>
</pre>
</body>

</html>