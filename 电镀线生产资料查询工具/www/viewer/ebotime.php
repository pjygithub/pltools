<!DOCTYPE html>
<html lang="zh-CN" style="height: 100%">

<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="js/echarts.min.js"></script>
</head>
<?php
// $output = shell_exec("echo | {$_ENV['SYSTEMROOT']}\System32\wbem\wmic.exe path win32_videocontroller get name");
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
$output = shell_exec("whoami /user /nh");
$output = iconv('GB2312', 'UTF-8', $output);
// $utf8_str = mb_convert_encoding($ansi_str, 'UTF-8', 'GB2312');
if ($output) {
    $username = explode(' ', $output);
    $username = $username[0];
    $username = str_replace('\\', '\\\\', $username);
    // var_dump($username);
} else {
    $username = "unKown";
}
if ($_COOKIE['type'] == 'DIY') {
    $ecart_mar = 40;
    $chartH_ = 0.935;
} else {
    $ecart_mar = 0;
    $chartH_ = 1;
}
?>

<body style="height: 100%; margin-top:<?php echo $ecart_mar; ?>px">
    <?php
    // echo '<pre>';
    // var_dump($data);
    $ebo_data = array();
    $count_data = count($data);
    $count_cols = count($cols);
    for ($i = 1; $i < $count_data; $i++) {
        $tmp = array();
        for ($j = 0; $j < $count_cols; $j++) {
            if (isset($data[$i][$cols[$j]])) {
                array_push($tmp, $data[$i][$cols[$j]]);
            } else {
                array_push($tmp, "");
            }
        }
        array_push($ebo_data, $tmp);
    }
    // var_dump($ebo_data);
    for ($i = 1; $i < $count_cols; $i++) {
        $cal_a = array();
        $count_ebodata = count($ebo_data);
        for ($j = 0; $j < $count_ebodata; $j++) {
            array_push($cal_a, $ebo_data[$j][$i]);
        }
        // var_dump($cal_a);
        $tb = array();
        for ($k = 0; $k < $count_ebodata; $k++) {
            // var_dump((floatval($cal_a[$k + 1]) - floatval($cal_a[$k])) / floatval($cal_a[$k]));
            if ($k < $count_ebodata) {
                if ((floatval($cal_a[$k + 1]) - floatval($cal_a[$k])) / floatval($cal_a[$k]) >= 0.033) {
                    array_push($tb, $k);
                }
            } else {
                if ((floatval($cal_a[$k]) - floatval($cal_a[$k - 1])) / floatval($cal_a[$k - 1]) >= 0.033) {
                    array_push($tb, $k);
                }
            }
        }
    }
    // var_dump($tb);
    $machines_str = file_get_contents(dirname(__DIR__) . '../config/machines.config.json');
    $machines_arr = json_decode($machines_str, true);
    $count_mac = count($machines_arr);
    for ($i = 0; $i < $count_mac; $i++) {
        if ($machines_arr[$i]['id'] == $_COOKIE['machine']) {
            $chageTime = $machines_arr[$i]['EBOtime'];
        }
    }
    ?>
    <div id="container" style="height: 100%"></div>
</body>

<script>
    // 方法 - 随机数生成
    // @parame min 随机数下限
    // @parame max 随机数上限
    function getRnd(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min
    }
    //日期字符串转成时间戳
    //例如var date = '2015-03-05 17:59:00.0';
    function dateStrChangeTimeTamp(dateStr) {
        dateStr = dateStr.substring(0, 19);
        dateStr = dateStr.replace(/-/g, '/');
        var timeTamp = new Date(dateStr).getTime();
        return timeTamp;
    }
    //把时间戳转成日期格式
    //例如 timeTamp = '1425553097';
    function formatTimeTamp(timeTamp) {
        var time = new Date(timeTamp * 1000);
        var ttMM = time.getMonth() + 1;
        if (ttMM < 10) {
            ttMM = '0' + ttMM;
        }
        var ttd = time.getDate();
        if (ttd < 10) {
            ttd = '0' + ttd;
        }
        var tth = time.getHours();
        if (tth < 10) {
            tth = '0' + tth;
        }
        var ttm = time.getMinutes();
        if (ttm < 10) {
            ttm = '0' + ttm;
        }
        var date = ((time.getFullYear()) + "/" +
            (ttMM) + "/" +
            (ttd) + " " +
            (tth) + ":" +
            (ttm) + "" +
            // (time.getSeconds())
            ''
        );
        return date;
    }

    var app = {};
    var option;
    var myDate = new Date();
    var tYear = myDate.getFullYear();
    var tMonth = myDate.getMonth();
    tMonth = (tMonth < 10 ? "0" + parseInt(tMonth + 1) : parseInt(tMonth + 1));
    var tDay = myDate.getDate();
    tDay = (tDay < 10 ? "0" + tDay : tDay);
    waterprint = '<?php echo '机台号#' . $_COOKIE['machine'] . ' - 查询类型1_' . $_COOKIE['func'] . ' | 资源目录_' . $dirname . ' - 查询类型2_' . $_COOKIE['type'] . ' - 选择日期' . date('Y_m_d', $_COOKIE['date_start']) . ' - ' . date('Y_m_d', $_COOKIE['date_end']); ?> - 随机码' + getRnd(1000, 9999);
    waterprint1 = '<?php echo '显示方式_', $_COOKIE['show'], ' - 语言_', $_COOKIE['lang'], ' - 模块_', $_COOKIE['model'], ' - 选择日期' . date('Y/m/d', $_COOKIE['date_start']) . ' - ' . date('Y/m/d', $_COOKIE['date_end']); ?>' + ' - 使用账户：' + '<?php echo $username ?>';
    // console.log(waterprint);
    var dom = document.getElementById('container');
    let chartH = dom.offsetHeight * parseFloat(<? echo $chartH_ ?>);
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false,
        height: chartH,
        locale: 'ZH',
        useDirtyRect: true //是否开启脏矩形渲染
    });
    myChart.showLoading(); //显示加载动画，默认样式

    let timeData = [
        <?php
        $count_data = count($data);
        // $i=1  略过表头
        for ($i = 1; $i < $count_data; $i++) {
            if ($i < $count_data - 1) {
                echo "'" . $data[$i][0] . "',";
            } else {
                echo "'" . $data[$i][0] . "',";
            }
        }
        ?>
    ];
    timeData = timeData.map(function(str) {
        str = str.replace(tYear + '.', tYear + '/');
        str = str.replace(tMonth + '.', tMonth + '/');
        str = str.replace(tYear + '/', '');
        str = str.replace(tMonth + '/' + tDay + ' ', '');
        str = str.replace('.', '/');
        return str.replace(" ", "\n");
    });
    if (timeData.length >= <?php echo $echartShowTime; ?>) {
        // var startz = 100 - (100 / timeData.length) * 600;
        var startz = 100 - (100 / ((timeData.length / 1440) * 1440)) * <?php echo $echartShowTime; ?>;
        startz = parseInt(startz, 10);
    } else {
        var startz = 0;
    }
    if ('<? echo $_COOKIE['show'] ?>' == 'allimage') {
        startz = 0;
    }
    // alert(timeData.length);
    // console.log(timeData);
    // 可选线型标记
    var symbol = ['circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow', 'none'];
    // echart配置
    option = {
        title: {
            show: true, //不显示
            text: waterprint, //主标题
            subtext: waterprint1, //副标题
            left: 'center',
            top: 'center',
            textStyle: {
                fontSize: 18,
                color: 'rgba(127,127,127,0.3)',
                fontFamily: '',
                // fontWeight: 'bolder',
                lineHeight: 18,
            },
            subtextStyle: {
                fontSize: 16,
                color: 'rgba(127,127,127,0.2)',
                lineHeight: 16,
            },
            itemGap: 10
        },
        // 可选线条颜色
        color: [
            // 官方默认
            '#5470C6', '#91CC75', '#FAC858', '#fd8686', '#73C0DE', '#3BA272', '#9A60B4', '#ca93bb',
            // 自定义
            '#003fff', '#000000', '#E6194B', '#A9A9A9', "#C05050", '#199E10', '#FF0000', '#FF00E0', '#37c7ff', '#9E0899', '#02ef80', '#FFDE00', "#07a2a4", "#9E2210", '#000075', "#B1EB0B", "#20EB12", "#EB6000", "#9E8010", '#ffffff',
        ],
        legend: { //图例区
            type: 'plain', //'plain'：普通图例。缺省就是普通图例。'scroll'：可滚动翻页的图例。当图例数量较多时可以使用。
            show: true,
            selector: ['all', 'inverse'],
            selectorPosition: 'left',
            data: [
                <?php
                $count_cols = count($cols);
                for ($i = 1; $i < $count_cols; $i++) {
                    if ($i < $count_cols - 1) {
                        echo "'" . lang($data[0][$cols[$i]]) . "',";
                    } else {
                        echo "'" . lang($data[0][$cols[$i]]) . "'";
                    }
                }
                ?>
            ],
            width: '90%',
            height: 'auto',
            left: 0,
            top: 0,
            orient: 'horizontal',
            itemGap: 1, //图例每项之间的间隔。横向布局时为水平间隔，纵向布局时为纵向间隔。
            selectedMode: 'multiple',
        },
        tooltip: {
            show: true,
            trigger: 'axis', //触发类型。
            orient: '',
            axisPointer: { // 坐标轴指示器配置项。
                show: true,
                type: 'cross', // 'line' 直线指示器  'shadow' 阴影指示器  'none' 无指示器  'cross' 十字准星指示器。
                axis: 'auto', // 指示器的坐标轴。 
                snap: true, // 坐标轴指示器是否自动吸附到点上
                animation: true,
                animationThreshold: 2000 //阀值
            },
            showContent: true, //是否显示提示框浮层，默认显示。
            alwaysShowContent: false,
            triggerOn: 'mousemove', // 触发时机  'mousemove'鼠标移动时触发。'click'鼠标点击时触发。  'mousemove|click'同时鼠标移动和点击时触发。
            confine: true,
            // enterable: false, // 鼠标是否可进入提示框浮层中，默认为false，如需详情内交互，如添加链接，按钮，可设置为 true。
            renderMode: 'html', // 浮层的渲染模式，默认以 'html 即额外的 DOM 节点展示 tooltip；'richText'
            backgroundColor: 'rgba(255,255,255,0.85)', // 提示框浮层的背景颜色。
            borderColor: 'rgba(0,0,255,1)', // 提示框浮层的边框颜色。
            borderWidth: 1, // 提示框浮层的边框宽。
            padding: 16, // 提示框浮层内边距，
            textStyle: { // 提示框浮层的文本样式。
                // color: '#fff',
                fontStyle: 'normal',
                fontWeight: 'normal',
                fontFamily: 'sans-serif',
                fontSize: 15,
                lineHeight: 10,
                margin: 0
            },
            extraCssText: 'box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);', // 额外附加到浮层的 css 样式
            confine: true, // 是否将 tooltip 框限制在图表的区域内。
            order: 'valueDesc', //'seriesAsc'根据系列声明, 升序排列。'seriesDesc'根据系列声明, 降序排列。'valueAsc'根据数据值, 升序排列。'valueDesc'根据数据值, 降序排列。
            transitionDuration: 0,
            // formatter: '{b} 的成绩是 {c}'
            formatter: function(data, ticket, callback) {
                console.log(data);
                var macID = <?php echo "'" . $_COOKIE['machine'] . "'" ?>;
                var htmlStr = ''
                var realtime = '';
                var timee = data[0]['name'].replace('\n', ' ').split('/');
                //console.log(timee);
                if (timee.length == 1) {
                    realtime = tYear + "/" + tMonth + "/" + tDay + " " + data[0]['name'];
                } else if (timee.length == 2) {
                    realtime = tYear + "/" + data[0]['name'];
                } else if (timee.length == 3) {
                    realtime = data[0]['name'];
                }
                //console.log(realtime);
                const chargeTime = '<? echo $chageTime ?>';
                const chargeTimeArr = chargeTime.split(",");
                htmlStr = '<p>所选时间：' + data[0]['name'] + '</p><br>';
                htmlStr += '<table><tbody>预计换药时间：';
                htmlStr += "<p><tr>";
                for (let idxx = 0; idxx < chargeTimeArr.length; idxx++) {
                    const ele = chargeTimeArr[idxx];
                    if ((ele) != 0) {
                        htmlStr += '<td style="padding-right:10px;border: 1px solid #009688;padding:10px"><span style="font-size:2rem;font-weight:800;">' + ele + '</span> 小时后 开始<br>';
                        htmlStr += '<p><b style="font-size: 1rem;">' + formatTimeTamp(dateStrChangeTimeTamp(realtime) / 1000 + ele * 60 * 60) + '</b></p>';
                        htmlStr = htmlStr + "<p>+15分钟：<br> <b style='font-size:1.5rem;'>" + formatTimeTamp(dateStrChangeTimeTamp(realtime) / 1000 + ele * 60 * 60 + 15 * 60) + "</b></p>";
                        htmlStr += '</td>';
                    }
                }
                htmlStr += "<tr></p>";
                htmlStr += "<td rowspan=" + chargeTimeArr.length + "><p style = 'color:blue;'> （有些机台停机不计时， 留意。） </p></td><br><table><tbody>";
                for (let i = 0; i < data.length; i++) {
                    const ele = data[i];
                    var param = data[i];
                    var xName = param.name; //x轴的名称
                    var seriesName = param.seriesName; //图例名称
                    var value = param.value; //y轴值
                    var color = param.color; //图例颜色
                    // 正常显示的数据，走默认
                    htmlStr += '<tr><td><span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:' + color + ';"></span>';
                    htmlStr += '' + seriesName + '</span></td><td style="text-align:right;padding-left:2em;">';
                    if (Number(value) === Math.round(value) | Number(value) !== Math.round(value)) {
                        value = Number(value).toFixed(<?php echo $echartShowFloatNum ?>)
                    }
                    htmlStr += value + '</td></tr>';
                    // htmlStr += '</div>';
                }
                htmlStr += '</tbody></table>';
                return htmlStr;
            }
        },
        //绘图区
        grid: {
            left: '0.5%',
            right: '0.7%',
            bottom: '0.2%',
            containLabel: true,
            // borderWidth: 1,
        },
        //工具区
        toolbox: {
            show: true,
            orient: 'vertical',
            itemSize: 14,
            itemGap: 5,
            showTitle: true,
            z: 9999,
            // 可选工具
            feature: {
                // 保存为图片
                saveAsImage: {
                    show: true
                },
                // 缩放
                dataZoom: {
                    yAxisIndex: 'none'
                },
                mark: {
                    show: true
                },
                // 显示数据视图
                // dataView: {
                //     show: true,
                //     readOnly: false
                // },
                // 折线柱状切换
                // magicType: {
                //     show: true,
                //     type: ['line', 'bar']
                // },
                // 重置缩放
                restore: {
                    show: true
                }
            },
            top: -8,
            right: 10
        },
        axisPointer: {
            link: {
                xAxisIndex: 'all'
            }
        },
        xAxis: {
            gridIndex: 0,
            type: 'category',
            name: '日期 时间',
            boundaryGap: false,
            data: timeData,
            position: 'bottom',
            show: true,
            axisLine: {
                interval: false,
                onZero: true,
                symbol: 'arrow',
                lineStyle: {
                    type: 'solid'
                }
            }
        },
        yAxis: {
            gridIndex: 0,
            name: '',
            type: 'value',
            scale: true,
            show: true,
            alignTicks: true,
            max: function(value) {
                if (parseInt(value.max) >= 200) {
                    return 200;
                } else {
                    return parseInt(value.max + 1);
                }
            },
            min: function(value) {
                if ((value.min - 3) <= 0) {
                    return 0;
                } else {
                    return parseInt(value.min - 3);
                }
            },
            minInterval: 1, //设置成1保证坐标轴分割刻度显示成整数。
            inverse: false, // 倒置
            splitNumber: 15,
            axisTick: {
                length: 1,
                lineStyle: {
                    type: 'dashed'
                }
            },
            axisLabel: {
                formatter: '{value}',
                align: 'right'
            },

        },
        series: [
            <?php
            for ($i = 1; $i < $count_data - 1; $i++) {
                for ($j = 0; $j < $count_cols; $j++) {
                    echo "\n";
                    echo "{\n";
                    echo "name: '" . lang($data[0][$cols[$j]]) . "',\n";
                    echo "type: 'line',\n";
                    echo "smooth: true,\n";
                    echo "colorBy: 'series', //'series'：按照系列分配调色盘中的颜色，同一系列中的所有数据都是用相同的颜色；'data'：按照数据项分配调色盘中的颜色，每个数据项都使用不同的颜色。\n";
                    echo "yAxisIndex: 0,\n";
                    echo "symbol: symbol[getRnd(0, symbol.length)],\n";
                    echo "symbolSize: 7,\n";
                    echo "symbolRotate: getRnd(0, 360),\n";
                    echo "symbolOffset: [0, 0],\n";
                    echo "showSymbol: true,\n";
                    echo "lineStyle: {width:2},\n";
                    if ($highEchart == 1) {
                        echo "emphasis:{disabled:false, scale:true,focus:'series',},\n"; // 设置高亮
                    }
                    echo "connectNulls: false,\n";
                    if ($j > 0) {
                        echo "
                        markPoint: {
                            data: [
                                {
                                    yAxis: " . round($data[$count_data - 1][$cols[$j]], 2) . ",
                                    x: '98.5%',
                                    value: '" . round($data[$count_data - 1][$cols[$j]], 2) . "'
                                },";
                        // for ($m = 0; $m < count($tb); $m++) {
                        //     $datetime = new DateTime($data[$tb[$m]][$cols[0]]);
                        //     $timestamp = $datetime->getTimestamp();
                        //     $datetime = $timestamp + 6 * 60 * 60 + 15 * 60;
                        //     echo "{
                        //             yAxis: " . round($data[$tb[$m] + 1][$cols[$j]], 2) . ",
                        //             x: '" . (($tb[$m] / $count_ebodata * 100) + 1.2) . "%',
                        //             value: '" . date("Y-m-d H:i", $timestamp) . "→" . date("Y-m-d H:i", $datetime) . "'
                        //         },";
                        // }
                        echo "    ],
                        },
                        ";
                    }
                    echo "data:[";
                    if ($j < $count_cols - 1) {
                        for ($i = 1; $i < $count_data; $i++) {
                            if ($i < $count_data) {
                                if (isset($data[$i][$cols[$j]]) and is_numeric($data[$i][$cols[$j]])) {
                                    echo "'" . $data[$i][$cols[$j]] . "',";
                                } else {
                                    echo "";
                                }
                            } else {
                                if (isset($data[$i][$cols[$j]]) and is_numeric($data[$i][$cols[$j]])) {
                                    echo "'" . $data[$i][$cols[$j]] . "'";
                                } else {
                                    echo "";
                                }
                            }
                        }
                        echo "]\n";

                        echo "},";
                    } else {
                        for ($i = 1; $i < $count_data - 1; $i++) {
                            if ($i < $count_data) {
                                if (isset($data[$i][$cols[$j]])) {
                                    echo "'" . $data[$i][$cols[$j]] . "',";
                                } else {
                                    echo "";
                                }
                            } else {
                                if (isset($data[$i][$cols[$j]])) {
                                    echo "'" . $data[$i][$cols[$j]] . "'";
                                } else {
                                    echo "";
                                }
                            }
                        }
                        echo "],\n";
                        echo "}\n";
                    }
                }
            }
            ?>
        ],
        dataZoom: [ // 缩放
            {
                id: 'dataZoomX',
                realtime: true,
                type: 'slider',
                start: startz, // 默认显示开始
                end: 100, // 默认显示结束
                xAxisIndex: [0],
                filterMode: 'filter', // 设定为 'filter' 从而 X 的窗口变化会影响 Y 的范围。
            },
            {
                id: 'dataZoomY',
                type: 'inside',
                realtime: true,
                start: 30,
                end: 70,
                xAxisIndex: [0],
                filterMode: 'empty',
            }
        ],
    };
    // console.log(option.series.length);
    var html = '';
    for (let ide = 0; ide < option.color.length; ide++) {
        const ele = option.color[ide];
        html += '<span style="display:inline-block;width:70px;height:3px;background-color:' + ele + ';color:#000;text-align:center;margin:2px;"><br>' + ele + '</span>';
    }
    // layer.open({
    //     type: 0,
    //     title: '可选颜色',
    //     closeBtn: 0,
    //     shadeClose: true,
    //     skin: 'layui-layer-lan',
    //     area: '45%',
    //     shade: 0.8,
    //     content: html,
    // });
    if (option && typeof option === 'object' && option.series.length > 1) {
        myChart.setOption(option);
    } else {
        layui.use('layer', function() {
            var layer = layui.layer;
            layer.msg('没有需要输出的数据！', {
                icon: 8,
                skin: 'layui-layer-lan',
                closeBtn: 0,
                anim: 6
            });
        });
    }
    window.addEventListener('resize', myChart.resize);
    myChart.hideLoading(); //隐藏加载动画
</script>

</html>