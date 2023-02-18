<?php
	include 'dbconnect.php';
	
	$username = '';

	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	}

	$name = $price = $img = $class = $rate = array();

	$get = $conn->query("SELECT * FROM `products`");
	if($get->num_rows > 0){
		$i = 0;
		while($row = $get->fetch_assoc()){
			$name[$i] = $row['name'];
			$price[$i] = $row['price'];
			$img[$i] = $row['img'];
			$class[$i] = $row['class'];
			$rate[$i] = $row['rate'];
			$i++;
		}
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
	<title>Shop</title>

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
										<a class="mobile-hide search-bar-icon"><i class="fas fa-search"></i></a>
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
						<h1>Shop</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">

			<div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <!-- <li data-filter=".Strawberry">Strawberry</li>
                            <li data-filter=".Berry">Berry</li>
                            <li data-filter=".Lemon">Lemon</li> -->
                        </ul>
                    </div>
                </div>
            </div>

			<div class="row product-lists">
				<!-- <div class="col-lg-4 col-md-6 text-center strawberry">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product.php"><img src="../assets/img/products/product-img-6.jpg" alt=""></a>
						</div>
						<h3>Strawberry</h3>
						<p class="product-price"><span>Per Kg</span> 80$ </p>
						<a href="cart.php" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
					</div>
				</div> -->
			</div>

			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="pagination-wrap">
						<ul>
							<!-- <li><a href="#">Prev</a></li> -->
							<!-- <li><a data-filter=".one" class="active">1</a></li> -->
							<!-- <li><a data-filter=".two">2</a></li> -->
							<!-- <li><a data-filter=".three">3</a></li> -->
							<!-- <li><a href="#">Next</a></li> -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end products -->

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
	<!-- numtoword js -->
	<script src="../assets/js/numtoword.js"></script>
	<!-- wordtonum js -->
	<script src="../assets/js/wordtonum.js"></script>
	<script src="../assets/js/sweetalert.min.js"></script>
	<script>
		var names = <?php echo json_encode($name); ?>;
		var img = <?php echo json_encode($img); ?>;
		var classes = <?php echo json_encode($class); ?>;
		var price = <?php echo json_encode($price); ?>;
		var rate = <?php echo json_encode($rate); ?>;
		var classfilter = [];
		var page = 1;
		for(i = 0; i < names.length; i++){
			if((i+1) < (page * 12)){
				var pclass = convertNumberToWords(page);
			}else{
				var pclass = convertNumberToWords(page);
				page++;
			}

			$(".product-lists").append('<div><div class="single-product-item"><div class="product-image"><a href="single-product.php"><img src="' + img[i] + '" alt="' + names[i] + '"></a></div><h3>' + names[i] + '</h3><p class="product-price"><span>' + rate[i] + '</span> ₦' + price[i] + '</p><a id="cart' + i + '" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a><a class="delete"><i class="fas fa-trash"></i></a></div></div>');
			$(".product-lists>div:nth-child(" + (i+1) + ")").addClass("col-lg-4 col-md-6 text-center " + classes[i] + " " + pclass);

			//Filter Classes for unique values
			classfilter = names.filter((item, j, ar) => ar.indexOf(item) === j);
		}

		// Create Filter Buttons
		for(i = 0; i < classfilter.length; i++){
			$(".product-filters>ul").append('<li data-filter=".' + classfilter[i] + '">' + classfilter[i] + '</li>')
		}

		// Create Page Filter Buttons
		$(".pagination-wrap>ul").append('<li><a class="prev" data-filter=".' + convertNumberToWords(i + 1) + '">Prev</a></li>')
		for(i = 0; i < page; i++){
			$(".pagination-wrap>ul").append('<li><a data-filter=".' + convertNumberToWords(i + 1) + '">' + (i + 1) + '</a></li>')
		}
		$(".pagination-wrap>ul").append('<li><a class="next" data-filter=".' + convertNumberToWords(i + 1) + '">Next</a></li>')

		$(".product-lists").isotope({
            filter: '.one',
        }); 
		$(".pagination-wrap>ul>li:nth-child(2)>a").addClass("active");

		// Functionality of Prev and Next
		var now;
		$(".pagination-wrap>ul>li>a").click(function(){
			now = $(".pagination-wrap>ul>li>.active").attr('data-filter');
		});

		$(".prev").click(function(){
			if(now == undefined){
				var selector = '.one';
        
				$(".product-lists").isotope({
					filter: selector,
				});

				$(".pagination-wrap>ul>li>a").removeClass("active");
				$(".prev").removeClass("active");
				$(".pagination-wrap>ul>li:nth-child(2)>a").addClass("active");
			}else{
				now = now.slice(1);
				now = text2num(now);
				now = now - 1;
				if(now > 0){
					$(".pagination-wrap>ul>li>a").removeClass("active");
					$(".prev").removeClass("active");
					$(".pagination-wrap>ul>li:nth-child(" + (now + 1) + ")>a").addClass("active");
					now = convertNumberToWords(now);
					$(this).attr('data-filter', "." + now);
					var selector = $(this).attr('data-filter');
					$(".product-lists").isotope({
						filter: selector,
					});
				}else{
					var selector = '.one';
			
					$(".product-lists").isotope({
						filter: selector,
					});

					$(".pagination-wrap>ul>li>a").removeClass("active");
					$(".prev").removeClass("active");
					$(".pagination-wrap>ul>li:nth-child(2)>a").addClass("active");
				}
			}
		});

		$(".next").click(function(){
			if(now == undefined){
				var selector = '.two';
        
				$(".product-lists").isotope({
					filter: selector,
				});

				$(".pagination-wrap>ul>li>a").removeClass("active");
				$(".next").removeClass("active");
				$(".pagination-wrap>ul>li:nth-child(3)>a").addClass("active");
			}else{
				now = now.slice(1);
				now = text2num(now);
				now = now + 1;
				if(now > 0 && now <= page){
					$(".pagination-wrap>ul>li>a").removeClass("active");
					$(".next").removeClass("active");
					$(".pagination-wrap>ul>li:nth-child(" + (now + 1) + ")>a").addClass("active");
					now = convertNumberToWords(now);
					$(this).attr('data-filter', "." + now);
					var selector = $(this).attr('data-filter');
				
					$(".product-lists").isotope({
						filter: selector,
					});
				}else{
					var selector = '.' + convertNumberToWords(page);
					$(".product-lists").isotope({
						filter: selector,
					});
					$(".pagination-wrap>ul>li>a").removeClass("active");
					$(".next").removeClass("active");
					$(".pagination-wrap>ul>li:nth-child(" + (page + 1) + ")>a").addClass("active");
				}
			}
		});

		$(".cart-btn").click(function(){
			let id = $(this).attr('id');
			id = parseInt(id.slice(id.length - 1));
			$(".product-lists").append('<form style="visibility: hidden;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="cartform" method="POST"><input required type="text" name="pname" value="' + names[id] + '"><input required type="text" name="pimg" value="' + img[id] + '"><input type="number" required name="pprice" value="' + price[id] + '"></form>')
			$("#cartform").submit();
		})

		$(".delete").click(function(){
			index = $(".delete").index($(this));
			swal({
				icon: "warning",
				title: 'Confirm Delete',
				text: 'Proceed to delete ' + names[index] + '?',
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

		function deleted(){
			swal({
				icon: "success",
				title: 'Deleted Successfully',
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

			}else{
				$send = $conn->query("INSERT INTO `$username`(`name`, `img`, `price`, `total`) VALUES ('$pname','$pimg', $pprice, $pprice)");
				echo '<script>$("#cartform").remove()</script>';
			}
		}else{
			$_SESSION['shop'] = 1;
			header("location: ./login.php");
		}
	};

	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletename'])){
		$dname = $_POST['deletename'];
		$conn->query("DELETE FROM `products` WHERE `products`.`name`='$dname'");
		header("Refresh:0");
		echo '<script> deleted() </script>';
	};

	if(isset($_SESSION['admin']) && $_SESSION['admin'] == "admin"){
		echo '<script>
				$("#addproduct").show();
				$(".delete").show();
			</script>';
	}else{
		echo '<script>
				$("#addproduct").hide();
				$(".delete").hide();
			</script>';
	};
?>