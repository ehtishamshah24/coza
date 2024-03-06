<?php
include('query.php'); 
include('header.php');

if(isset($_POST['addTocart'])) {
    if(isset($_SESSION['finalCart'])) {
        $productId = array_column($_SESSION['finalCart'], 'pId');
        if(in_array($_POST['p_id'], $productId)) {
            echo "<script>alert('Product is already added');</script>";
        } else {
            $_SESSION['finalCart'][] = array(
                "pId" => $_POST['p_id'],
                "pName" => $_POST['p_name'],
                "pPrice" => $_POST['p_price'],
                "pQty" => $_POST['num-product'],
                "pDes" => $_POST['p_des'],
                "pImage" => $_POST['p_image']
            );
            echo "<script>alert('Product added to cart successfully');</script>";
        }
    } else {
        $_SESSION['finalCart'][0] = array(
            "pId" => $_POST['p_id'],
            "pName" => $_POST['p_name'],
            "pPrice" => $_POST['p_price'],
            "pQty" => $_POST['num-product'],
            "pDes" => $_POST['p_des'],
            "pImage" => $_POST['p_image']
        );
        echo "<script>alert('Product added to cart successfully');</script>";
    }
}
						// remove
if(isset($_GET['remove'])){
	$id = $_GET['remove'];
	foreach($_SESSION['finalCart'] as $key =>$value){
		if($id == $value['pId']){
			unset($_SESSION['finalCart'][$key]);
						// reset
			$_SESSION['finalCart'] = array_values($_SESSION['finalCart']);
			echo  "<script>alert('product deleted');location.assign('shoping-cart.php')</script>";
		}
	}
}

						// Update Cart



// Calculate subtotal
$subTotal = 0;
if(isset($_SESSION['finalCart'])) {
    foreach($_SESSION['finalCart'] as $item) {
        $subTotal += ($item['pQty'] * $item['pPrice']);
    }
}

//checkout
if(isset($_GET['checkout'])){
	$uId = $_SESSION['userId'];
	$uName = $_SESSION['userName'];
	$uEmail = $_SESSION['userEmail'];
	foreach($_SESSION['finalCart'] as $key => $value){
		$pId = $value['pId'];
		$pName = $value['pName'];
		$pPrice = $value['pPrice']*$value['pQty'];
		$pQty = $value['pQty'];
		$query =$pdo->prepare("insert into oders (p_id , p_name , p_price , p_qty , u_id , u_name , u_email) values (:pId , :pName , :pPrice , :pQty , :uId , :uName , :uEmail)");
		$query->bindparam('uId',$uId);
		$query->bindparam('uName',$uName);
		$query->bindparam('uEmail',$uEmail);
		$query->bindparam('pId',$pId);
		$query->bindparam('pName',$pName);
		$query->bindparam('pPrice',$pPrice);
		$query->bindparam('pQty',$pQty);
		$query->execute();
		echo"<script>alert('oder placed successfully');
			location.assign('index.php')</script>";
	}

// invoice

$invoice_query= $pdo->prepare("insert into invoices (u_id, u_name, u_email, total_qty, total_amount) values (:u_id, :u_name, :u_email, :total_qty, :total_amount)");

$invoice_query->bindParam('u_id', $uId);
$invoice_query->bindParam('u_name',$uName);
$invoice_query->bindParam('u_email', $uEmail );
$totalQty = 0;
$totalAmount = 0;	

foreach($_SESSION ['finalCart'] as $key=>$value){
$totalQty += $value['pQty'];
$totalAmount += $value['pPrice']*$value['pQty'];
$invoice_query->bindparam('total_qty',$totalQty);
$invoice_query->bindparam('total_amount',$totalAmount);
}
$invoice_query->execute();

	unset($_SESSION['finalCart']);
}


?>



	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>
		

	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85" method="post" action="">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Product</th>
									<th class="column-2">Name</th>
									<th class="column-3">Price</th>
									<th class="column-4">Quantity</th>
									<th class="column-5">Total</th>
									<th class="column-6">Action</th>
									<th class="column-7">Action</th>
								</tr>
								<?php
								if(isset($_SESSION['finalCart'])){
                                    foreach($_SESSION['finalCart'] as $item){

									?>

								<tr class="table_row">
									<td class="column-1">
										<div class="how-itemcart1">
											<img src="AdminPanel/img/<?php echo $item['pImage']?>" alt="IMG">
										</div>
									</td>
									<td class="column-2"><?php echo $item['pName']?></td>
									<td class="column-3">$<?php echo $item['pPrice']?></td>
									<td class="column-4">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">

											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>
											<input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" value=""><?php echo $item['pQty']?>


											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
									</td>
									<td class="column-5">$<?php echo $item['pQty']*$item['pPrice']?></td>

									<td class="column-6 pr-4"><a href="?update<?php echo $item['pId']?>" class="btn btn-outline-success"><i class="fa fa-edit" style="font-size:18px;padding-right:5px;" name="updateQty"></i>Update</a></td>
									<td class="column-6 pr-4"><a href="?remove=<?php echo $item['pId']?>" class="btn btn-outline-danger"><i class="fa fa-trash-o" style="font-size:18px;padding-right:5px;"></i>Remove</a></td>
								</tr>
								<?php
									}
								}
								?>
							</table>

						</div>


						<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
							<div class="flex-w flex-m m-r-20 m-tb-5">
								<input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">
									
								<div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
									Apply coupon
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Cart Totals
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">
								$<?php echo $subTotal ?>
								</span>
							</div>
						</div>

						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Shipping:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<p class="stext-111 cl6 p-t-2">
									There are no shipping methods available. Please double check your address, or contact us if you need any help.
								</p>
								
								<div class="p-t-15">
									<span class="stext-112 cl8">
										Calculate Shipping
									</span>

									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
										<select class="js-select2" name="time">
											<option>Select a country...</option>
											<option>USA</option>
											<option>UK</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>

									<div class="bor8 bg0 m-b-12">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="State /  country">
									</div>

									<div class="bor8 bg0 m-b-22">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Postcode / Zip">
									</div>
									
									<div class="flex-w">
										<div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
											Update Totals
										</div>
									</div>
										
								</div>
							</div>
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
								$<?php echo $subTotal ?>
								</span>
							</div>
						</div>

						<?php 
						if(isset($_SESSION['userEmail'])){
							
						?>

						<a href="?checkout" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceed to Checkout
						</a>
							<?php 
						}
						else{
							?>
							<a  href="signin.php" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceed to Checkout
							</a>
							<?php
						}
							?>
					</div>
				</div>
			</div>
	</form>



	<?php
	include('footer.php')
	?>