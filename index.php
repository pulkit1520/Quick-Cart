<?php
    session_start();

    // Initialize the cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $showCart = false; // Default to hiding the cart

    // Add product to the cart
    if (isset($_POST['add_to_cart'])) {
        $product = $_POST['product'];
        $price = $_POST['price'];
        if (!isset($_SESSION['cart'][$product])) {
            $_SESSION['cart'][$product] = ['quantity' => 1, 'price' => $price];
        } else {
            $_SESSION['cart'][$product]['quantity']++;
        }

        $showCart = true; // Show the cart
    }

    // Remove product from the cart
    if (isset($_POST['remove_from_cart'])) {
        $product = $_POST['product'];
        if (isset($_SESSION['cart'][$product])) {
            $_SESSION['cart'][$product]['quantity']--;
            if ($_SESSION['cart'][$product]['quantity'] <= 0) {
                unset($_SESSION['cart'][$product]);
            }
        }

        $showCart = true; // Show the cart
    }

    // Clear the cart
    if (isset($_POST['clear_cart'])) {
        unset($_SESSION['cart']);
        $showCart = true; // Show the cart
    }

    // Show the cart explicitly
    if (isset($_POST['show_cart'])) {
        $showCart = true;
    }

    // Place an order
    if (isset($_POST['place_order'])) {
        $flat_no = htmlspecialchars($_POST['flat_no']); // Sanitize the flat number input

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'shop_product');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert each product into the orders table with the total price
        foreach ($_SESSION['cart'] as $product => $details) {
            $quantity = $details['quantity'];
            $price_per_item = $details['price'];
            $total_price = $quantity * $price_per_item; // Calculate total price for the product

            // Use prepared statements for security
            $sql = $conn->prepare("INSERT INTO orders (product, quantity, price, flat_no) VALUES (?, ?, ?, ?)");
            $sql->bind_param('siis', $product, $quantity, $total_price, $flat_no);
            $sql->execute();
        }

        // Close connection and clear cart
        $conn->close();
        unset($_SESSION['cart']);
        echo "<p>Order placed successfully!</p>";
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a id="logo"></a>
        <a id="about" href="about.html">About</a>
        <a id="contact" href="contect.php">Contect</a>
        <form method="post" action="">
            <button type="submit" name="show_cart">Cart</button>
        </form>
    </div>
    
    <!-- Product Listing -->
    <div class="product">
        <h1>Dairy & Bread</h1>
        <div class="product1">
            <!-- Product 1 -->
            <div class="pbox">
                <div class="pimage"></div>
                <div class="product1info">Amul Taaza Toned Fresh Milk</div>
                <div class="productq">500 ml</div>
                <div class="productprice">₹27
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Amul Taaza Toned Fresh Milk">
                        <input type="hidden" name="price" value="27">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
            
            <!-- Product 2 -->
            <div class="p2box">
                <div class="p2image"></div>
                <div class="product2info">Amul Gold Full Cream Fresh Milk</div>
                <div class="product2q">500 ml</div>
                <div class="product2price">₹34
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Amul Gold Full Cream Fresh Milk">
                        <input type="hidden" name="price" value="34">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="p3box">
                <div class="p3image"></div>
                <div class="product3info">Amul Masti Curd</div>
                <div class="product3q">200 g</div>
                <div class="product3price">₹23
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Amul Masti Curd">
                        <input type="hidden" name="price" value="23">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product4  -->
            <div class="p4box">
                <div class="p4image"></div>
                <div class="product4info">Amul Masti Curd</div>
                <div class="product4q">400 g</div>
                <div class="product4price">₹35
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Amul Masti Curd">
                        <input type="hidden" name="price" value="35">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product5  -->
            <div class="p5box">
                <div class="p5image"></div>
                <div class="product5info">Vijay Stone Ground Wheat Brown Bread</div>
                <div class="product5q">400 g</div>
                <div class="product5price">₹42
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Vijay Stone Ground Wheat Brown Bread">
                        <input type="hidden" name="price" value="42">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product6  -->
            <div class="p6box">
                <div class="p6image"></div>
                <div class="product6info">Amul Salted Butter</div>
                <div class="product6q">100 g</div>
                <div class="product6price">₹60
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Amul Salted Butter">
                        <input type="hidden" name="price" value="60">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Product Listing -->
<div class="product">
        <h1>Snacks & Munchies</h1>
        <div class="product2">
            <!-- Product 1 -->
            <div class="pbox1">
                <div class="pimage1"></div>
                <div class="productinfo1">Cheetos Slamin Hot Crunchy Puffs</div>
                <div class="productq1">28.3 g</div>
                <div class="productprice1">₹170
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Cheetos Slamin Hot Crunchy Puffs">
                        <input type="hidden" name="price" value="170">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
            
            <!-- Product 2 -->
            <div class="pbox2">
                <div class="pimage2"></div>
                <div class="productinfo2">Orion Tutle Masala Corn Chips-Pack Of 3</div>
                <div class="productq2">3 x 115g</div>
                <div class="productprice2">₹300
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Orion Tutle Masala Corn Chips-Pack Of 3">
                        <input type="hidden" name="price" value="300">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="pbox3">
                <div class="pimage3"></div>
                <div class="productinfo3">Kettle Studio Potato Chips</div>
                <div class="productq3">113 g</div>
                <div class="productprice3">₹99
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Kettle Studio Potato Chips">
                        <input type="hidden" name="price" value="99">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product4  -->
            <div class="pbox4">
                <div class="pimage4"></div>
                <div class="productinfo4">Kab's Jackpot Chilli Lemon Strix Crisps</div>
                <div class="productq4">80 g</div>
                <div class="productprice4">₹65
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Kab's Jackpot Chilli Lemon Strix Crisps">
                        <input type="hidden" name="price" value="65">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product5  -->
            <div class="pbox5">
                <div class="pimage5"></div>
                <div class="productinfo5">Orion Turtle Mexican Lime Corn Chips</div>
                <div class="productq5">115 g</div>
                <div class="productprice5">₹90
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Orion Turtle Mexican Lime Corn Chips">
                        <input type="hidden" name="price" value="90">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product6  -->
            <div class="pbox6">
                <div class="pimage6"></div>
                <div class="productinfo6">Nongshim Shrimp Flavoured Hot</div>
                <div class="productq6">75 g</div>
                <div class="productprice6">₹129
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Nongshim Shrimp Flavoured Hot">
                        <input type="hidden" name="price" value="129">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Product Listing -->
<div class="product">
        <h1>Cold Drinks & Juices</h1>
        <div class="product3">
            <!-- Product 1 -->
            <div class="pbox_1">
                <div class="pimage_1"></div>
                <div class="productinfo_1">Amul Probiotic Tadka Salted Buttermilk</div>
                <div class="productq_1">270 ml</div>
                <div class="productprice_1">₹10
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Amul Probiotic Tadka Salted Buttermilk">
                        <input type="hidden" name="price" value="10">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
            
            <!-- Product 2 -->
            <div class="pbox_2">
                <div class="pimage_2"></div>
                <div class="productinfo_2">Thums Up Soft Drink</div>
                <div class="productq_2">750 ml</div>
                <div class="productprice_2">₹40
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Thums Up Soft Drink">
                        <input type="hidden" name="price" value="40">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="pbox_3">
                <div class="pimage_3"></div>
                <div class="productinfo_3">Besleri Packaged Water</div>
                <div class="productq_3">5 l</div>
                <div class="productprice_3">₹70
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Besleri Packaged Water">
                        <input type="hidden" name="price" value="70">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product4  -->
            <div class="pbox_4">
                <div class="pimage_4"></div>
                <div class="productinfo_4">7UP Nimbooz With Lemon Juice</div>
                <div class="productq_4">350 ml</div>
                <div class="productprice_4">₹20
                    <form method="post" action="">
                        <input type="hidden" name="product" value="7UP Nimbooz With Lemon Juice">
                        <input type="hidden" name="price" value="20">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product5  -->
            <div class="pbox_5">
                <div class="pimage_5"></div>
                <div class="productinfo_5">Frooti Mango Drink</div>
                <div class="productq_5">125 ml</div>
                <div class="productprice_5">₹10
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Frooti Mango Drinks">
                        <input type="hidden" name="price" value="10">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>

            <!-- Product6  -->
            <div class="pbox_6">
                <div class="pimage_6"></div>
                <div class="productinfo_6">Sprite Lime Flavored Soft Drink</div>
                <div class="productq_6">750 ml</div>
                <div class="productprice_6">₹40
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Sprite Lime Flavored Soft Drink">
                        <input type="hidden" name="price" value="40">
                        <button type="submit" name="add_to_cart">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Cart Section -->
    <?php if ($showCart): ?>
        <div id="cart">
            <h2>Shopping Cart</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <table>
                    <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>
                    <?php $grand_total = 0; ?>
                    <?php foreach ($_SESSION['cart'] as $product => $details): ?>
                        <?php $total_price = $details['quantity'] * $details['price']; ?>
                        <tr>
                            <td><?= htmlspecialchars($product); ?></td>
                            <td>
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="product" value="<?= htmlspecialchars($product); ?>">
                                    <button type="submit" name="remove_from_cart">-</button>
                                </form>
                                <?= $details['quantity']; ?>
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="product" value="<?= htmlspecialchars($product); ?>">
                                    <input type="hidden" name="price" value="<?= htmlspecialchars($details['price']); ?>">
                                    <button type="submit" name="add_to_cart">+</button>
                                </form>
                            </td>
                            <td>₹<?= $details['price']; ?></td>
                            <td>₹<?= $total_price; ?></td>
                        </tr>
                        <?php $grand_total += $total_price; ?>
                    <?php endforeach; ?>
                    <tr><td colspan="3">Grand Total</td><td>₹<?= $grand_total; ?></td></tr>
                </table>
                <form method="post" action="">
                    <label for="flat_no">Flat Number:</label>
                    <input type="text" name="flat_no" required>
                    <button type="submit" name="place_order">Place Order</button>
                </form>
                <form method="post" action="">
                    <button type="submit" name="clear_cart">Clear Cart</button>
                </form>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>
