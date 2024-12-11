<?php
$servername = "localhost";
$username = "root"; // default username for XAMPP/WAMP/MAMP
$password = ""; // default password for XAMPP/WAMP/MAMP is empty
$dbname = "users_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['loginUsername']) && isset($_POST['loginPassword'])) {
        // Login form submitted
        $loginUsername = $_POST['loginUsername'];
        $loginPassword = $_POST['loginPassword'];
        
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $loginUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($loginPassword, $row['password'])) {
                echo "<script>
                        alert('Login successful');
                        window.location.href='home.html';
                      </script>";
            } else {
                echo "<script>
                        alert('Invalid password');
                        window.history.back();
                      </script>";
            }
        } else {
            echo "<script>
                    alert('No user found');
                    window.history.back();
                  </script>";
        }
    } elseif (isset($_POST['signupUsername']) && isset($_POST['signupPassword']) && isset($_POST['confirmPassword'])) {
        // Signup form submitted
        $signupUsername = $_POST['signupUsername'];
        $signupPassword = $_POST['signupPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($signupPassword == $confirmPassword) {
            $hashedPassword = password_hash($signupPassword, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $signupUsername, $hashedPassword);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Signup successful');
                        window.location.href='home.html';
                      </script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>
                    alert('Passwords do not match');
                    window.history.back();
                  </script>";
        }
    }
}

$conn->close();
?>
