<?php
	include './dbconnect.php';

	$empty = $name = $price = $rate = $class = $tracker = $gname = $gimg = $gprice = $grate = $gclass = $uname = $gempty = $description = $gdescription = '';

	if($_SESSION['admin'] == "admin"){
		if(isset($_POST['submit'])){
			$name = $_POST['name'];
			$class = strtolower($_POST['class']);
			$rate = $_POST['rate'];
			$price = $_POST['price'];
			$description = $_POST['description'];
			$check = $conn->query("SELECT * FROM `products` WHERE `name`='$name'");
			if($check->num_rows > 0){
				$tracker = 'exist';
			}else{
				$filename = $_FILES['img']['name'];
                if(strlen($filename) != 0){
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $file = $_FILES['img']['tmp_name'];
                    $size = $_FILES['img']['size'];

                    if(!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'heic'])){
                            
                    }elseif($size > 102400){ 
                        
                    }else{
                        $newfilename = $name . '.' . $extension;
                        $pathname = "../assets/img/products/" . $newfilename;
                        if(move_uploaded_file($file, $pathname)){
							$conn->query("INSERT INTO `products`(`name`, `img`, `class`, `rate`, `price`, `description`) VALUES('$name', '$pathname', '$class', '$rate', $price, '$description')");
							$tracker = 'added';
							$empty = 'empty';
                        }
                    }
                }else{
					$conn->query("INSERT INTO `products`(`name`, `class`, `rate`, `price`, `description`) VALUES('$name', '$class', '$rate', $price, '$description')");
					$tracker = 'added';
					$empty = 'empty';
				};
			}
		};

		if(isset($_POST['gsubmit'])){
			$gname = $_POST['gname'];
			$get = $conn->query("SELECT * FROM `products` WHERE `name`='$gname'");
			if($get->num_rows > 0){
				while($row = $get->fetch_assoc()){
					$gname = $_SESSION['name'] = $row['name'];
					$gimg = $row['img'];
					$gprice = $row['price'];
					$grate = $row['rate']; 
					$gclass = $row['class'];
					$gdescription = $row['description'];
				}
				$tracker = "pfound";
				$_SESSION['one'] = 1;
				$gempty = "gempty";
			}else{
				$tracker = "pnotfound";
				$_SESSION['one'] = 2;
			}
		}

		if(isset($_POST['usubmit'])){
			$uname = $_POST['uname'];
			$uprice = $_POST['uprice'];
			$urate = $_POST['urate'];
			$uclass = strtolower($_POST['uclass']);
			$gname = $_SESSION['name'];
			$udescription = $_POST['udescription'];
			$check = $conn->query("SELECT * FROM `products` WHERE `name`='$gname'");
			if($check->num_rows > 0){
				$filename = $_FILES['ufile']['name'];
                if(strlen($filename) != 0){
					echo 'got here';
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $file = $_FILES['ufile']['tmp_name'];
                    $size = $_FILES['ufile']['size'];

                    if(!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'heic'])){
                            
                    }elseif($size > 102400){ 
                        
                    }else{
                        $newfilename = $name . '.' . $extension;
                        $pathname = "../assets/img/products/" . $newfilename;
                        if(move_uploaded_file($file, $pathname)){
							$conn->query("UPDATE `products` SET `name`='$uname', `img`='$pathname', `class`='$uclass', `rate`='$urate', `price`=$uprice, `description`='$udescription' WHERE `name`='$gname'");
							$tracker = 'updated';
							$empty = 'empty';
                        }
                    }
                }else{
					$conn->query("UPDATE `products` SET `name`='$uname', `class`='$uclass', `rate`='$urate', `price`=$uprice, `description`='$udescription' WHERE `name`='$gname'");
					$tracker = 'updated';
					$empty = 'empty';
				};
			}
		}
	}else{
		$_SESSION['addproduct'] = 1;
		header("location: ./login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta property="author" content="Taiwo Joshua">
    <meta name="description" content="Change me (up to ~155 characters)">
    <meta property="og:description" content="Change me (up to ~155 characters)">
    <meta property="og:locale" content="en_UK">
    <meta property="og:image" content="https://">
    <meta property="og:title" content="Change me">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://">
    <meta name="theme-color" content="#FF00FF">
    <link rel="stylesheet" href="../assets/css/addproduct.css">
    <link rel="icon" href="../assets/img/favicon.png">
    <link rel="apple-touch-icon" href="../assets/img/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title class="pagetitle">Add New Product</title>
</head>
<body>

    <!--PreLoader-->
    <div class="loader">
      <div class="loader-inner">
        <div class="circle"></div>
      </div>
    </div>
    <!--PreLoader Ends-->

	<!-- logo -->
	<div class="site-logo">
		<a href="../index.php">
			<img src="../assets/img/logo.png" alt="">
		</a>
	</div>
	<!-- logo -->

    <div class="container">
      <div class="forms">
	  	<input type="checkbox" id="flip">
        <div class="form-content" id="addproductform">
            <div class="login-form">
              <div class="title">Add New Product</div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                <div class="input-boxes">
                  <div class="input-box">
                    <i class="fas fa-shopping-bag"></i>
                    <input type="text" id="name" name="name" placeholder="Product Name..." value="<?php if($empty == "empty"){}else{echo $name;} ?>" required>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="class" placeholder="Product Class(es)..." value="<?php if($empty == "empty"){}else{echo $class;} ?>" required>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-coins"></i>
                    <input type="text" id="price" name="price" placeholder="Product Price..." value="<?php if($empty == "empty"){}else{echo $price;} ?>" required>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-shopping-basket"></i>
                    <input type="text" id="rate" name="rate" placeholder="Product Rate..." value="<?php if($empty == "empty"){}else{echo $rate;} ?>" required>
                  </div>
				  <div class="input-box">
                    <i class="fas fa-info"></i>
                    <textarea name="description" placeholder="Product Desciption... (Min of 50 Char and Max of 250 Char)" required maxlength="250" minlength="50"><?php if($empty == "empty"){}else{echo $description;} ?></textarea>
                  </div>
                  <div class="input-box" id="filewrapper">
                    <p><i class="fas fa-image" style="position: relative;"></i> Product Image</p>
                    <input type="file" name="img" accept="image/jpg, image/jpeg image/png imge/heic" id="file">
                    <i>Max Size: 100kb</i>
                    <i class="red" id="max">Max Image Size Exceeded</i>
                    <i class="red" id="format">Unacceptable Image Format</i>
                  </div>
                  <div class="button input-box">
                    <input type="submit" name="submit" value="Add Product" id="submit">
                  </div>
				  <div class="text sign-up-text"><label for="flip">Update Product</label></div>
                </div>
              </form>
            </div>
            <div class="signup-form">
              <div class="title title2">Preview</div>
              <div class="preview-wrapper">
                <div class="single-product-item">
                    <div class="product-image">
                        <a><img src="../assets/img/products/product.jpg" id="pimg"></a>
                    </div>
                    <h3 id="pname">Product Name</h3>
                    <p class="product-price"><span id="prate">Per Unit</span><span id="pprice">Price</span></p>
                    <a class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div>
            </div>
          </div>
		  <div class="form-content" id="updateproductform">
            <div class="login-form">
              <div class="title">Update Product</div>

			  <!-- Get Product to be Updated Form Section -->
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="getupdateform" method="POST">
                <div class="input-boxes">
                  <div class="input-box">
                    <i class="fas fa-shopping-bag"></i>
                    <input type="text" name="gname" value="<?php if($gempty == "gempty"){}else{echo $gname;} ?>" placeholder="Product Name..." required>
                  </div>
                  <div class="button input-box">
                    <input type="submit" value="Submit" name="gsubmit">
                  </div>
				  <div class="text sign-up-text"><label for="flip">Add New Product</label></div>
                </div>
              </form>

			  <!-- Update Form Section -->
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data" id="updateform">
                <div class="input-boxes">
					<div class="input-box">
						<i class="fas fa-shopping-bag"></i>
						<input type="text" id="uname" required value="<?php if($empty == "empty"){}else{echo $gname;} ?>" name="uname" placeholder="New Product Name...">
					</div>
					<div class="input-box">
						<i class="fas fa-search"></i>
						<input type="text" value="<?php if($empty == "empty"){}else{echo $gclass;} ?>" placeholder="New Product Class..." required name="uclass">
					</div>
					<div class="input-box">
						<i class="fas fa-coins"></i>
						<input type="text" id="uprice" value="<?php if($empty == "empty"){}else{echo $gprice;} ?>" required placeholder="New Product Price..." name="uprice">
					</div>
					<div class="input-box">
						<i class="fas fa-shopping-basket"></i>
						<input type="text" id="urate" value="<?php if($empty == "empty"){}else{echo $grate;} ?>" required placeholder="New Product Rate..." name="urate">
					</div>
					<div class="input-box">
                    <i class="fas fa-info"></i>
                    <textarea name="udescription" placeholder="New Product Desciption... (Min of 50 Char and Max of 250 Char)" required maxlength="250" minlength="50"><?php if($empty == "empty"){}else{echo $gdescription;} ?></textarea>
                  </div>
					<div class="input-box" id="ufilewrapper">
						<p><i class="fas fa-image" style="position: relative;"></i> Product Image</p>
						<input type="file" name="ufile" accept="image/jpg, image/jpeg image/png imge/heic" id="ufile">
						<i>Max Size: 100kb</i>
						<i class="red" id="umax">Max Image Size Exceeded</i>
						<i class="red" id="uformat">Unacceptable Image Format</i>
					</div>
					<div class="button input-box">
						<input type="submit" name="usubmit" value="Update Product" id="usubmit">
					</div>
					<div class="text sign-up-text"><label for="flip">Add New Product</label></div>
                </div>
              </form>
            </div>
            <div class="signup-form">
              <div class="title title2">Preview</div>
              <div class="preview-wrapper">
                <div class="single-product-item">
                    <div class="product-image">
                        <a><img src="<?php if($gimg == ''){echo '../assets/img/products/product.jpg';}else{echo $gimg;} ?>" id="upimg"></a>
                    </div>
                    <h3 id="upname"><?php if($gname == ''){echo 'Product Name';}else{echo $gname;} ?></h3>
                    <p class="product-price"><span id="uprate"><?php if($grate == ''){echo 'Per Unit';}else{echo $grate;} ?></span><span id="upprice"><?php if($gprice == ''){echo 'Price';}else{echo '₦'.$gprice;} ?></span></p>
                    <a class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div>
            </div>
          </div>
      </div>
    </div>
    <script src="../assets/js/jquery-1.11.3.min.js"></script>
	<script src="../assets/js/sweetalert.min.js"></script>
    <script src="../assets/js/addproduct.js"></script>
	<script>
		function added(){
			let product = '<?php echo $name ?>';
			swal({
				icon: "success",
				title: product + ' Added Successfully',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				}
			})
		}
		function exist(){
			let product = '<?php echo $name ?>';
			swal({
				icon: "error",
				title: 'Product ' + product + ' Exists',
				text: 'You can use the update option if you wish to make changes to this product',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				}
			})
		}
		function pnotfound(){
			let product = '<?php echo $gname ?>';
			swal({
				icon: "error",
				title: 'Product ' + product + ' does not Exist',
				text: 'You can use the add new product option if you wish to add this product to your collection',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				buttons: {
					cancel: {
						text: "Continue",
						value: "continue",
						visible: true,
						closeModal: true
					},
					confirm: {
						text: "Add Product",
						value: "addproduct",
						visible: true,
						closeModal: true
					},
				},
			}).then(okay => {
				if(okay == "addproduct"){
					$("#flip").attr("checked", true);
				}
			})
		}
		function updated(){
			let product = '<?php echo $uname ?>';
			swal({
				icon: "success",
				title: product + ' Updated Successfully',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				}
			})
		}
	</script>
  </body>
</html>      
<?php
	if($tracker == 'added'){
		echo '<script>
				added();
			</script>';
	}
	if($tracker == 'exist'){
		echo '<script>
				exist();
			</script>';
	}
	if($tracker == "pfound"){
		if($_SESSION['one'] == 1){
			$_SESSION['one'] = 0;
			echo '<script>
					$("#getupdateform").hide();
					$("#addproductform").hide();
					$("#updateform").show();
					$("#updateproductform").css("display", "flex");
				</script>';
		}
	}
	if($tracker == "pnotfound"){
		if($_SESSION['one'] == 2){
			$_SESSION['one'] = 0;
			echo '<script>
					pnotfound();
				</script>';
		}
	}
	if($tracker == 'updated'){
		echo '<script>
					updated();
				</script>';
	}
?>