<?php
	include 'dbconnect.php';

	$username = $name = $price = $img = $quantity = $total = '';

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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Taiwo Joshua from https://taiwojoshua.netlify.app/">

	<!-- title -->
	<title>Cart</title>

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
								<li class="current-list-item"><a href="../index.php">Home</a></li>
								<li><a href="about.php">About</a></li>
								<li><a href="contact.php">Contact</a></li>
								<li><a href="shop.php">Shop</a>
									<ul class="sub-menu">
										<li><a href="shop.php">Shop</a></li>
										<li><a href="single-product.php">Single Product</a></li>
										<li><a href="cart.php">Cart</a></li>
									</ul>
								</li>
								<li>
									<div class="header-icons">
										<a class="shopping-cart" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
										<a href="login.php" id="loginicon" class="fas fa-user-plus"></a>
										<a class="fas fa-user" id="loggedinicon"></a>
										<div id="usercard">
											<img src="../assets/img/user.png" alt="<?php echo $username ?>">
											<div><?php echo $username ?></div>
											<a href="logout.php" class="bordered-btn" style="padding: 5px 15px;">Logout</a>
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
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
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

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="../assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->

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
							<li>+00 111 222 3333</li>
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
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; <span id="year"></span> - <a href="https://taiwojoshua.netlify.app/">Taiwo Joshua</a>,  All Rights Reserved.</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
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
	<script>
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
		$("#subtotal").text('₦' + subtotal);
		var shipping = parseInt(($("#shipping").text()).slice(1));
		var finaltotal = subtotal + shipping;
		$("#finaltotal").text('₦' + finaltotal);

		$("#updatebtn").click(function(){
			nlength = document.querySelectorAll(".cart-table>tbody>.table-body-row").length;
			console.log(nlength);
			$("#nitems").val(nlength);
		})

		$(".product-remove>a").click(function(){
			index = $(".product-remove>a").index($(this));
			nthchild = index + 1;
			$("table>tbody>.table-body-row:nth-child(" + nthchild + ")").remove();
		})
	</script>
</body>
</html>
<?php
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

	if(isset($_SESSION['admin']) && $_SESSION['admin'] == "admin"){
		echo '<script>
				$("#addproduct").show();
			</script>';
	}else{
		echo '<script>
				$("#addproduct").hide();
			</script>';
	}
?>