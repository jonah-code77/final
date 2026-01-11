<h3>Admin <?= ucfirst(Session::getSession('email')); ?></h3>
<h4>total approved student: <?= $getStat['approved_student'] ?></h4>
<h4>total pending student: <a href="/final/admin/pendingStudent"><?= $getStat['pending_student'] ?></a></h4>
<h4>total rejected sudent: <a href="/final/admin/rejectedStudent"><?= $getStat['declined_student'] ?></a></h4>


<a href="/final/admin/pendingStudent">pending Student</a><br>
<a href="/final/admin/approveStudent">approved Student</a><br>

<a href="../logout.php">logout</a>