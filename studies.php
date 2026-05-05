<?php
// Include controller
require_once 'controllers/StudiesController.php';

// Inisialisasi controller
$controller = new StudiesController($dbh);

// Ambil data untuk edit
$edit = null;
if(isset($_GET['edit'])) {
    $edit = $controller->edit($_GET['edit']);
}

// Ambil semua data
$data = $controller->index();
$levels = $controller->getLevels();
?>

<div class="container-fluid">
    <h2>Data Riwayat Pendidikan</h2>
    <hr>
    
    <div class="row">
        <!-- Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <?php if($edit): ?>
                    Edit Riwayat Pendidikan
                    <?php else: ?>
                    Tambah Riwayat Pendidikan
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <?php if($edit): ?>
                        <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
                        <input type="hidden" name="foto_lama" value="<?php echo $edit['foto_sekolah']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label>Nama Sekolah/Universitas</label>
                            <input type="text" name="nama" class="form-control" 
                                   value="<?php echo $edit ? $edit['nama'] : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Level Pendidikan</label>
                            <select name="idlevel" class="form-control" required>
                                <option value="">-- Pilih Level --</option>
                                <?php foreach($levels as $level): ?>
                                <option value="<?php echo $level['id']; ?>" 
                                    <?php echo ($edit && $edit['idlevel'] == $level['id']) ? 'selected' : ''; ?>>
                                    <?php echo $level['nama']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3"><?php echo $edit ? $edit['keterangan'] : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" class="form-control" 
                                   value="<?php echo $edit ? $edit['tahun_lulus'] : ''; ?>" 
                                   min="1900" max="2100">
                        </div>
                        
                        <div class="form-group">
                            <label>Foto Sekolah</label>
                            <input type="file" name="foto_sekolah" class="form-control-file">
                            <?php if($edit && $edit['foto_sekolah']): ?>
                            <small class="text-muted">Foto saat ini: <?php echo basename($edit['foto_sekolah']); ?></small>
                            <?php endif; ?>
                        </div>
                        
                        <?php if($edit): ?>
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                        <a href="index.php?page=studies" class="btn btn-secondary">Batal</a>
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
                    Daftar Riwayat Pendidikan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sekolah</th>
                                    <th>Level</th>
                                    <th>Tahun Lulus</th>
                                    <th>Foto</th>
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
                                    <td>
                                        <strong><?php echo $row['nama']; ?></strong><br>
                                        <small class="text-muted"><?php echo $row['keterangan']; ?></small>
                                    </td>
                                    <td><?php echo $row['nama_level']; ?></td>
                                    <td><?php echo $row['tahun_lulus']; ?></td>
                                    <td>
                                        <?php if($row['foto_sekolah']): ?>
                                        <img src="<?php echo $row['foto_sekolah']; ?>" 
                                             alt="Foto" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="index.php?page=studies&edit=<?php echo $row['id']; ?>" 
                                           class="btn btn-warning btn-sm">Edit</a>
                                        <a href="index.php?page=studies&hapus=<?php echo $row['id']; ?>" 
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
</div>
