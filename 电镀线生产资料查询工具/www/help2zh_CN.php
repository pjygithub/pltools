<?php
// 中文翻译
echo '<<中文翻译帮助>>：';
$tbheader = $tbheader;
// $data[0]
$all = array_merge($tbheader, $data[0]);
// 数组消重
$all = array_unique($all);
$all = array_values($all);
sort($all);
$debug_data = array();
$count_rows = array();
$debug_data[0] = $data[0];
array_push($count_rows, count($data[0]));
$debug_data[1] = $tbheader;
array_push($count_rows, count($tbheader));
$debug_data[2] = $all;
array_push($count_rows, count($all));
// 需要翻译的细节数据的列名
$heard = array('Description', 'Mode', 'Err Desc', 'ErrDesc', 'Mode', 'Remark', 'Remark2', 'Remark3', 'Remarks', 'Remarks2', 'Remarks3', "Event", "Pump", "Run", 'Down_Code', "Parameter", "L1 Status", "L2 Status", "Reason", "Reasons", "Reasons1", "Reasons2", "Reasons3", "Reason1", "Reason2", "Reason3", "Strand 1 Status", "Strand 2 Status", 'TankName', 'AlarmNoteEn');
$cols_ = array();
// 根据表头获取$data索引
$count_heard = count($heard);
for ($i = 0; $i < $count_heard; $i++) {
    $r = array_search($heard[$i], $data[0], true);
    if (is_int($r)) {
        array_push($cols_, $r);
    }
}
// echo '<pre>';
// print_r($cols_);
// 数组消重
$cols_ = array_unique($cols_);
$cols_ = array_values($cols_);
sort($cols_);
for ($j = 0; $j < count($cols_); $j++) {
    $count_row = count($data);
    $res = array();
    for ($i = 1; $i < $count_row; $i++) {
        if ($data[$i][$cols_[$j]] != '' or $data[$i][$cols_[$j]] != ' ') {
            array_push($res, $data[$i][$cols_[$j]]);
        }
    }
    // 数组消重
    $res = array_unique($res);
    $res = array_values($res);
    sort($res);
    $debug_data[$j + 3] = $res;
    array_push($count_rows, count($res));
}
// echo '<pre>';
// print_r($debug_data);
sort($count_rows);
?>
<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="../handsontable/handsontable.min.js"></script>
    <link rel="stylesheet" href="../handsontable/handsontable.full.min.css" />
    <script type="text/javascript" src="../handsontable/zh-CN.js"></script>
</head>

<body>
    <div id="debugTab"></div>
    <button id="debug_export-file">保存本页数据</button>
    <script>
        const debug_container = document.querySelector('#debugTab');
        const debug_button = document.querySelector('#debug_export-file');
        const debug_data = [
            <?php
            $debug_data_count = count($debug_data);

            echo "[";
            echo "'// 按分类-原始表头，" . count($debug_data[0]) . "',''";
            echo ",'// 按表头-使用中的表头，" . count($debug_data[1]) . "',''";
            echo  ",'// 全部-混合排序，" . count($debug_data[2]) . "',''";
            for ($i = 3; $i < $debug_data_count; $i++) {
                echo ",'计数：" . count($debug_data[$i]) . "个',' '";
            }
            echo "],\n";

            echo "[";
            echo "'// " . $dirname . "',''";
            echo ",'// " . $dirname . "',''";
            echo  ",'// " . $dirname . "',''";
            for ($i = 3; $i < $count; $i++) {
                echo ",'// " . $dirname . "',''";
            }
            echo "],\n";

            for ($i = 0; $i < $count_rows[count($count_rows) - 1]; $i++) {
                echo "[";
                if ($debug_data[0][$i] != '') {
                    echo "'\"" . $debug_data[0][$i] . "\"','=>\"\",'";
                } else {
                    echo "'',''";
                }
                if ($debug_data[1][$i] != '') {
                    echo ",'\"" . $debug_data[1][$i] . "\"','=>\"\",'";
                } else {
                    echo ",'',''";
                }
                if ($debug_data[2][$i] != '') {
                    echo ",'\"" . $debug_data[2][$i] . "\"','=>\"\",'";
                } else {
                    echo ",'',''";
                }
                for ($j = 3; $j < $debug_data_count; $j++) {
                    if ($debug_data[$j][$i] != '') {
                        echo ",'\"" . $debug_data[$j][$i] . "\"','=>\"\",'";
                    } else {
                        echo ",'',''";
                    }
                }
                echo "],\n";
            }
            ?>
        ];
        const debug_colHeader = [
            <?php
            echo "'// 按分类-原始表头，" . count($debug_data[0]) . "',' '";
            echo ",'// 按表头-使用中的表头，" . count($debug_data[1]) . "',' '";
            echo  ",'// 全部-混合排序，" . count($debug_data[2]) . "',' '";
            for ($i = 3; $i < $debug_data_count; $i++) {
                echo ",'计数：" . count($debug_data[$i]) . "个',' '";
            }
            ?>
        ];
        // 方法 - 随机数生成
        // @parame min 随机数下限
        // @parame max 随机数上限
        function getRnd(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min
        }

        function colorRowRenderer_1(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#fdf5de';
        }

        function colorRowRenderer_2(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#e7f3e7';
        }

        function colorRowRenderer_3(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#f1e2e3';
        }

        function colorRowRenderer_4(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#FDE6E0';
        }

        function colorRowRenderer_5(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#DCE2f1';
        }

        function colorRowRenderer_6(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#e9ebfe';
        }

        function colorRowRenderer_7(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#fbcafb';
        }

        function colorRowRenderer_8(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#caf9d2';
        }

        function colorRowRenderer_9(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.background = '#e8e8ad';
        }
        const debug_hot = new Handsontable(debug_container, {
            language: 'zh-CN',
            locale: 'zh-CN',
            data: debug_data,
            rowHeaders: false,
            colHeaders: debug_colHeader,
            columnSorting: true,
            filters: true,
            height: 'auto',
            width: '100%',
            height: '92vh',
            manualColumnMove: false, //移动列
            //右键可用，默认为undefined
            // contextMenu: true,
            contextMenu: ['---------', 'remove_row', 'clear_column', 'undo', 'redo', 'copy'],
            manualColumnResize: true, //手动列宽
            dropdownMenu: true, //上下文菜单
            // fixedRowsTop: 0, //行冻结
            // fixedColumnsStart: 0,
            rowHeights: 5,
            autoRowSize: true,
            autoWrapRow: true,
            // cells(row, col) {
            //     const cellProperties = {};
            //     switch (row % 10) {
            //         case 1:
            //             cellProperties.renderer = colorRowRenderer_1; 
            //             break;
            //         case 2:
            //             cellProperties.renderer = colorRowRenderer_2;
            //             break;
            //         case 3:
            //             cellProperties.renderer = colorRowRenderer_3;
            //             break;
            //         case 4:
            //             cellProperties.renderer = colorRowRenderer_4;
            //             break;
            //         case 5:
            //             cellProperties.renderer = colorRowRenderer_5;
            //             break;
            //         case 6:
            //             cellProperties.renderer = colorRowRenderer_6;
            //             break;
            //         case 7:
            //             cellProperties.renderer = colorRowRenderer_7;
            //             break;
            //         case 8:
            //             cellProperties.renderer = colorRowRenderer_8;
            //             break;
            //         case 9:
            //             cellProperties.renderer = colorRowRenderer_9;
            //             break;
            //         default:
            //             break;
            //     }
            //     return cellProperties;
            // },
            licenseKey: 'non-commercial-and-evaluation', // for non-commercial use only
            // colWidths: [130, 50, 160, 160, 130, 550, 80],
            autoColumnSize: true,
        });
        var date = new Date();
        var hour = date.getHours(); // 获取当前小时数(0-23)
        var min = date.getMinutes(); // 获取当前分钟数(0-59)
        var sec = date.getSeconds(); // 获取当前秒数(0-59)
        if (hour < 10) hour = "0" + hour;
        if (min < 10) min = "0" + min;
        if (sec < 10) sec = "0" + sec;
        const debug_exportPlugin = debug_hot.getPlugin('exportFile');
        debug_button.addEventListener('click', () => {
            debug_exportPlugin.downloadFile('csv', {
                bom: true,
                columnDelimiter: ',',
                columnHeaders: debug_colHeader,
                exportHiddenColumns: true,
                exportHiddenRows: true,
                fileExtension: 'csv',
                filename: '<?php echo "#" . $machines_arr[$index]['id'] . "_" . $dirname; ?>_在[YYYY]-[MM]-[DD]__' + hour + "_" + min + "_" + sec + "_" + getRnd(1000, 9999) + '_Debuger_？_©powerByHandsontable©',
                mimeType: 'text/csv',
                rowDelimiter: '\r\n',
                rowHeaders: false,
            });
        });
    </script>
    <?php
    die;
    ?>
</body>

</html>