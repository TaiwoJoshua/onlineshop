<?php
	include 'dbconnect.php';

	$username = $name = $price = $img = $quantity = $total = $emptycart = '';

	//Checks if User is Logged In
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];

		//Onclick of Update Cart
		if(isset($_POST['submit'])){
			$n = $_POST['nitems'];
			$i = 0;
			$select = $conn->query("TRUNCATE table `$username`");
			while($i < $n){
				$name = $_POST['name'][$i];
				$quantity = $_POST['quantity'][$i];
				$price = $_POST['price'][$i];
				$img = $_POST['img'][$i];
				$total = $price * $quantity;
				$conn->query("INSERT INTO `$username`(`name`, `img`, `price`, `quantity`, `total`) VALUES ('$name', '$img', $price, $quantity, $total)");		
				$i++;
			}
		}
		
		//Get User's Cart Items From Database
		if(isset($_SESSION['createtable'])){
			$name = $price = $img = $quantity = $total = array();

			$get = $conn->query("SELECT * FROM `$username`");
			if($get->num_rows > 0){
				$i = 0;
				while($row = $get->fetch_assoc()){
					$name[$i] = $row['name'];
					$price[$i] = $row['price'];
					$img[$i] = $row['img'];
					$quantity[$i] = $row['quantity'];
					$total[$i] = $row['total'];
					$i++;
				}
			}
		}
	}else if($_SESSION['admin'] == "admin"){

	}else{
		$_SESSION['cart'] = 1;
		header("location: ./login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="shop e-commerce online buying teejay store">
    <meta property="author" content="Taiwo Joshua">
    <meta name="description" content="An e-commerce website where you can buy products">
    <meta property="og:description" content="An e-commerce website where you can buy products">
    <meta property="og:locale" content="en_UK">
    <meta property="og:image" content="https://">
    <meta property="og:title" content="Change me">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://">
    <meta name="theme-color" content="#F28123 #012738">

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="../assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="../assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="../assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="../assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="../assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="../assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="../assets/css/responsive.css">
	<!-- Icon -->
	<link rel="icon" href="../assets/img/favicon.png">
    <link rel="apple-touch-icon" href="../assets/img/favicon.png">

	<!-- title -->
	<title>Cart</title>
</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="../index.php">
								<img src="../assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li><a href="../index.php"><i class="fas fa-home ititle"></i> Home</a></li>
								<li><a href="about.php"><i class="fas fa-info-circle ititle"></i> About</a></li>
								<li><a href="contact.php"><i class="fas fa-phone ititle"></i> Contact</a></li>
								<li><a href="shop.php"><i class="fas fa-store ititle"></i> Shop</a></li>
								<li>
									<div class="header-icons">
										<a class="shopping-cart current-list-item" href="cart.php" style="color: #F28123;"><i class="fas fa-shopping-cart"></i></a>
										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
										<a href="login.php" id="loginicon" title="Login/Signup" class="fas fa-user-plus"></a>
										<a class="fas fa-user loggedinicon" id="loggedinicon"></a>
										<div id="usercard">
											<img src="../assets/img/user.png" alt="<?php echo $username ?>">
											<div><?php echo $username ?></div>
											<a href="logout.php" class="bordered-btn">Logout</a>
										</div>
										<a class="fas fa-cart-plus" id="addproduct" href="./addproduct.php"></a>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<form method="POST" action="./shop.php" class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="keyword here" name="keyword">
							<button type="submit" name="searchbtn">Search <i class="fas fa-search"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end search arewa -->
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Fresh and Organic</p>
						<h1>Cart</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- cart -->
	<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<div class="cart-table-wrap">
						<table class="cart-table">
							<thead class="cart-table-head">
								<tr class="table-head-row">
									<th class="product-remove"></th>
									<th class="product-image">Product Image</th>
									<th class="product-name">Name</th>
									<th class="product-price">Price</th>
									<th class="product-quantity">Quantity</th>
									<th class="product-total">Total</th>
								</tr>
							</thead>
							<tbody>
								<input type="number" style="position: absolute; visibility: hidden; z-index: -1;" form="form1" readonly id="nitems" name="nitems">
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="total-section">
						<table class="total-table">
							<thead class="total-table-head">
								<tr class="table-total-row">
									<th>Total</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody>
								<tr class="total-data">
									<td><strong>Subtotal: </strong></td>
									<td id="subtotal">₦0</td>
								</tr>
								<tr class="total-data">
									<td><strong>Shipping: </strong></td>
									<td id="shipping">₦500</td>
								</tr>
								<tr class="total-data">
									<td><strong>Total: </strong></td>
									<td id="finaltotal">₦1000</td>
								</tr>
							</tbody>
						</table>
						<form class="cart-buttons" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form1" method="POST">
							<input type="submit" class="boxed-btn" name="submit" id="updatebtn" value="Update Cart" style="font-size: 14px;">
							<a href="checkout.php" class="boxed-btn black">Check Out</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end cart -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>34/8, East Hukupara, Gifirtok, Sadan.</li>
							<li>support@teejay.com</li>
							<li>+234 810 318 2378</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="footer-box pages">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="../index.php">Home</a></li>
							<li><a href="about.php">About</a></li>
							<li><a href="shop.php">Shop</a></li>
							<li><a href="contact.php">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-12">
					<p>&copy; Copyright TeeJay Store <span id="year"></span>. All Rights Reserved. Designed and Developed by <a href="https://taiwojoshua.netlify.app/">Taiwo Joshua</a></p>
				</div>
				<div class="col-lg-3 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	
	<!-- Javascript Files and Libraries -->

	<!-- jquery -->
	<script src="../assets/js/jquery-1.11.3.min.js"></script>
	
	<!-- bootstrap -->
	<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
	
	<!-- count down -->
	<script src="../assets/js/jquery.countdown.js"></script>
	
	<!-- isotope -->
	<script src="../assets/js/jquery.isotope-3.0.6.min.js"></script>
	
	<!-- waypoints -->
	<script src="../assets/js/waypoints.js"></script>
	
	<!-- owl carousel -->
	<script src="../assets/js/owl.carousel.min.js"></script>
	
	<!-- magnific popup -->
	<script src="../assets/js/jquery.magnific-popup.min.js"></script>
	
	<!-- mean menu -->
	<script src="../assets/js/jquery.meanmenu.min.js"></script>
	
	<!-- sticker js -->
	<script src="../assets/js/sticker.js"></script>
	
	<!-- main js -->
	<script src="../assets/js/main.js"></script>
	
	<!-- Sweet Alert js -->
	<script src="../assets/js/sweetalert.min.js"></script>
	
	<script>
		//Get the User's Cart Products
		var names = <?php echo json_encode($name); ?>;
		var img = <?php echo json_encode($img); ?>;
		var quantity = <?php echo json_encode($quantity); ?>;
		var price = <?php echo json_encode($price); ?>;
		var total = <?php echo json_encode($total); ?>;
		var subtotal = 0;
		for(i = 0; i < names.length; i++){
			$(".cart-table>tbody").append('<tr class="table-body-row"><td class="product-remove"><a><i class="far fa-window-close"></i></a></td><td class="product-image"><img src="' + img[i] + '" alt=""></td><td class="product-name"><input form="form1" value="' + names[i] + '" type="text" readonly name="name[]" style="width: 100%;border: none; outline: none; text-align: center;"><input form="form1" value="' + img[i] + '" type="text" readonly name="img[]" style="position: absolute; visibility: hidden;"><input form="form1" value="' + price[i] + '" type="text" readonly name="price[]" style="position: absolute; visibility: hidden;"></td><td class="product-price">₦' + price[i] + '</td><td class="product-quantity"><input form="form1" value="' + quantity[i] + '" type="number" name="quantity[]" placeholder="0"></td><td class="product-total">₦' + total[i] + '</td></tr>');
			subtotal += parseInt(total[i]);
		}

		function empty(){
			$(".cart-table>tbody").append('<tr><td colspan="6"><h4>Cart is Empty <br> Go to the <a style="color:  #F28123;" href="./shop.php">Shop</a> to Add Products</h4></td></tr>');	
		}

		//Checks the Number of Products in Cart
		function checknoitems(){
			let items = $("table>tbody>.table-body-row");
			if(items.length == 0){
				empty();
			}
		}

		//Calc Total and Subtotal
		$("#subtotal").text('₦' + subtotal);
		var shipping = parseInt(($("#shipping").text()).slice(1));
		var finaltotal = subtotal + shipping;
		$("#finaltotal").text('₦' + finaltotal);

		//Onclick of Update Cart Button
		$("#updatebtn").click(function(){
			nlength = document.querySelectorAll(".cart-table>tbody>.table-body-row").length;
			console.log(nlength);
			$("#nitems").val(nlength);
		})

		//Onclick of Remove Item Button
		$(".product-remove>a").click(function(){
			index = $(".product-remove>a").index($(this));
			nthchild = index + 1;
			$("table>tbody>.table-body-row:nth-child(" + nthchild + ")").remove();
			checknoitems();
		})

		//Sweet Alert Checkout Failed Notification
		function emptycart(){
			swal({
				icon: "error",
				title: 'Checkout Failed',
				text: 'Cart is Empty',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				buttons: {
					cancel: {
						text: "OK",
						value: "ok",
						visible: true,
						closeModal: true
					}
				}
			})
		}
	</script>
</body>
</html>
<?php
	//Checks If User is Logged In
	if(isset($_SESSION['username'])){
		echo '<script>
				$("#loggedinicon").show();
				$("#loginicon").hide();
			</script>';
	}else{
		echo '<script>
				$("#loggedinicon").hide();
				$("#loginicon").show();
			</script>';
	}; 

	//Checks if Admin is Logged In
	if(isset($_SESSION['admin']) && $_SESSION['admin'] == "admin"){
		echo '<script>
				$("#addproduct").show();
			</script>';
	}else{
		echo '<script>
				$("#addproduct").hide();
			</script>';
	}

	//Checks if Cart Empty
	if($_SESSION['emptycart'] == 1){
		echo '<script> emptycart(); </script>';
		$_SESSION['emptycart'] = 0;
	}

	// Monitors Number of Products in Cart
	echo '<script>checknoitems();</script>';
?>