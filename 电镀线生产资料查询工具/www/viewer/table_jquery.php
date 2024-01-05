<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../js/jqueryDataTable/datatables.min.css" />
    <link rel="stylesheet" href="../js/jqueryDataTable/tableStyle.css" />
    <script src="../js/jquery.js"></script>
    <script src="../js/jqueryDataTable/datatables.min.js"></script>
</head>

<body>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <?php
                if ($dirname == 'ParameterLog' or $dirname == 'ErrorLog' or $dirname == 'EventLog' or $_COOKIE['model'] == "debuger" or $dirname == 'downtimelog' or $dirname = 'Stopline') {
                    for ($i = 0; $i < count($cols); $i++) {
                        echo '<th>' . lang($data[0][$cols[$i]]) . '</th>';
                    }
                }
                ?>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</body>
<script>
    let table = new DataTable('#myTable', {
        paging: false,
        // scrollY: 680,
        searching: false,
        ordering: false,
        select: true,
        data: [
            <?php
            $count_data = count($data);
            for ($i = 1; $i < $count_data; $i++) {
                echo '[';
                for ($j = 0; $j < count($data[$i]); $j++) {
                    // var_dump($data[$i][$j]);
                    if ($data[$i][$j] == "") {
                        echo '"NULL",';
                    } else {
                        echo '"' . $data[$i][$j] . '",';
                    }
                }
                echo '],';
            }
            ?>
        ]
    });
</script>

</html>