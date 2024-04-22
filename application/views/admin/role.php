<div class="pad margin no-print">
    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Add New Role</a>
                </h3>
            </div>
            <div class="box-body">
                <?php if (empty($role)) : ?>
                    <div class="alert alert-danger" role="alert">
                        data belum dicari atau tidak ditemukan
                    </div>
                <?php else : ?>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5px">#</th>
                                    <th>icon</th>
                                    <th>role</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($role as  $r) : ?>
                                    <tr>
                                        <td><?= ++$i; ?></td>
                                        <td> <img width="50px" height="50px" src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="image" /></td>
                                        <td> <?= $r['role']; ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="badge badge-pill badge-warning">access</a>
                                            <a href="" class="badge badge-pill badge-success">edit</a>
                                            <a href="" class="badge badge-pill badge-danger">delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="box-footer clearfix">
                <?= $links; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModal">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/role'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Role Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Role</button>
                </div>

            </form>
        </div>
    </div>
</div>