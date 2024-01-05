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
    <title>设置</title>
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

    table>tbody>tr>td {
        /* border: 1px solid red; */
        text-align: center;
    }
</style>

<body>
    <form action="./function/settings_func.php" method="post">
        <input type="submit" value="保存设置" class="layui-btn1">
        <h2 style="margin-top:43px;">“状态显示”登录账户配置：</h2>
        <label for="status_name">登录账户：</label><input type="text" name="status_name" id="status_name" value="<?php echo urldecode($status_name) ?>"><label for="status_name"> 比如：aam-intl\p02public</label><br>
        <label for="status_password">账户密码：</label><input type="text" name="status_password" id="status_password" value="<?php echo urldecode($status_password) ?>"><label for="status_password"> 比如：P02369258147</label>
        <br>
        <label for="status_url">网页地址：</label><input type="text" name="status_url" id="status_url" value="<?php echo urldecode($status_url) ?>" style="width:28rem"><label for="status_url"> 比如：amcnts19.amcex.asmpt.com/PltLinestate/ViewState.aspx，不包括http://或https:// </label><br>
        <h2>其他设置：</h2>
        <label for="echartShowTime">图表默认显示长度（分钟）：</label><input type="number" name="echartShowTime" id="echartShowTime" value="<?php echo $echartShowTime ?>" step="1" min="10" max="3000"><label for="echartShowTime"> 比如：450个数据点。可输入10~3000</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        <label for="echartShowFloatNum">图表显示小数位数：</label><input type="number" name="echartShowFloatNum" id="echartShowFloatNum" value="<?php echo $echartShowFloatNum ?>" step="1" min="0" max="6"><label for="echartShowFloatNum"> 比如：3是0.001，0为整数。可输入0~6</label><br>
        <div class="layui-form">
            运行图表使用高亮显示（鼠标悬停在线条或图例上会突出显示）：
            <?
            if ($highEchart == 1) {
                echo '
                <input type="radio" name="highEchart" value="1" title="启用图表高亮" checked>
                <input type="radio" name="highEchart" value="2" title="禁用图表高亮">';
            } else {
                echo '
                <input type="radio" name="highEchart" value="1" title="启用图表高亮">
                <input type="radio" name="highEchart" value="2" title="禁用图表高亮" checked>';
            }
            ?>
        </div>
        <label for="lockTime">重新认证间隔（cookie缓存时间，分钟）：</label><input type="number" name="lockTime" id="lockTime" value="<?php echo $lockTime ?>" step="1" min="15" max="2160"><label for="lockTime"> 比如：15分钟后需要重新输入口令进行认证。可输入15~2160</label><br>

        <div class="layui-form" style="display:none">
            测试版发布版：<?
                    if ($Release == 1) {
                        echo '
                <input type="radio" name="Release" value="1" title="发行版" checked>
                <input type="radio" name="Release" value="0" title="测试版">';
                    } else {
                        echo '
                <input type="radio" name="Release" value="1" title="发行版">
                <input type="radio" name="Release" value="0" title="测试版" checked>';
                    }
                    ?>
        </div>
        <div class="layui-form">
            全局页面自动刷新：<?
                        if ($autoRefresh == 1) {
                            echo '
                <input type="radio" name="autoRefresh" value="1" title="启用页面自动刷新" checked>
                <input type="radio" name="autoRefresh" value="0" title="禁用页面自动刷新">';
                        } else {
                            echo '
                <input type="radio" name="autoRefresh" value="1" title="启用页面自动刷新">
                <input type="radio" name="autoRefresh" value="0" title="禁用页面自动刷新" checked>';
                        }
                        ?>
        </div>
        <label for="autoRefreshTime">全局页面自动刷新间隔（秒）：</label><input type="number" name="autoRefreshTime" id="autoRefreshTime" value="<?php echo $autoRefreshTime ?>" step="1" min="15" max="360"><label for="autoRefreshTime"> 比如：15秒后整体页面自动刷新。可输入15~360</label><br>
        <label for="calendarMark">日历节日设置：</label>
        <textarea name="calendarMark" id="calendarMark" cols="30" rows="5"><?php echo $calendarMark ?></textarea><label for="calendarMark"> 格式如：<span style="padding:5px;color:#fff;background-color:#16b777;font-weight: 800;font-family: '宋体';">'0-0-0:' ',</span>，均用半角符号，不可省略，数字分别表示年月日，0均为任意年月日。标题最多4个字。</label><br>

        <div class="layui-form">
            ☆自定义筛选☆的筛选项排序方式：
            <?
            if ($titleSort == 1) {
                echo '
                <input type="radio" name="titleSort" value="0" title="源文件顺序">
                <input type="radio" name="titleSort" value="1" title="重新降序排列" checked>
                <input type="radio" name="titleSort" value="2" title="重新升序排列">';
            } elseif ($titleSort == 2) {
                echo '
                <input type="radio" name="titleSort" value="0" title="源文件顺序">
                <input type="radio" name="titleSort" value="1" title="重新降序排列">
                <input type="radio" name="titleSort" value="2" title="重新升序排列" checked>';
            } else {
                echo '
                <input type="radio" name="titleSort" value="0" title="源文件顺序" checked>
                <input type="radio" name="titleSort" value="1" title="重新降序排列">
                <input type="radio" name="titleSort" value="2" title="重新升序排列">';
            }
            ?>
        </div>
        <div class="layui-form" style="display:none">
            运行图表提示框排序方式：
            <?
            if ($echartSort == 'seriesAsc') {
                echo '
                <input type="radio" name="echartSort" value="seriesAsc" title="根据系列声明, 升序排列" checked>
                <input type="radio" name="echartSort" value="seriesDesc" title="根据系列声明, 降序排列">
                <input type="radio" name="echartSort" value="valueAsc" title="根据数据值, 升序排列">
                <input type="radio" name="echartSort" value="valueDesc" title="根据数据值, 降序排列">';
            } elseif ($echartSort == "seriesDesc") {
                echo '
                <input type="radio" name="echartSort" value="seriesAsc" title="根据系列声明, 升序排列">
                <input type="radio" name="echartSort" value="seriesDesc" title="根据系列声明, 降序排列" checked>
                <input type="radio" name="echartSort" value="valueAsc" title="根据数据值, 升序排列">
                <input type="radio" name="echartSort" value="valueDesc" title="根据数据值, 降序排列">';
            } elseif ($echartSort == "valueAsc") {
                echo '
                <input type="radio" name="echartSort" value="seriesAsc" title="根据系列声明, 升序排列">
                <input type="radio" name="echartSort" value="seriesDesc" title="根据系列声明, 降序排列">
                <input type="radio" name="echartSort" value="valueAsc" title="根据数据值, 升序排列"  checked>
                <input type="radio" name="echartSort" value="valueDesc" title="根据数据值, 降序排列">';
            } elseif ($echartSort == "valueDesc") {
                echo '
                <input type="radio" name="echartSort" value="seriesAsc" title="根据系列声明, 升序排列">
                <input type="radio" name="echartSort" value="seriesDesc" title="根据系列声明, 降序排列">
                <input type="radio" name="echartSort" value="valueAsc" title="根据数据值, 升序排列" >
                <input type="radio" name="echartSort" value="valueDesc" title="根据数据值, 降序排列" checked>';
            }
            ?>

        </div>
        <div class="layui-form">
            表格显示方式：
            <?
            if ($tableType == 'layui') {
                echo '
                <input type="radio" name="tableType" value="layui" title="layui前端框架(支持分页，分页下载，不可筛选)" checked>
                <input type="radio" name="tableType" value="handsontable6" title="handsontable_v6框架(速度快，可下载，不可筛选)">
                <input type="radio" name="tableType" value="luckysheet" title="luckysheet"  disabled>
                <input type="radio" name="tableType" value="handsontable7" title="handsontable_v7.0+ 框架"  disabled>
                ';
            } elseif ($tableType == "handsontable6") {
                echo '
                <input type="radio" name="tableType" value="layui" title="layui前端框架(支持分页，分页下载，不可筛选)">
                <input type="radio" name="tableType" value="handsontable6" title="handsontable_v6框架(速度快，可下载，不可筛选)"  checked >
                <input type="radio" name="tableType" value="luckysheet" title="luckysheet"  disabled>
                <input type="radio" name="tableType" value="handsontable7" title="handsontable_v7.0+ 框架"  disabled>
                ';
            } elseif ($tableType == "luckysheet") {
                echo '
                <input type="radio" name="tableType" value="layui" title="layui前端框架(支持分页，分页下载，不可筛选)">
                <input type="radio" name="tableType" value="handsontable6" title="handsontable_v6框架(速度快，可下载，不可筛选)">
                <input type="radio" name="tableType" value="luckysheet" title="luckysheet"  checked  disabled>
                <input type="radio" name="tableType" value="handsontable7" title="handsontable_v7.0+ 框架" disabled>';
            } elseif ($tableType == "handsontable7") {
                echo '
                <input type="radio" name="tableType" value="layui" title="layui前端框架(支持分页，分页下载，不可筛选)">
                <input type="radio" name="tableType" value="handsontable6" title="handsontable_v6框架(速度快，可下载，不可筛选)">
                <input type="radio" name="tableType" value="luckysheet" title="luckysheet" disabled>
                <input type="radio" name="tableType" value="handsontable7" title="handsontable_v7.0+ 框架"  checked>';
            }
            ?>

        </div>
        <div class="layui-form" style="display: none;">
            验证过期后重新开始时：
            <?
            if ($usezh_cn == 1) {
                echo '
                <input type="radio" name="usezh_cn" value="0" title="先启用英文" >
                <input type="radio" name="usezh_cn" value="1" title="先启用中文" checked>
                <input type="radio" name="usezh_cn" value="2" title="禁用中文">';
            } elseif ($usezh_cn == 2) {
                echo '
                <input type="radio" name="usezh_cn" value="0" title="先启用英文">
                <input type="radio" name="usezh_cn" value="1" title="先启用中文" >
                <input type="radio" name="usezh_cn" value="2" title="禁用中文" checked>';
            } else {
                echo '
                <input type="radio" name="usezh_cn" value="0" title="先启用英文" checked>
                <input type="radio" name="usezh_cn" value="1" title="先启用中文">
                <input type="radio" name="usezh_cn" value="2" title="禁用中文" >';
            }
            ?>
        </div>
        <div style="display:none">
            <label for="tableLicensekey">handsontable_v7+ 授权码：</label><input type="text" name="tableLicensekey" id="tableLicensekey" value="<?php echo urldecode($tableLicensekey) ?>" style="width:28rem">
        </div>
        <br>
        <h2>机台主机名和IP设置：</h2>

        <table>
            <tbody>
                <tr>
                    <td>机台号</td>
                    <td>主机名</td>
                    <td>IP地址</td>
                    <td>EBO更换间隔(小时)</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>机台号</td>
                    <td>主机名</td>
                    <td>IP地址</td>
                    <td>EBO更换间隔(小时)</td>
                </tr>
                <?php
                // 数组总个数
                $coun_mac = count($machines_arr);
                $machines_arr_t = $machines_arr;
                echo '<pre>';
                // var_dump($machines_arr);
                echo '</pre>';

                for ($i = 0; $i < $coun_mac; $i++) {
                    if ($machines_arr_t[$i]['type'] != "测试" and $machines_arr_t[$i]['type'] != "RSA") {
                        if ($machines_arr_t[$i]['id'] < 10 and strlen($machines_arr_t[$i]['id']) < 2) {
                            $machines_arr_t[$i]['id'] = "0" . $machines_arr_t[$i]['id'];
                        }
                        if ($i % 2 == 0) {
                ?>
                            <tr>
                                <td><? echo $machines_arr_t[$i]['id'] ?></td>
                                <td><input type="text" name="machost[]" value="<? echo $machines_arr_t[$i]['host'] ?>" style="width:12rem;"></td>
                                <td><input type="text" name="macip[]" value="<? echo $machines_arr_t[$i]['ip'] ?>" style="width:12rem;"></td>
                                <td>
                                    <input type="text" name="macEBOtime[]" value="<? echo $machines_arr_t[$i]['EBOtime'] ?>" style="width:8rem;">
                                    <input type="text" name="macid[]" value="<? echo $machines_arr_t[$i]['id'] ?>" hidden>
                                    <input type="text" name="mactype[]" value="<? echo $machines_arr_t[$i]['type'] ?>" hidden>
                                    <input type="text" name="macDataLog[]" value="<? echo $machines_arr_t[$i]['DataLog'] ?>" hidden>
                                    <input type="text" name="macErrorLog[]" value="<? echo $machines_arr_t[$i]['ErrorLog'] ?>" hidden>
                                    <input type="text" name="macEventLog[]" value="<? echo $machines_arr_t[$i]['EventLog'] ?>" hidden>
                                    <input type="text" name="macStartStopLog[]" value="<? echo $machines_arr_t[$i]['StartStopLog'] ?>" hidden>
                                    <input type="text" name="macdowntimelog[]" value="<? echo $machines_arr_t[$i]['downtimelog'] ?>" hidden>
                                    <input type="text" name="macParameterLog/Machine[]" value="<? echo $machines_arr_t[$i]['ParameterLog/Machine'] ?>" hidden>
                                    <input type="text" name="macParameterLog/Product[]" value="<? echo $machines_arr_t[$i]['ParameterLog/Product'] ?>" hidden>
                                </td>
                                <td>&nbsp;&nbsp;</td>
                                <td><? echo $machines_arr_t[$i + 1]['id'] ?></td>
                                <td><input type="text" name="machost[]" value="<? echo $machines_arr_t[$i + 1]['host'] ?>" style="width:12rem;"></td>
                                <td><input type="text" name="macip[]" value="<? echo $machines_arr_t[$i + 1]['ip'] ?>" style="width:12rem;"></td>
                                <td><input type="text" name="macEBOtime[]" value="<? echo $machines_arr_t[$i + 1]['EBOtime'] ?>" style="width:8rem;"><input type="text" name="macid[]" value="<? echo $machines_arr_t[$i + 1]['id'] ?>" hidden>
                                    <input type="text" name="mactype[]" value="<? echo $machines_arr_t[$i + 1]['type'] ?>" hidden>
                                    <input type="text" name="macDataLog[]" value="<? echo $machines_arr_t[$i + 1]['DataLog'] ?>" hidden>
                                    <input type="text" name="macErrorLog[]" value="<? echo $machines_arr_t[$i + 1]['ErrorLog'] ?>" hidden>
                                    <input type="text" name="macEventLog[]" value="<? echo $machines_arr_t[$i + 1]['EventLog'] ?>" hidden>
                                    <input type="text" name="macStartStopLog[]" value="<? echo $machines_arr_t[$i + 1]['StartStopLog'] ?>" hidden>
                                    <input type="text" name="macdowntimelog[]" value="<? echo $machines_arr_t[$i + 1]['downtimelog'] ?>" hidden>
                                    <input type="text" name="macParameterLog/Machine[]" value="<? echo $machines_arr_t[$i + 1]['ParameterLog/Machine'] ?>" hidden>
                                    <input type="text" name="macParameterLog/Product[]" value="<? echo $machines_arr_t[$i + 1]['ParameterLog/Product'] ?>" hidden>
                                </td>

                            </tr>
                        <?php }
                    }
                    if ($machines_arr_t[$i]['type'] == "RSA") {
                        // var_dump($machines_arr_t[$i]['id']);
                        ?>
                        <tr>
                            <td><? echo $machines_arr_t[$i]['id'] ?></td>
                            <td><input type="text" name="machost[]" value="<? echo $machines_arr_t[$i]['host'] ?>"></td>
                            <td><input type="text" name="macip[]" value="<? echo $machines_arr_t[$i]['ip'] ?>"></td>
                            <td><input type="text" name="macEBOtime[]" value="<? echo $machines_arr_t[$i]['EBOtime'] ?>" style="width:8rem;">
                                <input type="text" name="macid[]" value="<? echo $machines_arr_t[$i]['id'] ?>" hidden>
                                <input type="text" name="mactype[]" value="<? echo $machines_arr_t[$i]['type'] ?>" hidden>
                                <input type="text" name="macDataLog[]" value="<? echo $machines_arr_t[$i]['Rsa'] ?>" hidden>
                                <input type="text" name="macErrorLog[]" value="<? echo $machines_arr_t[$i]['Alarm'] ?>" hidden>
                                <!-- <input type="text" name="macEventLog[]" value="<? echo $machines_arr_t[$i]['EventLog'] ?>" hidden> -->
                                <!-- <input type="text" name="macStartStopLog[]" value="<? echo $machines_arr_t[$i]['StartStopLog'] ?>" hidden> -->
                                <input type="text" name="macdowntimelog[]" value="<? echo $machines_arr_t[$i]['Stopline'] ?>" hidden>
                                <!-- <input type="text" name="macParameterLog/Machine[]" value="<? echo $machines_arr_t[$i]['ParameterLog/Machine'] ?>" hidden> -->
                                <input type="text" name="macParameterLog/Product[]" value="<? echo $machines_arr_t[$i]['ParametricModifierLog'] ?>" hidden>
                            </td>
                        </tr>
            </tbody>
        </table>

<?php
                    }
                }
?>
<div style="height:10px">&nbsp;</div>

</body>

</html>