<?php
require_once "dp.php";

$sql = "SELECT id, name, number, email, resume FROM student";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 85%;
            margin: 30px auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h2>Student Records</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Resume</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['number']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="<?php echo htmlspecialchars($row['resume']); ?>" target="_blank">Open PDF</a>
                </td>
            </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No records found</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </table>

    <br>
    <a href="Employe.html">Add New Candidate</a>

</body>
</html>