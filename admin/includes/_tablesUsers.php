<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Data Table
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-center">
                    <div class="ajax-loading spinner-border text-primary m-5" role="status" id="loading-users">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped data-table" id="users-list" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Register day</th>
                                <th>Confirmed</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr class="user-row">
                                    <td><?= $user['user_id'] ?></td>
                                    <td><?= $user['user_name'] ?></td>
                                    <td><?= $user['user_email'] ?></td>
                                    <td><?= $user['register_date'] ?></td>
                                    <td>
                                        <?php if ($user['confirmed'] == 'Y') : ?>
                                            <p class="text-success">Yes</p>
                                        <?php else : ?>
                                            <p class="text-danger">No</p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary change-role" data-user="<?= $user['user_id'] ?>" data-role="<?= $user['user_role'] ?>" data-bs-toggle="modal" data-bs-target="#modal-change-role">
                                                <i class="bi bi-file-person-fill"></i>
                                                <span class="user-role"><?= ucfirst(strtolower($user['role_name'])); ?></span>
                                            </button>
                                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item edit-user" data-bs-target="#modal-add-edit-user" data-bs-toggle="modal" data-user="<?= $user['user_id'] ?>">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item user-details" data-bs-target="#modal-user-details" data-bs-toggle="modal" data-user="<?= $user['user_id'] ?>">
                                                        <i class="bi bi-info-square"></i> Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item delete-user" href="javascript:;" data-user="<?= $user['user_id'] ?>">
                                                        <i class=" bi bi-trash"></i>
                                                        <span class="text-danger">Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-user-details">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Loading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="dl-horizontal">
                    <dt title="email">email</dt>
                    <dd id="modal-details--email"></dd>
                    <dt title="full_name">Full Name</dt>
                    <dd id="modal-details--full-name"></dd>
                    <dt title="city">City</dt>
                    <dd id="modal-details--city"></dd>
                    <dt title="address">Address</dt>
                    <dd id="modal-details--address"></dd>
                    <dt title="phone">Phone</dt>
                    <dd id="modal-details--phone"></dd>
                </dl>
            </div>

            <div class="d-flex justify-content-center">
                <div class="ajax-loading spinner-border text-primary m-5" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a class="btn btn-primary" data-bs-dismiss="modal" href="javascript:void(0);">Save changes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-change-role" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-username">Pick User Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="details-body">
                <?php if (count($roles) > 0) : ?>
                    <label>Selected Role</label>
                    <select id="select-user-role" class="form-control">
                        <?php foreach ($roles as $role) : ?>
                            <option value="<?= $role['role_id'] ?>">
                                <?= ucfirst(strtolower($role['role_name'])) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a type="button" class="btn btn-primary" id="change-role-button" data-bs-dismiss="modal" href="javascript:;">Save changes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-edit-user" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-username">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="p-2" id="add-user-form">
                <div class="modal-body" id="details-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Full Name</label>
                        <input name="name" type="text" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" type="password" id="password" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Confirmed Password</label>
                        <input name="passwordConfirm" type="password" class="form-control" />
                    </div>

                    <hr class="mt-4 mb-4">

                    <div class="form-group">
                        <label>City</label>
                        <input name="city" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input name="address" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input name="phone" type="text" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="ajax-loading spinner-border text-primary m-5" role="status" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-add-user" name="button">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>