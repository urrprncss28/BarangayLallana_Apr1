<?php
include('../config/db.php');

$result = $conn->query("SELECT * FROM users");
?>

<h2>User Management</h2>
<a href="add_user.php">Add User</a>

<table border="1">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['role'] ?></td>
    <td>
        <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a>
        <a href="delete_user.php?id=<?= $row['id'] ?>">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>