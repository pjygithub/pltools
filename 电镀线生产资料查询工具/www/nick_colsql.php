<?php
$inner = array(); // 一维数组
$col = 'L1';
$type_def = '1';
function in_array_recursive($item, $array)
{
    foreach ($array as $val) {
        if (is_array($val)) {
            if (in_array_recursive($item, $val)) {
                return true;
            }
        } else {
            if ($val == $item) {
                return true;
            }
        }
    }
    return false;
}
$db_file = "./config/db_datalog_table_pltool.sqlite3";
$db_handle = new SQLite3($db_file);
// 检测连接是否成功
if (!$db_handle) {
    die("数据库连接失败: " . $db_handle->lastErrorMsg());
}
// 执行SQL语句
$results_lang = $db_handle->query('SELECT * FROM `tb_nick_col`');

// 检测SQL执行是否成功
if (!$results_lang) {
    die("SQL执行错误: " . $db_handle->lastErrorMsg());
}
// 遍历结果集
$arr_nick = array();
$results_nick_col = $db_handle->query('SELECT * FROM `tb_nick_col`');
while ($row = $results_nick_col->fetchArray()) {
    $ID = $row["ID"];
    $tbheader = $row["nick_col"];
    $type = $row["type"];
    $L0 = $row["L0"];
    $L1 = $row["L1"];
    $L2 = $row["L2"];
    $L3 = $row["L3"];
    $L4 = $row["L4"];
    $default = $row["default"];
    $main = $row["main"];
    $isNum = $row["isNum"];
    $res = compact("ID", "nick_col", "type", "L0", "L1", "L2", "L3", "L4", "default", "main", "isNum");
    array_push($arr_nick, $res);
}
echo '<pre>';
// echo "待加入的有：";
// var_dump($inner);
// echo "数据库中有：";
// var_dump($arr_nick);

$e = array();
foreach ($inner as $key => $value) {
    // var_dump($value);
    // if (in_array_recursive($value, $arr_nick)) {
    //     // 已存在，更新
    //     $sql = 'update `tb_nick_col` set("' . $col . '","type") = (select "1","' . $type_def . '") where `nick_col`="' . $value . '";commit;';
    //     // $sql = 'UPDATE `tb_nick_col` SET `' . $col . '`="1",`type`="' . $type_def . '" WHERE `nick_col`="' . $value . '"';
    // } else {
    //     // 不存在，插入
    //     $sql = 'INSERT INTO `tb_nick_col` (`nick_col`,`type`,`' . $col . '`) VALUES  ("' . $value . '","' . $type_def . '","1");';
    // }
    $sql = 'INSERT INTO `tb_nick_col` (`nick_col`,`type`,`' . $col . '`) VALUES  ("' . $value . '","' . $type_def . '","1");';
    var_dump($sql);
    $results = $db_handle->query($sql);
    // 检测SQL执行是否成功
    if (!$results) {
        array_push($e, $db_handle->lastErrorMsg());
    }
}
echo "写入/更新信息：";
var_dump($e);
$db_handle->close();
