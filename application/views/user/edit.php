<style>
    .kbw-signature {
        height: 250px;
        width: 100%;
    }

    /* mengatur ukuran canvas tanda tangan  */
            canvas {
                border: 1px solid #ccc;
                border-radius: 0.5rem;
                width: 100%;
                height: 400px;
            }
</style>
<div class="row">
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title; ?></h3>
            </div>
            <!-- <form accept="<?= base_url('user/edit') ?>" class="form-horizontal" method="POST"> -->
            <?php $attributes = array('class' => 'form-horizontal', 'id' => 'formuser'); ?>
            <?= form_open_multipart('user/edit', $attributes); ?>
            <div class="box-body">
                <div class="form-group">
                    <label for="pd_nickname" class="col-sm-2 control-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pd_nickname" name="pd_nickname" autocomplete="off" value="<?= $user['pd_nickname']; ?>">
                        <?= form_error('pd_nickname', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
				<div class="form-group">
                    <label for="no_identitas" class="col-sm-2 control-label">No Identitas</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_identitas" autocomplete="off" name="no_identitas" value="<?= $user['no_identitas']; ?>">
                        <?= form_error('no_identitas', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <!-- <div class="form-group">
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
                </div> -->
				<div class="form-group">
                    <label for="tanggal_lahir" class="col-sm-2 control-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_lahir" autocomplete="off" name="tanggal_lahir" value="<?= $user['tanggal_lahir']; ?>">
                        <?= form_error('tanggal_lahir', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="alamat" autocomplete="off" name="alamat"><?= $user['alamat']; ?></textarea>
                        <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_telp" class="col-sm-2 control-label">No Telepon</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_telp" autocomplete="off" name="no_telp" value="<?= $user['no_telp']; ?>" >
                        <?= form_error('no_telp', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="userlevelid" class="col-sm-2 control-label">Ruang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="userlevelid" autocomplete="off" name="userlevelid" value="<?= getRuangan($user['userlevelid'],'userlevelname'); ?>" readonly>
                        <?= form_error('userlevelid', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nip" class="col-sm-2 control-label">Nip</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nip" autocomplete="off" name="nip" value="<?= $user['nip']; ?>">
                        <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tanggal_masuk_kerja" class="col-sm-2 control-label">Tanggal Masuk Kerja</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_masuk_kerja" autocomplete="off" name="tanggal_masuk_kerja" value="<?= $user['tanggal_masuk_kerja']; ?>">
                        <?= form_error('tanggal_masuk_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
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
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
        <script>
            // script di dalam ini akan dijalankan pertama kali saat dokumen dimuat
            document.addEventListener('DOMContentLoaded', function () {
                resizeCanvas();
            })
    
            //script ini berfungsi untuk menyesuaikan tanda tangan dengan ukuran canvas
            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }
    
    
            var canvas = document.getElementById('signature-pad');
    
            //warna dasar signaturepad
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
    
            //saat tombol clear diklik maka akan menghilangkan seluruh tanda tangan
            document.getElementById('clear').addEventListener('click', function () {
                signaturePad.clear();
            });
    
            //saat tombol undo diklik maka akan mengembalikan tanda tangan sebelumnya
            document.getElementById('undo').addEventListener('click', function () {
                var data = signaturePad.toData();
                if (data) {
                    data.pop(); // remove the last dot or line
                    signaturePad.fromData(data);
                }
            });
    
            //saat tombol change color diklik maka akan merubah warna pena
            document.getElementById('change-color').addEventListener('click', function () {
    
                //jika warna pena biru maka buat menjadi hitam dan sebaliknya
                if(signaturePad.penColor == "rgba(0, 0, 255, 1)"){
    
                    signaturePad.penColor = "rgba(0, 0, 0, 1)";
                }else{
                    signaturePad.penColor = "rgba(0, 0, 255, 1)";
                }
            })
    
            //fungsi untuk menyimpan tanda tangan dengan metode ajax
            $(document).on('click', '#btn-submit', function () {
                var signature = signaturePad.toDataURL();
    
                $.ajax({
                    url: "proses.php",
                    data: {
                        foto: signature,
                    },
                    method: "POST",
                    success: function () {
                        location.reload();
                        alert('Tanda Tangan Berhasil Disimpan');
                    }
    
                })
            })
        </script>