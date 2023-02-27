<?php
	include 'dbconnect.php';
	
	$username = $admin = $dname = $pname = $keyword = $added = $alreadyadded = $delete = '';
	$pagenum = 2;
	
	//Check if user is logged in
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	}

	if(isset($_SESSION['admin'])){
		$admin = "Admin";
	}

	//Select all products from Database
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
	};

	//Store the current page that is clicked
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pagenum'])){
		$pagenum = $_POST['pagenum'];
	};

	//Onsubmission of Search Form
	if(isset($_POST['searchbtn']) && $_SERVER["REQUEST_METHOD"] == "POST"){
		$keyword = $_POST['keyword'];
		$keyword = ".".strtolower($keyword);
	}

	// Onclick of Add to Cart 
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
			header("location: ./login.php");
		}
	};

	// Onclick of Delete
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletename'])  && $_SESSION['admin'] == "admin"){
		$dname = $_POST['deletename'];
		$get = $conn->query("SELECT * FROM `products` WHERE `products`.`name`='$dname'");
		if($get->num_rows > 0){
			while($row = $get->fetch_assoc()){
				$img = $row['img'];
			}
		}
		if($img == '../assets/img/products/product.jpg'){

		}else{
			unlink($img);
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
	<title>Shop</title>

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
								<li class="current-list-item"><a href="shop.php"><i class="fas fa-store ititle"></i> Shop</a></li>
                                <li>
									<div class="header-icons">
										<a class="shopping-cart" href="cart.php"><i class="fas fa-shopping-cart"></i><span class="ititle ititle2">&nbsp;&nbsp;Cart</span></a>
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
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="search-bar">
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

                        </ul>
                    </div>
                </div>
            </div>

			<div class="row product-lists">
				
			</div>

			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="pagination-wrap">
						<ul>
							
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end products -->

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
	
	<!-- Javascipt Files and Libraries -->

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
	
	<!-- numtoword js -->
	<script src="../assets/js/numtoword.js"></script>
	
	<!-- wordtonum js -->
	<script src="../assets/js/wordtonum.js"></script>
	
	<!-- sweetalert js -->
	<script src="../assets/js/sweetalert.min.js"></script>

	<script>
		//Get all products from db and insert them
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

			$(".product-lists").append('<div><div class="single-product-item"><div class="product-image"><a id="product' + i + '"><img src="' + img[i] + '" alt="' + names[i] + '"></a></div><h3>' + names[i] + '</h3><p class="product-price"><span>' + rate[i] + '</span> ₦' + price[i] + '</p><a id="cart' + i + '" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a><a class="delete"><i class="fas fa-trash"></i></a></div></div>');
			$(".product-lists>div:nth-child(" + (i+1) + ")").addClass("col-lg-4 col-md-6 text-center " + classes[i] + " " + pclass);
			
			//Filter Classes for unique values
			clas = classes.join(" ");
			classfilter = clas.split(" ");
			classfilter = classfilter.filter((item, j, ar) => ar.indexOf(item) === j).sort();
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

		//Onclick of Page Number
        $(".pagination-wrap>ul>li>a:not(.prev, .next)").on('click', function () {
            $(".pagination-wrap>ul>li>a").removeClass("active");
            $(this).addClass("active");    
        });

		//Store the clicked Page Number
		$(".pagination-wrap>ul>li>a").click(function(){
			var now = $(".pagination-wrap>ul>li>.active").attr('data-filter');
			now = now.slice(1);
			now = text2num(now);
			now = now + 1;
			$(".product-lists").append('<form style="visibility: hidden;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="pageform" method="POST"><input required type="number" name="pagenum" value="' + now + '"></form>');
			$("#pageform").submit();
			$("#pageform").remove();
		});

		//Add Class Active to Current Page and Filter
		var pagenum = <?php echo $pagenum ?>;
		$(".pagination-wrap>ul>li:nth-child(" + pagenum + ")>a").addClass("active");
		var pagefilter = "." + convertNumberToWords(pagenum - 1);
		$(".product-lists").isotope({
            filter: pagefilter,
        });

		// Onclick of Add to Cart 
		$(".cart-btn").click(function(){
			let id = $(this).attr('id');
			id = parseInt(id.slice(id.length - 1));
			$(".product-lists").append('<form style="visibility: hidden;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="cartform" method="POST"><input required type="text" name="pname" value="' + names[id] + '"><input required type="text" name="pimg" value="' + img[id] + '"><input type="number" required name="pprice" value="' + price[id] + '"></form>')
			$("#cartform").submit();
		})

		// Onclick of Product Image
		$(".product-image>a").click(function(){
			let id = $(this).attr('id');
			id = parseInt(id.slice(id.length - 1));
			$(".product-lists").append('<form style="visibility: hidden;" action="./single-product.php" id="singleform" method="POST"><input required type="number" name="productid" value="' + id + '"></form>');
			$("#singleform").submit();
			$("#singleform").remove();
		})

		// Onclick of Delete
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

		//Sweet Alert Search Failed Notification
		function notfound(){
			let keyword = '<?php echo $keyword; ?>';
			keyword = keyword.charAt(0).toUpperCase() + keyword.slice(1);
			swal({
				icon: "error",
				title: 'Search Failed',
				text: keyword + ' not found',
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

		//Sweet Alert No Ticket Notification
		function noticket(){
			swal({
				icon: "error",
				title: 'No Record Found',
				// text: ' not found',
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

		//Search Function
		function search(){
			let selector = '<?php echo $keyword; ?>';
			$(".product-lists").isotope({
                filter: selector,
            });
			count = $(selector + ':not(.isotope-hidden)').length;
			if(count == 0){
				$(".product-lists").isotope({
					filter: '*',
				});
				notfound();
			}
		}
	</script>
</body>
</html>
<?php
	if($keyword != ''){
		echo '<script> search(); </script>';
	}	

	if($alreadyadded == 'alreadyadded'){
		echo '<script>alreadyaddedtocart();</script>';
	}

	if($added == 'added'){
		echo '<script>$("#cartform").remove(); addedtocart();</script>';
	}

	if($delete == 'delete'){
		echo '<script> deleted() </script>';
	}

	//Check if User is Logged In
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

	//Check if Admin is Logged In
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

	if(isset($_SESSION['gettickets'])){
		if($_SESSION['gettickets'] == "failed"){
			echo '<script>
					noticket();
				</script>';
			$_SESSION['gettickets'] = 'delivered';
		}
	}
?>