<?php
session_start();
require "../../model/users.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) { 
    header("Location: ../signup.php");
    exit();
}

$pendingEnseignants = Teacher::getPendingEnseignants(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Enseignants</title>
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

<h1>Manage Enseignants</h1>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pendingEnseignants as $enseignant): ?>
        <tr>
            <td><?php echo $enseignant['nom'] . ' ' . $enseignant['prenom']; ?></td>
            <td><?php echo $enseignant['email']; ?></td>
            <td>
                <form method="post" action="../../controller/admin/teacher_manage.php">
                    <input type="hidden" name="user_id" value="<?php echo $enseignant['id']; ?>">
                    <button type="submit" name="action" value="accept">Accept</button>
                    <button type="submit" name="action" value="refuse">Refuse</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>