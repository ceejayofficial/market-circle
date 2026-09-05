<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/db.php';

echo "<h2>MarketCircle Database Test</h2>";

try {

    // 1. Confirm database connection
    $database = $pdo->query("SELECT DATABASE()")->fetchColumn();

    echo "<p style='color:green;'>✓ Connected to database: <strong>"
        . htmlspecialchars($database)
        . "</strong></p>";

    // 2. Confirm users table exists
    $table = $pdo->query("SHOW TABLES LIKE 'users'")->fetchColumn();

    if (!$table) {
        die("<p style='color:red;'>✗ users table does not exist.</p>");
    }

    echo "<p style='color:green;'>✓ users table exists.</p>";

    // 3. User information
    $full_name   = "Test User";
    $email       = "test_" . time() . "@marketcircle.com";
    $phone       = "0550000000";
    $gender      = "Male";
    $location    = "Kumasi";
    $gps_address = "Kumasi, Ghana";
    $ghana_card  = "GHA-" . time();
    $password    = "admin";
    $role        = "user";

    // 4. Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 5. Insert
    $sql = "
        INSERT INTO users (
            full_name,
            email,
            phone,
            gender,
            location,
            gps_address,
            ghana_card,
            password,
            role
        )
        VALUES (
            :full_name,
            :email,
            :phone,
            :gender,
            :location,
            :gps_address,
            :ghana_card,
            :password,
            :role
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':full_name'   => $full_name,
        ':email'       => $email,
        ':phone'       => $phone,
        ':gender'      => $gender,
        ':location'    => $location,
        ':gps_address' => $gps_address,
        ':ghana_card'  => $ghana_card,
        ':password'    => $hashed_password,
        ':role'        => $role
    ]);

    // 6. Get inserted ID
    $user_id = $pdo->lastInsertId();

    // 7. Verify from database
    $verify = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $verify->execute([$user_id]);

    $user = $verify->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("<h2 style='color:red;'>✗ Insert ran but record could not be found.</h2>");
    }

    echo "
    <div style='
        margin-top:20px;
        padding:20px;
        background:#dcfce7;
        border:1px solid #22c55e;
        font-family:Arial;
    '>

        <h2 style='color:#15803d;'>
            ✓ USER INSERTED SUCCESSFULLY
        </h2>

        <p><strong>User ID:</strong> {$user_id}</p>

    </div>
    ";

    // 8. Show data before insert
    echo "<h2>USER DATA BEFORE INSERT</h2>";

    echo "<pre>";

    echo "Full Name: {$full_name}\n";
    echo "Email: {$email}\n";
    echo "Phone: {$phone}\n";
    echo "Gender: {$gender}\n";
    echo "Location: {$location}\n";
    echo "GPS Address: {$gps_address}\n";
    echo "Ghana Card: {$ghana_card}\n";
    echo "Original Password: {$password}\n";
    echo "Hashed Password: {$hashed_password}\n";
    echo "Role: {$role}\n";

    echo "</pre>";

    // 9. Show database record
    echo "<h2>DATABASE RECORD</h2>";

    echo "<pre>";
    print_r($user);
    echo "</pre>";

} catch (PDOException $e) {

    echo "
    <div style='
        margin-top:20px;
        padding:20px;
        background:#fee2e2;
        border:1px solid #ef4444;
        color:#991b1b;
        font-family:Arial;
    '>

        <h2>✗ INSERT FAILED</h2>

        <strong>MySQL Error:</strong>

        <pre>"
        . htmlspecialchars($e->getMessage()) .
        "</pre>

    </div>
    ";
}