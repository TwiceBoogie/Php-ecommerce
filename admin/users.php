<?php
$site = "Users";

include 'includes/adminHeader.php';

$currentUser = app('current_user');
if (!$currentUser->is_admin === 'Y') {
    redirect('login.php');
}

$users = app('db')->select(
    "SELECT `users`.*, `roles`.`role_name` 
    FROM `users` LEFT JOIN `roles` 
    ON `users`.`user_role` = `roles`.`role_id` 
    WHERE `user_id` != :id",
    array("id" => $currentUser->id)
);

$roles = app('db')->select(
    "SELECT * FROM `roles`"
);


?>
<div id="layoutDrawer_content">
    <main>
        <div class="container-xl p-5 center">
            <div class="row">
                <div class="col-md-12">
                    <h4>Dashboard</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-success mb-2" id="btn-show-user-modal" data-bs-target="#modal-add-edit-user" data-bs-toggle="modal">
                        <i class="bi bi-file-person-fill"></i> Add User
                    </button>
                </div>
            </div>

            <?php include 'includes/_tablesUsers.php'; ?>
        </div>
    </main>
</div>
<?php
include 'includes/adminFooter.php';
