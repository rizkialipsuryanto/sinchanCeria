      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Dashboard</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Dashboard v1</li>
                      </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row">

                  <div class="col-12">
                      <div class="card">
                          <div class="card-header">
                              <h3 class="card-title">DataTable with minimal features & hover style</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                              <h1>Heading</h1>
                              <div class="paging"><?php echo $pagination; ?></div>
                              <div class="data"><?php echo $table; ?></div>
                              <div class="paging"><?php echo $pagination; ?></div><br />
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->

                      <!-- /.card -->
                  </div>
                  <!-- /.col -->



              </div>
              <!-- /.row -->

          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->