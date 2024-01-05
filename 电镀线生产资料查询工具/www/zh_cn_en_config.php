<!DOCTYPE html>
<html lang="zh_cn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>表头设置</title>
    <script src="./layui/layui.js"></script>
    <link rel="stylesheet" href="./layui/css/layui.css">
    <script src="js/jquery.js"></script>
</head>
<style>
    * {
        font-size: 1rem;
    }

    input {
        padding-left: 10px;
        width: 100%;
    }

    input[type=text] {
        /* width: 26rem; */
        /* width: 30%; */
        height: 2rem;
        border: 0px;
        border-bottom: 1px solid #333;
        margin-left: 10px;
        margin-right: 10px;
    }

    input[type=number] {
        /* width: 26rem; */
        /* width: 30%; */
        height: 2rem;
        border: 0px;
        border-bottom: 1px solid #333;
    }

    .leftRight {
        width: 49.5%;
        /* position: absolute; */
        float: left;
    }

    .layui-btn1 {
        position: fixed;
        height: 36px;
        line-height: 36px;
        border: 1px solid transparent;
        padding: 0 18px;
        background-color: #009688;
        color: #fff;
        white-space: nowrap;
        text-align: center;
        font-size: 14px;
        border-radius: 20px;
        cursor: pointer;
        outline: 0;
        -webkit-appearance: none;
        transition: all .3s;
        -webkit-transition: all .3s;
        box-sizing: border-box;
        top: 0;
        left: 0;
    }

    table {
        width: 100%;
    }

    table>tbody>tr>td {
        /* border: 1px solid red; */
        text-align: center;
        font-size: 12px;
    }

    .layui-table td,
    .layui-table th {
        text-align: left;
    }

    select {
        height: 2rem;
    }

    input[type=text] {
        border-bottom: 1px solid #333;
        border-radius: 5px;
        margin-left: unset;
        margin-right: unset;
    }
</style>
<?php
// 关闭报错
include(dirname(__DIR__) . '/www/function/close_debuger.php');
$db_file = dirname(__DIR__) . "/www/config/db_zh_cn_pltool.sqlite3";
$db_handle = new SQLite3($db_file);
// 检测连接是否成功
if (!$db_handle) {
    die("数据库连接失败: " . $db_handle->lastErrorMsg());
}
// 执行SQL语句
$results_lang = $db_handle->query('SELECT * FROM `tb_lang_zh_cn` ORDER BY `type` ASC, `en_source` asc');

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
// 关闭数据库连接
$db_handle->close();
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
if (!isset($_GET['limit'])) {
    $_GET['limit'] = 20;
}
?>

<body>
    <div>
        <span style="display:inline-block;margin-top:2.5rem;width:49%;font-weight: 900;font-size:1.5rem;">中文翻译设置<span>（实验性，不是实时从机台读取的，是需要手动复制添加的.）</span></span>
        <!-- <span style="display:inline-block;margin-top:2.5rem;width:49%;font-weight: 900;font-size:1.5rem;text-align:right;"><a href="./allNickOnDB.php">链接: 管理数据库中已有的</a></span> -->
        <span><a href="javascript:add(1);">添加 1 组翻译，</a>&nbsp;&nbsp;<a href="javascript:add(2);">添加 2 组翻译，</a>&nbsp;&nbsp;<a href="javascript:add(4);">添加 4 组翻译，</a>&nbsp;&nbsp;<a href="javascript:add(10);">添加 10 组翻译</a></span>
        <div id="demo-laypage-1" style="height: 35px;"></div>
        <script>
            function add(num) {
                if (num % 2 == 0) {
                    for (let i = 0; i < num / 2; i++) {
                        let htmll = '<tr><td>+' + num + '</td><td><input type="text" name="adden[]" value=""></td><td><input type="text" name="addzh[]" value=""></td><td>+' + num + '</td><td><input type="text" name="adden[]" value=""></td><td><input type="text" name="addzh[]" value=""></td></tr>';
                        $('#tb_data').before(htmll);
                    }
                } else {
                    for (let i = 0; i < num; i++) {
                        let htmll = '<tr><td>+' + num + '</td><td><input type="text" name="adden[]" value=""></td><td><input type="text" name="addzh[]" value=""></td></tr>';
                        $('#tb_data').before(htmll);
                    }
                }
            }
        </script>
    </div>
    <form action="./function/lang_zh_cn_func.php" method="post">
        <input type="submit" value="保存设置" class="layui-btn1" style="z-index:999;width:unset">
        <script>
            $('input.layui-btn1').on("click", function() {
                $('input.layui-btn1').val('正在保存，请稍后……');
            });
        </script>
        <table class="layui-table" lay-even>
            <colgroup>
                <col width="15">
                <col>
                <col>
                <col width="15">
                <col>
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th style="width:1px;">序号</th>
                    <th>源(必填)</th>
                    <th>翻译</th>
                    <!-- <th>类型</th> -->
                    <th style="width:1px;">序号</th>
                    <th>源(必填)</th>
                    <th>翻译</th>
                    <!-- <th>类型</th> -->
                </tr>
            </thead>

            <tbody id="tb_data">
                <?php
                $count_data = count($data[0]);
                $count_type =  count($arr_type);
                $count_zh_cn = count($arr_zh_cn);
                $select_color = array(
                    '#5470C6', '#91CC75', '#FAC858', '#fd8686', '#73C0DE', '#3BA272', '#9A60B4', '#ca93bb', '#7f89ab', '#efd7dd', '#A9A9A9', "#C05050", '#ddec9f', '#6cff3b', '#FF00E0', '#37c7ff', '#9E0899', '#02ef80', '#FFDE00', "#07a2a4", "#9E2210", '#000075', "#B1EB0B", "#20EB12", "#EB6000", "#9E8010", '#ffffff',
                );
                $tb_start = intval($_GET['limit'] * ($_GET['page'] - 1));
                $tb_end = intval($_GET['limit'] * ($_GET['page']));
                if ($tb_end >= $count_zh_cn) {
                    $tb_end = $count_zh_cn;
                }
                for ($i = $tb_start; $i < $tb_end; $i++) {
                    if ($i % 2 == 0) {
                        echo '<tr>';
                        echo '<td>' . ($i + 1) . '</td>';
                        echo '<td><input type="text" name="ened[]" value="' . $arr_zh_cn[$i]['en_source'] . '" readonly unselectable="on" style="background-color: #e2e2e2;border-bottom: unset;"></td>';
                        echo '<td><input type="text" name="zhed[]" value="' . $arr_zh_cn[$i]['zh_cn'] . '"></td>';
                        echo '<td>' . ($i + 2) . '</td>';
                        echo '<td><input type="text" name="ened[]" value="' . $arr_zh_cn[$i + 1]['en_source'] . '"  readonly unselectable="on"  style="background-color: #e2e2e2;border-bottom: unset;"></td>';
                        echo '<td><input type="text" name="zhed[]" value="' . $arr_zh_cn[$i + 1]['zh_cn'] . '"></td>';
                        echo '</tr>';
                    } else {
                        continue;
                    }
                }
                // foreach ($arr_zh_cn as $key => $value) {
                //     if ($key % 2 == 0) {
                //         echo '<tr>';
                //         echo '<td>' . ($key + 1) . '</td>';
                //         echo '<td><input type="text" name="ened[]" value="' . $arr_zh_cn[$key]['en_source'] . '" readonly unselectable="on" style="background-color: #e2e2e2;border-bottom: unset;"></td>';
                //         echo '<td><input type="text" name="zhed[]" value="' . $arr_zh_cn[$key]['zh_cn'] . '"></td>';
                //         echo '<td>' . ($key + 2) . '</td>';
                //         echo '<td><input type="text" name="ened[]" value="' . $arr_zh_cn[$key + 1]['en_source'] . '"  readonly unselectable="on"  style="background-color: #e2e2e2;border-bottom: unset;"></td>';
                //         echo '<td><input type="text" name="zhed[]" value="' . $arr_zh_cn[$key + 1]['zh_cn'] . '"></td>';
                //         echo '</tr>';
                //     } else {
                //         continue;
                //     }
                // }
                ?>
            </tbody>
        </table>
    </form>
    <div id="demo-laypage-2" style="height: 35px;"></div>
    <script>
        layui.use(function() {
            var laypage = layui.laypage;
            // 完整显示
            laypage.render({
                elem: 'demo-laypage-1', // 元素 id
                count: <?php echo $count_zh_cn ?>, // 数据总数
                layout: ['count', 'prev', 'page', 'limit', 'next', 'refresh', 'skip'], // 功能布局
                limit: <?php echo $_GET['limit'] ?>,
                curr: <?php echo $_GET['page'] ?>, // 初始获取 hash 值为 curr 的当前页
                hash: 'page', // 自定义 hash 名称
                jump: function(obj, first) {
                    console.log(obj);
                    if (!first) {
                        // do something
                        location = location.hash + '?page=' + obj.curr + '&limit=' + obj.limit;
                    }
                }
            });
            laypage.render({
                elem: 'demo-laypage-2', // 元素 id
                count: <?php echo $count_zh_cn ?>, // 数据总数
                layout: ['count', 'prev', 'page', 'limit', 'next', 'refresh', 'skip'], // 功能布局
                limit: <?php echo $_GET['limit'] ?>,
                curr: <?php echo $_GET['page'] ?>, // 初始获取 hash 值为 curr 的当前页
                hash: 'page', // 自定义 hash 名称
                jump: function(obj, first) {
                    console.log(obj);
                    if (!first) {
                        // do something
                        location = location.hash + '?page=' + obj.curr + '&limit=' + obj.limit;
                    }
                }
            });
        });
    </script>
    <div style="height:10px">&nbsp;</div>
</body>

</html>