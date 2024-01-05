<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="handsontable_v6/handsontable.full.js"></script>
    <link rel="stylesheet" href="handsontable_v6/handsontable.full.css" />
    <script type="text/javascript" src="handsontable_v6/languages/zh-CN.js"></script>
</head>
<?
if (isset($_COOKIE['model']) and $_COOKIE['model'] == 'zh_help') {
    include(dirname(__DIR__) . '\help2zh_CN.php');
}
if (empty($tbheader)) {
    echo "<script>
    layui.use('layer', function() {
        var layer = layui.layer;
        layer.msg('没有需要展示的数据！请重新筛选。', {
            icon: 8,
            skin: 'layui-layer-lan',
            closeBtn: 0,
            anim: 6
        });
    });
    </script>";
    die;
}
// include(dirname(__DIR__) . '/common_config.php');
// 按需加载
// if ($usezh_cn == 1) {
//     if (isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'en') {
//         include(dirname(__DIR__) . '/www/language/lang.en.php');
//     } else {
//         include(dirname(__DIR__) . '/www/language/lang.zh_CN.php');
//     }
// } else {
//     if (isset($_COOKIE['lang']) and $_COOKIE['lang'] == 'zh') {
//         include(dirname(__DIR__) . '/www/language/lang.zh_CN.php');
//     } else {
//         include(dirname(__DIR__) . '/www/language/lang.en.php');
//     }
// }
if ($_COOKIE['type'] == "DIY" and $_COOKIE['func'] == "DataLog") {
    $marginTop = "40px";
} else {
    $marginTop = "5px";
}
?>
<style>
    .layui-btn-container .layui-btn {
        margin: 0;
    }

    #mainTab {
        margin-bottom: 22px;
        margin-top: <?php echo $marginTop ?>;
    }
</style>


<body>
    <div id="mainTab"></div>
    <div class="layui-btn-container controls" style="position: fixed;bottom: 0px;left: 8px;z-index: 999;">
        <button type="button" class="layui-btn layui-bg-blue layui-btn-xs layui-btn-radius " id="export-file">&nbsp;&nbsp; 导出本页数据&nbsp;&nbsp;<i class="layui-icon layui-icon-download-circle layui-font-12"></i></button>
    </div>
    <script>
        const container = document.querySelector('#mainTab');
        const button = document.querySelector('#export-file');
        const data = [
            <?php
            $count_data = count($data);
            $count_cols = count($cols);
            for ($i = 1; $i < $count_data; $i++) {
                echo "[";
                // echo "'" . lang($data[$i][0]) . "',";
                for ($k = 0; $k < $count_cols; $k++) {
                    $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
                    $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
                    if ($data[0][$cols[1]] == "Start_Time") {
                        $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
                        $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
                    }
                    if ($k == ($count_cols - 1)) {
                        echo "'" . lang($data[$i][$cols[$k]]) . "'";
                    } else {
                        echo "'" . lang($data[$i][$cols[$k]]) . "',";
                    }
                }
                if ($i == ($count_data - 1)) {
                    echo "]";;
                } else {
                    echo "],\n";;
                }
            }
            ?>
        ];
        const colHeader = [
            <?php
            // if (count(explode(' ', $data[1][0])) > 2 or count(explode('-', $data[1][0])) >= 3 or count(explode('/', $data[1][0])) >= 3) {
            //     echo "'日期 时间',";
            // } elseif (count(explode('/', $data[1][0])) == 3 or count(explode('-', $data[1][0])) == 3) {
            //     echo "'日期',";
            // } elseif ($dirname == 'downtimelog') {
            //     echo "'？？？',";
            // } else {
            //     echo "'时间',";
            // }
            // $t = "";
            if ($dirname == 'ParameterLog' or $dirname == 'ErrorLog' or $dirname == 'EventLog' or $_COOKIE['model'] == "debuger" or $dirname == 'downtimelog' or $dirname = 'Stopline') {
                for ($i = 0; $i < $count_cols; $i++) {
                    if ($i == ($count_cols - 1)) {
                        echo "'" . lang($data[0][$cols[$i]]) . "'";
                    } else {
                        echo "'" . lang($data[0][$cols[$i]]) . "',";
                    }
                }
            } else {
                for ($i = 0; $i < $count_cols; $i++) {
                    if (isset($data[1][$cols[$i]]) and $data[1][$cols[$i]] != "") {
                        if ($i == ($count_cols - 1)) {
                            echo "'" . lang($data[0][$cols[$i]]) . "'";
                        } else {
                            echo "'" . lang($data[0][$cols[$i]]) . "',";
                        }
                    }
                }
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
            // console.log(parseFloat(value, 10));
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#fdf5de';
        }

        function colorRowRenderer_2(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#e7f3e7';
        }

        function colorRowRenderer_3(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#f1e2e3';
        }

        function colorRowRenderer_4(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#FDE6E0';
        }

        function colorRowRenderer_5(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#DCE2f1';
        }

        function colorRowRenderer_6(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#e9ebfe';
        }

        function colorRowRenderer_7(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#fbcafb';
        }

        function colorRowRenderer_8(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#caf9d2';
        }

        function colorRowRenderer_9(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#e8e8ad';
        }

        function colorRowRenderer_0(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            if (value == '0.000000') {
                td.style.color = '#a2a2a2';
            }
            td.style.background = '#FFFFFF';
        }

        const hot = new Handsontable(container, {
            language: 'zh-CN',
            locale: 'zh-CN',
            data: data,
            rowHeaders: false,
            colHeaders: colHeader,
            filters: true,
            columnSorting: true, // 排序
            dropdownMenu: true, //上下文菜单
            contextMenu: ['---------', 'remove_row', 'clear_column', 'undo', 'redo', 'copy'], //右键可用
            // width: 100,
            // height: 200,
            // colWidths: 100,
            rowHeights: 13,
            fixedRowsTop: 0,
            fixedColumnsLeft: 2,
            fixedRowsBottom: 1,
            manualColumnFreeze: true,
            manualColumnMove: false, //移动列
            manualColumnResize: true, //手动列宽
            // stretchH: 'all',

            // dropdownMenu: true,
            // fixedRowsTop: 0, //行冻结
            // fixedColumnsStart: 2,
            // fixedColumnsLeft: 2,
            // rowHeights: 5,
            // renderAllRows: true,
            // autoRowSize: false,
            // autoWrapRow: true,
            // autoRowSize: false,
            cells(row, col) {
                const cellProperties = {};

                switch (row % 10) {
                    case 1:
                        cellProperties.renderer = colorRowRenderer_1; // uses function directly
                        break;
                    case 2:
                        cellProperties.renderer = colorRowRenderer_2;
                        break;
                    case 3:
                        cellProperties.renderer = colorRowRenderer_3;
                        break;
                    case 4:
                        cellProperties.renderer = colorRowRenderer_4;
                        break;
                    case 5:
                        cellProperties.renderer = colorRowRenderer_5;
                        break;
                    case 6:
                        cellProperties.renderer = colorRowRenderer_6;
                        break;
                    case 7:
                        cellProperties.renderer = colorRowRenderer_7;
                        break;
                    case 8:
                        cellProperties.renderer = colorRowRenderer_8;
                        break;
                    case 9:
                        cellProperties.renderer = colorRowRenderer_9;
                        break;
                    default:
                        cellProperties.renderer = colorRowRenderer_0;
                        break;
                }
                return cellProperties;
            },
            currentRowClassName: 'currentRow',
            currentColClassName: 'currentCol',
            //扩展最后一列，其他列的宽度是47
            // stretchH: 'last',
            //把table的宽度设为容器的宽度，列平分宽度
            // stretchH: 'all',
            //默认值
            // stretchH: 'none',
            <?php
            if ($dirname == "EventLog") {
                echo "colWidths: [130,50,150,150,130,500,80],";
            } else {
                echo "autoColumnSize: true,";
            }
            ?>

        });
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
        const exportPlugin = hot.getPlugin('exportFile');
        <?php
        $filename = "tb_";
        (isset($machines_arr[$index]['id']) and $machines_arr[$index]['id'] != "") ? $filename .= "机台号#" . $machines_arr[$index]['id'] : "";
        (isset($_COOKIE['func']) and $_COOKIE['func'] != "") ? $filename .= " - 查询类型1_" . $_COOKIE['func'] : "";
        if ($_COOKIE['func'] == 'DataLog') {
            (isset($_COOKIE['type']) and $_COOKIE['type'] != "") ? $filename .= " - 查询类型2_" . $_COOKIE['type'] : "";
        }
        (isset($_COOKIE['line']) and $_COOKIE['line'] != "") ? $filename .= " - 线体_" . $_COOKIE['line'] : "";
        (isset($_COOKIE['model']) and $_COOKIE['model'] != "") ? $filename .= " - 模块_" . $_COOKIE['model'] : "";
        (isset($_COOKIE['lang']) and $_COOKIE['lang'] != "") ? $filename .= " - 语言_" . $_COOKIE['lang'] : "";
        (isset($_COOKIE['show']) and $_COOKIE['show'] != "") ? $filename .= " - 显示_" . $_COOKIE['show'] : "";
        ?>
        // button.addEventListener('click', () => {
        //     exportPlugin.downloadFile('csv', {
        //         bom: true,
        //         columnDelimiter: ',',
        //         columnHeaders: colHeader,
        //         exportHiddenColumns: true,
        //         exportHiddenRows: true,
        //         fileExtension: 'csv',
        //         filename: '<?php echo $filename ?>@[YYYY]-[MM]-[DD]__' + hour + "_" + min + "_" + sec + "_" + getRnd(1000, 9999) + '筛选导出的_©powerByHandsontable©',
        //         mimeType: 'text/csv',
        //         rowDelimiter: '\r\n',
        //         rowHeaders: false,
        //     });
        // });
    </script>
    <script>
        // class csvExport {
        //     constructor(table, header = true) {
        //         this.table = table;
        //         this.rows = Array.from(table.querySelectorAll("tr"));
        //         if (!header && this.rows[0].querySelectorAll("th").length) {
        //             this.rows.shift();
        //         }
        //         // console.log(this.rows);
        //         // console.log(this._longestRow());
        //     }

        //     exportCsv() {
        //         const lines = [];
        //         const ncols = this._longestRow();
        //         for (const row of this.rows) {
        //             let line = "";
        //             for (let i = 0; i < ncols; i++) {
        //                 if (row.children[i] !== undefined) {
        //                     line += csvExport.safeData(row.children[i]);
        //                 }
        //                 line += i !== ncols - 1 ? "," : "";
        //             }
        //             lines.push(line);
        //         }
        //         //console.log(lines);
        //         return lines.join("\n");
        //     }
        //     _longestRow() {
        //         return this.rows.reduce((length, row) => (row.childElementCount > length ? row.childElementCount : length), 0);
        //     }
        //     static safeData(td) {
        //         let data = td.textContent;
        //         //Replace all double quote to two double quotes
        //         data = data.replace(/"/g, `""`);
        //         //Replace , and \n to double quotes
        //         data = /[",\n"]/.test(data) ? `"${data}"` : data;
        //         return data;
        //     }
        // }

        const btnExport = document.querySelector("#export-file");
        const tableElement = document.querySelector(".htCore");

        btnExport.addEventListener("click", () => {
            const count_d = data.length;
            var csvData = "";
            for (let i = 0; i < colHeader.length; i++) {
                const e = colHeader[i];
                if (i < (colHeader.length - 1)) {
                    csvData += "" + e + ","
                } else {
                    csvData += "" + e + ""
                }
            }
            csvData += "\n";
            for (let i = 0; i < count_d; i++) {
                const a = data[i];
                for (let j = 0; j < a.length; j++) {
                    const e = a[j];
                    if (j < (a.length - 1)) {
                        csvData += "" + e + ","
                    } else {
                        csvData += "" + e + ""
                    }
                }
                if (i < (count_d - 1)) {
                    csvData += "\n";
                }
            }
            var blob = new Blob([csvData], {
                type: "text/plain;charset=utf-8"
                //type: 'application/octet-binary'
            });
            //解决中文乱码问题
            blob = new Blob([String.fromCharCode(0xFEFF), blob], {
                type: blob.type
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "<?php echo $filename ?>" + "_" + year + "_" + month + "_" + day + "__" + hour + "_" + min + "_" + sec + "_" + getRnd(1000, 9999) + '筛选导出的.csv';
            a.click();
            setTimeout(() => {
                URL.revokeObjectURL(url);
            }, 500);
        });
    </script>
    <style>
        td {
            font-size: 13px;
        }
    </style>
</body>


</html>