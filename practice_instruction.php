<?php
require __DIR__ . '/vendor/autoload.php';
error_reporting(0);

$code = $_GET['id'];

$client = new Google_Client();

$client->setApplicationName('Practice Instructions');

$client->setScopes([Google\Service\Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google\Service\Sheets($client);

$spreadsheetId = "1HOkLicWIffmT7UxTqd2XNWKz5CmCLL5Ue9gO9rq5iBA"; //It is present in your URL

$get_range = "PRACTICE-INSTRUCTIONS!A2:E";


$response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
$values = $response->getValues();

$status = false;
$data = array();
foreach ($values as $row) {
    if ($row[0] == $code) {
        $data[] = $row;
        $status = true;
    }
}

// $grading = explode("\n", $data[5]);

// var_dump($grading);

?>

<html>

<head>
    <style>
        body {
            background-color: #F5F5F5;
            font-family: Arial, Helvetica, sans-serif;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 1024px;
            background-color: #ffffff;
            margin: 0 auto;

        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 12px;
        }

        #main-table td {
            padding: 10px;
        }
    </style>
</head>

<body>
    <?php
    if (!$status) {
    ?>
        <h1>Data Not Found</h1>
    <?php
    } else {
    ?>
        <div>
            <div class="card">
                <div class="container">
                    <table cellspacing="0" style="width: 1000px;">
                        <tbody>
                            <tr>
                                <td style="width: 150px; text-align: center; padding-bottom: 12px; border-bottom: 2px double #000000;"><img src="http://ilkom.unila.ac.id/wp-content/uploads/2018/03/Logo-unila-2018-300x300.png" style="width: 100px;"></td>
                                <td style="width: 850px; text-align: left; padding-bottom: 12px; border-bottom: 2px double #000000;">
                                    <span style="font-size: 18pt;">UNIVERSITY OF LAMPUNG</span><br>
                                    <span style="font-size: 14pt;">FACULTY OF MATHEMATICS AND NATURAL SCIENCES</span><br>
                                    <span style="font-size: 14pt; font-weight: bold;">Department of Computer Sciences</span><br>
                                    <span style="font-size: 12pt;">Jl. Prof. Dr. Soemantri Brodjonegoro No. 1 Bandar Lampung 35145</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="padding: 24px;">
                        <!-- <b style="font-size: 24px; text-align: center; display: block; padding-top:20px;">PRACTICE INSTRUCTIONS</b><br> -->
                        <table style="padding-top:20px; padding-bottom:20px; font-size: 18px;">
                            <tr>
                                <td style="padding-right: 50px;">Subject</td>
                                <td>: <b><?= $data[0][1] ?></b></td>
                            </tr>
                            <tr>
                                <td>Code</td>
                                <td>: <?= $data[0][0] ?></td>
                            </tr>
                            <tr>
                                <td>Credit</td>
                                <td>: <?= $data[0][2] ?></td>
                            </tr>
                        </table>
                        <p>
                            <b style="font-size: 24px; text-align: center; display: block; padding-top:0px;">PRACTICE INSTRUCTIONS</b><br>
                        <table id="main-table" width="100%" border="1" cellspacing="0" cellpadding="4" align="center">
                            <thead style="text-align: center;">
                                <th>Topics</th>
                                <th>Instruction</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data as $row) {
                                    $instruction = explode("\n", $row[4]);
                                ?>
                                    <tr>
                                        <td><?= $row[3] ?></td>
                                        <td>
                                            <ol>
                                                <?php
                                                foreach ($instruction as $ins) {
                                                ?>
                                                    <li><?= $ins ?></li>
                                                <?php
                                                }
                                                ?>
                                            </ol>
                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>


</body>

</html>