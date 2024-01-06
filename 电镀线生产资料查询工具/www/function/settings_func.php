<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="../layui/layui.js"></script>
  <link rel="stylesheet" href="../layui//css/layui.css" media="all">
  <link rel="stylesheet" href="./css/style.css">
</head>
<?php
include(dirname(__DIR__) . '/config/common_config.php');
$machines_str = file_get_contents(dirname(__DIR__) . '/config/machines.config.json');
$machines_arr = json_decode($machines_str, true);

// 单个更改
function setConfig1($s, $e)
{
  $sfile = dirname(__DIR__) . '/config/common_config.php';
  $efile = dirname(__DIR__) . '/config/bak.common_config.php';
  copy($sfile, $efile);
  $content = file_get_contents($sfile);
  $content = str_replace("$s", "$e", $content);
  // var_dump($content);
  file_put_contents($sfile, $content);
}
if (
  $_POST['status_name'] != $status_name or
  !empty($_POST['status_name'])
) {
  setConfig1('$status_name = "' . urldecode($status_name) . '"', '$status_name = "' . $_POST['status_name'] . '"');
}
if (
  $_POST['status_password'] != $status_password or
  !empty($_POST['status_password'])
) {
  setConfig1('$status_password = "' . urldecode($status_password) . '"', '$status_password = "' . $_POST['status_password'] . '"');
}
if (
  $_POST['status_url'] != $status_url or
  !empty($_POST['status_url'])
) {
  setConfig1('$status_url = "' . urldecode($status_url) . '"', '$status_url = "' . $_POST['status_url'] . '"');
}
if (
  $_POST['echartShowTime'] != $echartShowTime or
  !empty($_POST['echartShowTime'])
) {
  setConfig1('$echartShowTime = ' . $echartShowTime . '', '$echartShowTime = ' . $_POST['echartShowTime'] . '');
}
if (
  $_POST['echartlinewidth'] != $echartlinewidth or
  !empty($_POST['echartlinewidth'])
) {
  setConfig1('$echartlinewidth = ' . $echartlinewidth . '', '$echartlinewidth = ' . $_POST['echartlinewidth'] . '');
}
if (
  $_POST['echartShowFloatNum'] != $echartShowFloatNum or
  !empty($_POST['echartShowFloatNum'])
) {
  setConfig1('$echartShowFloatNum = ' . $echartShowFloatNum . '', '$echartShowFloatNum = ' . $_POST['echartShowFloatNum'] . '');
}
if (
  $_POST['lockTime'] != $lockTime or
  !empty($_POST['lockTime'])
) {
  setConfig1('$lockTime = ' . $lockTime . '', '$lockTime = ' . $_POST['lockTime'] . '');
}
if (
  $_POST['echartSort'] != $echartSort or
  !empty($_POST['echartSort'])
) {
  setConfig1('$echartSort = "' . $echartSort . '"', '$echartSort = "' . $_POST['echartSort'] . '"');
}
if (
  $_POST['tableType'] != $tableType or
  !empty($_POST['tableType'])
) {
  setConfig1('$tableType = "' . $tableType . '"', '$tableType = "' . $_POST['tableType'] . '"');
}
if (
  $_POST['tableLicensekey'] != $tableLicensekey or
  !empty($_POST['tableLicensekey'])
) {
  setConfig1('$tableLicensekey = "' . $tableLicensekey . '"', '$tableLicensekey = "' . $_POST['tableLicensekey'] . '"');
} else {
  setConfig1('$tableLicensekey = "' . $tableLicensekey . '"', '$tableLicensekey = "' . $tableLicensekey . '"');
}
if (
  $_POST['Release'] != $Release or
  !empty($_POST['Release'])
) {
  setConfig1('$Release = ' . $Release . '', '$Release = ' . $_POST['Release'] . '');
}
if (
  $_POST['autoRefresh'] != $autoRefresh or
  !empty($_POST['autoRefresh'])
) {
  setConfig1('$autoRefresh = ' . $autoRefresh . '', '$autoRefresh = ' . $_POST['autoRefresh'] . '');
}
if (
  $_POST['autoRefreshTime'] != $autoRefreshTime or
  !empty($_POST['autoRefreshTime'])
) {
  setConfig1('$autoRefreshTime = ' . $autoRefreshTime . '', '$autoRefreshTime = ' . $_POST['autoRefreshTime'] . '');
}
if (
  $_POST['calendarMark'] != $calendarMark or
  !empty($_POST['calendarMark'])
) {
  setConfig1('$calendarMark = "' . $calendarMark . '"', '$calendarMark = "' . $_POST['calendarMark'] . '"');
}
if (
  $_POST['highEchart'] != $highEchart or
  !empty($_POST['highEchart'])
) {
  setConfig1('$highEchart = ' . $highEchart . '', '$highEchart = ' . $_POST['highEchart'] . '');
}
if (
  $_POST['titleSort'] != $titleSort or
  !empty($_POST['titleSort'])
) {
  setConfig1('$titleSort = ' . $titleSort . '', '$titleSort = ' . $_POST['titleSort'] . '');
}
if (
  $_POST['usezh_cn'] != $usezh_cn or
  !empty($_POST['usezh_cn'])
) {
  setConfig1('$usezh_cn = ' . $usezh_cn . '', '$usezh_cn = ' . $_POST['usezh_cn'] . '');
}

// 机台配置的修改
$macstr = "[";
for ($i = 0; $i < count($_POST['macid']); $i++) {
  if ($_POST['mactype'][$i] != "RSA") {
    if (abs($_POST['macEBOtime'][$i]) > 99) {
      echo '<script>
      var index = layer.alert("哈哈哈，你真调皮！😀不过还是给你保存啦。😉", {
                  icon: 6,
                  shadeClose: true,
                  zIndex:999,
                  title: "信息提示"
                }
      );
      </script>;';
    }
    if ($i == (count($_POST['macid']) - 1)) {
      $macstr = $macstr . '{
      "id":"' . $_POST['macid'][$i] . '",
      "type": "' . $_POST['mactype'][$i] . '",
      "host": "' . $_POST['machost'][$i] . '",
      "ip": "' . $_POST['macip'][$i] . '",
      "EBOtime": "' . $_POST['macEBOtime'][$i] . '",
      "DataLog": ' . $_POST['macDataLog'][$i] . ',
      "ErrorLog": ' . $_POST['macErrorLog'][$i] . ',
      "EventLog": ' . $_POST['macEventLog'][$i] . ',
      "StartStopLog": ' . $_POST['macStartStopLog'][$i] . ',
      "downtimelog": ' . $_POST['macdowntimelog'][$i] . ',
      "ParameterLog/Machine":' . $_POST['macParameterLog/Machine'][$i] . ',
      "ParameterLog/Product":' . $_POST['macParameterLog/Product'][$i] . '
      }';
    } else {
      $macstr = $macstr . '{
      "id":"' . $_POST['macid'][$i] . '",
      "type": "' . $_POST['mactype'][$i] . '",
      "host": "' . $_POST['machost'][$i] . '",
      "ip": "' . $_POST['macip'][$i] . '",
      "EBOtime": "' . $_POST['macEBOtime'][$i] . '",
      "DataLog": ' . $_POST['macDataLog'][$i] . ',
      "ErrorLog": ' . $_POST['macErrorLog'][$i] . ',
      "EventLog": ' . $_POST['macEventLog'][$i] . ',
      "StartStopLog": ' . $_POST['macStartStopLog'][$i] . ',
      "downtimelog": ' . $_POST['macdowntimelog'][$i] . ',
      "ParameterLog/Machine":' . $_POST['macParameterLog/Machine'][$i] . ',
      "ParameterLog/Product":' . $_POST['macParameterLog/Product'][$i] . '
      },
      ';
    }
  }
  if ($_POST['mactype'][$i] == "RSA") {
    if (abs($_POST['macEBOtime'][$i]) > 99) {
      echo '<script>
      var index = layer.alert("哈哈哈，你真调皮！😀不过还是给你保存啦。😉", {
                  icon: 6,
                  shadeClose: true,
                  zIndex:999,
                  title: "信息提示"
                }
      );
      </script>;';
    }
    $macstr = $macstr . '{
      "id":"' . $_POST['macid'][$i] . '",
      "type": "' . $_POST['mactype'][$i] . '",
      "host": "' . $_POST['machost'][$i] . '",
      "ip": "' . $_POST['macip'][$i] . '",
      "EBOtime": "' . $_POST['macEBOtime'][$i] . '",
      "Rsa": ' . $_POST['macDataLog'][$i] . ',
      "Alarm": ' . $_POST['macErrorLog'][$i] . ',
      "Stopline": ' . $_POST['macdowntimelog'][$i] . ',
      "ParametricModifierLog": ' . $_POST['macParameterLog/Product'][$i] . '
    }';
  }
}
// 固定字段
$macstr = $macstr . ',
{
      "id": "testKuaiji",
      "type": "测试",
      "host": "",
      "ip": "localhost/www/csvtest/Kuaiji",
      "DataLog": 1,
      "EBOtime": "6",
      "ErrorLog": 1,
      "EventLog": 1,
      "StartStopLog": 1,
      "downtimelog": 1,
      "ParameterLog/Machine": 1,
      "ParameterLog/Product": 1
},
{
      "id": "testSRmanji",
      "type": "测试",
      "host": "",
      "ip": "localhost/www/csvtest/MANJI",
      "EBOtime": "6",
      "DataLog": 1,
      "ErrorLog": 1,
      "EventLog": 1,
      "StartStopLog": 1,
      "downtimelog": 1,
      "ParameterLog/Machine": 1,
      "ParameterLog/Product": 1
},
{
      "id": "testME2",
      "type": "测试",
      "host": "",
      "ip": "localhost/www/csvtest/ME2",
      "EBOtime": "6",
      "DataLog": 1,
      "ErrorLog": 1,
      "EventLog": 1,
      "StartStopLog": 1,
      "downtimelog": 1,
      "ParameterLog/Machine": 1,
      "ParameterLog/Product": 1
},
{
      "id": "testNiPdAu",
      "type": "测试",
      "host": "",
      "ip": "localhost/www/csvtest/NIPDAU",
      "EBOtime": "6",
      "DataLog": 1,
      "ErrorLog": 1,
      "EventLog": 1,
      "StartStopLog": 1,
      "downtimelog": 1,
      "ParameterLog/Machine": 1,
      "ParameterLog/Product": 1
},
{
      "id": "testBOC",
      "type": "测试",
      "host": "",
      "ip": "localhost/www/csvtest/BOC",
      "EBOtime": "6",
      "DataLog": 1,
      "ErrorLog": 1,
      "EventLog": 0,
      "StartStopLog": 0,
      "downtimelog": 0,
      "ParameterLog/Machine": 0,
      "ParameterLog/Product": 0
},
{
      "id": "testRSA",
      "type": "测试",
      "host": "",
      "ip": "localhost/www/csvtest/RSA",
      "EBOtime": "6",
      "Rsa": 1,
      "Alarm": 1,
      "Stopline": 1,
      "ParametricModifierLog": 1
},
{
      "id": "test33#",
      "type": "测试",
      "host": "",
      "ip": "localhost/www/csvtest/33",
      "EBOtime": "6",
      "DataLog": 1,
      "ErrorLog": 1,
      "EventLog": 1,
      "StartStopLog": 1,
      "downtimelog": 1,
      "ParameterLog/Machine": 1,
      "ParameterLog/Product": 1
}
]';
// echo $macstr;
file_put_contents(dirname(__DIR__) . '/config/machines.config.json', $macstr);
// echo "<pre>";
// var_dump($_POST);
// // echo "<script>alert('OK！');self.location=document.referrer;</script>";
// echo "</pre>";
?>

<script>
  // 取消alert标题网址。
  (function() {
    window.alert = function(name) {
      var iframe = document.createElement("IFRAME");
      iframe.style.display = "none";
      iframe.setAttribute("src", 'data:text/plain');
      document.documentElement.appendChild(iframe);
      window.frames[0].window.alert(name);
      iframe.parentNode.removeChild(iframe);
    }
  })();
  // 提示框
  var index = layer.open({
    type: 1,
    title: '提示信息',
    area: 'auto',
    anim: 'slideDown',
    icon: 6,
    zIndex: 9,
    content: '<div style="padding:15px;font-size: 2rem;">设置已保存，正在跳转...</div>'
  });
  setInterval(function() {
    self.location = document.referrer;
  }, 2000);
</script>

<body>
</body>

</html>