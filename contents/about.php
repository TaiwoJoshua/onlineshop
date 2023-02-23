<?php
	include './dbconnect.php';

	$username = '';

	//Checks if User is Logged In
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
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
	<title>About</title>
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
								<li class="current-list-item"><a href="about.php"><i class="fas fa-info-circle ititle"></i> About</a></li>
								<li><a href="contact.php"><i class="fas fa-phone ititle"></i> Contact</a></li>
								<li><a href="shop.php"><i class="fas fa-store ititle"></i> Shop</a></li>
								<li>
									<div class="header-icons">
										<a class="shopping-cart" href="cart.php"><i class="fas fa-shopping-cart"></i><span class="ititle">&nbsp;&nbsp;Cart</span></a>
										<a class="mobile-hide search-bar-icon"><i class="fas fa-search"></i></a>
										<a href="login.php" id="loginicon" title="Login/Signup" class="fas fa-user-plus"><span class="ititle">&nbsp;&nbsp;Login / Signup</span></a>
										<a class="fas fa-user loggedinicon" id="loggedinicon"><span class="ititle">&nbsp;&nbsp;<?php echo $username ?></span></a>
										<div id="usercard">
											<img src="../assets/img/user.png" alt="<?php echo $username ?>">
											<div><?php echo $username ?></div>
											<a href="logout.php" class="bordered-btn">Logout</a>
										</div>
										<a class="fas fa-cart-plus" id="addproduct" href="addproduct.php"><span class="ititle">&nbsp;&nbsp;Add Product</span></a>
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
						<p>We sale fresh fruits</p>
						<h1>About Us</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- featured section -->
	<div class="feature-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-7">
					<div class="featured-text">
						<h2 class="pb-3">Why <span class="orange-text">TeeJay</span></h2>
						<div class="row">
							<div class="col-lg-6 col-md-6 mb-4 mb-md-5">
								<div class="list-box d-flex">
									<div class="list-icon">
										<i class="fas fa-shipping-fast"></i>
									</div>
									<div class="content">
										<h3>Home Delivery</h3>
										<p>sit voluptatem accusantium dolore mque laudantium, totam rem aperiam, eaque ipsa quae ab illo.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 mb-5 mb-md-5">
								<div class="list-box d-flex">
									<div class="list-icon">
										<i class="fas fa-money-bill-alt"></i>
									</div>
									<div class="content">
										<h3>Best Price</h3>
										<p>sit voluptatem accusantium dolore mque laudantium, totam rem aperiam, eaque ipsa quae ab illo.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 mb-5 mb-md-5">
								<div class="list-box d-flex">
									<div class="list-icon">
										<i class="fas fa-briefcase"></i>
									</div>
									<div class="content">
										<h3>Custom Box</h3>
										<p>sit voluptatem accusantium dolore mque laudantium, totam rem aperiam, eaque ipsa quae ab illo.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="list-box d-flex">
									<div class="list-icon">
										<i class="fas fa-sync-alt"></i>
									</div>
									<div class="content">
										<h3>Quick Refund</h3>
										<p>sit voluptatem accusantium dolore mque laudantium, totam rem aperiam, eaque ipsa quae ab illo.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end featured section -->

	<!-- team section -->
	<div class="mt-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">
						<h3>Our <span class="orange-text">Team</span></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="single-team-item">
						<div class="team-bg team-bg-1"></div>
						<h4>Jimmy Doe <span>Farmer</span></h4>
						<ul class="social-link-team">
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="single-team-item">
						<div class="team-bg team-bg-2"></div>
						<h4>Marry Doe <span>Farmer</span></h4>
						<ul class="social-link-team">
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
					<div class="single-team-item">
						<div class="team-bg team-bg-3"></div>
						<h4>Simon Joe <span>Farmer</span></h4>
						<ul class="social-link-team">
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end team section -->

	<!-- testimonail-section -->
	<div class="testimonail-section mt-80 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<div class="testimonial-sliders">
						<div class="single-testimonial-slider">
							<div class="client-avater">
								<img src="../assets/img/avaters/avatar1.png" alt="">
							</div>
							<div class="client-meta">
								<h3>Saira Hakim <span>Local shop owner</span></h3>
								<p class="testimonial-body">
									" Sed ut perspiciatis unde omnis iste natus error veritatis et  quasi architecto beatae vitae dict eaque ipsa quae ab illo inventore Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium "
								</p>
								<div class="last-icon">
									<i class="fas fa-quote-right"></i>
								</div>
							</div>
						</div>
						<div class="single-testimonial-slider">
							<div class="client-avater">
								<img src="../assets/img/avaters/avatar2.png" alt="">
							</div>
							<div class="client-meta">
								<h3>David Niph <span>Local shop owner</span></h3>
								<p class="testimonial-body">
									" Sed ut perspiciatis unde omnis iste natus error veritatis et  quasi architecto beatae vitae dict eaque ipsa quae ab illo inventore Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium "
								</p>
								<div class="last-icon">
									<i class="fas fa-quote-right"></i>
								</div>
							</div>
						</div>
						<div class="single-testimonial-slider">
							<div class="client-avater">
								<img src="../assets/img/avaters/avatar3.png" alt="">
							</div>
							<div class="client-meta">
								<h3>Jacob Sikim <span>Local shop owner</span></h3>
								<p class="testimonial-body">
									" Sed ut perspiciatis unde omnis iste natus error veritatis et  quasi architecto beatae vitae dict eaque ipsa quae ab illo inventore Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium "
								</p>
								<div class="last-icon">
									<i class="fas fa-quote-right"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end testimonail-section -->

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
</body>
</html>
<?php
	//Checks if User is Logged In
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
?>