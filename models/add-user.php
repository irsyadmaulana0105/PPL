<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pecos_menu";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['name'], $_POST['generated_code'], $_POST['role'])) {
        $name = $_POST['name'];
        $generatedCode = $_POST['generated_code'];
        $role = $_POST['role']; // Assuming role is sent via POST
        
        try {
            $stmt = $conn->prepare("SELECT `id_meja` FROM `user` WHERE `id_meja` = :name");
            $stmt->execute(['name' => $name]);

            $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($nameExist)) {
                $conn->beginTransaction();

                $insertStmt = $conn->prepare("INSERT INTO `user` (`id_meja`, `generated_code`, `role`) VALUES (:id_meja, :generated_code, :role)");
                $insertStmt->bindParam(':id_meja', $name, PDO::PARAM_STR);
                $insertStmt->bindParam(':generated_code', $generatedCode, PDO::PARAM_STR);
                $insertStmt->bindParam(':role', $role, PDO::PARAM_STR);

                $insertStmt->execute();

                $conn->commit(); 

                echo "
                <script>
                    alert('Registered Successfully!');
                    window.location.href = '/mvcpecos/views/auth/register.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Account Already Exist!');
                    window.location.href = '/mvcpecos/views/auth/register.php';
                </script>
                ";
            }

        } catch (PDOException $e) {
            // $conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
    