
<?php
header("Content-Type: application/json");

class DB_con
{
    private $connect;

    public function __construct()
    {
        $this->connect = new PDO(
            "mysql:host=localhost;dbname=dash;charset=utf8mb4",
            "root",
            ""
        );

        $this->connect->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    // Get all users
    public function getUsers()
    {
        $sql = "SELECT id, name, email FROM users";
        return $this->connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one user
    public function getUser($id)
    {
        $sql = "SELECT id, name, email FROM users WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create user
    public function createUser($data)
    {
        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $data["name"],
            $data["email"],
            password_hash($data["password"], PASSWORD_DEFAULT)
        ]);
    }

    // Update user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE users
                SET name = ?, email = ?, password = ?
                WHERE id = ?";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $data["name"],
            $data["email"],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $id
        ]);
    }

    // Delete user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([$id]);
    }
}

header("Content-Type: application/json");


    // Get all users
    public function getUsers()
    {
        $sql = "SELECT id, name, email FROM users";
        return $this->connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one user
    public function getUser($id)
    {
        $sql = "SELECT id, name, email FROM users WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create user
    public function createUser($data)
    {
        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";
        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $data["name"],
            $data["email"],
            password_hash($data["password"], PASSWORD_DEFAULT)
        ]);
    }

    // Update user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE users
                SET name = ?, email = ?, password = ?
                WHERE id = ?";
        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $data["name"],
            $data["email"],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $id
        ]);
    }

    // Delete user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([$id]);
    }
}

// GET API
try {
    $db = new DB_con();

    $method = $_SERVER["REQUEST_METHOD"];
    if (isset($_GET['id'])){
        $id=$_GET['id'];
    }else{
    $id=0;
    }

    if ($method == "GET") {

       

            if ($id > 0) {
                $user = $db->getUser($id);

                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode([
                        "error" => "User not found"
                    ]);
                }
            } else {
                echo json_encode($db->getUsers());
            }

        } else {
            echo json_encode($db->getUsers());
        }

   

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
?>



