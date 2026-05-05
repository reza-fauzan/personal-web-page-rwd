<?php
require_once 'koneksi.php';

class Studies {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nama, $idlevel, $keterangan, $tahun_lulus, $foto_sekolah) {
        try {
            $query = "INSERT INTO studies (nama, idlevel, keterangan, tahun_lulus, foto_sekolah) 
                      VALUES (:nama, :idlevel, :keterangan, :tahun_lulus, :foto_sekolah)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':idlevel', $idlevel);
            $stmt->bindParam(':keterangan', $keterangan);
            $stmt->bindParam(':tahun_lulus', $tahun_lulus);
            $stmt->bindParam(':foto_sekolah', $foto_sekolah);
            
            if($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Data studies berhasil ditambahkan',
                    'id' => $this->db->lastInsertId()
                ];
            }
            return ['success' => false, 'message' => 'Gagal menambahkan data'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function getAll() {
        try {
            $query = "SELECT s.*, l.nama as nama_level 
                      FROM studies s 
                      INNER JOIN level l ON s.idlevel = l.id 
                      ORDER BY s.tahun_lulus ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function getById($id) {
        try {
            $query = "SELECT s.*, l.nama as nama_level 
                      FROM studies s 
                      INNER JOIN level l ON s.idlevel = l.id 
                      WHERE s.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return null;
        }
    }
    
    public function getByLevel($idlevel) {
        try {
            $query = "SELECT s.*, l.nama as nama_level 
                      FROM studies s 
                      INNER JOIN level l ON s.idlevel = l.id 
                      WHERE s.idlevel = :idlevel 
                      ORDER BY s.tahun_lulus ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idlevel', $idlevel);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    public function update($id, $nama, $idlevel, $keterangan, $tahun_lulus, $foto_sekolah) {
        try {
            $query = "UPDATE studies 
                      SET nama = :nama, 
                          idlevel = :idlevel, 
                          keterangan = :keterangan, 
                          tahun_lulus = :tahun_lulus, 
                          foto_sekolah = :foto_sekolah 
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':idlevel', $idlevel);
            $stmt->bindParam(':keterangan', $keterangan);
            $stmt->bindParam(':tahun_lulus', $tahun_lulus);
            $stmt->bindParam(':foto_sekolah', $foto_sekolah);
            
            if($stmt->execute()) {
                return ['success' => true, 'message' => 'Data studies berhasil diupdate'];
            }
            return ['success' => false, 'message' => 'Gagal mengupdate data'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function updateFoto($id, $foto_sekolah) {
        try {
            $query = "UPDATE studies SET foto_sekolah = :foto_sekolah WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':foto_sekolah', $foto_sekolah);
            
            if($stmt->execute()) {
                return ['success' => true, 'message' => 'Foto sekolah berhasil diupdate'];
            }
            return ['success' => false, 'message' => 'Gagal mengupdate foto'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    public function delete($id) {
        try {
            // Ambil data foto sebelum dihapus untuk menghapus file foto
            $data = $this->getById($id);
            
            $query = "DELETE FROM studies WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()) {
                // Hapus file foto jika ada
                if($data && !empty($data['foto_sekolah']) && file_exists($data['foto_sekolah'])) {
                    unlink($data['foto_sekolah']);
                }
                return ['success' => true, 'message' => 'Data studies berhasil dihapus'];
            }
            return ['success' => false, 'message' => 'Gagal menghapus data'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    public function count() {
        try {
            $query = "SELECT COUNT(*) as total FROM studies";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }
    
    public function countByLevel($idlevel) {
        try {
            $query = "SELECT COUNT(*) as total FROM studies WHERE idlevel = :idlevel";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idlevel', $idlevel);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }
}
?>
