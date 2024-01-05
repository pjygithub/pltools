<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../xspreadsheet/xspreadsheet.css">
  <script src="../xspreadsheet/xspreadsheet.js"></script>
  <script src="../xspreadsheet/locale/zh-cn.js"></script>
</head>
<?php
$jsonStr = '[';
$count_r = count($data);
$count_c = count($data[0]);
for ($i = 0; $i < $count_r; $i++) {
  $jsonStr .= "{";
  foreach ($data[0] as $key => $value) {
    $jsonStr .= "\"" . $value  . "\":\"" . $key . "\",";
  }
  $jsonStr = rtrim($jsonStr, ","); // 去掉最后一个逗号
  $jsonStr .= "}";
}
$jsonStr .= "]";
// var_dump($jsonStr);
// die;
?>

<body>
  <div id="x-spreadsheet-demo"></div>

</body>
<script>
  var data = '<?php echo $jsonStr; ?>'
  console.log(data);
  var options = {
    mode: 'edit', // edit | read
    showToolbar: true,
    showGrid: true,
    showContextmenu: true,
    view: {
      height: () => document.documentElement.clientHeight,
      width: () => document.documentElement.clientWidth,
    },
    row: {
      len: 100,
      height: 25,
    },
    col: {
      len: 26,
      width: 100,
      indexWidth: 60,
      minWidth: 60,
    },
    style: {
      bgcolor: '#ffffff',
      align: 'left',
      valign: 'middle',
      textwrap: false,
      strike: false,
      underline: false,
      color: '#0a0a0a',
      font: {
        name: 'Helvetica',
        size: 10,
        bold: false,
        italic: false,
      },
    },
  }
  var xs = x_spreadsheet('#x-spreadsheet-demo', options);
  // xs.locale('zh-cn');
  xs.loadData({}) // load data
  xs.change(data => {
    // save data to db
  })
  // data validation

  xs.cellText(5, 5, 'xxxx').cellText(6, 5, 'yyy').reRender();
  <?php
  for ($i = 1; $i < count($data); $i++) {
    echo "xs.";
    // echo "'" . lang($data[$i][0]) . "',";
    for ($k = 0; $k < count($cols); $k++) {
      $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
      $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
      if ($data[0][$cols[1]] == "Start_Time") {
        $data[$i][$cols[0]] = str_replace('.', '/', $data[$i][$cols[0]]);
        $data[$i][$cols[0]] = str_replace('-', '/', $data[$i][$cols[0]]);
      }
      // echo "'" . lang($data[$i][$cols[$k]]) . "',";
      echo "cellText(" . $i . ", " . $k . ", '" . lang($data[$i][$cols[$k]]) . "').";
    }
    echo "reRender();";
  }
  // die;

  ?>
  xs.validate()
</script>

</html>