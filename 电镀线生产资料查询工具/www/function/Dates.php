<?

function Dates($format)
{
    // 机台号预处理
    include(dirname(__DIR__) . '/function/using_machine.php');
    // 验证cookie中的时间是否存在
    (empty($_COOKIE['date_start']) or $_COOKIE['date_start'] == "NaN") && $_COOKIE['date_start'] = time();
    (empty($_COOKIE['date_end']) or $_COOKIE['date_end'] == "NaN") && $_COOKIE['date_end'] = time();
    // 计算时间差=>天数，用于循环
    $DayNum = intval(($_COOKIE['date_end'] - $_COOKIE['date_start']) / 86400) + 1;
    $Dates = array();
    for ($i = 0; $i < $DayNum; $i++) {
        $r1 = date($format, ($_COOKIE['date_start']) + 86400 * $i);
        $r2 = explode('-', $r1);
        $count_r2 = count($r2);
        $r = '';
        if ($machines_arr[$index]['type'] == "RSA") {
            foreach ($r2 as $key => $val) {
                $r .= $val;
            }
        } else {
            switch ($count_r2) {
                case 1:
                    $r = "Y" . $r2[0];
                    break;
                case 2:
                    $r = "Y" . $r2[0] . "M" . $r2[1];
                    break;
                case 3:
                    $r = "Y" . $r2[0] . "M" . $r2[1] . "D" . $r2[2];
                    break;
                default:
                    $r = "";
                    break;
            }
        }
        array_push($Dates, $r);
    }
    // 例外处理，确保同一天也有数据
    if (empty($Dates)) {
        $r1 = date($format, time());
        $r2 = explode('-', $r1);
        $count_r2 = count($r2);
        $r = '';
        if ($machines_arr[$index]['type'] == "RSA") {
            foreach ($r2 as $val) {
                $r .= $val;
            }
        } else {
            switch ($count_r2) {
                case 1:
                    $r = "Y" . $r2[0];
                    break;
                case 2:
                    $r = "Y" . $r2[0] . "M" . $r2[1];
                    break;
                case 3:
                    $r = "Y" . $r2[0] . "M" . $r2[1] . "D" . $r2[2];
                    break;
                default:
                    $r = "";
                    break;
            }
        }
        array_push($Dates, $r);
    }
    // 去重复
    $Dates = array_unique($Dates);
    $Dates = array_values($Dates);
    $Dates = array_filter($Dates);
    return $Dates;
}
