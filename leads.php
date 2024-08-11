<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to MySQL Database
    $conn = new mysqli('localhost', 'u299653610_test67', '22211161@Vknke', 'u299653610_testapi');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize form data
    $store_name = $conn->real_escape_string($_POST['store_name']);
    $address = $conn->real_escape_string($_POST['address']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);

    // Generate the subdomain
    $subdomain = strtolower(str_replace(' ', '', $store_name)) . '.api.madlyscale.com';

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO leads (store_name, subdomain, address, phone, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $store_name, $subdomain, $address, $phone, $email);

    if ($stmt->execute()) {
        // Redirect to the payment page
        header("Location: payment.php?subdomain=$subdomain");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Collection</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { max-width: 600px; margin: auto; }
        label { display: block; margin: 10px 0 5px; }
        input[type="text"], input[type="email"] { width: 100%; padding: 8px; }
        input[type="submit"] { padding: 10px 15px; background-color: #007BFF; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Lead Collection Form</h1>
    <form method="POST" action="">
        <label for="store_name">Store Name:</label>
        <input type="text" id="store_name" name="store_name" required>

        <label for="address">Store Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>

        <input type="submit" value="Submit Lead">
    </form>
</body>
</html>
