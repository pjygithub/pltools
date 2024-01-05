<?php
// 设置请求头和时区
ini_set('user_agent', 'Linux W-Get Monitor2 index.php set');
ini_set('date.timezone', 'Asia/Shanghai');
// 跳过证书验证
stream_context_set_default([
    'ssl' => [
        'verify_host' => false,
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);
function url_exist($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
    if (curl_exec($ch) !== FALSE) {
        return true;
    } else {
        return false;
    }
}
function toUrldecode($str)
{
    $r = $str;
    $arr = array(
        '#' => '%23',
        '%' => '%25',
        '&' => '%26',
        '+' => '%2B',
        '/' => '%2F',
        '\\' => '%5C',
        '=' => '%3D',
        '?' => '%3F',
        ' ' => '%20',
        '.' => '%2E',
        ':' => '%3A',
        '!' => '%21',
        '*' => '%2A',
        '"' => '%22',
        "'" => "%27",
        '(' => '%28',
        ')' => '%29',
        ';' => '%3B',
        '@' => '%40',
        '&' => '%26',
        ',' => '%2C',
        '?' => '%3F',
        '[' => '%5B',
        ']' => '%5D',
        '<' => '%3C',
        '>' => '%3E',
        '~' => '%7E',
        '`' => '%60',
        '$' => '%24',
        '^' => '%5E',
        // '-' => '',
        // '_' => '',
        '{' => '%7B',
        '}' => '%7D',
        '|' => '%7C'
    );
    foreach ($arr as $key => $value) {
        $r = str_replace($key, $value, $r);
    }
    return $r;
}
// 状态显示访问用户资料
// $status_name = 'aam-intl\p02public2';
$status_name = "aam-intl\p02public";
$status_name = toUrldecode($status_name);
$status_password = "P02369258147";
$status_password = toUrldecode($status_password);
$status_url = "amcnts19.amcex.asmpt.com/PltLinestate/ViewState.aspx";
$echartShowTime = 450;
$ebotime10 = 2.5;
$ebotime12 = 6;
$ebotime31 = 2.5;
$ebotime38 = 6;
$ebotimeRSA = 6;
$ebotimeOther = 6;
$titleSort = 0; //筛选项排序，2为升排序，1为降排序，0为不排序；
$echartShowFloatNum = 3;
$tableLicensekey = "non-commercial-and-evaluation";
$echartSort = "seriesDesc";
$lockTime = 15;
$autoRefresh = 0; //自动刷新页面，0为禁用，1为打开
$autoRefreshTime = 360;
$calendarMark = "'0-0-15': '月中',
'0-0-7': '工资',
'0-2-2': '湿地',
'0-2-10': '气象',
'0-2-21': '反殖民',
'0-3-1': '海豹',
'0-3-3': '爱耳',
'0-3-5': '学雷锋',
'0-3-7': '女生',
'0-3-12': '植树',
'0-3-17': '航海',
'0-3-22': '水',
'0-3-24': '结核病',
'0-3-31': '安全',
'0-4-7': '卫生',
'0-4-7': '地球',
'0-5-5': '碘缺乏',
'0-5-8': '微笑',
'0-5-12': '护士',
'0-5-15': '家庭',
'0-5-17': '电信',
'0-5-19': '助残',
'0-5-22': '多样性',
'0-5-30': '五卅运',
'0-5-31': '无烟草',
'0-6-5': '环境',
'0-6-6': '爱眼',
'0-6-11': '人口',
'0-6-20': '难民',
'0-6-25': '土地',
'0-6-26': '禁毒',
'0-7-1': '建党',
'0-7-7': '抗日战',
'0-7-28': '一战始',
'0-8-1': '建军',
'0-8-3': '男人',
'0-8-6': '电影节',
'0-8-15': '国难',
'0-9-3': '抗战胜',
'0-9-8': '扫盲',
'0-9-16': '臭氧层',
'0-9-17': '和平',
'0-9-18': '九一八',
'0-9-27': '旅游',
'0-10-4': '动物',
'0-10-7': '住房',
'0-10-9': '邮政',
'0-10-14': '标准',
'0-10-15': '盲人',
'0-10-16': '粮食',
'0-10-17': '消贫',
'0-10-24': '联合国',
'0-10-31': '万圣',
'0-11-2': '万灵',
'0-11-8': '记者',
'0-11-9': '消防',
'0-11-11': '光棍',
'0-11-14': '糖尿病',
'0-11-16': '宽容',
'0-11-16': '大学生',
'0-11-21': '问候',
'0-12-1': '艾滋病',
'0-12-3': '残疾人',
'0-12-9': '足球',
'0-12-21': '篮球',
'0-12-24': '平安夜',
'0-12-29': '多样性',
'0-12-31': '跨年',
'2099-10-14': '呵呵'";
$highEchart = 1;
$tableType = "handsontable6";
$usezh_cn = 2;
$Release = 0; //1为发行版，0为测试版