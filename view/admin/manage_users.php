<?php
session_start();
require "../../model/users.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) { 
    header("Location: ../login.php");
    exit();
}

$allUsers = User::getAll(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
<?php if(isset($_SESSION['error'])): ?>
    <div class="error"><?php echo $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="success"><?php echo $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<h1>Manage Users</h1>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allUsers as $user): ?>
        <tr>
            <td><?php echo $user['nom'] . ' ' . $user['prenom']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['ban'] === 'true' ? 'Banned' : 'Active'; ?></td>
            <td>
                <form method="post" action="../../controller/admin/user_manage.php">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <?php if ($user['ban'] === 'true'): ?>
                        <button type="submit" name="action" value="unban">Unban</button>
                    <?php else: ?>
                        <button type="submit" name="action" value="ban">Ban</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>