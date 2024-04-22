      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark"><?= $subtitle; ?></h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
                          <li class="breadcrumb-item active"><?= $subtitle; ?></li>
                      </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <!-- disini -->

      <?php if ($this->session->flashdata('external_message_push')) : ?>
          <?php $message = $this->session->flashdata('external_message_push'); ?>
          <?php switch ($message["metaData"]["code"]) {
                case 200:
                    echo '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check"></i> Status</h5>
                                    ' . $message["metaData"]["message"] . '
                                    </div>
                                </div>
                            </div>';
                    break;
                case 201:
                    echo '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Status</h5>
                                    ' . $message["metaData"]["message"] . '
                                    </div>
                                </div>
                            </div>';
                    break;
                default:
                    echo '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Status</h5>
                                ' . $message["metaData"]["message"] . '
                                </div>
                            </div>
                        </div>';
            } ?>
      <?php endif; ?>