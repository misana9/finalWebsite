<?php
include("database/database.php");
session_start();
?>



<?php

if (isset($_POST['add'])) {
    $name = $_POST['Product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $fileName = $_FILES['files']['name'];
    $tempName = $_FILES['files']['tmp_name'];
    $folder = "images/".$fileName;

    $sql = "INSERT INTO productList (name, image ,category, description, quantity, price) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisii", $name, $fileName, $category, $description, $quantity, $price);
    $stmt->execute();
    move_uploaded_file($tempName,$folder);
    header("Location: " . $_SERVER['PHP_SELF']);
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM productList WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $fileName = $_FILES['files']['name'];

    $sql = "UPDATE productList SET name=?, category=?, description=?, quantity=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisiii", $name, $category, $description, $quantity, $price, $id);
    $stmt->execute();


    header("Location: " . $_SERVER['PHP_SELF'] . "?page=products");
    exit();
}


$name = isset($_GET['name']) ? trim($_GET['name']) : '';

if ($name !== '') {
    $sql = "SELECT * FROM productList WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search = "%$name%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM productList";
    $result = $conn->query($sql);
}

$name = isset($_GET['name']) ? trim($_GET['name']) : '';

if ($name !== '') {
    $sql = "SELECT * FROM productList WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search = "%$name%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM productList";
    $result = $conn->query($sql);
}

// Display products
if ($result->num_rows > 0) {
    echo "<div class='product-container'>";
    while ($row = $result->fetch_assoc()) {
        $image = !empty($row['image']) ? "images/" . htmlspecialchars($row['image']) : "/images/placeholder.png";

        echo "
        <form method='POST' action='cart.php' style='display:inline;'>
            <div class='product-card' style='border:1px solid #ccc; border-radius:10px; width:250px; padding:15px; box-shadow:0 4px 8px rgba(0,0,0,0.1); text-align:center; background:#fff;'>
                <img src='$image' alt='Product Image' style='width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:10px;'>
                <h3 style='margin-bottom:5px;'>" . htmlspecialchars($row['name']) . "</h3>
                <p style='font-size:14px; color:#555; margin:5px 0;'>Category: " . htmlspecialchars($row['category']) . "</p>
                <p style='font-size:14px; color:#555; margin:5px 0;'>Description: " . htmlspecialchars($row['description']) . "</p>
                <p style='font-size:14px; color:#555; margin:5px 0;'>Quantity: " . htmlspecialchars($row['quantity']) . "</p>
                <p style='font-size:14px; color:#555; margin:5px 0;'>Price: ₱" . htmlspecialchars($row['price']) . "</p>
                
                <div class='actions' style='margin-top:10px;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='name' value='" . htmlspecialchars($row['name']) . "'>
                    <input type='hidden' name='price' value='" . htmlspecialchars($row['price']) . "'>
                    <input type='hidden' name='quantity' value = '". htmlspecialchars($row['quantity'])."'>
                    <button type='submit' name='add_to_cart' style='background:#007BFF; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer;'>
                        Add to Cart
                    </button>";

                    if($_SESSION['admin']){
                        echo "
                        <a href='?page=products&edit=" . $row['id'] . "'>Edit</a>
                        <a href='?page=products&delete=" . $row['id'] . "' onclick=\"return confirm('Delete this product?');\">Delete</a>";
                    }
                    echo "
                </div>
            </div>
        </form>
        ";
    }
    echo "</div>";
} else {
    echo "<p>No results found.</p>";
}



if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = "SELECT * FROM productList WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editResult = $stmt->get_result();
    $product = $editResult->fetch_assoc();

    if ($product) {
        echo "
        <form method='POST' enctype='multipart/form-data' style='margin:20px auto; width:300px; border:1px solid #ccc; padding:15px;' class='updateForm' autocomplete='off'>
            <h3>Edit Product</h3>
            <input type='hidden' name='id' value='{$product['id']}'>
            <label>Name: </label>
            <input type='text' name='product_name' value='" . htmlspecialchars($product['name']) . "' required>
            <label>Category: </label>
            <select type='category' name='category' required>
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            </select> <br>
            <label>Description: </label>
            <input type='text' name='description' value='" . htmlspecialchars($product['description']) . "' required>
            <label>Quantity: </label>
            <input type='number' name='quantity' value='" . htmlspecialchars($product['quantity']) . "' required>
            <label>Price: </label>
            <input type='text' name='price' value='" . htmlspecialchars($product['price']) . "' required>
            <button type='submit' name='update' id='updateBtn'>Update</button>
        </form>
        ";
    }
}

?>

