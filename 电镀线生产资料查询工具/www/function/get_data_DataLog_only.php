<link rel="stylesheet" href="layui/css/layui.css">
<script src="layui/layui.js"></script>
<script src="layui/layer/layer.js"></script>
<?
function redot($lines_j, $re, $re_b, $re_e)
{
    $str = $lines_j;
    preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
    // Print the entire match result
    $count_mact = count($matches);
    for ($m = 0; $m < $count_mact; $m++) {
        $tem_ = str_replace($re_b, $re_e, $matches[$m][0]);
        $lines_j = str_replace($matches[$m][0], $tem_, $lines_j);
    }
    return $lines_j;
}
function get_data_lines($Dates, $dirname, $format_normal, $format_rsa)
{
    // 机台号预处理
    include(dirname(__DIR__) . '/function/using_machine.php');
    // 记录行
    $data_lines = array();
    $count_Dates = count($Dates);
    for ($i = 0; $i < $count_Dates; $i++) {
        // 自动判断用域名还是用IP
        try {
            if (url_exist('http://' . $machines_arr[$index]['host'] . '/')) {
                $url = 'http://' . $machines_arr[$index]['host'] . '/' . $dirname . '/' . $Dates[$i] . $format_normal . '.csv';
                if ($machines_arr[$index]['type'] == "RSA") {
                    $url = "http://" . $machines_arr[$index]['host'] . "/" . $dirname . "/" . $format_rsa . $Dates[$i] . ".csv";
                }
            } else {
                throw new Exception('IP无法访问！');
            }
        } catch (\Throwable $th) {
            try {
                if (url_exist('http://' . $machines_arr[$index]['ip'] . '/')) {
                    $url = 'http://' . $machines_arr[$index]['ip'] . '/' . $dirname . '/' . $Dates[$i] . $format_normal . '.csv';
                    if ($machines_arr[$index]['type'] == "RSA") {
                        $url = "http://" . $machines_arr[$index]['ip'] . "/" . $dirname . "/" . $format_rsa . $Dates[$i] . ".csv";
                    }
                } else {
                    throw new Exception('访问失败！');
                }
            } catch (\Throwable $th) {
                $err = $th->getMessage();
                echo "<script>
                layui.use('layer', function(){
                    var layer = layui.layer;
                    layer.alert('出现错误：<span style=\'font-weight:600;\'>域名: " . $machines_arr[$index]['host'] . " </span> / <span style=\'font-weight:600;\'>IP: " . $machines_arr[$index]['ip'] . "</span><span style=\'font-weight:600;color:red;\'> " . $err . "</span> → 该机台似乎<span style=\'font-weight:600;color:red;\'>无法连接</span>！<br> Error: domain name: " . $machines_arr[$index]['host'] . " / IP: " . $machines_arr[$index]['ip'] . " cannot be accessed → the machine cannot be connected!', {
                        icon: 5
                        ,skin: 'layui-layer-lan'
                        ,closeBtn: 0
                        ,anim: 6
                    });
                });
                </script>";
                exit;
            }
        }
        // var_dump($url);
        // 判断是否存在，节约时间
        try {
            if (url_exist($url)) {
                $contents = file_get_contents($url);
            } else {
                throw new Exception('该日期似乎没有相应的文件！');
            }
        } catch (\Throwable $th) {
            continue;
        }
        // echo '<pre>';
        // print_r($contents);
        // 数据流预处理 => 行的数组
        if (isset($contents) and strlen($contents) > 0 and $contents != "" and $contents != null) {
            $lines = explode("\r\n", $contents);
            $count_lines = count($lines);
            $count_lines = 1;
            for ($j = 0; $j < $count_lines; $j++) {
                $lines_j = $lines[$j];
                $lines_j = str_replace('"', '', $lines_j);
                $lines_j = str_replace("'", '', $lines_j);
                $lines_j = preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', trim($lines_j));
                // 档案名称输入包含空格导致识别错误
                $re = '/[0-9a-zA-Z-]{4,5}[-][0-9a-zA-Z-]{13,18}[( （][a-zA-Z0-9-]{0,}[,][a-zA-Z0-9-]{0,}[)）].txt/m';
                $lines_j = redot($lines_j, $re, ',', ' ');
                // 开关机事件报错引用文件File
                $re = '/File[,]{0,1}[0-9a-zA-Z-]{4,5}[-][0-9a-zA-Z-]{13,18}[( （][a-zA-Z0-9-]{0,}[a-zA-Z0-9]{0,}[)）].txt/m';
                $lines_j = redot($lines_j, $re, ',', ' ');
                // IO (1,2,3)
                $re = '/IO[ ]{0,}[(][0-9A-Za-z]{0,}[,][0-9A-Za-z]{0,}[,]{0,}[0-9a-zA-Z]{0,}[,]{0,}[0-9a-zA-Z]+[)]/m';
                $lines_j = redot($lines_j, $re, ',', '，');
                // 处理csv由于错误使用半角逗号造成的识别错误
                $re = '/([LS][0-9-]+)([,])([0-9])( )(([0-9a-zA-Z()-]{0,}[ ][0-9a-zA-Z()-]{0,}){0,})/m';
                $lines_j = redot($lines_j, $re, ',', '&');
                // [L3,4]
                $re = '/[[][0-9A-Za-z]{0,}[,]{0,}[0-9A-Za-z]{0,}[,]{0,}[0-9A-Za-z]{0,}[,]{0,}[0-9A-Za-z]{0,}]/m';
                $lines_j = redot($lines_j, $re, ',', '&');
                // Diagnostic Digital Output
                $re = '/IO:[0-9A-Za-z- )(:&]{0,}[,][0-9A-Za-z- :)(&]{0,}[)]/m';
                $lines_j = redot($lines_j, $re, ',', '，');
                // IO:
                $re = '/IO:[0-9A-Za-z &#_]{0,}[,][0-9A-Za-z &#_]{0,}/m';
                $lines_j = redot($lines_j, $re, ',', '，');
                if ($j != 0 and $lines_j != "" and $lines_j != " " and strlen($lines_j) > 0 and $machines_arr[$index]['type'] != "RSA" and $dirname != 'ErrorLog' and $dirname != 'EventLog' and $dirname != 'ParameterLog/Machine' and $dirname != 'ParameterLog/Product') {
                    array_push($data_lines, substr($Dates[$i], 1, 4) . '/' . substr($Dates[$i], 6, 2) . '/' . substr($Dates[$i], 9, 2) . ' ' . $lines_j);
                } else {
                    array_push($data_lines,  $lines_j);
                }
            }
        }
    }
    unset($contents);
    unset($lines);

    // 零数据判断
    if (empty($data_lines)) {
        echo "<script>layui.use('layer', function(){
            var layer = layui.layer;
            layer.alert('出现错误：该机台似乎没有相应<span style=\'color:red;font-weight:700;\'>日期范围</span>的数据。请尝试修改时间范围！<br> Error: There is NO DATA for this machine. Please try modifying the DATE!', {
                icon: 7
                ,skin: 'layui-layer-lan'
                ,closeBtn: 0
                ,anim: 6
            });
        });
            </script>";
        die;
    }
    $data_lines = array_unique($data_lines); // 删除重复
    $data_lines = array_values($data_lines); // 重新编号
    $data_lines = array_filter($data_lines);
    // echo '<pre>';
    // print_r($data_lines);
    // die;
    if ($_COOKIE['func'] == 'DataLog') {
        $table_hear = $data_lines[0];
    } elseif ($_COOKIE['func'] == 'ErrorLog') {
        $table_hear = $data_lines[0] . ",Remarks2,Remarks3";
        $data_lines_ = array_reverse($data_lines); //反置
        $data_lines = array();
        array_push($data_lines, $table_hear);
        for ($i = 0; $i < count($data_lines_) - 1; $i++) {
            array_push($data_lines, $data_lines_[$i]);
        }
    } elseif ($_COOKIE['func'] == 'EventLog') {
        $table_hear = $data_lines[0] . ",Code,Other";
        $data_lines_ = array_reverse($data_lines); //反置
        $data_lines = array();
        array_push($data_lines, $table_hear);
        for ($i = 0; $i < count($data_lines_) - 1; $i++) {
            array_push($data_lines, $data_lines_[$i]);
        }
    } elseif ($_COOKIE['func'] == 'StartStopLog') {
        $table_hear = "Time,Event";
        $data_lines_ = array_reverse($data_lines); //反置
        $data_lines = array();
        array_push($data_lines, $table_hear);
        for ($i = 0; $i < count($data_lines_) - 1; $i++) {
            array_push($data_lines, $data_lines_[$i]);
        }
    } elseif ($_COOKIE['func'] == 'downtimelog' or $_COOKIE['func'] == 'MachineParameterLog' or $_COOKIE['func'] == 'ProductParameterLog') {
        $table_hear = $data_lines[0];
        $data_lines_ = array_reverse($data_lines); //反置
        $data_lines = array();
        array_push($data_lines, $table_hear);
        for ($i = 0; $i < count($data_lines_) - 1; $i++) {
            array_push($data_lines, $data_lines_[$i]);
        }
    }
    // echo '<pre>';
    // print_r($_COOKIE['func'] . '<br>');
    // print_r($data_lines);
    //表头去重
    if (isset($data_lines[0]) and strlen($data_lines[0]) > 0 and $data_lines[0] != "") {
        $count_data_lines = count($data_lines);
        for ($j = 1; $j < $count_data_lines; $j++) {
            if ($data_lines[$j] == $data_lines[0]) {
                unset($data_lines[$j]);
            }
            if ($data_lines[$j] == "") {
                unset($data_lines[$j]);
            }
        }
    }
    $data_lines = array_values($data_lines); // 重新编号
    $data = array();
    $count_data_lines = count($data_lines);
    for ($i = 0; $i < $count_data_lines; $i++) {
        if (isset($data_lines[$i]) and strlen($data_lines[$i]) > 0 and $data_lines[$i] != "") {
            $row = explode(",", $data_lines[$i]);
            array_push($data, $row);
        }
    }
    unset($data_lines);
    // echo '<pre>';
    // print_r($data);
    return $data;
}
