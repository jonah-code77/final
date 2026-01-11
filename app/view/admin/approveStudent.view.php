<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin || Dashboard</title>
</head>
<body>
    <h2>Approved students</h2>
    <div id="msg"></div>
    <table cellpadding='8' border="1" cellspacing='0' id="pendingStudent">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last name</th>
                <th>profile picture</th>
                <th>Gender</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($approvedStudents)) : ?>
                <?php foreach($approvedStudents as $approvedStudent):?>
                    <tr id="student-<?= $approvedStudent['id'] ?>">
                        <td><?= $approvedStudent['firstname']  ?></td>
                        <td><?= $approvedStudent['lastname']  ?></td>
                        <td><img src="/FINAL/<?= $approvedStudent['profile_picture']  ?>"
                        style = "width : 60px; height: 60px; object-fit: cover; border-radius: 20px;" ></td>
                        <td><?= $approvedStudent['gender'] ?></td>
                        <td><?= $approvedStudent['dept'] ?></td>
                        <td>
                            <button class="admin-action" data-action="approved" data-id="<?= $approvedStudent['id'] ?>">
                                approved
                            </button>
                            <button class="admin-action" data-action="reject" data-id="<?= $approvedStudent['id'] ?>">
                                Reject
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" align="center">no approved studen yet</td>
                    </tr>
            <?php endif;?>    
        </tbody>
    </table>
    <script src="<?= BASE_URL ?>/js/adminApp.js"></script>
</body>
</html>
