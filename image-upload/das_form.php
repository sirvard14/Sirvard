<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>

    <style>
        body {
            background-color: #a9c9fc;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .container {
            border: 2px solid blue;
            padding: 20px;
            width: 400px;
            margin: auto;
            background-color: #FCDCA9;
            border-radius: 10px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            background-color: #FCDCA9;
        }

        input, textarea, select {
            width: 80%;
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #555;
            margin-top: 5px;
        }

        textarea {
            height: 80px;
            resize: none;
        }

        button {
            margin-top: 15px;
            border-radius: 20%;
            height: 35px;
            width: 80px;
            background-color: white;
            border: 1px solid #333;
            cursor: pointer;
        }

        button:hover {
            background-color: #e6e6e6;
        }
    </style>
</head>

<body>

    <h1>REGISTRATION PAGE</h1>

    <div class="container">
        <form method="POST" action="patasxan.php" enctype="multipart/form-data">

            <label for="fname">First Name</label>
            <input type="text" name="name" id="fname" placeholder="Enter first name">

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="second-name" placeholder="Enter last name">

            <label for="email">Email</label>
            <input type="email" id="email" name="my-email" placeholder="example@mail.com">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password">

            <label for="confirm">Confirm Password</label>
            <input type="password" id="confirm"  name="confirmed" placeholder="Confirm password">

            <label for="username">Username</label>
            <input type="text" id="username" name=user-name placeholder="Enter username">

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="+374...">

            <label for="dob">Date of Birth</label>
            <input type="date" name="date" id="dob">

            <label>Gender</label>
            <div style="background:#FCDCA9;">
                <label><input type="radio" name="gender" value="male"> Male</label>
                <label><input type="radio" name="gender" value="female"> Female</label>
            </div>

            <label for="address">Address</label>
            <textarea id="address" placeholder="Enter your address"></textarea>

            <label for="profile_image">Նկար (առավելագույնը 5MB)</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">

            <button type="submit">SEND</button>
            
        </form>
    </div>

</body>
</html>