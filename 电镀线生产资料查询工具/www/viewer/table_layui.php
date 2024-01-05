<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="../layui/css/layui.css" rel="stylesheet">
    <link rel="stylesheet" href="../layui/TableFilter/tableFilter.css">
</head>
<style type="text/css">
    .addFilexd {
        position: fixed;
        top: 0;
        z-index: 999;
        background: #fff;
        width: 100%;
    }

    .layui-table-header {
        position: fixed;
        top: 0px;
        z-index: 999;
    }

    .table-header-fixed {
        position: fixed;
        top: 0;
        z-index: 99
    }

    .table-header-fixed {
        position: fixed;
        top: 0;
        z-index: 99;
        width: 100%;
        overflow: hidden;
    }

    .layui-table-view {
        margin-top: 28px;
    }

    .layui-table-page {
        background-color: #fff;
        z-index: 999;
        position: fixed;
        bottom: 0;
    }

    .layui-table-box {
        margin-bottom: 30px;
    }

    .layui-table-cell {
        height: 30px;
        line-height: 20px;
        padding: 5px 10px;
        position: relative;
        font-size: 13px;
    }
</style>

<body>
    <div class="layui-btn-container controls" style="position: fixed;bottom: 0px;right: 8px;z-index: 9999;">
        <button type="button" class="layui-btn layui-bg-blue layui-btn-xs layui-btn-radius " id="export-file">&nbsp;&nbsp; 导出本页数据&nbsp;&nbsp;<i class="layui-icon layui-icon-download-circle layui-font-12"></i></button>
    </div>
    <table class="layui-hide" id="ID-table-demo-data" style="margin-top:100px;"></table>

    <!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
    <script src="../layui/layui.js"></script>
    <script src="../layui/TableFilter/tableFilter.js"></script>
    <script src="../js/jquery.js"></script>
    <script>
        // 方法 - 随机数生成
        // @parame min 随机数下限
        // @parame max 随机数上限
        function getRnd(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min
        }
        var date = new Date();
        var year = date.getFullYear(); // 获取当前小时数(0-23)
        var month = date.getMonth(); // 获取当前分钟数(0-59)
        var day = date.getDay(); // 获取当前秒数(0-59)
        var hour = date.getHours(); // 获取当前小时数(0-23)
        var min = date.getMinutes(); // 获取当前分钟数(0-59)
        var sec = date.getSeconds(); // 获取当前秒数(0-59)
        if (hour < 10) hour = "0" + hour;
        if (min < 10) min = "0" + min;
        if (sec < 10) sec = "0" + sec;
        <?php
        if ($_COOKIE['func'] == 'DataLog') {
            $filename = "mID_#" . $machines_arr[$index]['id'] . (($_COOKIE['func'] == "") ? "" : " - func_" . $_COOKIE['func']) . (($_COOKIE['type'] == "") ? "" : ' - type_' . $_COOKIE['type']) . (($_COOKIE['line'] == "") ? "" : ' - line_' . $_COOKIE['line']) . (($_COOKIE['model'] == "") ? "" : ' - model_' . $_COOKIE['model']) . (($_COOKIE['show']) ? "" : ' - show_' . $_COOKIE['show']);
        } else {
            $filename = "mID_#" . $machines_arr[$index]['id'] . (($_COOKIE['func'] == "") ? "" : " - func_" . $_COOKIE['func']) . (($_COOKIE['line'] == "") ? "" : ' - line_' . $_COOKIE['line']) . (($_COOKIE['model'] == "") ? "" : ' - model_' . $_COOKIE['model']) . (($_COOKIE['show']) ? "" : ' - show_' . $_COOKIE['show']);
        }
        ?>
        layui.use(['jquery', 'table', 'code', 'tableFilter'], function() {
            var table = layui.table;
            // 已知数据渲染
            var inst = table.render({
                elem: '#ID-table-demo-data',
                id: 'test',
                title: "<?php echo $filename ?>" + "_" + year + "_" + month + "_" + day + "__" + hour + "_" + min + "_" + sec + "_" + getRnd(1000, 9999) + '筛选导出的',
                toolbar: false,
                pagebar: true,
                even: true,
                height: 'full-0',
                defaultContextmenu: true, // 是否在 table 行中允许默认的右键菜单
                cellExpandedMode: 'tips',
                cellExpandedWidth: 180,
                cellMinWidth: 30,
                cellMaxWidth: 500,
                loading: true,
                scroll: {
                    x: '100%', // 设定表格宽度100%
                    y: '100%' // 设定表格高度400px
                },
                // lineStyle: 'border:1px solid #666;',
                cols: [ //标题栏
                    <?php
                    echo "[";
                    if ($dirname == 'ParameterLog' or $dirname == 'ErrorLog' or $dirname == 'EventLog' or $_COOKIE['model'] == "debuger" or $dirname == 'downtimelog' or $dirname = 'Stopline') {
                        for ($i = 0; $i < count($cols); $i++) {
                            echo "{";
                            echo "field:'", $data[0][$cols[$i]], "',";
                            echo "title:'", lang($data[0][$cols[$i]]), "',";
                            echo "minWidth:10,";
                            // echo "maxWidth:300,";
                            if ($i == 0) {
                                echo "width:170,";
                            }
                            // switch ($_COOKIE['func']) {
                            //     case 'ErrorLog':
                            //         switch ($i) {
                            //             case '0':
                            //                 echo "width:170,";
                            //                 break;
                            //             case '1':
                            //                 echo "width:110,";
                            //                 break;
                            //             case '2':
                            //                 echo "width:70,";
                            //                 break;
                            //             case '3':
                            //                 echo "width:330,";
                            //                 break;
                            //             case '4':
                            //                 echo "width:400,";
                            //                 break;
                            //             case '8':
                            //                 echo "width:150,";
                            //                 break;
                            //             default:
                            //                 echo "width:100,";
                            //                 break;
                            //         }
                            //         break;
                            //     case 'EventLog':
                            //         switch ($i) {
                            //             case '0':
                            //                 echo "width:170,";
                            //                 break;
                            //             case '1':
                            //                 echo "width:70,";
                            //                 break;
                            //             case '2':
                            //                 echo "width:130,";
                            //                 break;
                            //             case '3':
                            //                 echo "width:130,";
                            //                 break;
                            //             case '4':
                            //                 echo "width:120,";
                            //                 break;
                            //             case '5':
                            //                 echo "width:250,";
                            //                 break;
                            //             default:
                            //                 echo "width:200,";
                            //                 break;
                            //         }
                            //         break;
                            //     case 'MachineParameterLog':
                            //         switch ($i) {
                            //             case '0':
                            //                 echo "width:110,";
                            //                 break;
                            //             case '1':
                            //                 echo "width:100,";
                            //                 break;
                            //             case '2':
                            //                 echo "width:330,";
                            //                 break;
                            //             case '3':
                            //                 echo "width:80,";
                            //                 break;
                            //             case '4':
                            //                 echo "width:80,";
                            //                 break;
                            //             case '5':
                            //                 echo "width:150,";
                            //                 break;
                            //             case '10':
                            //                 echo "width:200,";
                            //                 break;
                            //             default:
                            //                 echo "width:100,";
                            //                 break;
                            //         }
                            //         break;
                            //     case 'ProductParameterLog':
                            //         switch ($i) {
                            //             case '0':
                            //                 echo "width:110,";
                            //                 break;
                            //             case '1':
                            //                 echo "width:100,";
                            //                 break;
                            //             case '2':
                            //                 echo "width:330,";
                            //                 break;
                            //             case '3':
                            //                 echo "width:330,";
                            //                 break;
                            //             case '4':
                            //                 echo "width:80,";
                            //                 break;
                            //             case '5':
                            //                 echo "width:80,";
                            //                 break;
                            //             case '6':
                            //                 echo "width:130,";
                            //                 break;
                            //             default:
                            //                 echo "width:100,";
                            //                 break;
                            //         }
                            //         break;
                            //     default:
                            //         echo "width:150,";
                            //         break;
                            // }
                            // echo "unresize:true,";
                            echo "expandedMode:'tips',";
                            if ($i < 2 and $_COOKIE['func'] != 'StartStopLog') {
                                echo "fixed:true,";
                            }
                            echo "sort:true,";
                            // if ($i == 0) {
                            //     echo "fixed: 'left',";
                            // } elseif ($i == (count($cols) - 1)) {
                            //     echo "fixed: 'right',";
                            // }
                            echo "},";
                        }
                    }
                    echo "]";
                    ?>
                ],
                data: [
                    <?php
                    $count_data = count($data);
                    for ($i = 1; $i < $count_data; $i++) {
                        echo "{";
                        // echo "'" . lang($data[$i][0]) . "',";
                        for ($k = 0; $k < count($cols); $k++) {
                            $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
                            $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
                            if ($data[0][$cols[1]] == "Start_Time") {
                                $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
                                $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
                            }
                            echo "'" . $data[0][$cols[$k]] . "':'" . lang($data[$i][$cols[$k]]) . "',";
                        }
                        echo "},";
                    }
                    ?>
                ],
                skin: 'line', // 表格风格
                even: true,
                page: true, // 是否显示分页
                limits: [50, 100, 200, 300, 500 <?php if ($count_data > 500) {
                                                    $count_data_t = ceil($count_data / 100) * 100;
                                                    echo "," . $count_data_t;
                                                }; ?>],
                limit: 200, // 每页默认显示的数量
                done: function() { //表格渲染完成的回调函数
                    var $ = jQuery;
                    var headertop = $(".layui-table-header").offset().top //获取表头到文档顶部的距离
                    $(window).scroll(function() { //开始监听滚动条                        
                        if (headertop - $(window).scrollTop() < 0) { //超过了                              
                            $(".layui-table-header").addClass('table-header-fixed') //添加样式，固定住表头
                        } else { //没超过
                            $(".layui-table-header").removeClass('table-header-fixed') //移除样式
                        }
                    });
                }
            });
            table.on('colToggled(ID-table-demo-data)', function(obj) {
                var col = obj.col; // 获取当前列属性配置项
                var options = obj.config; // 获取当前表格基础属性配置项
                console.log(obj); // 查看对象所有成员
                localtableFilterIns.reload();
            });

            const btnExport = document.querySelector("#export-file");
            const tableElement = document.querySelector(".htCore");
            btnExport.addEventListener("click", function() {
                table.exportFile('test')
            });

            //2、定义layui组件 得到 tableFilter 对象
            var $ = layui.jquery,
                table = layui.table,
                tableFilter = layui.tableFilter;
            var localtableFilterIns = tableFilter.render({
                'elem': '#localtable',
                'parent': '#LAY_APP_BODY',
                'mode': 'local',
                'filters': [
                    <?php
                    if ($dirname == 'ParameterLog' or $dirname == 'ErrorLog' or $dirname == 'EventLog' or $_COOKIE['model'] == "debuger" or $dirname == 'downtimelog' or $dirname = 'Stopline') {
                        for ($i = 0; $i < count($cols); $i++) {
                            echo "{";
                            echo "field:'", $data[0][$cols[$i]], "',";
                            echo "type:'checkbox'";
                            echo "},";
                        }
                    }
                    ?>
                ],
                'done': function(filters) {}
            })
        });
    </script>

</body>

</html>