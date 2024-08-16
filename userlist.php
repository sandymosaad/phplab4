<table border="3">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Address</th>
        <th>Country</th>
        <th>Gender</th>
        <th>Department</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php
    require 'conndb.php';

    $stmt = $pdo->query("SELECT * FROM users");

    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            echo "<tr>";

            foreach ($row as $key => $value) {
                if ($key == "img") {
                    echo "<td><img src='" . ($value) . "' width='100' height='100'></td>";
                } 
                else {
                    echo "<td>" . ($value) . "</td>";
                }
            }

            echo "<td>
                    <a href='view.php?id=" . $row['id'] . "'>View</a>
                    <a href='edit.php?id=" . $row['id'] . "'>Edit</a>
                    <a href='delete.php?id=" . $row['id'] . "'>Delete</a>
                </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No records found</td></tr>";
    }
    ?>
</table>