<?php
/*
 * Author: Jones Pon
 * Version: 0.5.6
 * Release date: 2023/12/06 15:00
 */

$db_file = dirname(__DIR__) . "/config/db_zh_cn_pltool.sqlite3";
$db_handle = new SQLite3($db_file);
// 检测连接是否成功
if (!$db_handle) {
    die("数据库连接失败: " . $db_handle->lastErrorMsg());
}

// 遍历结果集
$_lang = array();
$result_lang = $db_handle->query('SELECT * FROM `tb_lang_zh_cn`');
// 检测SQL执行是否成功
if (!$result_lang) {
    die("SQL执行错误: " . $db_handle->lastErrorMsg());
}
while ($row = $result_lang->fetchArray()) {
    // $id = $row["id"];
    $en_source = $row["en_source"];
    // $type = $row["type"];
    $zh_cn = $row["zh_cn"];
    // $res = compact("id", "en_source", "type", "zh_cn");
    // array_push($_lang, $en_source=>$zh_cn);
    $_lang[$en_source] = $zh_cn;
}
$db_handle->close();
function lang($str)
{
    global $_lang;
    // var_dump($_lang);
    // array_search($str, $_arr);
    // 正则处理ErrorLog报错原因未完成
    $a_ = explode('=', $str);
    if (count($a_) > 1) {
        $c_a = count($a_);
        $r = '';
        for ($i = 0; $i < $c_a; $i++) {
            if (isset($_lang[$a_[$i]]) and $_lang[$a_[$i]] != "") {
                $r = $r . $_lang[$a_[$i]];
            } else {
                $r = $r . $str;
            }
        }
    } else {
        if (isset($_lang[$str]) and $_lang[$str] != "") {
            return $_lang[$str];
        } else {
            return $str;
        }
    }
}

// echo lang("L1 Conductivity");