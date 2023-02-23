<?php
    //Gets the User's Products from Cart
    if(isset($_SESSION['createtable'])){
        $get = $conn->query('SELECT * FROM `$username`');
        if($get->num_rows > 0){
            $i = 0;
            while($row = $get->fetch_assoc()){
                $name[$i] = $row['name'];
                $total[$i] = $row['total'];
                $i++;
            }
        }
    }
?>
<html lang='en'>
    <head>
        <link rel='stylesheet' href='../../assets/css/main.css'>
        <link rel='stylesheet' href='../../assets/bootstrap/css/bootstrap.min.css'>
        <title>Contact Form</title>
        <style>
            *{
                padding: 0;
                margin-top: 20px;
                box-sizing: border-box;
                font-family: 'Open Sans', sans-serif;
            }
            .pagewrapper{
                width: 100%;
                padding: 10px;
                color: #F28123;
                background-color: white;
            }
            .formwrapper{
                border: 1px solid #051922;
                padding: 10px;
                border-radius: 15px;
            }
            h2{
                margin: 20px auto; 
                color: #F28123; 
                font-size: 35px;
                text-align: center;
            }
            span{
                color: #051922 !important;
            }
        </style>
    </head>
    <body>
        <div class='pagewrapper'>
            <div class='formwrapper'>
                <h2>TeeJay<span>Store</span></h2>
                <h4>Taiwo Joshua Checkout</h4>
                <p>Full Name: <span>Taiwo Joshua</span></p>
                <p>E-Mail: <span>example@gmail.com</span></p>
                <p>Phone Number: <span>0812346788</span></p>
                <p>Message: <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit praesentium veniam accusamus exercitationem asperiores neque modi non, eligendi consequatur doloribus. Facilis magni accusantium, officia sed, inventore modi accusamus neque harum atque rem autem a illum maxime amet necessitatibus quisquam tempora natus? Quis, labore doloribus? Praesentium saepe suscipit dolore id excepturi.</span></p>
                <div class='col-lg-4'>
					<div class='order-details-wrap'>
						<table class='order-details'>
							<thead>
								<tr>
									<th>Your order Details</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody class='order-details-body'>
								<tr>
									<td>Product</td>
									<td>Total</td>
								</tr>
							</tbody>
							<tbody class='checkout-details'>
								<tr>
									<td>Subtotal</td>
									<td id='subtotal'>₦0</td>
								</tr>
								<tr>
									<td>Shipping</td>
									<td id='shipping'>₦500</td>
								</tr>
								<tr>
									<td>Total</td>
									<td id='finaltotal'>₦500</td>
								</tr>
							</tbody>
						</table>
						<input type='submit' class='boxed-btn' style='margin-top: 5px;' form='form1' value='Place Order'>
					</div>
				</div>
            </div>
        </div>
        <script>
            //Gets User's Products
            var names = <?php echo json_encode($name); ?>;
            var total = <?php echo json_encode($total); ?>;
            var subtotal = 0;
            for(i = 0; i < names.length; i++){
                $('.order-details-body').append('<tr><td>' + names[i] + '</td><td>₦' + total[i] + '</td></tr>');
                subtotal += parseInt(total[i]);
            }
    
            //Calc Subtotal and Total
            $('#subtotal').text('₦' + subtotal);
            var shipping = parseInt(($('#shipping').text()).slice(1));
            var finaltotal = subtotal + shipping;
            $('#finaltotal').text('₦' + finaltotal);
        </script>
    </body>
    </html>