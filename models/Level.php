<?php
require_once 'koneksi.php';

class Level {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    public function create($nama) {
        try {
            $query = "INSERT INTO level (nama) VALUES (:nama)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama', $nama);
            
            if($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Data level berhasil ditambahkan',
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
            $query = "SELECT * FROM level ORDER BY id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function getById($id) {
        try {
            $query = "SELECT * FROM level WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return null;
        }
    }
    
    public function update($id, $nama) {
        try {
            $query = "UPDATE level SET nama = :nama WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama', $nama);
            
            if($stmt->execute()) {
                return ['success' => true, 'message' => 'Data level berhasil diupdate'];
            }
            return ['success' => false, 'message' => 'Gagal mengupdate data'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    public function delete($id) {
        try {
            // Cek apakah level masih digunakan di tabel studies
            $checkQuery = "SELECT COUNT(*) as total FROM studies WHERE idlevel = :id";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->bindParam(':id', $id);
            $checkStmt->execute();
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if($result['total'] > 0) {
                return [
                    'success' => false, 
                    'message' => 'Level tidak bisa dihapus karena masih digunakan di data studies'
                ];
            }
            
            $query = "DELETE FROM level WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()) {
                return ['success' => true, 'message' => 'Data level berhasil dihapus'];
            }
            return ['success' => false, 'message' => 'Gagal menghapus data'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function count() {
        try {
            $query = "SELECT COUNT(*) as total FROM level";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }
}
?>
