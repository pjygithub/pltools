<?php
$inner = array(); // 有键名的数组
$type_def = '0';
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
$db_file = "./config/db_zh_cn_pltool.sqlite3";
$db_handle = new SQLite3($db_file);
// 检测连接是否成功
if (!$db_handle) {
    die("数据库连接失败: " . $db_handle->lastErrorMsg());
}
// 执行SQL语句
$results_lang = $db_handle->query('SELECT * FROM `tb_type_lang`');

// 检测SQL执行是否成功
if (!$results_lang) {
    die("SQL执行错误: " . $db_handle->lastErrorMsg());
}
// 遍历结果集
$lang_cn = array();
$results_nick_col = $db_handle->query('SELECT * FROM `tb_lang_zh_cn`');
while ($row = $results_nick_col->fetchArray()) {
    $id = $row["id"];
    $en_source = $row["en_source"];
    $type = $row["type"];
    $zh_cn = $row["zh_cn"];
    $res = compact("id", "en_source", "type", "zh_cn");
    array_push($lang_cn, $res);
}
echo '<pre>';
// echo "待加入的有：";
// var_dump($inner);
// echo "数据库中有：";
// var_dump($lang_cn);

$e = array();
foreach ($inner as $key => $value) {
    // var_dump($value);
    // var_dump($value);
    if (in_array_recursive($key, $lang_cn)) {
        // 已存在，更新
        $sql = 'update `tb_lang_zh_cn` set("zh_cn","type") = (select "' . $value . '","' . $type_def . '") where `en_source`="' . $key . '";commit;';
    } else {
        // 不存在，插入
        $sql = 'INSERT INTO `tb_lang_zh_cn` (`en_source`,`zh_cn`,`type`) VALUES  ("' . $key . '","' . $value . '","' . $type_def . '");';
    }
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
