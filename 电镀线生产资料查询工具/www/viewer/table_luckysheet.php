<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='../Luckysheet_v2.1.13/plugins/css/pluginsCss.css' />
    <link rel='stylesheet' href='../Luckysheet_v2.1.13/plugins/plugins.css' />
    <link rel='stylesheet' href='../Luckysheet_v2.1.13/css/luckysheet.css' />
    <link rel='stylesheet' href='../Luckysheet_v2.1.13/assets/iconfont/iconfont.css' />
    <script src="../Luckysheet_v2.1.13/plugins/js/plugin.js"></script>
    <script src="../Luckysheet_v2.1.13/luckysheet.umd.js"></script>

</head>
<pre>
<?php
// var_dump($data);
?>

</pre>

<body>
    <div id="luckysheet" style="margin:0px;padding:0px;position:absolute;width:100%;height:100%;left: 0px;top: 0px;"></div>

</body>
<script>
    $(function() {
        //配置项
        var options = {
            container: 'luckysheet', //luckysheet为容器id
            title: 'Luckysheet Demo', // 设定表格名称
            lang: 'zh', // 设定表格语言
            data: [{
                "name": "Cell", //工作表名称
                "color": "", //工作表颜色
                "index": 0, //工作表索引
                "status": 1, //激活状态
                "order": 0, //工作表的下标
                "hide": 0, //是否隐藏
                // "row": 36, //行数
                // "column": 18, //列数
                "defaultRowHeight": 19, //自定义行高
                "defaultColWidth": 73, //自定义列宽
                "celldata": [ //初始化使用的单元格数据
                    <?php
for ($i = 1; $i < count($data); $i++) {
    // echo '[';
    // echo ''' . lang($data[$i][0]) . '',';
    for ($k = 0; $k < count($cols); $k++) {
        $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
        $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
        if ($data[0][$cols[1]] == 'Start_Time') {
            $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
            $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
        }
        echo '{r:'.$i.',c:' . $k . ',v:{m:"' . lang($data[$i][$cols[$k]]) . '",v:"' . lang($data[$i][$cols[$k]]) . '",ct: {fa: "General", t: "g"}}},
        ';
    }
    // echo '],\n';
}
$data = array();
// die;
?>
                ],
                "config": {
                    "merge": {}, //合并单元格
                    "rowlen": {}, //表格行高
                    "columnlen": {}, //表格列宽
                    "rowhidden": {}, //隐藏行
                    "colhidden": {}, //隐藏列
                    "borderInfo": {}, //边框
                    "authority": {}, //工作表保护

                },
                "scrollLeft": 0, //左右滚动条位置
                "scrollTop": 0, //上下滚动条位置
                "luckysheet_select_save": [], //选中的区域
                "calcChain": [], //公式链
                "isPivotTable": false, //是否数据透视表
                "pivotTable": {}, //数据透视表设置
                "filter_select": {}, //筛选范围
                "filter": null, //筛选配置
                "luckysheet_alternateformat_save": [], //交替颜色
                "luckysheet_alternateformat_save_modelCustom": [], //自定义交替颜色	
                "luckysheet_conditionformat_save": {}, //条件格式
                "frozen": {}, //冻结行列配置
                "chart": [], //图表配置
                "zoomRatio": 1, // 缩放比例
                "image": [], //图片
                "showGridLines": 1, //是否显示网格线
                "dataVerification": {} //数据验证配置
            }]
        }
        luckysheet.create(options)
    })
</script>

</html>