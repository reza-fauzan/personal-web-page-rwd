<?php
require_once 'koneksi.php';

class Member {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // Cek login berdasarkan email dan password
    public function login($email, $password) {
        try {
            $query = "SELECT * FROM member WHERE email = :email AND password = :password";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($result) {
                return [
                    'success' => true,
                    'data' => $result
                ];
            }
            return ['success' => false, 'message' => 'Email atau password salah'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    // Ambil data member berdasarkan ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM member WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return null;
        }
    }
    
    // Ambil data member berdasarkan email
    public function getByEmail($email) {
        try {
            $query = "SELECT * FROM member WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return null;
        }
    }
    
    // Ambil semua member
    public function getAll() {
        try {
            $query = "SELECT * FROM member ORDER BY id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Tambah member baru
    public function create($fullname, $email, $password, $role, $foto) {
        try {
            $query = "INSERT INTO member (fullname, email, password, role, foto) 
                      VALUES (:fullname, :email, :password, :role, :foto)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':foto', $foto);
            
            if($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Member berhasil ditambahkan',
                    'id' => $this->db->lastInsertId()
                ];
            }
            return ['success' => false, 'message' => 'Gagal menambahkan member'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    // Update member
    public function update($id, $fullname, $email, $password, $role, $foto) {
        try {
            $query = "UPDATE member 
                      SET fullname = :fullname, 
                          email = :email, 
                          password = :password, 
                          role = :role, 
                          foto = :foto 
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':foto', $foto);
            
            if($stmt->execute()) {
                return ['success' => true, 'message' => 'Member berhasil diupdate'];
            }
            return ['success' => false, 'message' => 'Gagal mengupdate member'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    // Hapus member
    public function delete($id) {
        try {
            $query = "DELETE FROM member WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()) {
                return ['success' => true, 'message' => 'Member berhasil dihapus'];
            }
            return ['success' => false, 'message' => 'Gagal menghapus member'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    // Cek jumlah admin
    public function countAdmin() {
        try {
            $query = "SELECT COUNT(*) as total FROM member WHERE role = 'admin'";
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
