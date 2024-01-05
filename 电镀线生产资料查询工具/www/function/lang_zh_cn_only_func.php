<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="javascript:window.history.go(-2);">点此返回</a>
    <pre>
    <?php
    // var_dump($_POST);
    echo ("写入/更新信息如下（为空正常，其他可能有异常。<span style='color:red'>如果是第一次保存设置，可能有较多错误输出！请“点此返回”后再次保存设置，重复步骤直到输出<br>array(0) {<br>}<br></span><br>");
    if (!isset($_POST['tbheaderIDID'])) {
        $a_tbheader = "";
    } else {
        $a_tbheader = urldecode($_POST['tbheaderIDID']);
    }
    if (!isset($_POST['zh_cn_only'])) {
        $b_zh_cn_only = "";
    } else {
        $b_zh_cn_only = $_POST['zh_cn_only'];
    }
    function isValueInArray($array, $value)
    {
        foreach ($array as $subArray) {
            if (in_array($value, array_column($array, 'en_source'))) {
                return true;
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

    if (isValueInArray($arr_zh_cn, $_POST['tbheaderIDID'])) {
        // 已存在，更新
        $sql = 'UPDATE `tb_lang_zh_cn` SET `zh_cn`="' . $b_zh_cn_only . '" WHERE `en_source`="' . $a_tbheader . '"';
    } else {
        // 不存在，插入
        $sql = 'INSERT INTO `tb_lang_zh_cn` (`en_source`,`zh_cn`) VALUES  ("' . $a_tbheader . '","' . $b_zh_cn_only . '");';
    }
    $results = $db_handle->query($sql);
    // 检测SQL执行是否成功
    var_dump($sql);
    if (!$results) {
        array_push($e, $db_handle->lastErrorMsg());
    }

    var_dump($e);
    ?>
</pre>
</body>

</html>