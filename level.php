<?php
// Include controller
require_once 'controllers/LevelController.php';

// Inisialisasi controller
$controller = new LevelController($dbh);

// Ambil data untuk edit
$edit = null;
if(isset($_GET['edit'])) {
    $edit = $controller->edit($_GET['edit']);
}

// Ambil semua data
$data = $controller->index();
?>

<div class="container-fluid">
    <h2>Data Level Pendidikan</h2>
    <hr>
    
    <div class="row">
        <!-- Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <?php if($edit): ?>
                    Edit Level
                    <?php else: ?>
                    Tambah Level
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php if($edit): ?>
                        <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label>Nama Level</label>
                            <input type="text" name="nama" class="form-control" 
                                   value="<?php echo $edit ? $edit['nama'] : ''; ?>" required>
                        </div>
                        
                        <?php if($edit): ?>
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                        <a href="index.php?page=level" class="btn btn-secondary">Batal</a>
                        <?php else: ?>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Daftar Level
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($data as $row): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td>
                                    <a href="index.php?page=level&edit=<?php echo $row['id']; ?>" 
                                       class="btn btn-warning btn-sm">Edit</a>
                                    <a href="index.php?page=level&hapus=<?php echo $row['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin hapus?')">Hapus</a>
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
