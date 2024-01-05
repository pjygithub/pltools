<?php
session_start();
// 关闭报错
include(dirname(__DIR__) . '/www/function/close_debuger.php');
// 载入公共配置
include(dirname(__DIR__) . '/www/config/common_config.php');
// 机台号预处理
include(dirname(__DIR__) . '/www/function/using_machine.php');
// 输出机台选择信息
// echo '<pre>';
// print_r($machines_arr[$index]);
// $machines_json = file_get_contents(dirname(__DIR__) . '\www\machines.config.json');
// $machines_arr = json_decode($machines_json, true);

// 关于程序
$FFrelease = dirname(__DIR__) . '/!关于和说明.txt';
if (file_exists($FFrelease)) {  // 判断是否有这个文件
    if (($fp = fopen($FFrelease, "a+")) != FALSE) {
        //读取文件
        $conn = fread($fp, filesize($FFrelease));
        // 替换字符串
        $conn = str_replace("\r\n", "<br>", $conn);
        // echo $conn;
    }
    fclose($fp);
}
// 关于程序
$FFversion = dirname(__DIR__) . '/version.txt';
if (file_exists($FFversion)) {  // 判断是否有这个文件
    if (($fp = fopen($FFversion, "a+")) != FALSE) {
        //读取文件
        $aboutAPP = fread($fp, filesize($FFversion));
        // 替换字符串
        $aboutAPP = str_replace("\r\n", "<br>", $aboutAPP);
        // echo $aboutAPP;
    } else {
        $aboutAPP = '<san  style="color: #757575;font-size:14px;">版本：？？？</span>';
    }
    fclose($fp);
} else {
    $aboutAPP =  '<san  style="color: #757575;font-size:14px;">版本：？？？</span>';
}
$random = time();
// var_dump($random);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<!-- 
/*
 * Author: Jones Pon
 * Version: 1.0.9
 * Release date: 2023/12/15
 */ 
-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>电镀生产资料查询工具</title>
    <script src="./js/jquery.js"></script>
    <script src="./js/jquery.cookie.min.js"></script>
    <script src="./js/md5.min.js"></script>
    <script src="./layui/layer/layer.js?randrom=<?php echo $random; ?>"></script>
    <link rel="stylesheet" href="./layui/css/layui.css?randrom=<?php echo $random; ?>" media="all">
    <link rel="stylesheet" href="./css/style.css">
    <!-- body 末尾处引入 layui -->
    <script src="./layui/layui.js" charset="utf-8"></script>
    <!-- 单位为秒，其中15指每隔15秒刷新一次页面 -->
    <?php if ($autoRefresh == 1) {
        echo '<meta http-equiv="refresh" content="' . $autoRefreshTime . '">';
    } ?>

</head>

<style>
    select {
        border: solid #ececec 1px;
    }

    .layui-input,
    .layui-textarea {
        width: 100px;
        height: 25px;
    }

    .layui-form-item .layui-input-inline {
        float: left;
        width: 100px;
        margin-right: 0;
    }

    .layui-form-item .layui-inline {
        margin-bottom: 0;
        margin-right: 0;
    }

    .layui-form-item {
        margin-bottom: 0;
        /* clear: both; */
        zoom: 1;
    }

    .layui-form-mid {
        height: 18px;
        padding: unset;
        padding-left: 5px;
        padding-right: 5px;
    }

    .layui-layer-prompt .layui-layer-input {
        border-color: rgb(0, 0, 0);
    }

    .top a {
        font-weight: 900;
        /* text-decoration: underline;
        text-decoration-color: #999;
        text-decoration-style: dotted; */
    }

    .showDiv {
        display: block;
    }

    .divClass {
        display: none;
    }

    #showMachine {
        z-index: 999;
    }

    .layui-btn {
        height: 25px;
        line-height: 25px;
    }

    span.layui-layer-setwin {
        display: none;
    }
</style>
<script>
    /*
    设置 cookie
    setCookie(name, value, expires, path, domain, secure)
    name: 键名，必选
    value: 键值，必选
    expires: 过期分钟, 必选
    path: 路径，选填
    domain: 域名，选填
    secure: 加密，选填
    */
    function setCookie(name, value, expires, path, domain, secure) {
        var today = new Date();
        today.setTime(today.getTime());
        if (expires) {
            expires = expires * 1 / 24 / 60 * 1000 * 60 * 60 * 24; //计算cookie的过期毫秒数
        } else {
            expires = 7 * 24 * 60 * 1 / 24 / 60 * 1000 * 60 * 60 * 24; //计算cookie的过期毫秒数
        }
        //计算cookie的过期日期
        var expires_date = new Date(today.getTime() + (expires));
        //构造并保存cookie字符串
        document.cookie = name + '=' + escape(value) +
            ((expires) ? ';expires=' + expires_date.toGMTString() : '') + //expires.toGMTString()
            ((path) ? ';path=' + path : '') +
            ((domain) ? ';domain=' + domain : '') +
            ((secure) ? ';secure' : '');
    }
    //读取cookie
    function getCookie(cookieName) {
        var cookieWord = $.cookie(cookieName);
        return cookieWord;
    }
    //检测cookie是否存在
    function checkCookie(cookieName) {
        var user = getCookie(cookieName);
        if (user != "") {
            return 1;
        } else {
            return 0;
        }
    }
    var configs = [
        ["func", "ConetionStatusViewer"]
    ];

    function setCookies(configs) {
        for (let i = 0; i < configs.length; i++) {
            const ele = configs[i];
            setCookie(ele[0], ele[1], 10080);
        }
        window.location.reload();
    }
    // console.log(md5(md5('111')));
    // 都是极其简单的密码或奇异密码
    var passwdmd5 = ['d9b1d7db4cd6e70935368a1efb10e377', 'c53e45a6eb973bad1cb842e6ddd648d0', 'd2e659c75637d8a4ab53b2d4a9df83cf', 'b900afac6b173100b1e55432e9d58c88', '3049a1fof1c808cdaa4fbed0e01649b1', '28c8edde3d61a0411511d3b1866f0636', 'dcfcd07e645d245babe887e5e2daa016', '3049a1f0f1c808cdaa4fbed0e01649b1'];
    // var passwdmd5 = ['74be16979710d4c4e7c6647856088456']; //取消密码验证
    if (checkCookie('login') == 0 || !getCookie('login') || passwdmd5.indexOf(getCookie('login')) <= -1) {
        var index = layer.prompt({
            formType: 1,
            value: '',
            title: '请输入口令，然后确认...',
            maxlength: 32,
            shade: 0.95,
            closeBtn: false, //右上角的关闭
            btnAlign: 'c',
            shadeClose: false, // 表示点击阴影部分是否关闭
            icon: '2',
            btn: ['确认'],
            success: function(layero, index) {
                this.enterConfirm = function(event) {
                    if (event.keyCode === 13) {
                        $(".layui-layer-btn0").click();
                        return false; //阻止系统默认回车事件
                    }
                };
                $(document).on('keydown', this.enterConfirm); //监听键盘事件
                // 点击确定按钮回调事件
                $(".layui-layer-btn0").on("click", function() {
                    // console.log("peace and love");
                })
            },
            end: function() {
                $(document).off('keydown', this.enterConfirm); //解除键盘事件
            }
            // area: ['800px', '350px'] //自定义文本域宽高
        }, function(passwd, index, elem) {
            if (passwdmd5.indexOf(md5(md5(passwd))) > -1) {
                var inputpasswd = md5(md5(passwd));
                setCookie('login', md5(md5(passwd)), <?php echo $lockTime ?>);
                layer.close(index);
                return inputpasswd;
            } else {
                layer.msg('口令验证错误，请重新输入！', {
                    offset: 'c',
                    anim: 6
                });
                $('.layui-layer-input')[0].value = '';
            }
        });
        console.log(index);
    }
    var status = 0;
    var time = 1 * 1000;
    var mousex, mousey;
    document.onkeydown = function(e) {
        status = 1;
    }
    document.onmousemove = function(e) {
        var e = e || window.event;
        if (e.pageX || e.pageY) {
            var ex = e.pageX;
            var ey = e.pageY;
        } else {
            var ex = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            var ey = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        if (ex != mousex || ey != mousey) {
            status = 1;
        }
        mousex = ex;
        mousey = ey;
        // console.log(mousex, mousey);
    }
    document.onscroll = function() {
        status = 1;
    }
    setInterval(function() {
        // console.log($.cookie().expires_date);
        if (status == 0) {
            // alert('您设置的时间内，用户没有进行操作');
            if (checkCookie('login') && passwdmd5.indexOf(getCookie('login')) >= 0) {
                // setCookie('login', 'd2e659c75637d8a4ab53b2d4a9df83cf', 0);
            }
        } else {
            var maxHeight = document.body.clientHeight * 7 / 10
            window.frames[0].document.onmousemove = function(e) {
                var e = window.frames[0].event || window.frames[0].window.event
                var exi = e.clientX;
                if (exi >= 0) {
                    // console.log(exi);
                    status = 1;
                    if (checkCookie('login') && passwdmd5.indexOf(getCookie('login')) >= 0) {
                        // setCookie('login', 'd2e659c75637d8a4ab53b2d4a9df83cf', 15);
                    }
                } else {
                    status = 0;
                }
            }
        }
    }, time);
    // if (checkCookie('readed') == 0 || !getCookie('readed') || getCookie('readed') != 1) {
    function about() {
        var index = layer.open({
            type: 0,
            title: '关于和说明',
            closeBtn: 0,
            shadeClose: true,
            skin: 'layui-layer-lan',
            area: '60%',
            shade: 0.8,
            content: '<? echo $conn; ?> ',
            success: function(index) {
                console.log(index);
                setCookie('readed', 1, 10080);
            }
        });
        // layer.close(index, function() {
        //     setCookie('readed', 1,10080);
        //     index = "";
        // });
    }
</script>
<div id="showMachine">
    <div>
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
    <?php
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
</div>

<body>
    <div class="top">
        <!-- <a href="javascript:setCookies([['func', 'ConetionStatusViewer']]);" id="idConetionStatusViewer" title="查看全部机台 域名/IP 的连接是否可用（现在还测不准！）">连接状态</a> -->
        <?php
        // 设置默认选择日期范围
        if (!isset($_COOKIE['date_start']) or $_COOKIE['date_start'] == "NaN") {
            $date_start =  date("Y/m/d", time());
        } else {
            $date_start =   date("Y/m/d", $_COOKIE['date_start']);
        }
        if (!isset($_COOKIE['date_end']) or $_COOKIE['date_end'] == "NaN") {
            $date_end =  date("Y/m/d", time());
        } else {
            $date_end =   date("Y/m/d", $_COOKIE['date_end']);
        }
        ?>
        <label for="start_date">② 选择日期范围：</label>从
        <div class="layui-inline" id="dates">
            <div class="layui-input-inline">
                <input type="text" autocomplete="on" name="date_start" id="date_start" class="layui-input" placeholder="开始日期" value="<?php echo $date_start ?>">
            </div> 到
            <div class="layui-input-inline">
                <input type="text" autocomplete="on" name="date_end" id="date_end" class="layui-input" placeholder="结束日期" value="<?php echo $date_end ?>">
            </div>
        </div>
        <script>
            var date = new Date();
            var year = date.getFullYear(); // 获取完整的年份(4位,1970-至今)
            var month = 1 + date.getMonth(); // 获取当前月份(0-11,0代表1月)
            var day = date.getDate(); // 获取当前日(1-31)
            if (month < 10) month = "0" + month;
            if (day < 10) day = "0" + day;
            layui.use('laydate', function() {
                var laydate = layui.laydate.render({
                    //设置开始日期、日期日期的 input 选择器
                    elem: '#dates',
                    // lang: 'en', //国际版
                    type: 'date', // year,month,time,datetime'
                    range: ['#date_start', '#date_end'], //数组格式为 2.6.6 开始新增，之前版本直接配置 true 或任意分割字符即可. true,'~'
                    calendar: true, //开启公历节日
                    format: 'yyyy/MM/dd', //自定义格式: yyyy年MM月dd日,dd/MM/yyyy,yyyyMMdd,H点m分,yyyy-MM,yyyy年M月d日H时m分s秒

                    // value: year + "/" + month + "/" + day + " " + hour + ":" + min, // 初始赋值

                    //自定义重要日
                    mark: <?php echo "{" . $calendarMark . "}" ?>,
                    //限定可选日期, 前后若干天可选，这里以7天为例 min: -7,max: 7
                    min: -1096, //2016-10-14/09:30:00/-7
                    max: 0, // 2080-10-14/09:30:00/7

                    isInitValue: true,
                    // showBottom: false, //不出现底部栏
                    shade: 0.8, // 遮罩透明度
                    shadeClose: true, // 点击遮罩区域，关闭弹层
                    // rangeLinked: true, // 开启日期范围选择时的区间联动标注模式(2.8+ 新增)
                    trigger: 'click', //自定义事件，mousedown, click点击触发/只读
                    theme: 'molv', //主题：molv墨绿，'#393D49'自定义颜色，'grid'格子主题
                    // position: 'static' // 直接嵌套
                    extrabtns: [{
                            id: 'today',
                            text: '今天',
                            range: [new Date(new Date().setDate(new Date().getDate())), new Date(new Date().setDate(new Date().getDate()))]
                        },
                        {
                            id: 'yesterday',
                            text: '昨天',
                            range: [new Date(new Date().setDate(new Date().getDate() - 1)), new Date(new Date().setDate(new Date().getDate() - 1))]
                        },
                        {
                            id: 'lastday-7',
                            text: '近7天',
                            range: [new Date(new Date().setDate(new Date().getDate() - 7)), new Date(new Date().setDate(new Date().getDate() - 1))]
                        },
                        {
                            id: 'lastday-30',
                            text: '近30天',
                            range: [new Date(new Date().setDate(new Date().getDate() - 30)), new Date(new Date().setDate(new Date().getDate() - 1))]
                        }
                    ],
                    // btns: ['clear', 'now', 'confirm', 'reset', 'today'], //按钮clear, confirm,now ,reset
                    ready: function() {
                        // laydate.hint('可选范围：过去的三年');
                    },
                    done: function(value, date) {
                        layer.msg('你选择的日期时间是： ' + value); //提示语
                        // layer.alert('你选择的时间范围是：' + value + '<br>获得的对象是' + JSON.stringify(date)); //弹出框
                        // console.log(date);
                        const arr_date = value.split(' - ');
                        let d1 = new Date(arr_date[0]);
                        let t1 = parseInt((parseInt(d1.getTime(d1))) / 1000 + 10);
                        let d2 = new Date(arr_date[1]);
                        let t2 = parseInt((parseInt(d2.getTime(d2))) / 1000 + 10);
                        setCookie('date_start', t1, 10080);
                        setCookie('date_end', t2, 10080);
                        window.location.reload();
                    }
                });
            });
        </script>
        <a href="javascript:setCookies([['func', 'Home']]);" id="idHome" title="显示AMC-AAMI机台主页">主页</a>
        <a href="javascript:setCookies([['func', 'DataLog']]);" id="idDataLog" title="显示<DataLog>机台生产数据（包括所有电流、电压、速度、温度、流量、压力、安培、上水、脉冲、电导率、其他等数据）">运行图表</a>
        <?php if ($machines_arr[$index]['ErrorLog'] == '1' or $machines_arr[$index]['Alarm'] == '1') {
            echo '<a href="javascript:setCookies([[\'func\', \'ErrorLog\']]);" id="idErrorLog" title="显示<ErrorLog/Alarm>问题记录（包括问题事件、原因、机台状态等）">(月)问题记录</a>';
        } ?>
        <?php if ($machines_arr[$index]['EventLog'] == '1') {
            echo '<a href="javascript:setCookies([[\'func\', \'EventLog\']]);" id="idEventLog"  title="显示<EventLog>开关机事件（包括开关机事件、机台状态等）">(月)开关机事件</a>';
        } ?>
        <?php if ($machines_arr[$index]['StartStopLog'] == '1') {
            echo '<a href="javascript:setCookies([[\'func\', \'StartStopLog\']]);" id="idStartStopLog"   title="显示<StartStopLog>开停机查询（包括开停机事件、按钮动作等）">开停机查询</a>';
        } ?>
        <?php if ($machines_arr[$index]['downtimelog'] == '1' or $machines_arr[$index]['Stopline'] == '1') {
            echo '<a href="javascript:setCookies([[\'func\', \'downtimelog\']]);" id="iddowntimelog"  title="显示<downtimelog、Stopline>停机原因（包括停机原因、停机时长、线体等）">(月)停机原因</a>';
        } ?>
        <?php if ($machines_arr[$index]['ParameterLog/Machine'] == '1') {
            echo '<a href="javascript:setCookies([[\'func\', \'MachineParameterLog\']]);" id="idMachineParameterLog"  title="显示<ParameterLog/Machine>机器参数修改记录（包括机器参数修改记录、原因、机台状态等）">(年)机器参数</a>';
        } ?>
        <?php if ($machines_arr[$index]['ParameterLog/Product'] == '1' or $machines_arr[$index]['ParametricModifierLog'] == '1') {
            echo '<a href="javascript:setCookies([[\'func\', \'ProductParameterLog\']]);" id="idProductParameterLog"  title="显示<ParameterLog/Product、ParametricModifierLog>产品参数修改记录（包括产品参数修改记录、原因、机台状态等）">(年)产品参数</a>';
        } ?>
        <a href="javascript:setCookies([['func', 'DataLogViewer']]);" id="idDataLogViewer" title="DataLogViewer，显示原版运行图表（内链会打开新窗口）">原 [运行图表]</a>
        </a>
        <a href="javascript:setCookies([['func', 'ErrorLogViewer']]);" id="idErrorLogViewer" title="ErrorLogViewer, 显示原版问题纪录（内链会打开新窗口）">原 [问题记录]</a>
        <a href="javascript:setCookies([['func', 'ASD']]);" id="idASD" title="显示原版ASD电流密度">ASDviewer</a>
        <a href="javascript:setCookies([['func', 'StatusViewer']]);" id="idStatusViewer" title="查看全部机台生产状态（产品、速度等）">状态显示</a>
        <!-- <input type="button" onclick="javascript:location.reload();" value="刷新页面" style="border:0;background-color:#0080ff;color:white;position:fixed;right:0px;top:0px;padding:5px"> -->
        <!-- <a href="javascript:setCookies([['func', 'calAmpMin']]);" id="idcalAmpMin" title="安培计算（便于复制）">安培计算</a> -->
        <!-- <a href="javascript:setCookies([['func', 'ClearCookie']]);" id="idClearCookie" title="清理cookie">清理cookie</a> -->
    </div>

    <div class="left">
        <label for="">① 选择机台</label>
        <input type="text" name="selectMachine" id="selectMachine" placeholder="点击选择机台" class="layui-input" style="width:7.5rem;padding:1px" value="<?php echo '# ', $_COOKIE['machine'] ?>" readonly lay-on="page">
        <label for="">-PARAMETER-筛选：</label>
        <ul>
            <li><a href="javascript:setCookies([['type', 'mainPlatingTankCurr'],['func', 'DataLog']]);" id="idmainPlatingTankCurr" title="显示该机台镀银缸、镍钯金缸、ME2缸等主要电镀缸及退镀缸等电流">mainPlatingTank Curr.</a></li>
            <li><a href="javascript:setCookies([['type', 'otherCurrents'],['func', 'DataLog']]);" id="idotherCurrents" title="显示该机台除以上主要缸体之外的电流">orther Currents</a></li>
            <li><a href="javascript:setCookies([['type', 'L1CurrRunSpeed'],['func', 'DataLog']]);" id="idL1CurrRunSpeed" title="显示该机台线1-所有电流和速度">L1 Curr. & Run Speed</a></li>
            <li><a href="javascript:setCookies([['type', 'L1Voltage'],['func', 'DataLog']]);" id="idL1Voltage" title="显示该机台线1-所有电压">L1 Voltage</a></li>
            <li><a href="javascript:setCookies([['type', 'L2CurrRunSpeed'],['func', 'DataLog']]);" id="idL2CurrRunSpeed" title="显示该机台线2-所有电流和速度">L2 Curr. & Run Speed</a></li>
            <li><a href="javascript:setCookies([['type', 'L2Voltage'],['func', 'DataLog']]);" id="idL2Voltage" title="显示该机台线2-所有电压">L2 Voltage</a></li>
            <?php
            if ($_COOKIE['machine'] == '10' or $_COOKIE['machine'] == '12' or $_COOKIE['machine'] == '31'  or $_COOKIE['machine'] == "33"  or count(explode('test', $_COOKIE['machine'])) > 1) {
                echo '<li><a href="javascript:setCookies([[\'type\', \'L3CurrRunSpeed\'],[\'func\', \'DataLog\']]);" id="idL3CurrRunSpeed" title="显示该机台线3-所有电流和速度">L3 Curr. & Run Speed</a></li>
                <li><a href="javascript:setCookies([[\'type\', \'L3Voltage\'],[\'func\', \'DataLog\']]);" id="idL3Voltage"  title="显示该机台线3-所有电压">L3 Voltage</a></li>';
            }
            if ($_COOKIE['machine'] == '12'  or $_COOKIE['machine'] == "33"  or count(explode('test', $_COOKIE['machine'])) > 1) {
                echo '<li><a href="javascript:setCookies([[\'type\', \'L4CurrRunSpeed\'],[\'func\', \'DataLog\']]);" id="idL4CurrRunSpeed"  title="显示该机台线4-所有电流和速度">L4 Curr. & Run Speed</a></li>
                <li><a href="javascript:setCookies([[\'type\', \'L4Voltage\'],[\'func\', \'DataLog\']]);" id="idL4Voltage"  title="显示该机台线4-所有电压">L4 Voltage</a></li>';
            }
            ?>
            <li><a href="javascript:setCookies([['type', 'Temperatures'],['func', 'DataLog']]);" id="idTemperatures" title="显示该机台所有温度">Temperatures</a></li>
        </ul>
        <label for="">-DataLog 选项-：</label>
        <?
        if ($_COOKIE['type'] == 'Current' or $_COOKIE['type'] == 'Voltage' or $_COOKIE['type'] == 'Speed' or $_COOKIE['type'] == 'Temperature' or $_COOKIE['type'] == 'FlowRate' or $_COOKIE['type'] == 'Conductivity' or $_COOKIE['type'] == 'EBOtime' or $_COOKIE['type'] == 'Pressure' or $_COOKIE['type'] == 'AmpMin' or $_COOKIE['type'] == 'OnOffPumpSpeed' or $_COOKIE['type'] == 'Temperatures') {
            echo '<br>
        <label for="" style="color:red">选线体</label>
        <select name="lineSelect" id="lineSelect">';
            if (!empty($_COOKIE['line']) && $_COOKIE['line'] == 'lineall') {
                echo '<option value="lineall" title="显示相应线体" selected>Line 全部</a></option>';
            } else {
                echo '<option value="lineall" title="显示相应线体">Line 全部</a></option>';
            }
            if (!empty($_COOKIE['line']) && $_COOKIE['line'] == 'line0') {
                echo '<option value="line0" title="显示相应线体" selected>Line 0 共有</a></option>';
            } else {
                echo '<option value="line0" title="显示相应线体">Line 0 共有</a></option>';
            }
            if (!empty($_COOKIE['line']) && $_COOKIE['line'] == 'line1') {
                echo '<option value="line1" title="显示相应线体" selected>Line 1</a></option>';
            } else {
                echo '<option value="line1" title="显示相应线体">Line 1</a></option>';
            }
            if (!empty($_COOKIE['line']) && $_COOKIE['line'] == 'line2') {
                echo '<option value="line2" title="显示相应线体" selected>Line 2</a></option>';
            } else {
                echo '<option value="line2" title="显示相应线体">Line 2</a></option>';
            }
            if ($_COOKIE['machine'] == '10' or $_COOKIE['machine'] == '12' or $_COOKIE['machine'] == '31'  or $_COOKIE['machine'] == "33"  or count(explode('test', $_COOKIE['machine'])) > 1) {
                if (!empty($_COOKIE['line']) && $_COOKIE['line'] == 'line3') {
                    echo '<option value="line3" title="显示相应线体" selected>Line 3</a></option>';
                } else {
                    echo '<option value="line3" title="显示相应线体">Line 3</a></option>';
                }
            }
            if ($_COOKIE['machine'] == '12'  or $_COOKIE['machine'] == "33"  or count(explode('test', $_COOKIE['machine'])) > 1) {
                if (!empty($_COOKIE['line']) && $_COOKIE['line'] == 'line4') {
                    echo '<option value="line4" title="显示相应线体" selected>Line 4</a></option>';
                } else {
                    echo '<option value="line4" title="显示相应线体">Line 4</a></option>';
                }
            }
        }
        echo '</select>';
        ?>
        <script>
            $('#lineSelect').change(function() {
                setCookie('line', this.value, 10080);
                window.location.reload();
            });
            // alert(getCookie('line'));
        </script>

        <ul>
            <!-- <li><a href="javascript:setCookies([['type', 'main'],['func', 'DataLog']]);" id="idmain"  title="显示默认">初始化</a></li> -->
            <li><a href="javascript:setCookies([['type', 'Current'],['func', 'DataLog']]);" id="idCurrent" title="显示电流">电流</a></li>
            <li><a href="javascript:setCookies([['type', 'Voltage'],['func', 'DataLog']]);" id="idVoltage" title="显示电压">电压</a></li>
            <li><a href="javascript:setCookies([['type', 'Speed'],['func', 'DataLog' ]]);" id="idSpeed" title="显示速度">速度</a></li>
            <li><a href="javascript:setCookies([['type', 'Temperature'],['func', 'DataLog']]);" id="idTemperature" title="显示温度">温度</a></li>
            <li><a href="javascript:setCookies([['type', 'Conductivity'],['func', 'DataLog']]);" id="idConductivity" title="显示抗氧化电导率">电导率</a></li>
            <li><a href="javascript:setCookies([['type', 'EBOtime'],['func', 'DataLog']]);" id="idEBOtime" title="显示加药时间计算">EBO换药时间(实验性)</a></li>
            <li><a href="javascript:setCookies([['type', 'FlowRate'],['func', 'DataLog']]);" id="idFlowRate" title="显示水流量、气流量">流量</a></li>
            <li><a href="javascript:setCookies([['type', 'Pressure'],['func', 'DataLog']]);" id="idPressure" title="显示气压、水压">压力</a></li>
            <li><a href="javascript:setCookies([['type', 'AmpMin'],['func', 'DataLog']]);" id="idAmpMin" title="显示安培分钟">安培</a></li>
            <li><a href="javascript:setCookies([['type', 'OnOffPumpSpeed'],['func', 'DataLog']]);" id="idOnOffPumpSpeed" title="显示脉冲比、上水速度">脉冲上水</a></li>
            <li><a href="javascript:setCookies([['type', 'other'],['func', 'DataLog']]);" id="idother" title="显示不好归类的">其他未分类</a></li>
            <li><a href="javascript:setCookies([['type', 'DIY'],['func', 'DataLog']]);" id="idDIY" title="自行定义数据">☆自定义筛选☆</a></li>
            <!-- <li><a href="javascript:setCookies([['type', 'unUsed'],['func', 'DataLog']]);" id="idunUsed" title="显示尚未使用的">未使用</a></li> -->
        </ul>
        <label for="">全局选项：</label>
        <ul>
            <li><a href="javascript:setCookies([['model', 'normal']]);" id="idnormal" title="切换正常使用的模式！">正常模式</a></li>
            <?
            if ($Release == 0) {
                echo '
                <li><a href="javascript:setCookies([[\'model\', \'debuger\']]);" id="iddebuger" title="切换到观察未使用的表头的模式">~Debuger</a></li>
                <li><a href="javascript:setCookies([[\'model\', \'zh_help\']]);" id="idzh_help" title="切换到观察使用中未使用中的表头、过滤重复的数值等，便于用于翻译。">~zh_help</a></li>';
            }
            ?>
            <li><a href="javascript:setCookies([['lang', 'en']]);" id="iden" title="切换到英文English显示">~英文显示</a></li>
            <?php
            if ($usezh_cn != 2) {
                echo '<li><a href="javascript:setCookies([[\'lang\', \'zh\']]);" id="idzh" title="切换到中文(简体)显示">~中文显示(实验性)</a></li>';
            }
            ?>
        </ul>
        <label for="">视图选项：</label>
        <ul>
            <li><a href="javascript:setCookies([['show', 'image']]);" id="idimage" title="切换到图表echart显示！">(分段)图像(实验性)</a></li>
            <li><a href="javascript:setCookies([['show', 'allimage']]);" id="idallimage" title="切换到图表echart显示！">(全幅)图像</a></li>
            <li><a href="javascript:setCookies([['show', 'table']]);" id="idtable" title="切换到表格table显示！">表格</a></li>
        </ul>
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-primary demo-dropdown-on" lay-options="{trigger: 'mousedown'}">
                <?php
                switch ($_COOKIE['func']) {
                    case 'Settings':
                        echo "设置&优化";
                        break;
                    case 'tbheader_config':
                        echo "D.L.表头管理";
                        break;
                    case 'zh_cn_en_config':
                        echo "中文翻译管理";
                        break;
                    case 'phpliteadmin':
                        echo "数据库管理";
                        break;

                    default:
                        echo "更多...";
                        break;
                }
                ?>
                <i class="layui-icon layui-icon-up layui-font-12"></i>
            </button>
        </div>

        <!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
        <!-- <script src="//unpkg.com/layui@2.8.18/dist/layui.js"></script> -->
        <script>
            layui.use(function() {
                var dropdown = layui.dropdown;
                // 自定义事件
                dropdown.render({
                    elem: '.demo-dropdown-on',
                    trigger: 'hover', // trigger 已配置在元素 `lay-options` 属性上
                    delay: '',
                    shade: 0.8,
                    align: 'left',
                    data: [{
                        title: '关于(About)',
                        id: 100,
                        href: "javascript:about();"
                    }, {
                        title: '设置&优化',
                        id: 101,
                        href: "javascript:setCookies([['func', 'Settings']]);"
                    }, {
                        title: 'DataLog表头管理',
                        id: 102,
                        href: "javascript:setCookies([['func', 'tbheader_config']]);"
                    }, {
                        title: '中文翻译管理',
                        id: 103,
                        href: "javascript:setCookies([['func', 'zh_cn_en_config']]);"
                    }, {
                        title: '数据库管理',
                        id: 104,
                        href: "javascript:setCookies([['func', 'phpliteadmin']]);"
                    }]
                });

            });
        </script>
        <ul>
            <?php
            echo $aboutAPP;
            ?>
        </ul>
    </div>
    </div>
    <script>
        $("#machine").on('change', function() {
            // alert(this.value);
            setCookie('machine', this.value, 10080);
            window.location.reload();
        });
        $("#date_start").on('change', function() {
            // alert(this.value);
            var timestamp1 = Date.parse(this.value);
            var timestamp = Date.parse(new Date());
            if (timestamp1 > timestamp) {
                setCookie('date_start', timestamp / 1000 + 10, 10080);
            } else {
                setCookie('date_start', timestamp1 / 1000 + 10, 10080);
            }
            window.location.reload();
        });
        $("#date_end").on('change', function() {
            var timestamp1 = Date.parse(this.value);
            var timestamp = Date.parse(new Date());
            if (timestamp1 > timestamp) {
                setCookie('date_end', timestamp / 1000, 10080);
            } else {
                setCookie('date_end', timestamp1 / 1000, 10080);
            }
            window.location.reload();
        });
        (getCookie('func')) ? ($("#id" + getCookie('func')).addClass('unText')) : "";
        (getCookie('line')) ? ($("#id" + getCookie('line')).addClass('unText')) : "";
        if (getCookie('type')) {
            if (getCookie('func') == "DataLog") {
                $("#id" + getCookie('type')).addClass('unText');
            }
        }
        if (!getCookie('model') || getCookie('model') == 'image' || getCookie('model') == undefined) {
            $("#idnormal").addClass('unText');
        } else {
            $("#id" + getCookie('model')).addClass('unText');
        }
        if (getCookie('func') != 'Home' && getCookie('func') != 'DataLogViewer' &&
            getCookie('func') != 'ErrorLogViewer' &&
            getCookie('func') != 'ASD' &&
            getCookie('func') != 'StatusViewer') {
            if (!getCookie('show') || getCookie('show') == 'image' || getCookie('show') == 'allimage' || getCookie('show') == undefined) {
                if (getCookie('show') == 'allimage') {
                    $("#idallimage").addClass('unText');
                } else if (getCookie('func') != 'DataLog') {
                    $("#idtable").addClass('unText');
                } else {
                    $("#idimage").addClass('unText');
                }
            } else {
                $("#idtable").addClass('unText');
            }
            if (<?php echo $usezh_cn ?> == 1) {
                if (!getCookie('lang') || getCookie('lang') == 'zh' || getCookie('lang') == undefined) {
                    $("#idzh").addClass('unText');
                } else {
                    $("#iden").addClass('unText');
                }
            } else {
                if (!getCookie('lang') || getCookie('lang') == 'en' || getCookie('lang') == undefined) {
                    $("#iden").addClass('unText');
                } else {
                    $("#idzh").addClass('unText');
                }
            }
        }
        layui.use(function() {
            var layer = layui.layer;
            var util = layui.util;
            // 批量事件
            util.on('lay-on', {
                page: function() {
                    // 页面层
                    const ltop = 18 + 0.5 * 18 + 25 + 10;
                    layer.open({
                        type: 1,
                        title: false,
                        area: ['50vw', '33em'], // 宽高
                        offset: [ltop + 'px', '16px'],
                        shadeClose: true,
                        shade: 0.5,
                        content: $("#showMachine")
                    });
                },
            });
        })
    </script>
    <?php
    // 定义默认值
    (isset($_COOKIE['func'])) ? ($func = $_COOKIE['func']) : ($func = "DataLog");
    (isset($_COOKIE['show'])) ? ($show = $_COOKIE['show']) : ($show = "image");
    (isset($_COOKIE['type'])) ? ($type = $_COOKIE['type']) : ($type = "main");
    (isset($_COOKIE['line'])) ? ($line = $_COOKIE['line']) : ($line = "line0");
    (isset($_COOKIE['machine'])) ? ($machine = $_COOKIE['machine']) : ($machine = "0");
    (isset($_COOKIE['date_start'])) ? ($date_start = $_COOKIE['date_start']) : ($date_start = "0");
    (isset($_COOKIE['date_end'])) ? ($date_end = $_COOKIE['date_end']) : ($date_end = "0");
    (isset($_COOKIE['model'])) ? ($model = $_COOKIE['model']) : ($model = "normal");
    $url = $func . ".php?show=" . $show . "&type=" . $type . "&line=" . $line . "&machine=" . $machine . "&date_start=" . $date_start . "&date_end=" . $date_end . "&model=" . $model;
    ?>
    <div class="main" onclick="disp()">
        <iframe src="<?php echo $url ?>" frameborder="0" name="mainifr" height="100%" width="100%"></iframe>
    </div>

</body>

</html>