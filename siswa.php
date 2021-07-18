<?php
require 'connection.php';
checkLogin();
$siswa = mysqli_query($conn, "SELECT * FROM warga ORDER BY nama_warga ASC");
if (isset($_POST['btnEditSiswa'])) {
  if (editSiswa($_POST) > 0) {
    setAlert("Siswa has been changed", "Successfully changed", "success");
    header("Location: siswa.php");
  }
}

if (isset($_POST['btnTambahSiswa'])) {
  if (addSiswa($_POST) > 0) {
    setAlert("Siswa has been added", "Successfully added", "success");
    header("Location: siswa.php");
  }
}
if (isset($_GET['toggle_modal'])) {
  $toggle_modal = $_GET['toggle_modal'];
  echo "
    <script>
      $(document).ready(function() {
        $('#$toggle_modal').modal('show');
      });
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>

<head>
  <?php include 'include/css.php'; ?>
  <title>Data Warga</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include 'include/navbar.php'; ?>

    <?php include 'include/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row justify-content-center mb-2">
            <div class="col-sm text-left">
              <h1 class="m-0 text-dark">WARGA DESA PUNDENREJO</h1>
            </div><!-- /.col -->
            <div class="col-sm text-right">
              <?php if ($_SESSION['id_jabatan'] !== '3') : ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSiswaModal"><i class="fas fa-fw fa-plus"></i> Tambah Warga</button>
                <!-- Modal -->
                <div class="modal fade text-left" id="tambahSiswaModal" tabindex="-1" role="dialog" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form method="post">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Data Warga</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <div class="form-group">
                            <label for="nik">nik</label>
                            <input type="number" id="nik" name="nik" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="nama_warga">Nama_warga</label>
                            <input type="text" id="nama_warga" name="nama_warga" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label>Jenis Kelamin</label><br>
                            <input type="radio" id="pria" name="jenis_kelamin" value="pria"> <label for="pria">Pria</label> |
                            <input type="radio" id="wanita" name="jenis_kelamin" value="wanita"> <label for="wanita">Wanita</label>
                          </div>
                          <div class="form-group">
                            <label for="alamat">alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" required>
                          </div>

                          <div class="form-group">
                            <label for="no_rumah">No. rumah</label>
                            <input type="number" name="no_rumah" id="no_rumah" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="status">status</label>
                            <input type="text" name="status" id="status" class="form-control">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Close</button>
                          <button type="submit" class="btn btn-primary" name="btnTambahSiswa"><i class="fas fa-fw fa-save"></i> Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              <?php endif ?>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table_id">
                  <thead>
                    <tr>
                      <th>id_warga</th>
                      <th>nik</th>
                      <th>nama_warga</th>
                      <th>jenis_kelamin</th>
                      <th>alamat</th>
                      <th>no_rumah</th>
                      <th>status</th>
                      <?php if ($_SESSION['id_jabatan'] !== '3') : ?>
                        <th>Aksi</th>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($siswa as $ds) : ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?= ucwords(htmlspecialchars_decode($ds['nik'])); ?></td>
                        <td><?= ucwords($ds['nama_warga']); ?></td>
                        <td><?= $ds['jenis_kelamin']; ?></td>
                        <td><?= $ds['alamat']; ?></td>
                        <td><?= $ds['no_rumah']; ?></td>
                        <td><?= $ds['status']; ?></td>


                        <?php if ($_SESSION['id_jabatan'] !== '3') : ?>
                          <td>
                            <!-- Button trigger modal -->
                            <a href="ubah_siswa.php?id_siswa=<?= $ds['id_warga']; ?>" class="badge badge-success" data-toggle="modal" data-target="#editSiswa<?= $ds['id_warga']; ?>">
                              <i class="fas fa-fw fa-edit"></i> Ubah
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="editSiswa<?= $ds['id_warga']; ?>" tabindex="-1" role="dialog" aria-labelledby="editSiswa<?= $ds['id_warga']; ?>" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form method="post">
                                  <input type="hidden" name="id_warga" value="<?= $ds['id_warga']; ?>">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editSiswaModalLabel<?= $ds['id_warga']; ?>">Ubah Data Warga</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">

                                      <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="number" id="nik" name="nik" class="form-control" required>
                                      </div>
                                      <div class="form-group">
                                        <label for="nama_warga">Nama Warga</label>
                                        <input type="text" id="nama_warga" name="nama_warga" class="form-control" required>
                                      </div>
                                      <div class="form-group">
                                        <label>Jenis Kelamin</label><br>
                                        <input type="radio" id="pria" name="jenis_kelamin" value="pria"> <label for="pria">Pria</label> |
                                        <input type="radio" id="wanita" name="jenis_kelamin" value="wanita"> <label for="wanita">Wanita</label>
                                      </div>
                                      <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" id="alamat" name="alamat" class="form-control" required>
                                      </div>
                                      <div class="form-group">
                                        <label for="no_rumah">No. Rumah</label>
                                        <input type="number" name="no_rumah" id="no_rumah" class="form-control">
                                      </div>
                                      <div class="form-group">
                                        <label for="status">Status</label>
                                        <input type="text" name="status" id="status" class="form-control">
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Close</button>
                                      <button type="submit" class="btn btn-primary" name="btnEditSiswa"><i class="fas fa-fw fa-save"></i> Save</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <?php if ($_SESSION['id_jabatan'] == '1') : ?>
                              <a data-nama="<?= $ds['nama_warga']; ?>" class="btn-delete badge badge-danger" href="hapus_siswa.php?id_warga=<?= $ds['id_warga']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                            <?php endif ?>
                          </td>
                        <?php endif ?>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong> Yusup Jhonpe</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">

      </div>
    </footer>

  </div>
</body>

</html>