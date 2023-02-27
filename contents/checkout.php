<?php
	include 'dbconnect.php';

	$username = $admin = '';
	$name = $price = array();

	//Checks if User is Logged In
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];

		//Gets the User's Products from Cart
		if(isset($_SESSION['createtable'])){
			$get = $conn->query("SELECT * FROM `$username`");
			if($get->num_rows > 0){
				$i = 0;
				while($row = $get->fetch_assoc()){
					$name[$i] = $row['name'];
					$total[$i] = $row['total'];
					$i++;
				}
			}else{
				header("location: ./shop.php");
			}
		}else{
			header("location: ./shop.php");
		}
	}else if(isset($_SESSION['admin']) && $_SESSION['admin'] == "admin"){
		$admin = "Admin";
	}else{
		$_SESSION['checkout'] = 1;
		header("location: ./login.php");
	}

	if(!isset($_SESSION['createtable'])){
		$_SESSION['emptycart'] = 1;
		header("location: ./cart.php");
	}else{
		$_SESSION['emptycart'] = 0;
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
	<title>Check Out</title>
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
										<a class="shopping-cart current-list-item" href="cart.php"><i class="fas fa-shopping-cart"></i><span class="ititle ititle2">&nbsp;&nbsp;Cart</span></a>
										<a href="ticket.php" id="ticketicon"><i class="fas fa-ticket-alt" title="Tickets"></i><span class="ititle ititle2">&nbsp;&nbsp;Tickets</span></a>
										<a class="mobile-hide search-bar-icon"><i class="fas fa-search"></i></a>
										<a href="login.php" id="loginicon" title="Login/Signup" class="fas fa-user-plus"><span class="ititle ititle2">&nbsp;&nbsp;Login / Signup</span></a>
										<a class="fas fa-user loggedinicon" id="loggedinicon"><span class="ititle ititle2">&nbsp;&nbsp;<?php echo $username.$admin ?></span></a>
										<div id="usercard">
											<img src="../assets/img/user.png" alt="<?php echo $username.$admin ?>">
											<div><?php echo $username.$admin ?></div>
											<a href="logout.php" class="bordered-btn">Logout</a>
										</div>
										<a class="fas fa-cart-plus" id="addproduct" href="addproduct.php"><span class="ititle ititle2">&nbsp;&nbsp;Add Product</span></a>
										<a href="logout.php" class="fas fa-sign-out-alt" id="logouticon" title="Logout"><span class="ititle ititle2">&nbsp;&nbsp;Logout</span></a>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon"><i class="fas fa-search"></i></a>
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
						<h1>Check Out Product</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- check out section -->
	<div class="checkout-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="checkout-accordion-wrap">
						<div class="accordion" id="accordionExample">
						  <div class="card single-accordion">
						    <div class="card-header" id="headingOne">
						      <h5 class="mb-0">
						        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          Billing Address
						        </button>
						      </h5>
						    </div>

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="billing-address-form">
						        	<form action="./mails/checkout_mail.php" method="POST" id="form1">
						        		<p><input type="text" name="cname" required placeholder="*Fullname here..."></p>
						        		<p><input type="email" required name="cemail" placeholder="*Email here..."></p>
						        		<p><input type="text" name="caddress" placeholder="Address here... (optional)"></p>
						        		<p><input type="tel" required name="cphone" placeholder="*Phone number here..."></p>
						        		<p><textarea name="cmessage" id="bill" cols="30" rows="10" placeholder="Something About Products/Services (optional but advisable)"></textarea></p>
										<input type="hidden" name="accept" value="accept" />
									</form>
						        </div>
						      </div>
						    </div>
						  </div>
						</div>

					</div>
				</div>

				<div class="col-lg-4">
					<div class="order-details-wrap">
						<table class="order-details">
							<thead>
								<tr>
									<th>Your order Details</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody class="order-details-body">
								<tr>
									<td>Product</td>
									<td>Total</td>
								</tr>
							</tbody>
							<tbody class="checkout-details">
								<tr>
									<td>Subtotal</td>
									<td id="subtotal">₦0</td>
								</tr>
								<tr>
									<td>Shipping</td>
									<td id="shipping">₦500</td>
								</tr>
								<tr>
									<td>Total</td>
									<td id="finaltotal">₦500</td>
								</tr>
							</tbody>
						</table>
						<input type="submit" class="boxed-btn" name="checkout" style="margin-top: 5px;" form="form1" value="Place Order">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end check out section -->

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
	<script src="../assets/js/isotope-docs.min.js"></script>
	
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
		//Gets User's Products
		var names = <?php echo json_encode($name); ?>;
		var total = <?php echo json_encode($total); ?>;
		var subtotal = 0;
		for(i = 0; i < names.length; i++){
			$(".order-details-body").append('<tr><td>' + names[i] + '</td><td>₦' + total[i] + '</td></tr>');
			subtotal += parseInt(total[i]);
		}

		//Calc Subtotal and Total
		$("#subtotal").text('₦' + subtotal);
		var shipping = parseInt(($("#shipping").text()).slice(1));
		var finaltotal = subtotal + shipping;
		$("#finaltotal").text('₦' + finaltotal);
	</script>
</body>
</html>
<?php
	//Checks if User is Logged In
	if(isset($_SESSION['username'])){
		echo '<script>
				$("#loggedinicon").show();
				$("#loginicon").hide();
				$("#logouticon").show();
                $("#ticketicon").show();
			</script>';
	}else{
		echo '<script>
				$("#loggedinicon").hide();
				$("#loginicon").show();
				$("#logouticon").hide();
                $("#ticketicon").hide();
			</script>';
	}; 

	//Checks if Admin is Logged In
	if(isset($_SESSION['admin']) && $_SESSION['admin'] == "admin"){
		echo '<script>
				$("#loggedinicon").show();
				$("#loginicon").hide();
				$("#ticketicon").show();
				$("#logouticon").show();
				$("#addproduct").show();
			</script>';
	}else{
		echo '<script>
				$("#addproduct").hide();
			</script>';
	}
?>