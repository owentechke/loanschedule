<?php
function fgenerateschedule($loanid, $loandate, $loanprincipalamount, $interestamount, $loanduration){
	//global $dbconnection;
	$totalloanamount = $loanprincipalamount + $interestamount;
	
	$monthlyamount = $totalloanamount/$loanduration; 
	$rounded_monthly_amount = round($monthlyamount, 0);
	echo "Plain ".$monthlyamount."<br>"; 
	echo "Rounded ".$rounded_monthly_amount."<br>"; 
	if ($rounded_monthly_amount < $monthlyamount){
		$monthlyamount = $rounded_monthly_amount + 1;
	}else{
		$monthlyamount = $rounded_monthly_amount;
	}
	$paid_total = 0;
	
	$instalmentdate = new DateTime($loandate);	
	$instalmentdate->modify('+1 month');//2024: added this line so that first payment is not immediate

	for ($i = 1; $i <= $loanduration; $i++) {
		$instdate = $instalmentdate->format('Y-m-d');
		if ($i == $loanduration){ //Last instalment
			$monthlyamount = $totalloanamount - $paid_total;
		}
		//$sql= "INSERT INTO tblloanschedules (loanidf, loanscheduledinstalmentdate, loanscheduledinstalmentamount) VALUES ('$loanid', '$instdate', '$monthlyamount')";
		//$result = mysqli_query($dbconnection, $sql) or die(mysqli_error());
		echo $i." ".$instdate." ".$monthlyamount."<br />";
		$paid_total = $paid_total + $monthlyamount;
		//$instalmentdate->modify('third saturday of next month'); 
		//$instdate = date("Y-m-d", strtotime("+1 month", $instdate));		//Sept 2024
		$instalmentdate->modify('+1 month');
	}
	echo "<br>Loan: ".$totalloanamount." Paid: ".$paid_total;
}

$loanid = 2;
//$loandate = date('Y-m-d', strtotime($_POST['txtloandate']));
$loandate = date('Y-m-d', strtotime("2024-10-30"));
$loanprincipalamount = 60000;
$interestamount = 2800;
$loanduration = 7;

fgenerateschedule($loanid, $loandate, $loanprincipalamount, $interestamount, $loanduration);

?>