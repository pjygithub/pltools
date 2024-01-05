<?php
// echo "设置<br>";
include(dirname(__DIR__) . '/www/config/common_config.php');
// include(dirname(__DIR__) . '/www/config/machines.config.json');
$machines_str = file_get_contents(dirname(__DIR__) . '/www/config/machines.config.json');
$machines_arr = json_decode($machines_str, true);
?>
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
</style>
<?php
// 关闭报错
include(dirname(__DIR__) . '/www/function/close_debuger.php');
// 载入公共配置
include_once(dirname(__DIR__) . '/www/config/common_config.php');
//中文语言文件
include(dirname(__DIR__) . '/www/language/lang.zh_CN.php');
// 机台号预处理
include(dirname(__DIR__) . '/www/function/using_machine.php');
// 输出机台选择信息
// echo '<pre>';
// print_r($machines_arr[$index]);
// 判断机台是否存在某个文件夹
if ($machines_arr[$index]['type'] == 'RSA') {
    $dirname = 'Rsa';
} else {
    $dirname = 'DataLog';
}
include(dirname(__DIR__) . '/www/function/isexistDIR.php');
// 列出选定的日期、月份、年份
include(dirname(__DIR__) . '/www/function/Dates.php');
$Dates = Dates('Y-m-d');
// echo '<pre>';
// print_r($Dates);

// 打开并返回数据流 $data
$format_normal = '_data';
$format_rsa = 'Rsa_';
include(dirname(__DIR__) . '/www/function/get_data_DataLog_only.php');
$data = get_data_lines($Dates, $dirname, $format_normal, $format_rsa);
// echo '<pre>';
// print_r($data);
$db_file = dirname(__DIR__) . "/www/config/db_datalog_table_pltool.sqlite3";
$db_handle = new SQLite3($db_file);
// 检测连接是否成功
if (!$db_handle) {
    die("数据库连接失败: " . $db_handle->lastErrorMsg());
}
// 执行SQL语句
$results_type = $db_handle->query('SELECT * FROM `tb_type_tbheader`');

// 检测SQL执行是否成功
if (!$results_type) {
    die("SQL执行错误: " . $db_handle->lastErrorMsg());
}
// 遍历结果集
$arr_type = array();

while ($row = $results_type->fetchArray()) {
    $r = array("id" => $row["id"], "type" => $row['type']);
    array_push($arr_type, $r);
}
// echo '<pre>';
// var_dump($arr_nick);
// var_dump($arr_type);
// 关闭数据库连接
$db_handle->close();
function getLineData($tbheader)
{
    $db_file = dirname(__DIR__) . "/www/config/db_datalog_table_pltool.sqlite3";
    $db_handle = new SQLite3($db_file);
    $results_tbheader = $db_handle->query('SELECT * FROM `tb_tbheader` WHERE `tbheader`="' . $tbheader . '"');
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
        // var_dump($r);
        return $res;
    }
}
?>

<body>
    <div>
        <span style="display:inline-block;margin-top:2.5rem;width:49%;font-weight: 900;font-size:1.5rem;">运行图表显示项设置（<span>当前机台当前日期实时DataLog表头</span>）</span>
        <span style="display:inline-block;margin-top:2.5rem;width:49%;font-weight: 900;font-size:1.5rem;text-align:right;"><a href="./allNickOnDB.php">链接: 管理数据库中已有的</a></span>
    </div>
    <form action="./function/tbheader_config_func.php" method="post">
        <input type="submit" value="保存设置" class="layui-btn1" style="z-index:999">
        <script>
            $('input.layui-btn1').on("click", function() {
                $('input.layui-btn1').val('正在保存，请稍后……');
            });
        </script>
        <table class="layui-table" lay-even>
            <colgroup>
                <col width="30">
                <col>
                <col>
                <col width="15">
                <col width="15">
                <col width="15">
                <col width="15">
                <?php
                if ($_COOKIE['machine'] == "10" or $_COOKIE['machine'] == "12" or $_COOKIE['machine'] == "31"  or $_COOKIE['machine'] == "33"  or count(explode('test', $_COOKIE['machine'])) > 1) {
                    echo "<col   width='15'>";
                } ?>
                <?php if ($_COOKIE['machine'] == "12" or $_COOKIE['machine'] == "33" or count(explode('test', $_COOKIE['machine'])) > 1) {
                    echo "<col   width='15'>";
                } ?>
                <col>
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th>序号</th>
                    <th>表头(源)</th>
                    <th>表头(中文)</th>
                    <th>类型选择</th>
                    <th>线0显示</th>
                    <th>线1显示</th>
                    <th>线2显示</th>
                    <?php
                    if ($_COOKIE['machine'] == "10" or $_COOKIE['machine'] == "12" or $_COOKIE['machine'] == "31" or $_COOKIE['machine'] == "33" or count(explode('test', $_COOKIE['machine'])) > 1) {
                        echo "<th>线3显示</th>";
                    } ?>
                    <?php if ($_COOKIE['machine'] == "12" or $_COOKIE['machine'] == "33" or count(explode('test', $_COOKIE['machine'])) > 1) {
                        echo "<th>线4显示</th>";
                    } ?>
                    <!-- <th>默认显示</th> -->
                    <th>mainPlating显示</th>
                    <th>是否数值</th>
                </tr>
            </thead>

            <tbody id="tb_data">
                <?php
                $count_data = count($data[0]);
                $count_type =  count($arr_type);
                $count_nick = count($arr_nick);
                $select_color = array(
                    '#5470C6', '#91CC75', '#FAC858', '#fd8686', '#73C0DE', '#3BA272', '#a6abe4', '#ca93bb', '#f6f7b7', '#efd7dd', '#A9A9A9', "#e6dbf9", '#ddec9f', '#6cff3b', '#6ff5e2', '#37c7ff', '#9E0899', '#02ef80', '#FFDE00', "#07a2a4", "#9E2210", '#000075', "#B1EB0B", "#20EB12", "#EB6000", "#9E8010", '#ffffff',
                );

                for ($i = 0; $i < $count_data; $i++) {
                    if (lang($data[0][$i]) != "时间" and lang($data[0][$i]) != "日期" and lang($data[0][$i]) != "日期时间" and lang($data[0][$i]) != "日期 时间" and lang($data[0][$i]) != "时间日期" and lang($data[0][$i]) != "时间 日期") {
                        $tbheader_key = getLineData($data[0][$i]);
                        echo '<tr>';
                        echo '<input type="text" name="tbheaderID[]" value="' . $data[0][$i] . '" hidden>';
                        echo '<td>' . ($i + 1) . '</td>';
                        echo '<td><a href="./zh_cn_en_only_config.php?tbheaderIDID=' . urlencode($data[0][$i]) . '" title="单个设置是否显示">' . $data[0][$i] . '</a></td>';
                        echo '<td><a href="./zh_cn_en_only_config.php?tbheaderIDID=' . urlencode($data[0][$i]) . '" title="单个设置中文翻译">' . lang($data[0][$i]) . '</a></td>';
                        echo '<td><div class="layui-col-md6">
                <select lay-search="" name="tbheader_type[]" style="background-color:' . $select_color[$tbheader_key["type"]] . '">
                  <option value="">请选择类型</option>';
                        for ($j = 0; $j < $count_type; $j++) {
                            if ($tbheader_key["type"] == $arr_type[$j]['id']) {
                                echo '<option value="' . $arr_type[$j]['id'] . '"  selected>' . lang($arr_type[$j]['type']) . ' _(' . $arr_type[$j]['type']  . ' )</option>';
                            } else {
                                echo '<option value="' . $arr_type[$j]['id'] . '">' . lang($arr_type[$j]['type']) . ' _(' . $arr_type[$j]['type']  . ')</option>';
                            }
                        }
                        echo '</select></div></td>';
                        if ($tbheader_key["L0"] == "1") {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L0[]" lay-text="线0" value="' . $data[0][$i] . '" checked> 
            </div></td>';
                        } else {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L0[]" lay-text="线0" value="' . $data[0][$i] . '"> 
            </div></td>';
                        }
                        if ($tbheader_key["L1"] == "1") {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L1[]" lay-text="线1" value="' . $data[0][$i] . '" checked> 
            </div></td>';
                        } else {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L1[]" lay-text="线1" value="' . $data[0][$i] . '"> 
            </div></td>';
                        }
                        if ($tbheader_key["L2"] == "1") {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L2[]" lay-text="线2" value="' . $data[0][$i] . '" checked> 
            </div></td>';
                        } else {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L2[]" lay-text="线2" value="' . $data[0][$i] . '"> 
            </div></td>';
                        }
                        if ($_COOKIE['machine'] == "10" or $_COOKIE['machine'] == "12" or $_COOKIE['machine'] == "31" or $_COOKIE['machine'] == "33"  or count(explode('test', $_COOKIE['machine'])) > 1) {
                            if ($tbheader_key["L3"] == "1") {
                                echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L3[]" lay-text="线3" value="' . $data[0][$i] . '" checked> 
            </div></td>';
                            } else {
                                echo '<td><div class="layui-form">
                <input type="checkbox" name="tbheader_L3[]" lay-text="线3" value="' . $data[0][$i] . '"> 
              </div></td>';
                            }
                        }
                        if ($_COOKIE['machine'] == "12" or $_COOKIE['machine'] == "33"  or count(explode('test', $_COOKIE['machine'])) > 1) {
                            if ($tbheader_key["L4"] == "1") {
                                echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L4[]" lay-text="线4" value="' . $data[0][$i] . '" checked> 
            </div></td>';
                            } else {
                                echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_L4[]" lay-text="线4" value="' . $data[0][$i] . '"> 
            </div></td>';
                            }
                        }
                        //if ($tbheader_key["default"] == "1") {
                        //                     echo '<td><div class="layui-form">
                        //     <input type="checkbox" name="tbheader_Def[]" lay-text="默认" value="' . $data[0][$i] . '"checked> 
                        //   </div></td>';
                        //                 } else {
                        //                     echo '<td><div class="layui-form">
                        //     <input type="checkbox" name="tbheader_Def[]" lay-text="默认" value="' . $data[0][$i] . '"> 
                        //   </div></td>';
                        //                 }
                        if ($tbheader_key["main"] == "1") {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_main[]" lay-text="mainPlating" value="' . $data[0][$i] . '" checked> 
            </div></td>';
                        } else {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_main[]" lay-text="mainPlating" value="' . $data[0][$i] . '"> 
            </div></td>';
                        }
                        if ($tbheader_key["isNum"] == "1") {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_isNum[]" lay-text="是否数值" value="' . $data[0][$i] . '"  checked> 
            </div></td>';
                        } elseif ($tbheader_key["isNum"] == "0") {
                            echo '<td><div class="layui-form">
                            <input type="checkbox" name="tbheader_isNum[]" lay-text="是否数值" value="' . $data[0][$i] . '" > 
                          </div></td>';
                        } else {
                            echo '<td><div class="layui-form">
              <input type="checkbox" name="tbheader_isNum[]" lay-text="是否数值" value="' . $data[0][$i] . '"  checked> 
            </div></td>';
                        }
                        echo '</tr>';
                    }
                }
                // echo '<input type="text" name="tbheaderID[]" value="useless" hidden>';
                // echo '<input type="checkbox" name="tbheader_L0[]" lay-text="线0" value="useless"> ';
                // echo '<input type="checkbox" name="tbheader_L1[]" lay-text="线1" value="useless"> ';
                // echo '<input type="checkbox" name="tbheader_L2[]" lay-text="线2" value="useless">';
                // echo '<input type="checkbox" name="tbheader_L3[]" lay-text="线3" value="useless">';
                // echo '<input type="checkbox" name="tbheader_L4[]" lay-text="线4" value="useless">';
                // echo '<input type="checkbox" name="tbheader_main[]" lay-text="mainPlating" value="useless">';
                // echo '<input type="checkbox" name="tbheader_isNum[]" lay-text="是否数值" value="useless">';
                ?>

            </tbody>
        </table>
    </form>
    <div style="height:10px">&nbsp;</div>

    <?php

    ?>
</body>

</html>