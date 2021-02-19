<?php
error_reporting (E_ALL ^ E_NOTICE); 

include("db.php");
session_start();

$pagename="Smart Basket"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file
echo "<h4>".$pagename."</h4>"; //display name of the page on the web page

//if the value of the product id to be deleted (which was posted through the hidden field) is set

if(isset($_POST['del_prodid'])){
//capture the posted product id and assign it to a local variable $delprodid
//unset the cell of the session for this posted product id variable
//display a "1 item removed from the basket" message
	$delprodid=$_POST['del_prodid'];
    unset($_SESSION['basket'][$delprodid]);

    echo "1 item removed from the basket";

	
}
	
	//capture the ID of selected product using the POST method and the $_POST superglobal variable
	//and store it in a new local variable called $newprodid
	
	$newprodid=$_POST['h_prodid'];


	//capture the required quantity of selected product using the POST method and $_POST superglobal variable
	//and store it in a new local variable called $reququantity
	$reququantity=$_POST['h_prodquantity'];

	//Display id of selected product
	//Display quantity of selected product

	//echo "<p>Selected product Id: ".$newprodid;
	//echo "<p>Selected product Quantity: ".$reququantity;

	//create a new cell in the basket session array. Index this cell with the new product id.
	//Inside the cell store the required product quantity
	$_SESSION['basket'][$newprodid]=$reququantity;

	if($_SESSION['basket'][$newprodid]=$reququantity){
	
		echo "<p><b>1 item added to the basket</b></p><br></br>";
	}
	
	if(isset($_SESSION['basket'])){

		$total=0.00;

		echo "<table id='checkouttable' style='width:50%'>";
	
		echo"<tr>";
			echo"<th>product name</th>";
			echo"<th>price</th>";
			echo"<th>selected quantity</th>";
			echo"<th>subtotal</th>";
			echo "<th>Remove Product</th>";				

		echo"</tr>";	
	
		
		foreach($_SESSION['basket'] as $index => $value){
			if (trim($_SESSION['basket'][$index])!='') {

			$SQL="select prodName,prodPrice from Product WHERE prodId='$index'";
			$exeSQL=mysqli_query($conn, $SQL) or die (mysqli_error($conn));
			$arrayp=mysqli_fetch_array($exeSQL);
			
		
			$subtotal=$arrayp['prodPrice']*$value;
			$total=$total+$subtotal;
			
			echo"<tr>";
				echo"<td>".$arrayp['prodName']."</td>";
				echo"<td>".$arrayp['prodPrice']."</td>";
				echo"<td>".$value."</td>";
				echo"<td>".$subtotal."</td>";
				echo "<td>";
				echo "<form action='basket.php' method='POST'>";
					echo"<button type=submit>Remove</button>";

					echo "<input type=hidden name=del_prodid value=$index>";

				echo "</form>";
				echo "</td>";
			echo"</tr>";
		
		}
		}
		echo "<tr>";
				echo"<td colspan=4><b>Total</b></td>";
				echo"<th>".$total."</th>";

			echo"</tr>";
		echo "</table>";

	}else{
		echo "Basket is empty...";
	}

		
			


echo "<br></br><a href='http://localhost/hometeq/clearbasket.php'>CLEAR BASKET</a><br></br>";
echo "New hometeq Customers: <a href='signup.php'>Sign Up</a><br><br>";
echo "Returning hometeq Customers: <a href=' login.php '> Log In</a>";

include("footfile.html"); //include head layout
echo "</body>";
?>