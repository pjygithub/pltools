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
    <table>
        <tbody>
        <?php
            for ($i = 1; $i < count($data); $i++) {
                echo "<tr>";
                // echo "'" . lang($data[$i][0]) . "',";
                for ($k = 0; $k < count($cols); $k++) {
                    $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
                    $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
                    if ($data[0][$cols[1]] == "Start_Time") {
                        $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
                        $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
                    }
                    echo "<td>" . lang($data[$i][$cols[$k]]) . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>