<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="layui/css/layui.css">
    <script src="layui/layui.js"></script>
    <script src="layui/layer/layer.js"></script>
</head>

<body>
    <?
    if ($machines_arr[$index][$dirname] !== 1) {
        echo "<script>
    layui.use('layer', function() {
        var layer = layui.layer;
        layer.alert('该机台似乎不存在 <span style=\'color:red;font-weight:700;\'>" . $dirname . "</span> 这样的生产资料！<br> Production data such as " . $dirname . " does not exist on this machine!', {
            icon: 2,
            skin: 'layui-layer-lan',
            closeBtn: 0,
            anim: 6
        });
    });
    </script>";
        die;
    } ?>
</body>

</html>