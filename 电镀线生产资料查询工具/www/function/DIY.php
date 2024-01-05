<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>自定义</title>
    <link rel="stylesheet" href="../layui/css/layui.css">
    <script src="../layui/layui.js"></script>
    <script src="../js/jquery.js"></script>
</head>
<style>
    .layui-form-item .layui-form-checkbox {
        margin-top: 3px;
    }

    .layui-form-checkbox {
        position: relative;
        height: 30px;
        line-height: 30px;
        margin-right: 20px;
        padding-right: 30px;
        cursor: pointer;
        font-size: 0;
        -webkit-transition: .1s linear;
        transition: .1s linear;
        box-sizing: border-box;
    }

    .layui-form-checkbox i {
        position: absolute;
        right: 0;
        top: 0;
        width: 30px;
        height: 28px;
        border: 1px solid #d2d2d2;
        border-left: none;
        border-radius: 0 2px 2px 0;
        color: #fff;
        font-size: 26px;
        text-align: center;
    }

    form {
        width: 100%;
        height: 90vh;
        overflow: auto;
        margin-top: 10px;
    }

    .layui-input-block {
        position: relative;
        bottom: 0;
    }
</style>
<?php
// echo "<pre>";
// print_r($data[0]);
// print_r($_POST);
// print_r();
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
// 非数值，防止出错
$noValue = array(
    'Time',
    'L1 ED On/Off',
    'L1 ED2 On/Off',
    'L1 Cu Plating On/Off',
    'L1 Ag Strike On/Off',
    'L1 Ag Plating On/Off',
    'L1 BS(2) On/Off',
    'L1 M9 On/Off',
    'L1 Mode',
    'L2 ED On/Off',
    'L2 ED2 On/Off',
    'L2 Cu Plating On/Off',
    'L2 Ag Strike On/Off',
    'L2 Ag Plating On/Off',
    'L2 BS(2) On/Off',
    'L2 M9 On/Off',
    'Strand 1 Pre-Clean On/Off',
    'Strand 1 Post-dip IA On/Off',
    'Strand 1 Post-dip IB On/Off',
    'Strand 1 Status',
    'Strand 2 Pre-Clean On/Off',
    'Strand 2 Post-dip IA On/Off',
    'Strand 2 Post-dip IB On/Off',
    'Strand 2 Status',
    'L1',
    'L2',
    'Time',
    'L1 Mode',
    'L1 Tool ID',
    'L1 Electrode ID',
    'L1 ED On/Off',
    'L1 ED2 On/Off',
    'L1 Mode',
    'L1 Cu Plating On/Off',
    'L1 Ag Strike On/Off',
    'L1 Ag Plating On/Off',
    'L1 BS(2) On/Off',
    'L2 Mode',
    'L2 Tool ID',
    'L2 Electrode ID',
    'L2 ED On/Off',
    'L2 ED2 On/Off',
    'L2 Cu Plating On/Off',
    'L2 Ag Strike On/Off',
    'L2 Ag Plating On/Off',
    'L2 BS(2) On/Off',
    'Time',
    'L1 Mode',
    'L1 Electrode ID',
    'L1 Tool ID',
    'L1 EC On/Off',
    'L1 Ag Strike On/Off',
    'L1 BS On/Off',
    'L1 KоH On/Off',
    'L1 Cu On/Off',
    'L1 Ag On/Off',
    'L2 Mode',
    'L2 Electrode ID',
    'L2 Tool ID',
    'L2 EC On/Off',
    'L2 Ag Strike On/Off',
    'L2 BS On/Off',
    'L2 KоH On/Off',
    'L2 Cu On/Off',
    'L2 Ag On/Off',
    'L3 Mode',
    'L3 Electrode ID',
    'L3 Tool ID',
    'L3 EC On/Off',
    'L3 Ag Strike On/Off',
    'L3 BS On/Off',
    'L3 KоH On/Off',
    'L3 Cu On/Off',
    'L3 Ag On/Off',
    'EF1000(LowerTank) On/Off',
    'BS(Tank) On/Off',
    'Time',
    'L1 Tool ID',
    'L1 Electrode ID',
    'L1 ED(1) On/Off',
    'L1 ED(2) On/Off',
    'L1 ME2(1) On/Off',
    'L1 ME2(2) On/Off',
    'L1 ME2(1&2)LT On/Off',
    'L1 ME2(3) On/Off',
    'L1 ME2(4) On/Off',
    'L1 ME2(3&4)LT On/Off',
    'L1 KоH On/Off',
    'L2 Tool ID',
    'L2 Electrode ID',
    'L2 ED(1) On/Off',
    'L2 ED(2) On/Off',
    'L2 ME2(1) On/Off',
    'L2 ME2(2) On/Off',
    'L2 ME2(1&2)LT On/Off',
    'L2 ME2(3) On/Off',
    'L2 ME2(4) On/Off',
    'L2 ME2(3&4)LT On/Off',
    'L2 KоH On/Off',
    'L1 Tool ID',
    'L1 Electrode ID',
    'L1 Mode',
    'L1 ED On/Off',
    'L1 Pre-Acid Rinse On/Off',
    'L1 Ni Strike(1.1) On/Off',
    'L1 Ni Strike(1.2) On/Off',
    'L1 Ni Strike(2.1) On/Off',
    'L1 Ni Strike(2.2) On/Off',
    'L1 Pd Strike On/Off',
    'L1 Au Strike On/Off',
    'L2 Tool ID',
    'L2 Electrode ID',
    'L2 Mode L2 ED On/Off',
    'L2 Pre-Acid Rinse On/Off',
    'L2 Ni Strike(1.1) On/Off',
    'L2 Ni Strike(1.2) On/Off',
    'L2 Ni Strike(2.1) On/Off',
    'L2 Ni Strike(2.2) On/Off',
    'L2 Pd Strike On/Off',
    'L2 Au Strike On/Off',
    'LO Ni Strike(1)LT On/Off',
    'LO Ni Strike(2)LT On/Off'
);
$noValue = array_unique($noValue); // 删除重复
$noValue = array_values($noValue); // 重新编号
$noValue = array_filter($noValue);
$count = count($data[0]);
/**
 * 
 * 中英混合字符串长度判断 
 * @param unknown_type $str
 * @param unknown_type $charset
 */
function strLength($string, $charset = 'utf-8')
{
    if ($charset == 'utf-8')
        $string = iconv('utf-8', 'gb2312', $string);
    $num = strlen($string);
    $cnNum = 0;
    for ($i = 0; $i < $num; $i++) {
        if (ord(substr($string, $i + 1, 1)) > 127) {
            $cnNum++;
            $i++;
        }
    }
    $enNum = $num - ($cnNum * 2);
    $number = ($enNum / 2) + $cnNum;
    return ceil($number);
}
$maxStr = 0;
// echo "<pre>";
foreach ($data[0] as $key => $value) {
    preg_match_all('/./u', $str, $matches);
    $length = count($matches[0]);
    $t_len = strLength($value);
    if ($t_len >= $maxStr) {
        $maxStr = $t_len;
    } else {
        $maxStr = $maxStr;
    }
    // var_dump($maxStr);
}
if ($maxStr <= 12) {
    $maxStr = $maxStr * 2;
} else {
    $maxStr = $maxStr + 3.5;
}

?>
<style>
    .layui-input-block {
        margin-left: unset;
        min-height: unset;
    }

    .layui-form-item .layui-form-checkbox {
        margin-top: 3px;
        width: calc(<?php echo $maxStr ?> * 14px);

    }

    .layui-unselect>div {
        width: calc(100% - 30px + 4px * 2);
        background-color: #969696;
    }

    .layui-form-checked>div {
        background-color: #16b777;
    }

    .layui-input-block>i {
        /* margin-left: 10px; */
        border: 1px solid rgba(0, 0, 0, 0);
        height: 30px;
    }
</style>

<body>
    <div class="layui-btn-container" style="position: fixed;top: 0;background-color: #FFF;width: 100%;z-index: 999;margin-left:0;">
        <button type="button" id="showhide" class="layui-btn layui-bg-blue layui-btn-radius layui-btn-sm">显示 筛选项 <i class="layui-icon layui-icon-down layui-font-12"></i>
        </button>
        <span style="color:#757575">（显示对应机台所有的Datalog表头，使用方法：展开待筛选项 → 点选 → 下滑拉点击“查询”按钮）</span>
    </div>
    <!-- <button type="button">显示 筛选</button> -->
    <!-- <button id="showhide" style="color:blue;font-size:13px;">显示 筛选</button> -->
    <!-- <a href="javascript:showhide()" id="showhide" style="color:blue;font-size:13px;z-index:999">显示 筛选</a>< -->
    <form class="layui-form layui-anim-up" action="./DataLog.php" method="post" style="display:none;margin-top:36px" id="layui-form">
        <div class="layui-form-item" style="position:fixed;top:0;right:100px;z-index:999;background-color:#fff">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">查询</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
        <div class="layui-form-item">
            <!-- <label class="layui-form-label">选择数据：</label> -->
            <div class="layui-input-block">
                <?php
                $title = $data[0];
                if ($titleSort == 1) {
                    sort($title); // 选项排序
                }
                if ($titleSort == 2) {
                    rsort($title); // 选项排序
                }
                // $count = count($data[0]);
                for ($i = 0; $i < $count; $i++) {
                    $name_ = str_replace('/', '__', $title[$i]);
                    if (in_array($title[$i], $noValue) == FALSE) {
                        // echo '<input type="checkbox" name="nick_cols[' . $name_ . ']" title="' . lang($title[$i]) . '">';
                        if ($_POST['nick_cols'][$name_] == 'on') {
                            echo '<input type="checkbox" name="nick_cols[' . $name_ . ']" lay-skin="tag" title="' . lang($title[$i]) . '" checked >';
                        } else {
                            echo '<input type="checkbox" name="nick_cols[' . $name_ . ']" lay-skin="tag" title="' . lang($title[$i]) . '">';
                        }
                    }
                }
                ?>
            </div>
        </div>

    </form>

    <script>
        $("#showhide").click(function() {
            // e.preventDefault();
            function $(id) {
                return document.getElementById(id);
            }
            var bom = document.defaultView.getComputedStyle($("layui-form"), null)
            var bomDis = bom.display;
            var box = document.querySelector('#layui-form');
            var box1 = document.querySelector('#showhide');
            if (bomDis == 'none') {
                box.style.display = "block";
                box1.innerHTML = '隐藏 筛选项<i class="layui-icon layui-icon-up layui-font-12">';
            } else {
                box.style.display = "none";
                box1.innerHTML = '显示 筛选项 <i class="layui-icon layui-icon-down layui-font-12"></i>';
            }
            // alert(qLL); //结果有值
        });
        layui.use('form', function() {
            var form = layui.form;
            //提交
            form.on('submit(formDemo)', function(data) {
                // layer.msg(JSON.stringify(data.field));
                layer.msg('正在查询。请稍后……');
                // return false;
            });
            form.on('reset(formDemo)', function(data) {
                // layer.msg(JSON.stringify(data.field));
                layer.msg('正在查询。请稍后……');
                // return false;
            });
        });
    </script>
    <!-- body 末尾处引入 layui -->
    <script src="../layui/layui.js"></script>
</body>
<?php
$tbheader = array();
array_push($tbheader, 'Time', 'Date');
foreach ($_POST['nick_cols'] as $key => $value) {
    if ($value == 'on') {
        $name = str_replace('__', '/', $key);
        array_push($tbheader, $name);
    }
}
// echo '<pre>';
// print_r($tbheader);
?>

</html>