<!DOCTYPE html>
<html lang="zh-CN" style="height: 100%">

<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="js/echarts.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cookie.min.js"></script>
</head>
<?php
include_once(dirname(__DIR__) . "/config/common_config.php");
// $output = shell_exec("echo | {$_ENV['SYSTEMROOT']}\System32\wbem\wmic.exe path win32_videocontroller get name");
$output = shell_exec("whoami /user /nh");
$output = iconv('GB2312', 'UTF-8', $output);
// $utf8_str = mb_convert_encoding($ansi_str, 'UTF-8', 'GB2312');
if ($output) {
    $username = explode(' ', $output);
    $username = $username[0];
    $username = str_replace('\\', '\\\\', $username);
    // var_dump($username);
} else {
    $username = "未知用户";
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
    <div id="container" style="height: 100%"></div>
    <div></div>
</body>
<script>
    // 方法 - 随机数生成
    // @parame min 随机数下限
    // @parame max 随机数上限
    function getRnd(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min
    }
    //读取cookie
    function getCookie(cookieName) {
        var cookieWord = $.cookie(cookieName);
        return cookieWord;
    }
    var app = {};
    var option;
    var myDate = new Date();
    var tYear = myDate.getFullYear();
    var tMonth = myDate.getMonth();
    tMonth = (tMonth < 10 ? "0" + parseInt(tMonth + 1) : parseInt(tMonth + 1));
    var tDay = myDate.getDate();
    tDay = (tDay < 10 ? "0" + tDay : tDay);
    <?php
    $waterprint = "Datalog - ";
    (isset($_COOKIE['machine']) and $_COOKIE['machine'] != "") ? $waterprint .= '机台号#' . $_COOKIE['machine'] : "";
    // (isset($_COOKIE['func']) and $_COOKIE['func'] != "") ? $waterprint .= ' - 查询类型1_' . $_COOKIE['func'] : "";
    (isset($_COOKIE['type']) and $_COOKIE['type'] != "") ? $waterprint .= ' - 查询类型_' . $_COOKIE['type'] : "";
    (isset($_COOKIE['machine']) and $_COOKIE['machine'] != "") ? $waterprint .= ' -资源目录_' . $dirname . "" : "";
    (isset($_COOKIE['date_start']) and $_COOKIE['date_start'] != "") ? $waterprint .= ' - 选择日期从_' . date('Y_m_d', $_COOKIE['date_start']) . "" :  "";
    (isset($_COOKIE['date_end']) and $_COOKIE['date_end'] != "") ? $waterprint .= ' 到 ' . date('Y_m_d', $_COOKIE['date_end']) . "" :  "";
    $waterprint2 = "";
    (isset($_COOKIE['line']) and $_COOKIE['line'] != "") ? $waterprint2 .= '线体_' . $_COOKIE['line'] : "";
    (isset($_COOKIE['show']) and $_COOKIE['show'] != "") ? $waterprint2 .= ' - 显示方式_' . $_COOKIE['show'] : "";
    (isset($_COOKIE['lang']) and $_COOKIE['lang'] != "") ? $waterprint2 .= ' - 语言_' . $_COOKIE['lang'] : "";
    (isset($_COOKIE['model']) and $_COOKIE['model'] != "") ? $waterprint2 .= ' - 模块_' . $_COOKIE['model'] : "";
    (isset($_COOKIE['machine']) and $_COOKIE['machine'] != "") ? $waterprint2 .= ' - 账户：' . $username : "";
    ?>
    waterprint = '<?php echo $waterprint; ?> - 随机码_' + getRnd(1000, 9999);
    waterprint2 = '<?php echo $waterprint2; ?>';
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
            subtext: waterprint2, //副标题
            left: 'center',
            top: 'center',
            textStyle: {
                fontSize: 18,
                color: 'rgba(127,127,127,0.4)',
                fontFamily: '',
                // fontWeight: 'bolder',
                lineHeight: 18,
            },
            subtextStyle: {
                fontSize: 18,
                color: 'rgba(127,127,127,0.4)',
                lineHeight: 18,
            },
            itemGap: 10
        },
        // 可选线条颜色
        color: [
            // 官方默认
            '#5470C6', '#91CC75', '#FAC858', '#fd8686', '#73C0DE', '#3BA272', '#9A60B4', '#ca93bb',
            // 自定义
            '#003fff', '#000000', '#E6194B', '#A9A9A9', "#C05050", '#199E10', '#FF0000', '#FF00E0', '#37c7ff', '#9E0899', '#02ef80', '#FFDE00', "#07a2a4", "#9E2210", '#000075', "#B1EB0B", "#20EB12", "#EB6000", "#9E8010",
            // 待选
            '#9A6324', "#EB1F00", '#FC8452', "#1C6AEB", "#08419E", "#9E4A10", "#371CEB", "#1B089E", "#02EACC", "#EBBA00", "#EB1CE4", "#9E0899", "#9C9E10", "#138EEB", "#E7EB00", "#EB221C", "#9E0C08", "#199E10", "#2201EB", "#0FEB00", "#EB711C", "#9E4608", "#109E5F", "#A901EB", "#00EB82", "#EBA91C", "#9E6E08", "#10989E", "#EA0099", "#00E0EB", "#EBCD1C", "#9E8808", "#107C9E", "#EB0041", "#00B3EB", "#EBDC1C", "#9E9408", "#10349E", "#EB2E00", "#003BEB", "#91EB1C", "#5D9E08", "#74519E", "#EB8C08", "#6B00EB", "#1CEB57", "#089E32", "#9E516B", "#EBD70D", "#EB0051", "#1CC1EB", "#08809E"
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
                animation: false,
                animationThreshold: 2000 //阀值
            },
            showContent: true, //是否显示提示框浮层，默认显示。
            alwaysShowContent: false,
            triggerOn: 'mousemove', // 触发时机  'mousemove'鼠标移动时触发。'click'鼠标点击时触发。  'mousemove|click'同时鼠标移动和点击时触发。
            // enterable: false, // 鼠标是否可进入提示框浮层中，默认为false，如需详情内交互，如添加链接，按钮，可设置为 true。
            renderMode: 'html', // 浮层的渲染模式，默认以 'html 即额外的 DOM 节点展示 tooltip；'richText'
            backgroundColor: 'rgba(255,255,255,0.85)', // 提示框浮层的背景颜色。
            borderColor: 'rgba(0,0,255,1)', // 提示框浮层的边框颜色。
            borderWidth: 0.3, // 提示框浮层的边框宽。
            padding: 16, // 提示框浮层内边距，
            textStyle: { // 提示框浮层的文本样式。
                // color: '#fff',
                fontStyle: 'normal',
                fontWeight: 'normal',
                fontFamily: 'sans-serif',
                fontSize: 14,
                lineHeight: 14,
                margin: 10
            },
            extraCssText: 'box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);', // 额外附加到浮层的 css 样式
            confine: true, // 是否将 tooltip 框限制在图表的区域内。
            order: '<? echo $echartSort ?>', //'seriesAsc'根据系列声明, 升序排列。'seriesDesc'根据系列声明, 降序排列。'valueAsc'根据数据值, 升序排列。'valueDesc'根据数据值, 降序排列。
            transitionDuration: 0,
            formatter: function(params, ticket, callback) {
                var htmlStr = '<table><tbody>';
                <?php
                if ($echartSort == 'seriesAsc') {
                    echo 'params.sort((a, b) => a.seriesName.localeCompare(b.seriesName));';
                } elseif ($echartSort == 'seriesDesc') {
                    # code...
                } elseif ($echartSort == 'valueAsc') {
                } elseif ($echartSort == 'valueDesc') {
                    # code...
                }
                ?>
                if (option.legend.data.length < 30) {
                    for (var i = 0; i < params.length; i++) {
                        var param = params[i];
                        var xName = param.name; //x轴的名称
                        var seriesName = param.seriesName; //图例名称
                        var value = param.value; //y轴值
                        var color = param.color; //图例颜色
                        if (i === 0) {
                            htmlStr += xName + '<br/>'; //x轴的名称
                        }
                        htmlStr += '<tr><td><span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:' + color + ';"></span>';
                        htmlStr += '' + seriesName + '</span></td><td style="text-align:right;padding-left:2em;">';
                        if (Number(value) === Math.round(value) | Number(value) !== Math.round(value)) {
                            value = Number(value).toFixed(<?php echo $echartShowFloatNum ?>)
                        }
                        htmlStr += value + '</td></tr>';
                        // htmlStr += '</div>';
                    }
                    // for (const key in params[i].data) {
                    //     if (Object.hasOwnProperty.call(param.data, key)) {
                    //         const elevalue = param.data[key];
                    //         if (key !== "value") {
                    //             htmlStr += '<span style="font-size:0.5rem;opacity:0.8;">' + key + '：' + elevalue + '</span><br>';
                    //         }
                    //     }
                    // }
                } else {
                    for (var i = 0; i < params.length; i++) {
                        if (i === 0) {
                            htmlStr += params[i].name + '<br/>'; //x轴的名称
                        }
                        htmlStr += '<tr>';
                        if (i % 2 === 0) {
                            htmlStr += '<td><span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:' + params[i].color + ';"></span>';
                            htmlStr += '' + params[i].seriesName + '</span></td><td style="text-align:right;padding-left:2em;padding-right:2em;">';
                            if (Number(params[i].value) === Math.round(params[i].value) | Number(params[i].value) !== Math.round(params[i].value)) {
                                value = Number(params[i].value).toFixed(<?php echo $echartShowFloatNum ?>)
                            }
                            htmlStr += value + '</td>';
                            htmlStr += '<td><span style="margin-right:5px;display:inline-block;width:10px;height:10px;border-radius:5px;background-color:' + params[i + 1].color + ';"></span>';
                            htmlStr += '' + params[i + 1].seriesName + '</span></td><td style="text-align:right;padding-left:2em;padding-right:0em;">';
                            if (Number(params[i + 1].value) === Math.round(params[i + 1].value) | Number(params[i + 1].value) !== Math.round(params[i + 1].value)) {
                                value = Number(params[i + 1].value).toFixed(<?php echo $echartShowFloatNum ?>)
                            }
                            htmlStr += value + '</td>';
                        }
                        htmlStr += '</tr>';
                        // htmlStr += '</div>';
                    }
                    // for (const key in params[i].data) {
                    //     if (Object.hasOwnProperty.call(param.data, key)) {
                    //         const elevalue = param.data[key];
                    //         if (key !== "value") {
                    //             htmlStr += '<span style="font-size:0.5rem;opacity:0.8;">' + key + '：' + elevalue + '</span><br>';
                    //         }
                    //     }
                    // }
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
                if ('<?php echo $_COOKIE['type'] ?>' == 'AmpMin') {
                    return parseInt(value.max + 1);
                }
                if (parseInt(value.max) >= 3122800000) {
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
                    echo "lineStyle: {width:" . $echartlinewidth . "},\n";
                    if ($highEchart == 1) {
                        echo "emphasis:{disabled:false, scale:true,focus:'series',},\n"; // 设置高亮
                    }
                    echo "connectNulls: false,\n";
                    // if ($j > 0) {
                    //     echo "
                    //     markPoint: {
                    //         data: [
                    //         {
                    //             yAxis: " . round($data[$count_data - 1][$cols[$j]], 2) . ",
                    //             x: '98.5%',
                    //             value: '" . round($data[$count_data - 1][$cols[$j]], 2) . "'
                    //         },
                    //         ],
                    //         // symbol: 'circle', // 标记图形
                    //         // symbolSize: 4, // 标记图形的大小
                    //         // 标注点的样式
                    //         itemStyle: {
                    //         //   color: '#FF4747', // 标注点颜色
                    //         },
                    //     },
                    //     ";
                    // }
                    echo "data:[";
                    if ($j < $count_cols - 1) {
                        for ($i = 1; $i < $count_data; $i++) {
                            if ($i < $count_data) {
                                if (isset($data[$i][$cols[$j]]) and is_numeric($data[$i][$cols[$j]])) {
                                    echo "{value:'" . $data[$i][$cols[$j]] . "',";
                                    for ($m = 0; $m < count($extraInfo); $m++) {
                                        $key = str_replace(" ", "", $data[0][$extraCols[$m]]);
                                        echo $key . ":'" . str_replace(".txt", "", $data[$i][$extraCols[$m]]) . "',";
                                    }
                                    echo "},";
                                } else {
                                    echo "";
                                }
                            } else {
                                if (isset($data[$i][$cols[$j]]) and is_numeric($data[$i][$cols[$j]])) {
                                    echo "{value:'" . $data[$i][$cols[$j]] . "',";
                                    for ($m = 0; $m < count($extraInfo); $m++) {
                                        $key = str_replace(" ", "", $data[0][$extraCols[$m]]);
                                        echo $key . ":'" . str_replace(".txt", "", $data[$i][$extraCols[$m]]) . "',";
                                    }
                                    echo "},";
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
                                    echo "{value:'" . $data[$i][$cols[$j]] . "',";
                                    for ($m = 0; $m < count($extraInfo); $m++) {
                                        $key = str_replace(" ", "", $data[0][$extraCols[$m]]);
                                        echo $key . ":'" . str_replace(".txt", "", $data[$i][$extraCols[$m]]) . "',";
                                    }
                                    echo "},";
                                } else {
                                    echo "";
                                }
                            } else {
                                if (isset($data[$i][$cols[$j]])) {
                                    echo "{value:'" . $data[$i][$cols[$j]] . "',";
                                    for ($m = 0; $m < count($extraInfo); $m++) {
                                        $key = str_replace(" ", "", $data[0][$extraCols[$m]]);
                                        echo $key . ":'" . str_replace(".txt", "", $data[$i][$extraCols[$m]]) . "',";
                                    }
                                    echo "},";
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
    // console.log(option.dataZoom[0].start);
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
            layer.msg('没有需要输出的数据！请重新筛选。', {
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