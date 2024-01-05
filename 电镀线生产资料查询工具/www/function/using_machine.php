<?
// 引入机器配置文件
$machines_json = file_get_contents(dirname(__DIR__) . '/config/machines.config.json');
$machines_arr = json_decode($machines_json, true);
// 机台号预处理
(empty($_COOKIE['machine'])) && $_COOKIE['machine'] = '0';
$count_machines = count($machines_arr);
for ($i = 0; $i < $count_machines; $i++) {
    if ($machines_arr[$i]['id'] == $_COOKIE['machine']) {
        $index = $i;
    }
}
