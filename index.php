<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Nike Store</title>
    <script>
        function setPreference(product) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    loadPreference();
                }
            };
            xhr.send("action=set&product=" + product);
        }

        function loadPreference() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("welcomeMessage").innerHTML = xhr.responseText;
                }
            };
            xhr.send("action=get");
        }

        function clearPreference() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    loadPreference();
                }
            };
            xhr.send("action=clear");
        }

        window.onload = function() {
            loadPreference();
        };
    </script>
</head>
<body>
    <nav id="nav">
        <div class="navTop">
            <div class="navItem">
                <img src="./img/sneakers.png" alt="">
            </div>
            <div class="navItem">
                <div class="search">
                    <input type="text" placeholder="Search..." class="searchInput">
                    <img src="./img/search.png" width="20" height="20" alt="" class="searchIcon">
                </div>
            </div>
            <div class="navItem">
                <span class="limitedOffer">Limited Offer!</span>
            </div>
        </div>
        <div class="navBottom">
            <h3 class="menuItem" onclick="setPreference('AIR FORCE')">AIR FORCE</h3>
            <h3 class="menuItem" onclick="setPreference('JORDAN')">JORDAN</h3>
            <h3 class="menuItem" onclick="setPreference('BLAZER')">BLAZER</h3>
            <h3 class="menuItem" onclick="setPreference('CRATER')">CRATER</h3>
            <h3 class="menuItem" onclick="setPreference('HIPPIE')">HIPPIE</h3>
        </div>
    </nav>
    <div id="welcomeMessage"></div>
    <button onclick="clearPreference()">Clear Preference</button>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];

            if ($action == 'set' && isset($_POST['product'])) {
                $product = $_POST['product'];
                setcookie('preferredProduct', $product, time() + (86400 * 7), "/"); // 7 days expiration
                echo "Preference saved: " . $product;
            } elseif ($action == 'get') {
                if (isset($_COOKIE['preferredProduct'])) {
                    echo "Welcome back! Your preferred product is " . $_COOKIE['preferredProduct'];
                } else {
                    echo "No preferred product set.";
                }
            } elseif ($action == 'clear') {
                setcookie('preferredProduct', '', time() - 3600, "/"); // unset cookie
                echo "Preference cleared.";
            }
        }
        exit;
    }
    ?>
</body>
</html>
