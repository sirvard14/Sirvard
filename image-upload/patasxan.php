<?php

$servername = "localhost";
$username = "root";
$password = ""; 
// Create connection
//$conn = new mysqli($servername, $username, $password);
/* $conn = new mysqli($servername, $username, $password,"ikm3shop");
$sql="CREATE DATABASE IF NOT EXISTS ikm3shop";

if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

$sqlUser = "CREATE TABLE IF NOT EXISTS user(
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    )";
if($conn->query($sqlUser)===TRUE){
    echo "Tabel Created successfully";

}else{
    echo "error creating table:" . $conn->error;
} */


$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "CREATE DATABASE IF NOT EXISTS ikm3shop";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    die("Error creating database: " . $conn->error);
}


$conn = new mysqli($servername, $username, $password, "ikm3shop");

$sqlUser = "CREATE TABLE IF NOT EXISTS user(
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    Email VARCHAR(50),
    Passwords VARCHAR(50),
    ConfirmPassword VARCHAR(50),
    username VARCHAR(50),
    PhoneNumber VARCHAR(50),
    DateOfBirth VARCHAR(50),
    Gender  VARCHAR(50),
    AddressOfUser VARCHAR(50),



)";

if ($conn->query($sqlUser) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}







  session_start();
  var_dump($_SESSION);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $errors = [];
    
    // Անուն
    $name = trim($_POST['name'] ?? '');
    if (empty($name)) {
        $errors[] = "Անունը պարտադիր է";
    } elseif (!preg_match("/^[a-zA-Zա-ֆԱ-Ֆ\s]+$/u", $name)) {
        $errors[] = "Անունը չպետք է պարունակի թվեր կամ սիմվոլներ";
    }
    
    // Ազգանուն
    $lastName = trim($_POST['second-name'] ?? '');
    if (empty($lastName)) {
        $errors[] = "Ազգանունը պարտադիր է";
    } elseif (!preg_match("/^[a-zA-Zա-ֆԱ-Ֆ\s]+$/u", $lastName)) {
        $errors[] = "Ազգանունը չպետք է պարունակի թվեր կամ սիմվոլներ";
    }
    
    // Էլ. փոստ
    $email = trim($_POST['my-email'] ?? '');
    if (empty($email)) {
        $errors[] = "Էլ. փոստը պարտադիր է";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Էլ. փոստի ֆորմատը սխալ է";
    }
    
    // Գաղտնաբառ
    $password = $_POST['password'] ?? '';
    if (empty($password)) {
        $errors[] = "Գաղտնաբառը պարտադիր է";
    }
    
    // Գաղտնաբառի հաստատում
    $confirmed = $_POST['confirmed'] ?? '';
    if (empty($confirmed)) {
        $errors[] = "Գաղտնաբառի հաստատումը պարտադիր է";
    } elseif ($password !== $confirmed) {
        $errors[] = "Գաղտնաբառերը չեն համընկնում";
    }
    
    // Օգտանուն
    $username = trim($_POST['user-name'] ?? '');
    if (empty($username)) {
        $errors[] = "Օգտանունը պարտադիր է";
    }
    
    // Հեռախոսահամար
    $phone = trim($_POST['phone'] ?? '');
    if (empty($phone)) {
        $errors[] = "Հեռախոսահամարը պարտադիր է";
    } elseif (!preg_match("/^\+374\s\d{2}\s\d{3}\s\d{3}$/", $phone)) {
        $errors[] = "Հեռախոսահամարը պետք է լինի +374 00 000 000 ֆորմատով";
    }
    
    // Ծննդյան ամսաթիվ և տարիք
    $dob = $_POST['date'] ?? '';
    if (empty($dob)) {
        $errors[] = "Ծննդյան ամսաթիվը պարտադիր է";
    } else {
        $birthDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        
        if ($age < 18) {
            $errors[] = "Դուք պետք է լինեք 18 տարեկան կամ ավելի մեծ";
        }
    }
    
    // Սեռ
    $gender = $_POST['gender'] ?? '';
    if (empty($gender)) {
        $errors[] = "Սեռը պարտադիր է ընտրել";
    }
    
    // Նկարի մշակում
    $uploadedImage = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $file = $_FILES['profile_image'];
        $fileSize = $file['size'];
        $fileTmpName = $file['tmp_name'];
        $fileType = $file['type'];
        $fileName = $file['name'];
        
        // Ստուգում՝ արդյոք ֆայլը նկար է
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Կարող եք ներբեռնել միայն նկարներ (JPEG, PNG, GIF)";
        }
        
        // Ստուգում՝ արդյոք չափը 5MB-ից փոքր է
        $maxSize = 5 * 1024 * 1024; // 5MB բայթերով
        if ($fileSize > $maxSize) {
            $errors[] = "Նկարի ծավալը չպետք է գերազանցի 5MB-ը";
        }
        
        // Եթե սխալներ չկան, պահպանել նկարը
        if (empty($errors)) {
            $uploadDir = 'uploads/'; // Ստեղծեք այս folder-ը ձեր նախագծի մեջ
            
            // Ստուգում՝ արդյոք uploads թղթապանակը գոյություն ունի
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Ստեղծել եզակի անուն ֆայլի համար
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
            $destination = $uploadDir . $newFileName;
            
            // Տեղափոխել ֆայլը
            if (move_uploaded_file($fileTmpName, $destination)) {
                $uploadedImage = $destination;
            } else {
                $errors[] = "Նկարի պահպանման սխալ";
            }
        }
    }
    
    $_SESSION['errors'] = $errors;
    header("Location: das_form.php");
    exit();
    
    // Եթե սխալներ կան՝ ցուցադրել
    if (!empty($errors)) {
        echo "<!DOCTYPE html>
<html lang='hy'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Սխալներ</title>
    <style>
        body {
            background-color: #a9c9fc;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .error-container {
            background-color: #ffcccc;
            border: 2px solid red;
            border-radius: 10px;
            padding: 20px;
            max-width: 500px;
            margin: 20px auto;
        }
        h2 {
            color: #cc0000;
        }
        ul {
            text-align: left;
            display: inline-block;
        }
        li {
            margin: 10px 0;
            color: #cc0000;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: white;
            color: #333;
            text-decoration: none;
            border: 1px solid #333;
            border-radius: 5px;
        }
        a:hover {
            background-color: #e6e6e6;
        }
    </style>
</head>
<body>
    <div class='error-container'>
        <h2>Սխալներ գրանցման ժամանակ</h2>
        <ul>";
        
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        
        echo "</ul>
        <a href='das_form.php'>Վերադառնալ ձևի էջ</a>
    </div>
</body>
</html>";
    } else {
        // Հաջող գրանցում
      $sqlInsert = "INSERT INTO user (firstName, lastName,Email,Passwords,ConfirmPassword,username,PhoneNumber,DateOfBirth,Gender,AddressOfUser)
      VALUES ('" . $_POST['name'] . "', '" . $_POST['second-name'] . "')";//values sharunake; tun@
      

        echo "<!DOCTYPE html>
<html lang='hy'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Հաջողություն</title>
    <style>
        body {
            background-color: #a9c9fc;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .success-container {
            background-color: #ccffcc;
            border: 2px solid green;
            border-radius: 10px;
            padding: 20px;
            max-width: 500px;
            margin: 20px auto;
        }
        h2 {
            color: #006600;
        }
        .info {
            text-align: left;
            display: inline-block;
            margin: 20px 0;
        }
        .info p {
            margin: 10px 0;
        }
        .profile-image {
            max-width: 200px;
            max-height: 200px;
            margin: 15px 0;
            border-radius: 10px;
            border: 2px solid #006600;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: white;
            color: #333;
            text-decoration: none;
            border: 1px solid #333;
            border-radius: 5px;
        }
        a:hover {
            background-color: #e6e6e6;
        }
    </style>
</head>
<body>
    <div class='success-container'>
        <h2>Գրանցումը հաջողվեց!</h2>";
        
        if (!empty($uploadedImage)) {
            echo "<img src='" . htmlspecialchars($uploadedImage) . "' alt='Նկար' class='profile-image'>";
        }
        
        echo "<div class='info'>
            <p><strong>Անուն:</strong> " . htmlspecialchars($name) . "</p>
            <p><strong>Ազգանուն:</strong> " . htmlspecialchars($lastName) . "</p>
            <p><strong>Էլ. փոստ:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Օգտանուն:</strong> " . htmlspecialchars($username) . "</p>
            <p><strong>Հեռախոսահամար:</strong> " . htmlspecialchars($phone) . "</p>
            <p><strong>Ծննդյան ամսաթիվ:</strong> " . htmlspecialchars($dob) . "</p>
            <p><strong>Սեռ:</strong> " . htmlspecialchars($gender) . "</p>
            <p><strong>Տարիք:</strong> " . $age . " տարեկան</p>
        </div>
        <a href='das_form.php'>Վերադառնալ ձևի էջ</a>
    </div>
</body>
</html>";
    }
} else {
  //  header("Location: das_form.php");
   // exit();
}

?>