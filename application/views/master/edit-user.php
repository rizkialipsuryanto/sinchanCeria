<style>
    .kbw-signature {
        height: 250px;
        width: 100%;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?></h3>
            </div>
            <form action="<?= base_url('user/updateUser') ?>" class="form-horizontal" method="POST">
	            <div class="box-body">
	                <div class="form-group">
	                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
	                    <div class="col-sm-10">
	                    	<input type="hidden" class="form-control" id="id" name="id" value="<?= $validation[0]['id']; ?>" >
	                        <input type="email" class="form-control" id="email" name="email" value="<?= $validation[0]['email']; ?>" readonly>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Nama Depan</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="namadepan" name="namadepan" value="<?= $validation[0]['firstname']; ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Nama Belakang</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="namabelakang" name="namabelakang" value="<?= $validation[0]['lastname']; ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Role</label>
	                    <div class="col-sm-10">
	                        <select class="form-control input-sm select2" id="role" name="role">
	                        	<option value=""> -- Role -- </option>
	                        	<?php if (!empty($role)) : ?>
	                        		<?php foreach ($role as $ro) : ?>
	                        			<option value="<?= $ro['id']; ?>" <?php if($validation[0]['role_id']== $ro['id']) echo 'selected="selected"'; ?>><?= $ro['role']; ?></option>
	                        		<?php endforeach ?>
	                        	<?php endif ?>
	                        </select>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Status</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="status" name="status" value="<?= $validation[0]['is_active']; ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">NIK</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $validation[0]['nik']; ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Nomor Hp</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nohp" name="nohp" value="<?= $validation[0]['nohp']; ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Alamat</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $validation[0]['alamat']; ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Ruang</label>
	                    <div class="col-sm-10">
	                        <select class="form-control input-sm" id="ruang" name="ruang">
	                        	<option value=""> -- Ruang -- </option>
	                        	<?php if (!empty($ruang)) : ?>
	                        		<?php foreach ($ruang as $ru) : ?>
	                        			<option value="<?= $ru['userlevelid']; ?>" <?php if($validation[0]['ruang']== $ru['userlevelid']) echo 'selected="selected"'; ?>><?= $ru['userlevelname']; ?></option>
	                        		<?php endforeach ?>
	                        	<?php endif ?>
	                        </select>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Pegawai</label>
	                    <div class="col-sm-10">
	                        <select class="form-control input-sm select2" id="pegawaiid" name="pegawaiid">
	                        	<option value=""> -- Pilih Pegawai -- </option>
	                        	<?php if (!empty($pegawai)) : ?>
	                        		<?php foreach ($pegawai as $pj) : ?>
	                        			<option value="<?= $pj['uid']; ?>" <?php if($validation[0]['pegawai_id']== $pj['uid']) echo 'selected="selected"'; ?>><?= $pj['pd_nickname']; ?>, <?= $pj['userlevelname']; ?></option>
	                        		<?php endforeach ?>
	                        	<?php endif ?>
	                        </select>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-sm-2 control-label">Tasks</label>
	                    <div class="col-sm-10">
	                        <select class="form-control input-sm select2" id="tasks" name="tasks">
	                        	<option value=""> -- Tasks -- </option>
	                        	<?php if (!empty($tasks)) : ?>
	                        		<?php foreach ($tasks as $pl) : ?>
	                        			<option value="<?= $pl['id']; ?>" <?php if($validation[0]['tasks']== $pl['id']) echo 'selected="selected"'; ?> ><?= $pl['tasks']; ?>, <?= getPoli($pl["ruang"], "userlevelname"); ?></option>
	                        		<?php endforeach ?>
	                        	<?php endif ?>
	                        </select>
	                    </div>
	                </div>
	                 <div class="pull-right">
	                 	<button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
	                 	<button type="button" class="btn btn-secondary">Close</button>
	                 </div>
	            </div>
            </form>
        </div>
    </div>
</div>