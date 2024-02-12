<?php
session_start(); // Start the session

// Database Connection
$servername = "localhost";
$username = "root";   // Default XAMPP username
$password = "";       // Default XAMPP has no password
$dbname = "stud"; // Replace with your database name
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getRealIpAddr() {
    return '127.0.0.1';
}

$isUserLoggedIn = isset($_SESSION['isUserLoggedIn']) ? $_SESSION['isUserLoggedIn'] : false;
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// User Registration Logic
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $created = date('Y-m-d H:i:s');
    $ip = getRealIpAddr();
    $role = isset($_POST['role']) ? $_POST['role'] : 'customer'; // Get role from the form

    $stmt = $conn->prepare("INSERT INTO zahi_elhelou_users (username, email, password, created, ip, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $email, $password, $created, $ip, $role);
    $stmt->execute();
}

// User Login Logic
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM zahi_elhelou_users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['isUserLoggedIn'] = true;
            $_SESSION['username'] = $username; // Store username in session
            $_SESSION['role'] = $row['role']; // Store role in session
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php"); // Redirect to refresh session state
            exit();
        }
    }
}

// Logout Logic
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to the login page
    exit();
}


if ($userRole === 'admin') {
    // Fetch Users
    $users = $conn->query("SELECT id, username, email, role FROM zahi_elhelou_users");

    // Add User Logic
    if (isset($_POST['add_user'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = isset($_POST['role']) ? $_POST['role'] : 'customer';

        $addSql = "INSERT INTO zahi_elhelou_users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($addSql);
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        $stmt->execute();
        header("Location: index.php");
    }

    // Delete User Logic
    if (isset($_GET['delete_user'])) {
        $userId = $_GET['delete_user'];
        $conn->query("DELETE FROM zahi_elhelou_users WHERE id = $userId");
        header("Location: index.php");
        exit();
    }
    // Edit User Logic
    if (isset($_GET['edit_user'])) {
        $editUserId = $_GET['edit_user'];
        $editUser = $conn->query("SELECT * FROM zahi_elhelou_users WHERE id = $editUserId")->fetch_assoc();
    }

    if (isset($_POST['update_user'])) {
        $userId = $_POST['user_id'];
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $role = $_POST['role'];

        $updateSql = "UPDATE zahi_elhelou_users SET username = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("sssi", $username, $email, $role, $userId);
        $stmt->execute();

        header("Location: index.php");
        exit();
    }
    if ($userRole === 'admin') {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $sql = "SELECT id, username, email, role FROM zahi_elhelou_users";

        if ($filter == 'customers') {
            $sql .= " WHERE role = 'customer'";
        } elseif ($filter == 'employees') {
            $sql .= " WHERE role = 'employee'";
        } elseif ($filter == 'admins') {
            $sql .= " WHERE role = 'admin'";
        }

        $sql .= " ORDER BY username ASC"; // Sorting users alphabetically
        $users = $conn->query($sql);
    }

}

// Employee Interface
if ($userRole === 'employee') {
    // Fetch Products
    echo "<div class='form-section'>";
    $products = $conn->query("SELECT * FROM products");

    // Add Product Logic
    if (isset($_POST['add_product'])) {
        $productName = $conn->real_escape_string($_POST['product_name']);
        $productImage = $conn->real_escape_string($_POST['product_image']);
        $productPrice = $_POST['product_price'];
        $productCategory = $conn->real_escape_string($_POST['product_category']);
        $productDescription = $conn->real_escape_string($_POST['product_description']);

        $addProductSql = "INSERT INTO products (name, image_path, price, category, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($addProductSql);
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param("ssdss", $productName, $productImage, $productPrice, $productCategory, $productDescription);
        $stmt->execute();
        header("Location: index.php");
        echo "</div>";
    }

    // Delete Product Logic
    if (isset($_GET['delete_product'])) {
        $productId = $_GET['delete_product'];
        $conn->query("DELETE FROM products WHERE id = $productId");
        header("Location: index.php");
        exit();
    }

    // Edit Product Logic
    if (isset($_GET['edit_product'])) {
        $editProductId = $_GET['edit_product'];
        $editProduct = $conn->query("SELECT * FROM products WHERE id = $editProductId")->fetch_assoc();
    }

    if (isset($_POST['update_product'])) {
        $productId = $_POST['product_id'];
        $productName = $conn->real_escape_string($_POST['product_name']);
        $productImage = $conn->real_escape_string($_POST['product_image']);
        $productPrice = $_POST['product_price'];
        $productCategory = $conn->real_escape_string($_POST['product_category']);
        $productDescription = $conn->real_escape_string($_POST['product_description']);

        $updateProductSql = "UPDATE products SET name = ?, image_path = ?, price = ?, category = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($updateProductSql);
        $stmt->bind_param("ssdssi", $productName, $productImage, $productPrice, $productCategory, $productDescription, $productId);
        $stmt->execute();

        header("Location: index.php");
        exit();
    }

    echo "<div class='form-section'>";
    $ordersQuery = "
        SELECT 
            o.id, 
            u.username, 
            p.name AS product_name, 
            p.image_path,
            o.quantity, 
            o.order_status,
            o.address
        FROM orders o
        JOIN products p ON o.product_id = p.id
        JOIN zahi_elhelou_users u ON o.user_id = u.id";

    $orders = $conn->query($ordersQuery);

    echo "<h2>Orders List</h2>";
    echo "<table>";
    echo "<tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Product</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>
          </tr>";

    while ($row = $orders->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td><img src='" . htmlspecialchars($row['image_path']) . "' alt='Product Image' style='width:50px; height:auto;'></td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . $row['order_status'] . "</td>";
        echo "<td><form method='post'>";
        echo "<input type='hidden' name='order_id' value='" . $row['id'] . "'>";
        echo "<select name='new_status'>
                <option value='Pending'>Pending</option>
                <option value='Shipped'>Shipped</option>
                <option value='Delivered'>Delivered</option>
                <option value='Cancelled'>Cancelled</option>
              </select>";
        echo "<input type='submit' name='update_order_status' value='Update Status'></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";

    // Logic to update order status
    if (isset($_POST['update_order_status'])) {
        $orderId = $_POST['order_id'];
        $newStatus = $_POST['new_status'];
        $updateStmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        $updateStmt->bind_param("si", $newStatus, $orderId);
        $updateStmt->execute();
    }


}

// Check if the user is a customer
if ($userRole === 'customer') {
    echo "<div class='form-section'>";
    // Initialize the cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Fetch and Display Products
    $products = $conn->query("SELECT * FROM products");
    echo "<h2>Available Products</h2>";
    echo "<table>";
    echo "<tr><th>Image</th><th>Name</th><th>Price</th><th>Quantity</th><th>Action</th></tr>";
    while ($row = $products->fetch_assoc()) {
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($row['image_path']) . "' alt='Product Image' style='width:100px; height:auto;'></td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
        echo "<td><form method='post'><input type='number' name='quantity' value='1' min='1' style='width: 50px;'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'></td>";
        echo "<td><input type='submit' name='add_to_cart' value='Add to Cart'></form></td>";
        echo "</tr>";
    }
    echo "</table>";

    // Add to Cart Logic
    if (isset($_POST['add_to_cart'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $_SESSION['cart'][$productId] = $quantity;
    }

    // Display Cart
    if (!empty($_SESSION['cart'])) {
        echo "<h2>Your Cart</h2>";
        echo "<table>";
        echo "<tr><th>Product Name</th><th>Quantity</th><th>Action</th></tr>";
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = $conn->query("SELECT name FROM products WHERE id = $productId")->fetch_assoc();
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['name']) . "</td>";
            echo "<td>" . $quantity . "</td>";
            echo "<td><form method='post'><input type='hidden' name='remove_product_id' value='" . $productId . "'>";
            echo "<input type='submit' name='remove_from_cart' value='Remove'></form></td>";
            echo "</tr>";
        }
        echo "</table>";

        // Place Order Button with Confirmation
        /*echo "<form method='post' onsubmit='return confirmOrder()'>";
        echo "<input type='submit' name='place_order' value='Place Order'>";
        echo "</form>";*/
    }

    // Remove from Cart Logic
    if (isset($_POST['remove_from_cart'])) {
        $removeProductId = $_POST['remove_product_id'];
        unset($_SESSION['cart'][$removeProductId]);
    }

    // Place Order Logic
    if (!empty($_SESSION['cart'])) {
        echo "<form method='post' onsubmit='return confirmOrder()'>";
        echo "<label for='address'>Enter your address:</label>";
        echo "<input type='text' name='address' id='address' required>";
        echo "<input type='submit' name='place_order' value='Place Order'>";
        echo "</form>";
    }

    // Place Order Logic
    if (isset($_POST['place_order'])) {
        $address = $conn->real_escape_string($_POST['address']);
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $userId = $_SESSION['user_id'];
            $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, order_status, address) VALUES (?, ?, ?, 'Pending', ?)");
            $stmt->bind_param("iiis", $userId, $productId, $quantity, $address);
            $stmt->execute();
        }
        $_SESSION['cart'] = array(); // Clear the cart after placing the order
        echo "<p>Order placed successfully.</p>";
    }

    // JavaScript for Confirmation Dialog
    echo "<script>
            function confirmOrder() {
                return confirm('Are you sure you want to purchase these products?');
            }
          </script>";



    $userId = $_SESSION['user_id']; // Retrieve user ID from session
    $userOrders = $conn->query("SELECT o.id, p.name as product_name, o.quantity, o.order_status, o.created_at FROM orders o JOIN products p ON o.product_id = p.id WHERE o.user_id = $userId");

    echo "<h2>Your Orders</h2>";
    echo "<table>";
    echo "<tr><th>Order ID</th><th>Product Name</th><th>Quantity</th><th>Status</th><th>Order Date</th></tr>";

    while ($row = $userOrders->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['order_status'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
}


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sports Shop</title>
    <style>
        /* Your CSS styling */
        /* Your CSS styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://cdn.wallpapersafari.com/12/68/h4Prcp.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        /* Adding an overlay for transparency effect */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.5); /* White background with 50% opacity */
            z-index: 1;
        }

        .main-container {
            z-index: 2; /* Make sure this is above the overlay */
            position: relative;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #007bff;
            color: white;
        }

        .hidden {
            display: none;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: orange;
        }

        form {
            margin-bottom: 20px;
        }

        input[type=text], input[type=password], input[type=email], select, input[type=number] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            box-sizing: border-box;
            background-color: #FFFFFF; /* Solid background for inputs */
        }

        input[type=submit], .logout-button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type=submit]:hover, .logout-button:hover {
            background-color: #4cae4c;
        }

        .logout-button {
            background-color: #d9534f;
        }

        .logout-button:hover {
            background-color: #c9302c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFFFFF; /* Solid background for the table */
            z-index: 10; /* Ensure table is above the overlay */
            position: relative; /* Required for z-index to take effect */
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
            background-color: #FFFFFF; /* Solid background for table cells */
        }

        th {
            background-color: #f2f2f2;
        }
        .form-section {
            background-color: white;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-section h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
<div class="main-container">
    <button id="loginButton">Login</button>
    <button id="registerButton">Register</button>

    <!-- Login Form -->
    <!-- <img src="https://cdn.wallpapersafari.com/12/68/h4Prcp.jpg" alt="Descriptive Text" width="200" height="100"> -->
    <?php if (!$isUserLoggedIn) { ?>
        <div id="loginForm" class="hidden">
            <h1>Log in</h1>
            <form method="post" action="">
                <input type="text" name="username" placeholder="Name: [Nickname]" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="login" value="Log in">
            </form>
        </div>

        <!-- Registration Form -->
        <div id="registerForm" class="hidden">
            <h1>Create an account</h1>
            <form method="post" action="">
                <input type="text" name="username" placeholder="Name: [Nickname]" required>
                <input type="email" name="email" placeholder="Email: [email@example.com]" required>
                <input type="password" name="password" placeholder="Password" required>
                <div>
                    <!--<label><input type="radio" name="role" value="admin"> Admin</label><br>-->
                    <label><input type="radio" name="role" value="employee"> Employee</label><br>
                    <label><input type="radio" name="role" value="customer" checked> Customer</label>
                </div>
                <input type="submit" name="register" value="Create an account">
            </form>
        </div>
        <script>
            document.getElementById("loginButton").addEventListener("click", function() {
                document.getElementById("loginForm").classList.toggle("hidden");
                document.getElementById("registerForm").classList.add("hidden");
            });

            document.getElementById("registerButton").addEventListener("click", function() {
                document.getElementById("registerForm").classList.toggle("hidden");
                document.getElementById("loginForm").classList.add("hidden");
            });
        </script>

    <?php } else { ?>
        <!-- Welcome Message -->
        <div>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <form method="post" action="">
                <input type="submit" name="logout" value="Logout" class="logout-button">
            </form>

            <!-- Admin Interface -->
            <?php if ($userRole === 'admin') { ?>
                <!-- Add/Edit User Form -->
                <?php if (isset($editUser)) { ?>
                    <h2>Edit User</h2>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="<?php echo $editUser['id']; ?>">
                        Username: <input type="text" name="username" value="<?php echo $editUser['username']; ?>" required><br>
                        Email: <input type="email" name="email" value="<?php echo $editUser['email']; ?>" required><br>
                        Role: <select name="role">
                            <option value="admin" <?php echo $editUser['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="employee" <?php echo $editUser['role'] == 'employee' ? 'selected' : ''; ?>>Employee</option>
                            <option value="customer" <?php echo $editUser['role'] == 'customer' ? 'selected' : ''; ?>>Customer</option>
                        </select><br>
                        <input type="submit" name="update_user" value="Update User">
                    </form>
                <?php } else { ?>
                    <h2>Add User</h2>
                    <form method="post" action="">
                        Username: <input type="text" name="username" required><br>
                        Email: <input type="email" name="email" required><br>
                        Password: <input type="password" name="password" required><br>
                        Role: <select name="role">
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                            <option value="customer" selected>Customer</option>
                        </select><br>
                        <input type="submit" name="add_user" value="Add User">
                    </form>
                <?php } ?>

                <!-- User List -->
                <h2>User List</h2>
                <form method="get" action="">
                    <input type="radio" name="filter" value="all" <?php echo $filter == 'all' ? 'checked' : ''; ?>> All
                    <input type="radio" name="filter" value="customers" <?php echo $filter == 'customers' ? 'checked' : ''; ?>> Customers
                    <input type="radio" name="filter" value="employees" <?php echo $filter == 'employees' ? 'checked' : ''; ?>> Employees
                    <input type="radio" name="filter" value="admins" <?php echo $filter == 'admins' ? 'checked' : ''; ?>> Admins
                    <input type="submit" value="Filter">
                </form>
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = $users->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td>
                                <a href="index.php?edit_user=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="index.php?delete_user=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php } ?>
        </div>
    <?php } ?>
    <!-- Employee Interface -->
    <?php if ($userRole === 'employee') { ?>
    <!-- Add Product Form -->
    <h2>Add Product</h2>
    <form method="post" action="">
        Product Name: <input type="text" name="product_name" required><br>
        Product Image URL: <input type="text" name="product_image" required><br>
        Product Price: <input type="number" name="product_price" step="0.01" required><br>
        Product Category: <input type="text" name="product_category" required><br>
        Product Description: <textarea name="product_description" required></textarea><br>
        <input type="submit" name="add_product" value="Add Product">
    </form>

    <!-- Product List -->
    <h2>Product List</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Category</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $products->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Product Image" style="max-width: 100px;"></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <a href="index.php?edit_product=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="index.php?delete_product=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Edit Product Form -->
    <?php if (isset($editProduct)) { ?>
        <h2>Edit Product</h2>
        <form method="post" action="">
            <input type="hidden" name="product_id" value="<?php echo $editProduct['id']; ?>">
            Product Name: <input type="text" name="product_name" value="<?php echo $editProduct['name']; ?>" required><br>
            Product Image URL: <input type="text" name="product_image" value="<?php echo $editProduct['image_path']; ?>" required><br>
            Product Price: <input type="number" name="product_price" value="<?php echo $editProduct['price']; ?>" step="0.01" required><br>
            Product Category: <input type="text" name="product_category" value="<?php echo $editProduct['category']; ?>" required><br>
            Product Description: <textarea name="product_description" required><?php echo $editProduct['description']; ?></textarea><br>
            <input type="submit" name="update_product" value="Update Product">
        </form>
    <?php } ?>
    <!-- Customer Interface -->
    <?php if ($userRole === 'customer') { ?>
        <!-- Product Listing -->
        <h2>Available Products</h2>
        <table>
            <tr><th>Name</th><th>Price</th><th>Actions</th></tr>
            <?php
            $products = $conn->query("SELECT * FROM products");
            while ($row = $products->fetch_assoc()) {
                echo "<tr>";
                echo "<td><img src='" . htmlspecialchars($row['image_path']) . "' alt='Product Image' style='width:100px; height:auto;'></td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php } ?>

    <!-- Additional interfaces for admin and employee can be added here -->
</div>
<?php } ?>
</div>
</body>
</html>