<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        Display games here...
        <?php
        // use select sql
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "softball";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM games";
        $result = $conn->query($sql);
        $datacount = $result->num_rows;

        if ($datacount > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Opponent</th>";
            echo "<th>Site</th>";
            echo "<th>Result</th>";
            echo "</tr>";

            // output data of each row
            for ($i = 0; $i < $datacount; $i++) {
                $row = $result->fetch_array(MYSQLI_NUM);
                echo "<tr>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </body>
</html>