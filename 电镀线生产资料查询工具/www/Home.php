<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>访问AAMI机台主页</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="layui/css/layui.css">
    <script src="layui/layui.js"></script>
    <script src="layui/layer/layer.js"></script>
    <base target="_self">
</head>

<body>
    <?php
    // $at = explode('/', $_SERVER['SCRIPT_NAME']);
    // $root = str_replace($at[count($at) - 1], '', $_SERVER['SCRIPT_FILENAME']);
    // 关闭报错
    include(dirname(__DIR__) . '/www/function/close_debuger.php');
    // 载入公共配置
    include(dirname(__DIR__) . '/www/config/common_config.php');
    // 机台号预处理
    include(dirname(__DIR__) . '/www/function/using_machine.php');
    // 输出机台选择信息
    // echo '<pre>';

    try {
        if (url_exist("http://" . $machines_arr[$index]['host'] . "/")) {
            $url = "http://" . $machines_arr[$index]['host'];
        } else {
            throw new Exception('域名无法访问！');
        }
    } catch (\Throwable $th) {
        try {
            if (url_exist("http://" . $machines_arr[$index]['ip'] . "/")) {
                $url = "http://" . $machines_arr[$index]['ip'];
            } else {
                throw new Exception('访问失败！');
            }
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            echo "<script>
                layui.use('layer', function(){
                    var layer = layui.layer;
                    layer.alert('出现错误：<span style=\'font-weight:600;\'>域名: " . $machines_arr[$index]['host'] . " </span> / <span style=\'font-weight:600;\'>IP: " . $machines_arr[$index]['ip'] . "</span><span style=\'font-weight:600;color:red;\'> " . $err . "</span> → 该机台似乎<span style=\'font-weight:600;color:red;\'>无法连接</span>！<br> Error: domain name: " . $machines_arr[$index]['host'] . " / IP: " . $machines_arr[$index]['ip'] . " cannot be accessed → the machine cannot be connected!', {
                        icon: 5
                        ,skin: 'layui-layer-lan'
                        ,closeBtn: 0
                        ,anim: 6
                    });
                });
                </script>";
            exit;
        }
    }
    // phpinfo();
    ?>
    <iframe src="<?php echo $url ?>" sandbox="allow-same-origin allow-scripts allow-popups allow-forms " frameborder="0" width="100%" style="display:block;width:100%;height:100vh;"></iframe>
</body>

</html>