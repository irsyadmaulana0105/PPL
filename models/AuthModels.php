<?php

class Auth {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function log($code) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE generated_code = ?");
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['id_meja'] = $row["id_meja"];
                $_SESSION['role'] = $row["role"];  
                return $row["role"];
            } else {
                echo "gagal";
                return null;
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Sesuaikan dengan kebutuhan Anda
    public function redirectBasedOnRole($role) {
        if ($role === 'user') {
            header("Location: /mvcpecos/");
            exit();
        } elseif ($role === 'employee') {
            header("Location: /mvcpecos/views/pegawai/index.php");
            exit();
        } else {
            // Handle other roles or scenarios
        }
    }
}

?>
