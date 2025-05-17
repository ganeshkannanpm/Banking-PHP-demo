<?php

require 'db.php';

// Check database connection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-openac'])) {

    $fullname = trim($_POST['fullname']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $account_type = trim($_POST['account_type']);
    $pan_number = trim($_POST['pan_number']);

    $photo = isset($_FILES['photo']) ? uploadFile($_FILES['photo'], 'Image') : '';
    $id_proof = isset($_FILES['id_proof']) ? uploadFile($_FILES['id_proof'], 'Id') : '';
    $signature = isset($_FILES['signature']) ? uploadFile($_FILES['signature'], 'Signature') : '';


    $password = trim($_POST['password']);
    $balance = 0.00; // default starting balance

    //Generate random account number
    $account_number = generateAccountNumber();

    //Password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO accounts (fullname, dob, gender, email, phone, address, account_type, 
    pan_number, photo, id_proof, signature, account_number, password, balance)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param(
        "sssssssssssssd",
        $fullname,
        $dob,
        $gender,
        $email,
        $phone,
        $address,
        $account_type,
        $pan_number,
        $photo,
        $id_proof,
        $signature,
        $account_number,
        $hashed_password,
        $balance

    );

    if ($stmt->execute()) {
        echo
            "<script>
                alert('Account created successfully! Your account number is: " . $account_number . "');
                window.location.href = 'index.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function uploadFile($file, $folder) {
    if (!$file || !isset($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return '';
    }

    $targetDir = "assets/uploads/" . $folder . "/";
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
    $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) return '';
    if ($file["size"] > 2 * 1024 * 1024) return '';
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

    $filename = uniqid() . "_" . basename($file["name"]);
    $targetFile = $targetDir . $filename;

    return move_uploaded_file($file["tmp_name"], $targetFile) ? $targetFile : '';
}


//Function for generate random 12-digit account number
function generateAccountNumber()
{
    return 'ACC' . rand(100000000000, 999999999999);
}