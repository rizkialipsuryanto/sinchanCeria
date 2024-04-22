<style>
    .kbw-signature {
        height: 250px;
        width: 100%;
    }
</style>
<div class="row">
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?></h3>
            </div>
            <?php $attributes = array('class' => 'form-horizontal', 'id' => 'formuser'); ?>
            <?= form_open_multipart('user/edit', $attributes); ?>
            <div class="box-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Firtsname</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="firstname" name="firstname" autocomplete="off" value="<?= $user['firstname']; ?>">
                        <?= form_error('firstname', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Lastname</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="lastname" autocomplete="off" name="lastname" value="<?= $user['lastname']; ?>">
                        <?= form_error('lastname', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Foto Profil</label>



                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                                </div>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Pilih Foto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ruang</label>
                    <div class="col-sm-10">
                        <select class="form-control input-sm" id="ruang" name="ruang">
                            <option value=""> -- Ruang -- </option>
                            <?php if (!empty($ruang)) : ?>
                                <?php foreach ($ruang as $ru) : ?>
                                    <option value="<?= $ru['userlevelid']; ?>" <?php if ($user['ruang'] == $ru['userlevelid']) echo 'selected="selected"'; ?>><?= $ru['userlevelname']; ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Ruang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ruang" name="ruang" autocomplete="off" value="<?= $user['ruang']; ?>">
                        <?= form_error('raung', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div> -->

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Tanda Tangan</label>



                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-6">

                            <?php if ($user["signature"]) : ?>
                                <img id="salinan" width="250" height="150" src="<?= $user["signature"]; ?>" class="resize" alt="tanda tangan petugas">
                            <?php else : ?>
                                <div class="row">
                                    <div id="tandatangan"></div>
                                    <input type="hidden" class="form-control input-sm" value="" id="json" name="json">
                                    <label class="text-danger">tanda tangan hanya bisa disimpan satu kali, apabila perlu perubahan silakan hubungi IT</label>
                                </div>
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-default">Cancel</button>

                    <button type="submit" class="btn btn-info pull-right" id="formatjson">Edit</button>
                </div>

                </form>
                <!-- <button id="formatjson" class="btn btn-info">Format ke JSON</button> -->
                <br>
            </div>
        </div>
    </div>