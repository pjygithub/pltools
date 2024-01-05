<?php
// 机台号预处理
include(dirname(__DIR__) . '/www/function/using_machine.php');
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
include(dirname(__DIR__) . '/www/config/common_config.php');
// 输出机台选择信息
// echo '<pre>';
// print_r($machines_arr[$index]);
// $machines_json = file_get_contents(dirname(__DIR__) . '\www\machines.config.json');
// $machines_arr = json_decode($machines_json, true);
session_start();
?><div>
    <p>快机</p>
    <ul>
        <?php
        foreach ($machines_arr as $key => $value) {
            if ($value['type'] == "快机") {
                echo '<li><a href="javascript:setCookies([[\'machine\', \'' . $value['id'] . '\']]);">' . $value['id'] . '</a></li>';
            }
        }
        ?>
    </ul>
</div>
<div>
    <p>慢机</p>
    <ul>
        <?php
        foreach ($machines_arr as $key => $value) {
            if ($value['type'] == "慢机") {
                echo '<li><a href="javascript:setCookies([[\'machine\', \'' . $value['id'] . '\']]);">' . $value['id'] . '</a></li>';
            }
        }
        ?>
    </ul>
</div>
<div>
    <p>钯机</p>
    <ul>
        <?php
        foreach ($machines_arr as $key => $value) {
            if ($value['type'] == "钯机") {
                echo '<li><a href="javascript:setCookies([[\'machine\', \'' . $value['id'] . '\']]);">' . $value['id'] . '</a></li>';
            }
        }
        ?>
    </ul>
</div>
<div>
    <p>棕色氧化</p>
    <ul>
        <?php
        foreach ($machines_arr as $key => $value) {
            if ($value['type'] == "棕色氧化") {
                echo '<li><a href="javascript:setCookies([[\'machine\', \'' . $value['id'] . '\']]);">' . $value['id'] . '</a></li>';
            }
        }
        ?>
    </ul>
</div>
<div>
    <p>ME2</p>
    <ul>
        <?php
        foreach ($machines_arr as $key => $value) {
            if ($value['type'] == "ME2") {
                echo '<li><a href="javascript:setCookies([[\'machine\', \'' . $value['id'] . '\']]);">' . $value['id'] . '</a></li>';
            }
        }
        ?>
    </ul>
</div>
<div>
    <br>
    <p>RSA</p>
    <ul>
        <?php
        foreach ($machines_arr as $key => $value) {
            if ($value['type'] == "RSA" && $value['id'] != 'RSA测试') {
                echo '<li><a href="javascript:setCookies([[\'machine\', \'' . $value['id'] . '\']]);">' . $value['id'] . '</a></li>';
            }
        }
        ?>
    </ul>
</div>
<?
if ($Release == 0) {
    echo "<div>
                <br>
                <p>仅用于测试</p>
                <ul>";
    foreach ($machines_arr as $key => $value) {
        if ($value['type'] == "测试" || $value['id'] == 'RSA测试') {
            echo '<li><a href="javascript:setCookies([[\'machine\', \'' . $value['id'] . '\']]);">' . $value['id'] . '</a></li>';
        }
    }
    echo "</ul>
                </div>";
}
?>