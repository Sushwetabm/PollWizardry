<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satisfaction with Educational Experiences  Survey</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: rgba(255, 206, 86, 0.7);
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 70%;
            margin-bottom: 20px;
            background-color: #f4f4f4;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        canvas {
            max-width: 80%;
            max-height: 200px;
            width: auto;
            height: auto;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pollwizardry";
$tableQ = "educationsatisfactionq";
$tableA = "educationsatisfactiona";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 1) == 'q') {
            $qid = substr($key, 1); 

            $sql = "UPDATE $tableA SET Option1 = Option1 + " . ($value == 'A' ? 1 : 0) . ",
                                        Option2 = Option2 + " . ($value == 'B' ? 1 : 0) . ",
                                        Option3 = Option3 + " . ($value == 'C' ? 1 : 0) . ",
                                        Option4 = Option4 + " . ($value == 'D' ? 1 : 0) . "
                    WHERE QID = $qid";

            $conn->query($sql);
        }
    }

}

$sql = "SELECT * FROM $tableQ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<center><table>";

    while ($row = $result->fetch_assoc()) {
        $qid = $row['QID'];
        $question = $row['Question'];
        $option1 = $row['Option1'];
        $option2 = $row['Option2'];
        $option3 = $row['Option3'];
        $option4 = $row['Option4'];

        $countSql = "SELECT Option1, Option2, Option3, Option4 FROM $tableA WHERE QID = $qid";
        $countResult = $conn->query($countSql);

        if ($countResult->num_rows > 0) {
            echo "<tr><td colspan='2'><center><h2>$question</h2></center></td></tr>";

            $countRow = $countResult->fetch_assoc();

            echo "<tr><td><center><canvas id='chart$qid' width='200' height='200'></canvas></center></td></tr>";
            echo "<script>
                    var ctx = document.getElementById('chart$qid').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['$option1', '$option2', '$option3', '$option4'],
                            datasets: [{
                                data: [{$countRow['Option1']}, {$countRow['Option2']}, {$countRow['Option3']}, {$countRow['Option4']}],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                ],
                            }],
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                },
                            },
                        },
                    });
                </script>";

        } else {
            echo "<tr><td colspan='2'>No data available for question: $question</td></tr>";
        }
    }

    echo "</table></center>";
} else {
    echo "<tr><td colspan='2'>No questions available.</td></tr>";
}

$conn->close();
?>

</body>
</html>
