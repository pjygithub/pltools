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
    // var_dump($_POST);
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
    $db_file = dirname(__DIR__) . "/config/db_zh_cn_pltool.sqlite3";
    $db_handle = new SQLite3($db_file);
    // 检测连接是否成功
    if (!$db_handle) {
        die("数据库连接失败: " . $db_handle->lastErrorMsg());
    }
    // 执行SQL语句
    $results_lang = $db_handle->query('SELECT * FROM `tb_lang_zh_cn`');

    // 检测SQL执行是否成功
    if (!$results_lang) {
        die("SQL执行错误: " . $db_handle->lastErrorMsg());
    }
    // 遍历结果集
    $arr_zh_cn = array();

    while ($row = $results_lang->fetchArray()) {
        $id = $row["id"];
        $en_source = $row["en_source"];
        $zh_cn = $row["zh_cn"];
        $type = $row["type"];
        $res = compact("id", "en_source", "zh_cn", "type");
        array_push($arr_zh_cn, $res);
    }
    // echo '<pre>';
    // var_dump($arr_zh_cn);

    $e = array();
    $count_zh_cn = count($arr_zh_cn);
    // 处理更新
    if (!empty($_POST['ened'])) {
        $count_ened = count($_POST['ened']);
        for ($i = 0; $i < $count_ened; $i++) {
            $b_ened = $_POST['ened'][$i];
            $c_zh = $_POST['zhed'][$i];
            if (in_array_recursive($_POST['ened'][$i], $arr_zh_cn)) {
                // 已存在，更新
                $sql = 'UPDATE `tb_lang_zh_cn` SET `zh_cn`="' . $c_zh . '" WHERE `en_source`="' . $b_ened . '"';
            } else {
                // 不存在，插入
                $sql = 'INSERT INTO `tb_lang_zh_cn` (`en_source`,`zh_cn`) VALUES  ("' . $b_ened . '","' . $c_zh . '");';
            }
            $results = $db_handle->query($sql);
            // 检测SQL执行是否成功
            if (!$results) {
                array_push($e, $db_handle->lastErrorMsg());
            }
        }
    }
    // 处理新增
    if (!empty($_POST['adden'])) {
        $count_adden = count($_POST['adden']);
        for ($i = 0; $i < $count_adden; $i++) {
            $b_adden = $_POST['adden'][$i];
            $c_zh = $_POST['addzh'][$i];
            if (in_array_recursive($_POST['adden'][$i], $arr_zh_cn)) {
                // 已存在，更新
                $sql = 'UPDATE `tb_lang_zh_cn` SET `zh_cn`="' . $c_zh . '" WHERE `en_source`="' . $b_adden . '"';
            } else {
                // 不存在，插入
                $sql = 'INSERT INTO `tb_lang_zh_cn` (`en_source`,`zh_cn`) VALUES  ("' . $b_adden . '","' . $c_zh . '");';
            }
            $results = $db_handle->query($sql);
            // 检测SQL执行是否成功
            if (!$results) {
                array_push($e, $db_handle->lastErrorMsg());
            }
        }
    }
    var_dump($e);
    ?>
</pre>
</body>

</html>