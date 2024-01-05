<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
    <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />

    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />

<body>
    <div id="spreadsheet"></div>
</body>
<script>
    jspreadsheet(document.getElementById('spreadsheet'), {
        data: <?php echo json_encode($data); ?>,
        columns: [
            <?php
            for ($i = 0; $i < count($data[0]); $i++) {
                echo "{
            type: 'text',
            title: '" . $data[0][$i] . "',
            //width: 90
        },";
            }
            ?>
        ],
        // columns: [{
        // type: 'text',
        //         title: 'Car',
        //         width: 90
        //     },
        //     {
        //         type: 'dropdown',
        //         title: 'Make',
        //         width: 120,
        //         source: [
        //             "Alfa Romeo",
        //             "Audi",
        //             "Bmw",
        //             "Chevrolet",
        //             "Chrystler",
        //             // (...)
        //         ]
        //     },
        //     {
        //         type: 'calendar',
        //         title: 'Available',
        //         width: 120
        //     },
        //     {
        //         type: 'image',
        //         title: 'Photo',
        //         width: 120
        //     },
        //     {
        //         type: 'checkbox',
        //         title: 'Stock',
        //         width: 80
        //     },
        //     {
        //         type: 'numeric',
        //         title: 'Price',
        //         mask: '$ #.##,00',
        //         width: 80,
        //         decimal: ','
        //     },
        //     {
        //         type: 'color',
        //         width: 80,
        //         render: 'square',
        //     },
        // ]
    });
</script>

</html>