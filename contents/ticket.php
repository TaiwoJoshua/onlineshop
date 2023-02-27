<?php
    include './dbconnect.php';

	$admin = $username = "";

    //Select all tickets from Database
	$usernamet = $price = $email = $ticket = $products = $status = $quantity = $time = array();

    //Check if user is logged in
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];

        $get = $conn->query("SELECT * FROM `tickets` WHERE `username`='$username'");
        if($get->num_rows > 0){
            $i = 0;
            while($row = $get->fetch_assoc()){
                $usernamet[$i] = $row['username'];
                $email[$i] = $row['email'];
                $price[$i] = $row['price'];
                $ticket[$i] = $row['ticket'];
                $products[$i] = $row['products'];
                $quantity[$i] = $row['quantity'];
                $status[$i] = $row['status'];
                $time[$i] = $row['time'];
                $i++;
            }
        }else{
            $_SESSION['gettickets'] = "failed";
            header("location: ./shop.php");
        };
	}else if(isset($_SESSION['admin']) && $_SESSION['admin'] == "admin"){
		$admin = "Admin";
        $get = $conn->query("SELECT * FROM `tickets`");

        if($get->num_rows > 0){
            $i = 0;
            while($row = $get->fetch_assoc()){
                $usernamet[$i] = $row['username'];
                $email[$i] = $row['email'];
                $price[$i] = $row['price'];
                $ticket[$i] = $row['ticket'];
                $products[$i] = $row['products'];
                $quantity[$i] = $row['quantity'];
                $status[$i] = $row['status'];
                $time[$i] = $row['time'];
                $i++;
            }
        };
    }else{
		$_SESSION['ticketpage'] = "ticket";
        header("location: ./login.php");
    }

	if(isset($_POST['submit'])){
		$num = $_POST['num'];
		$newlycompletedticket = array();
		for($i = 0; $i < $num; $i++){
			$ticketnumber = $_POST['ticketnumber'][$i];
			$newstatus = $_POST['statusoption'][$i];

			$compare = $conn->query("SELECT * FROM `tickets` WHERE `ticket`='$ticketnumber'");
			if($compare->num_rows > 0){
				while($row = $compare->fetch_assoc()){
					$oldstatus = $row['status'];
				}
			}

			if($oldstatus !== $newstatus && $newstatus == "completed"){
				$newlycompletedticket[$i] = $ticketnumber;
			}

			$conn->query("UPDATE `tickets` SET `status`='$newstatus' WHERE `ticket`='$ticketnumber'");
			$_SESSION["ticketupdate"] = "updated";
			
		};

		if(count($newlycompletedticket) < 0){
			$_SESSION['newcomplete'] = $newlycompletedticket;
			header("location: ./Mails/completed_order.php");
		}
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
	<title>Tickets</title>
    <style>
        table.order-details thead tr th {
            font-weight: 800;
            border: 2px solid white;
        }
		table.cart-table tbody tr, table.cart-table thead tr{
			width: 100%;
			display: grid;
			grid-template-columns: 3fr 6fr 3fr;
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
								<li><a href="shop.php"><i class="fas fa-store ititle"></i> Shop</a></li>
                                <li>
									<div class="header-icons">
										<a class="shopping-cart" href="cart.php"><i class="fas fa-shopping-cart"></i><span class="ititle ititle2">&nbsp;&nbsp;Cart</span></a>
                                        <a href="ticket.php" id="ticketicon" id="ticketicon" style="color: #F28123;"><i class="fas fa-ticket-alt" title="Tickets"></i><span class="ititle ititle2">&nbsp;&nbsp;Tickets</span></a>
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
						<h1>Tickets</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- ticket -->
    <div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<form class="cart-table-wrap" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <div id="searchwrapper">
                            <div>
                                <i class="fas fa-search"></i>
                                <input type="text" maxlength="10" placeholder="Ticket Number..." id="ticketsearch">
                            </div>
                        </div>
						<table class="cart-table">
							<thead class="cart-table-head">
								<tr class="table-head-row">
									<th class="product-image">Date</th>
									<th class="product-name">Ticket Number</th>
									<th class="product-price">Status</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
						<center><input type="submit" id="updatebtn" value="Update" name="submit" style="margin-top: 10px;" class="cart-btn"></center>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end ticket -->

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
    
	<!-- numtoword js -->
	<script src="../assets/js/numtoword.js"></script>
	
	<!-- Sweet Alert js -->
	<script src="../assets/js/sweetalert.min.js"></script>
	
    <script>
        //Get all products from db and insert them
		var usernames = <?php echo json_encode($usernamet); ?>;
		var email = <?php echo json_encode($email); ?>;
		var ticket = <?php echo json_encode($ticket); ?>;
		var price = <?php echo json_encode($price); ?>;
		var estatus = <?php echo json_encode($status); ?>;
        var quantity = <?php echo json_encode($quantity); ?>;
        var products = <?php echo json_encode($products); ?>;
        var time = <?php echo json_encode($time); ?>;
        var id = 1;
		$('form').append("<input type='hidden' name='num' value='" + usernames.length + "'>");
        for(i = (usernames.length - 1); i >= 0; --i){
            idword = convertNumberToWords(id);

            //Separate Products and Prices
            var eprices = price[i].split(",");
            var eproducts = products[i].split(",");
            var ftotal = 0;

            // Calculate Total
            for(k = 0; k < eprices.length; k++){
                ftotal += parseFloat(eprices[k]);
            }

            $(".cart-table>tbody").append('<tr class="table-body-row t' + ticket[i] + ' ticket' + id + '"><td><label for="'+ idword + '">' + time[i].slice(0, 10) +'</label></td><td><label for="'+ idword + '">' + ticket[i] +'</label></td><td><label for="'+ idword + '" id="label'+ idword + '">' + estatus[i] +'</label></td></tr>');

			admin = "<?php echo $admin ?>";
			if(admin == "Admin"){
				$("#label" + idword).html('<select name="statusoption[]" id="statusselect' + idword + '"><option value="pending">Pending</option><option value="confirmed">Confirmed</option><option value="processing">Processing</option><option value="completed">Completed</option><option value="canceled">Canceled</option></select>');

				var options = document.querySelector('#statusselect' + idword);
				options.value = estatus[i];
			}else{
				if(estatus[i] == "completed"){
					$("#label" + idword).css("color", "green");
				}else if(estatus[i] == "canceled"){
					$("#label" + idword).css("color", "red");
				}else{
					$("#label" + idword).css("color", "#F28123");
				}
			}

            $(".cart-table-wrap").append('<input type="radio" name="ticketradio" id="' + idword + '"><input type="hidden" name="ticketnumber[]" value="' + ticket[i] + '">');
            
            $(".cart-table-wrap").append('<div id="ticket' + idword + '" class="ticketwrapper"><td><div class="order-details-wrap"><table class="order-details"><thead><th colspan="2">Ticket: ' + ticket[i] + '</th><tr><th>Your order Details</th><th>Price</th></tr></thead><tbody class="order-details-body"></tbody><tbody class="checkout-details"><tr class="tbold"><td>TOTAL</td><td>₦' + ftotal + '</td></tr></tbody></table></div></td></div>');

            for(j = 0; j < eprices.length; j++){
                $(".order-details-body").append('<tr><td>' + eproducts[j] +'</td><td>₦' + eprices[j] + '</td></tr>');
            }
            id++;
        }

        $('input[type="radio"]').click(function(event){
            if($(this).is(':checked') == true && event.target.classList.contains("checked")){
                $(".ticketwrapper").css({
                    'transform': 'scale(0)',
                    'position': 'absolute'
                })
                $(this).prop("checked", false);
                $(this).removeClass("checked");
            }
        })

        $('input[type="radio"]').change(function(){
            if($('input[type="radio"]').is(':checked') == true){
                let rid = $(this).attr('id');
                $(this).addClass("checked");
                $(".ticketwrapper").css({
                    'transform': 'scale(0)',
                    'position': 'absolute'
                })
                $("#ticket" + rid).css({
                    'transform': 'scale(1)',
                    'position': 'relative'
                })
            }
        });

		// Ticket Search Function
		$("#ticketsearch").keyup(function(){
			let search = $(this).val();
			if(/^\d+$/.test(search) || search.length == 0) {
				selector = ".t" + search;
				if(search.length == 0){
					selector = "*";
				}
				$(".cart-table>tbody").isotope({
					filter: selector,
					layoutMode: 'vertical',
				});
			}
		})
		$("#ticketsearch").on("paste",function(){
			let search = $(this).val();
			if(/^\d+$/.test(search) || search.length == 0) {
				selector = ".t" + search;
				if(search.length == 0){
					selector = "*";
				}
				$(".cart-table>tbody").isotope({
					filter: selector,
					layoutMode: 'vertical',
				});
			}
		})

		//Sweet Alert Notification for Ticket Update
		function ticketupdated(){
			swal({
				icon: "success",
				title: 'Tickets Updated',
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

		// Show Only the first 10 tickets
		for(i = 1; i <= usernames.length; i++){
			tclass = ".ticket" + i.toString();
			let tclassnum = parseInt(tclass.slice(tclass.length - 1, tclass.length));
			if(tclassnum > 5){
				document.querySelector(tclass).style.display = "none";
			}
		}
		let theight = $(".cart-table>tbody").css("height");
		$("#ticketsearch").keyup(function(){
			let search = $(this).val();
			if(search.length == 0){
				for(i = 1; i <= usernames.length; i++){
					tclass = ".ticket" + i.toString();
					let tclassnum = parseInt(tclass.slice(tclass.length - 1, tclass.length));
					if(tclassnum > 5){
						document.querySelector(tclass).style.display = "none";
						$(".cart-table>tbody").css("height", theight);
					}
				}
			}
		})
    </script>
</body>
</html>
<?php
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
				$("#ticketicon").show();
				$("#updatebtn").show();
			</script>';
	}else{
		echo '<script>
				$("#addproduct").hide();
				$("#updatebtn").hide();
			</script>';
	};

	if(isset($_SESSION["ticketupdate"])){
		if($_SESSION["ticketupdate"] == "updated"){
			$_SESSION["ticketupdate"] = "done";
			echo '<script>
					ticketupdated();
				</script>';
		}
	}
?>