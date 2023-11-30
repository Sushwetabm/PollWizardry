<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technology Usage Patterns Survey</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fce4ec; 
      margin: 0;
      padding: 0;
    }

    form {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: rgb(119, 7, 55);
      font-family: sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 15px;
      text-align: left;
    }

    th {
      background-color: rgb(248, 200, 220); 
      color: #fff;
    }

    label {
      display: block;
      margin-bottom: 10px;
      color: #333;
    }

    input[type="radio"] {
      margin-right: 8px;
    }

    input[type="submit"] {
      background-color: rgb(227, 115, 131);
      color: white;
      padding: 15px 25px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: rgb(170, 51, 106); 
    }
  </style>
</head>

<body>

<?php
  $servername = "localhost";
  $username = "root";
  $password = "Sush#2004";
  $dbname = "pollwizardry";
  $table = "technologyq";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM $table";
  $result = $conn->query($sql);
?>

<form action="techusagepattern_submit.php" method="post">
  <h1>Technology Usage Patterns</h1>
  <table>
    <thead>
      <tr>
        <th style="background-color: rgb(248, 200, 220); color: rgb(119, 7, 55);">Question</th>
        <th style="background-color: rgb(248, 200, 220); color: rgb(119, 7, 55);">Options</th>
      </tr>
    </thead>
    <tbody>

<?php
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td style='background-color: #ecf0f1; color: #333;'>" . $row["Question"] . "</td>";
      echo "<td>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='A' required> A) " . $row["Option1"] . "</label>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='B'> B) " . $row["Option2"] . "</label>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='C'> C) " . $row["Option3"] . "</label>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='D'> D) " . $row["Option4"] . "</label>";
      echo "</td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='2'>0 results</td></tr>";
  }

  $conn->close();
?>

    </tbody>
  </table>

  <br/>
  <input type="submit" value="Submit">
</form>

</body>
</html>
