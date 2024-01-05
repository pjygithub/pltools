<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>安培计算</title>
    <link rel="stylesheet" href="layui/css/layui.css" media="all">
    <script src="./js/jquery.js"></script>
    <script src="./js/jquery.cookie.min.js"></script>
</head>
<?php
date_default_timezone_set('Asia/Shanghai');
// echo "<pre>";
// var_dump($_COOKIE);
// echo "</pre>";
if (isset($_COOKIE['date_select']) and $_COOKIE['date_select'] != "") {
    $date_value = explode(' - ', $_COOKIE['date_select']);
} else {
    $date_start = date("Y/m/d H:i", time() - 21600);
    $date_end = date("Y/m/d H:i", time());
    $date_value = array($date_start, $date_end);
}
?>

<body>
    <label for="start_date">选择日期时间范围：</label>从
    <div class="layui-inline" id="dates">
        <div class="layui-input-inline">
            <input type="text" autocomplete="on" name="date_start" id="date_start" class="layui-input" placeholder="开始日期" value="<?php echo $date_value[0] ?>">
        </div> 到
        <!-- <div class="layui-form-mid">-</div> -->
        <div class="layui-input-inline">
            <input type="text" autocomplete="on" name="date_end" id="date_end" class="layui-input" placeholder="结束日期" value="<?php echo $date_value[1] ?>">
        </div>
    </div>
    <script src="layui/layui.js" charset="utf-8"></script>
    <script>
        //设置cookie
        function setCookie(cookieName, cookieValue) {
            $.cookie(cookieName, cookieValue, {
                expires: 7,
                path: '/'
            }); //第一种
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
        var date = new Date();
        var year = date.getFullYear(); // 获取完整的年份(4位,1970-至今)
        var month = 1 + date.getMonth(); // 获取当前月份(0-11,0代表1月)
        var day = date.getDate(); // 获取当前日(1-31)
        var hour = date.getHours(); // 获取当前小时数(0-23)
        var min = date.getMinutes(); // 获取当前分钟数(0-59)
        var sec = date.getSeconds(); // 获取当前秒数(0-59)
        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;
        if (hour < 10) hour = "0" + hour;
        if (min < 10) min = "0" + min;
        if (sec < 10) sec = "0" + sec;
        layui.use('laydate', function() {
            var laydate = layui.laydate.render({
                //设置开始日期、日期日期的 input 选择器
                elem: '#dates',
                // lang: 'en',//国际版
                type: 'datetime', // year,month,time,datetime'
                range: ['#date_start', '#date_end'], //数组格式为 2.6.6 开始新增，之前版本直接配置 true 或任意分割字符即可. true,'~'
                calendar: true, //开启公历节日
                format: 'yyyy/MM/dd HH:mm', //自定义格式: yyyy年MM月dd日,dd/MM/yyyy,yyyyMMdd,H点m分,yyyy-MM,yyyy年M月d日H时m分s秒

                // value: year + "/" + month + "/" + day + " " + hour + ":" + min, // 初始赋值

                //自定义重要日
                mark: {
                    '0-12-31': '跨年', //每年的日期
                    '0-0-15': '月中', //每月某天
                    '0-8-15': '', //如果为空字符，则默认显示数字+徽章
                    '2099-10-14': '呵呵'
                },
                //限定可选日期, 前后若干天可选，这里以7天为例 min: -7,max: 7
                min: '2021-01-01 00:00:00', //2016-10-14/09:30:00/-7
                max: "'" + year + "-" + month + "-" + day + " " + hour + ":" + min + ":" + sec + "'", // 2080-10-14/09:30:00/7

                // btns: ['clear', 'now', 'confirm', 'reset'], //按钮clear, confirm,now ,reset
                isInitValue: true,
                // showBottom: false, //不出现底部栏
                trigger: 'click', //自定义事件，mousedown, click点击触发/只读
                theme: 'grid', //主题：molv墨绿，'#393D49'自定义颜色，'grid'格子主题
                // position: 'static' // 直接嵌套
                ready: function() {
                    // laydate.hint('日期时间可选值设定在 <br> 2021-01-01 00:00:00 <br>到<br> ' + year + "-" + month + "-" + day + " " + hour + ":" + min + ":" + sec);
                },
                done: function(value, date) {
                    layer.msg('你选择的日期时间是： ' + value); //提示语
                    // layer.alert('你选择的时间范围是：' + value + '<br>获得的对象是' + JSON.stringify(date)); //弹出框
                    // console.log(date);
                    setCookie('date_select', value);
                    window.location.reload();
                }
            });
        });
    </script>
</body>

</html>