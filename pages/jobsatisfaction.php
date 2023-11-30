<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Satisfaction and Fulfillment Survey</title>
  <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
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
  color: #333;
}

table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 20px;
}

th,
td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="radio"] {
  margin-right: 5px;
}

input[type="submit"] {
  background-color: #4caf50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

input[type="submit"]:hover {
  background-color: #45a049;
}
</style>
</head>

<body>

<?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "pollwizardry";
  $table = "jobsatisfactionq";

  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }


  $sql = "SELECT * FROM $table";
  $result = $conn->query($sql);
?>

  <form action="jobsatisfaction_submit.php" method="post">
    <h1>Job Satisfaction and Fulfillment</h1>

    <table>
      <thead>
        <tr>
          <th>Question</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>

<?php
  if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["Question"] . "</td>";
      echo "<td>";
      echo "<label><input type='radio' name='q" . $row["QID"] . "' value='A'> A) " . $row["Option1"] . "</label>";
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
