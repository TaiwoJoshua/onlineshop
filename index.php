<?php
	include './contents/dbconnect.php';

	$username = $admin = $alreadyadded = $added = $delete = $dname = $pname = '';

	//Checks if User is Logged In
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	} 

	if(isset($_SESSION['admin'])){
		$admin = "Admin";
	} 

	$name = $price = $img = $rate = array();

	// Selects the first 3 Products in the Database
	$get = $conn->query("SELECT * FROM `products`");
	if($get->num_rows > 0){
		$i = 0;
		while($row = $get->fetch_assoc()){
			if($i < 3){}else{break;};
			$name[$i] = $row['name'];
			$price[$i] = $row['price'];
			$img[$i] = $row['img'];
			$rate[$i] = $row['rate'];
			$i++;
		}
	}

	//Onclick of Add to Cart
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pname'])){
		if(isset($_SESSION['username'])){
			if(!isset($_SESSION['createtable'])){
				$_SESSION['createtable'] = 1;
				$conn->query("CREATE TABLE `onlineshopping`.`$username` (`id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(250) NOT NULL , `img` VARCHAR(250) NOT NULL DEFAULT '../assets/img/products/product.jpg' , `price` INT(10) NOT NULL , `quantity` INT(10) NOT NULL DEFAULT '1' , `total` INT(11) NOT NULL , PRIMARY KEY (`id`), UNIQUE `name` (`name`)) ENGINE = InnoDB;");
			}
			$pname = $_POST['pname'];
			$pimg = $_POST['pimg'];
			$pprice = $total = $_POST['pprice'];
			$check = $conn->query("SELECT * FROM `$username` WHERE `name`='$pname'");
			
			if($check->num_rows > 0){
				$alreadyadded = 'alreadyadded';
			}else{
				$send = $conn->query("INSERT INTO `$username`(`name`, `img`, `price`, `total`) VALUES ('$pname','$pimg', $pprice, $pprice)");
				$added = 'added';
			}
		}else{
			$_SESSION['shop'] = 1;
			header("location: ./contents/login.php");
		}
	}

	//Onclick of Delete
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletename']) && $_SESSION['admin'] == "admin"){
		$dname = $_POST['deletename'];
		$get = $conn->query("SELECT * FROM `products` WHERE `products`.`name`='$dname'");
		if($get->num_rows > 0){
			while($row = $get->fetch_assoc()){
				$img = $row['img'];
			}
		}
		if($img == '../assets/img/products/product.jpg'){

		}else{
			unlink(substr($img, 1));
		}
		$conn->query("DELETE FROM `products` WHERE `products`.`name`='$dname'");
		header("Refresh:0");
		$delete = 'delete';
	};
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
	<link rel="stylesheet" href="assets/css/all.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
	
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">

	<!-- Icon -->
	<link rel="icon" href="./assets/img/favicon.png">
    <link rel="apple-touch-icon" href="./assets/img/favicon.png">

	<!-- title -->
	<title>TeeJay Store</title>

	<style>
		.product-image img {
			object-fit: contain;
			height: 200px;
		}
	</style>
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
							<a href="index.php">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="index.php"><i class="fas fa-home ititle"></i> Home</a></li>
								<li><a href="./contents/about.php"><i class="fas fa-info-circle ititle"></i> About</a></li>
								<li><a href="./contents/contact.php"><i class="fas fa-phone ititle"></i> Contact</a></li>
								<li><a href="./contents/shop.php"><i class="fas fa-store ititle"></i> Shop</a></li>
								<li>
									<div class="header-icons">
										<a class="shopping-cart" href="contents/cart.php"><i class="fas fa-shopping-cart"></i><span class="ititle ititle2">&nbsp;&nbsp;Cart</span></a>
										<a href="contents/ticket.php" id="ticketicon"><i class="fas fa-ticket-alt" title="Tickets"></i><span class="ititle ititle2">&nbsp;&nbsp;Tickets</span></a>
										<a class="mobile-hide search-bar-icon"><i class="fas fa-search"></i></a>
										<a href="./contents/login.php" id="loginicon" title="Login/Signup" class="fas fa-user-plus"><span class="ititle ititle2">&nbsp;&nbsp;Login / Signup</span></a>
										<a class="fas fa-user loggedinicon" id="loggedinicon"><span class="ititle ititle2">&nbsp;&nbsp;<?php echo $username.$admin ?></span></a>
										<div id="usercard">
											<img src="./assets/img/user.png" alt="<?php echo $username.$admin ?>">
											<div><?php echo $username.$admin ?></div>
											<a href="./contents/logout.php" class="bordered-btn">Logout</a>
										</div>
										<a class="fas fa-cart-plus" id="addproduct" href="./contents/addproduct.php"><span class="ititle ititle2">&nbsp;&nbsp;Add Product</span></a>
										<a href="./contents/logout.php" class="fas fa-sign-out-alt" id="logouticon" title="Logout"><span class="ititle ititle2">&nbsp;&nbsp;Logout</span></a>
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
					<form method="POST" action="./contents/shop.php" class="search-bar">
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
	<!-- end search area -->

	<!-- home page slider -->
	<div class="homepage-slider">
		<!-- single home slider -->
		<div class="single-homepage-slider homepage-bg-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-lg-7 offset-lg-1 offset-xl-0">
						<div class="hero-text">
							<div class="hero-text-tablecell">
								<p class="subtitle">Fresh & Organic</p>
								<h1>Delicious Seasonal Fruits</h1>
								<div class="hero-btns">
									<a href="./contents/shop.php" class="boxed-btn">Fruit Collection</a>
									<a href="./contents/contact.php" class="bordered-btn">Contact Us</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- single home slider -->
		<div class="single-homepage-slider homepage-bg-2">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1 text-center">
						<div class="hero-text">
							<div class="hero-text-tablecell">
								<p class="subtitle">Fresh Everyday</p>
								<h1>100% Organic Collection</h1>
								<div class="hero-btns">
									<a href="./contents/shop.php" class="boxed-btn">Visit Shop</a>
									<a href="./contents/contact.php" class="bordered-btn">Contact Us</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end home page slider -->

	<!-- features list section -->
	<div class="list-section pt-80 pb-80">
		<div class="container">

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-shipping-fast"></i>
						</div>
						<div class="content">
							<h3>Free Shipping</h3>
							<p>When order over $75</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-phone-volume"></i>
						</div>
						<div class="content">
							<h3>24/7 Support</h3>
							<p>Get support all day</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon">
							<i class="fas fa-sync"></i>
						</div>
						<div class="content">
							<h3>Refund</h3>
							<p>Get refund within 3 days!</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- end features list section -->

	<!-- product section -->
	<div class="product-section mt-150 mb-150">
		<div class="container" style="display: flex; flex-direction: column; align-items: center;">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Our</span> Products</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>

			<div class="row">
				
			</div>
			<a href="./contents/shop.php" class="cart-btn mt-3">Visit Shop</a>
		</div>
	</div>
	<!-- end product section -->

	<!-- cart banner section -->
	<section class="cart-banner pt-100 pb-100">
    	<div class="container">
        	<div class="row clearfix">
            	<!--Image Column-->
            	<div class="image-column col-lg-6">
                	<div class="image">
                    	<div class="price-box">
                        	<div class="inner-price">
                                <span class="price">
                                    <strong>30%</strong> <br> off per kg
                                </span>
                            </div>
                        </div>
                    	<img src="assets/img/a.jpg" alt="">
                    </div>
                </div>
                <!--Content Column-->
                <div class="content-column col-lg-6">
					<h3><span class="orange-text">Deal</span> of the month</h3>
                    <h4>Hikan Strwaberry</h4>
                    <div class="text">Quisquam minus maiores repudiandae nobis, minima saepe id, fugit ullam similique! Beatae, minima quisquam molestias facere ea. Perspiciatis unde omnis iste natus error sit voluptatem accusant</div>
                    <!--Countdown Timer-->
                    <div class="time-counter"><div class="time-countdown clearfix" data-countdown="2020/2/01"><div class="counter-column"><div class="inner"><span class="count">00</span>Days</div></div> <div class="counter-column"><div class="inner"><span class="count">00</span>Hours</div></div>  <div class="counter-column"><div class="inner"><span class="count">00</span>Mins</div></div>  <div class="counter-column"><div class="inner"><span class="count">00</span>Secs</div></div></div></div>
                	<a href="cart.php" class="cart-btn mt-3"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div>
        </div>
    </section>
    <!-- end cart banner section -->
	
	<!-- advertisement section -->
	<div class="abt-section mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<div class="abt-bg">
						<a href="https://www.youtube.com/watch?v=DBLlFWYcIGQ" class="video-play-btn popup-youtube"><i class="fas fa-play"></i></a>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="abt-text">
						<p class="top-sub">Since Year 1999</p>
						<h2>We are <span class="orange-text">TeeJay</span></h2>
						<p>Etiam vulputate ut augue vel sodales. In sollicitudin neque et massa porttitor vestibulum ac vel nisi. Vestibulum placerat eget dolor sit amet posuere. In ut dolor aliquet, aliquet sapien sed, interdum velit. Nam eu molestie lorem.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente facilis illo repellat veritatis minus, et labore minima mollitia qui ducimus.</p>
						<a href="about.php" class="boxed-btn mt-4">know more</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end advertisement section -->
	
	<!-- shop banner -->
	<section class="shop-banner">
    	<div class="container">
        	<h3>December sale is on! <br> with big <span class="orange-text">Discount...</span></h3>
            <div class="sale-percent"><span>Sale! <br> Upto</span>50% <span>off</span></div>
            <a href="shop.php" class="cart-btn btn-lg">Shop Now</a>
        </div>
    </section>
	<!-- end shop banner -->

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
							<li><a href="index.php">Home</a></li>
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
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	
	<!-- isotope -->
	<script src="assets/js/isotope-docs.min.js"></script>
	
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	
	<!-- main js -->
	<script src="assets/js/main.js"></script>
	
	<!-- Seet Alert js -->
	<script src="assets/js/sweetalert.min.js"></script>
	
	<script>
		//get the first 3 products from database
		var names = <?php echo json_encode($name); ?>;
		var img = <?php echo json_encode($img); ?>;
		var price = <?php echo json_encode($price); ?>;
		var rate = <?php echo json_encode($rate); ?>;
		for(i = 0; i < names.length; i++){
			$(".product-section>div>.row:nth-child(2)").append('<div class="col-lg-4 col-md-6 text-center"><div class="single-product-item"><div class="product-image"><a id="product' + i + '"><img src="' + img[i].slice(1) + '" alt="' + names[i] + '"></a></div><h3>' + names[i] + '</h3><p class="product-price"><span>' + rate[i] + '</span> ₦' + price[i] + '</p><a id="cart' + i + '" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a><a class="delete"><i class="fas fa-trash"></i></a></div></div>');
		}

		//Onclick of Add to Cart
		$(".cart-btn").click(function(){
			let id = $(this).attr('id');
			id = parseInt(id.slice(id.length - 1));
			$(".product-section").append('<form style="visibility: hidden;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="cartform" method="POST"><input required type="text" name="pname" value="' + names[id] + '"><input required type="text" name="pimg" value="' + img[id] + '"><input type="number" required name="pprice" value="' + price[id] + '"></form>');
			$("#cartform").submit();
			$("#cartform").remove();
		});

		//Onclick of Product Image
		$(".product-image>a").click(function(){
			let id = $(this).attr('id');
			id = parseInt(id.slice(id.length - 1));
			$(".product-section").append('<form style="visibility: hidden;" action="./contents/single-product.php" id="singleform" method="POST"><input required type="number" name="productid" value="' + id + '"></form>');
			$("#singleform").submit();
			$("#singleform").remove();
		})

		//Onclick of Delete
		$(".delete").click(function(){
			index = $(".delete").index($(this));
			swal({
				icon: "warning",
				title: 'Confirm Delete',
				text: 'This is an irreversible action. Proceed to delete ' + names[index] + '?',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				buttons: {
					cancel: {
						text: "Cancel",
						value: "cancel",
						visible: true,
						closeModal: true
					},
					confirm: {
						text: "Delete",
						value: "delete",
						visible: true,
						closeModal: true
					},
				}
			}).then(okay => {
				if(okay == "delete"){
					$(".product-lists").append('<form style="visibility: hidden;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="deleteform" method="POST"><input required type="text" name="deletename" value="' + names[index] + '"></form>');
					$("#deleteform").submit();
				}
			})
		})

		//Sweet Alert Delete Successful Notification
		function deleted(){
			let dname = '<?php echo $dname; ?>';
			swal({
				icon: "success",
				title: dname + ' Deleted Successfully',
				// text: '',
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

		//Sweet Alert Add to Cart Successful Notification
		function addedtocart(){
			let pname = '<?php echo $pname; ?>';
			swal({
				icon: "success",
				title: 'Success',
				text: pname + ' added to your cart',
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

		//Sweet Alert Add to Cart Failed Notification
		function alreadyaddedtocart(){
			let pname = '<?php echo $pname; ?>';
			swal({
				icon: "error",
				title: 'Failed',
				text: pname + ' already in your cart',
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

		//Sweet Alert Check Out Successful Notification
		function checkedout(){
			swal({
				icon: "success",
				title: 'Checked Out Successfully',
				// text: '',
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
	if($alreadyadded == 'alreadyadded'){
		echo '<script>alreadyaddedtocart();</script>';
	}

	if($added == 'added'){
		echo '<script>$("#cartform").remove(); addedtocart();</script>';
	}

	if($delete == 'delete'){
		echo '<script> deleted() </script>';
	}

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

	if(isset($_SESSION['admin']) && $_SESSION['admin'] == "admin"){
		echo '<script>
				$("#loggedinicon").show();
				$("#loginicon").hide();
				$("#logouticon").show();
				$("#addproduct").show();
				$(".delete").show();
				$("#ticketicon").show();
			</script>';
	}else{
		echo '<script>
				$("#addproduct").hide();
				$(".delete").hide();
			</script>';
	};

	if(isset($_SESSION['checkoutstatus']) && $_SESSION['checkoutstatus'] == "successful"){
		$_SESSION['checkoutstatus'] = "ok";
		echo '<script>checkedout();</script>';
		$conn->query("TRUNCATE TABLE `$username`");
	}
?>