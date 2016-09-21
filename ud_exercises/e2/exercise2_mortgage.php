<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Exercise 2 - Mortgage Calculation</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>


<?php

// Gather Data from Form

$homeprice = $_POST['homeprice'];
$interestrate = $_POST['interestrate'];
$downpayment = $_POST['downpayment'];
$loanterm = $_POST['loanterm'];

if (!empty($homeprice)) {
    $homeprice_formatted = number_format($homeprice);
}
if (!empty($downpayment)) {
    $downpayment_formatted = number_format($downpayment);
}
//Do Validations

$msg = "";
$error_cnt = 0;

if (empty($homeprice)) {
    $msg .= "<p><span class='errormsg'>Please enter an amount for the home price.</span></p>";
    $error_cnt++;
} else {
    if (!is_numeric($homeprice)) {
	$msg .= "<p><span class='errormsg'>Amount entered, '".$homeprice_formatted."' is not numeric.</span></p>";
	$error_cnt++;
    }
}

if (empty($interestrate)) {
    $msg .= "<p><span class='errormsg'>Please enter an interest rate.</span></p>";
    $error_cnt++;
} else {
    if (!is_numeric($interestrate)) {
	$msg .= "<p><span class='errormsg'>Interest rate entered, '".$interestrate."' is not numeric.</span></p>";
	$error_cnt++;
    }
}

if (empty($downpayment)) {
    $msg .= "<p><span class='errormsg'>Please enter an amount for the down payment.</span></p>";
    $error_cnt++;
} else {
    if (!is_numeric($downpayment)) {
	$msg .= "<p><span class='errormsg'>Down payment entered, '".$downpayment_formatted."' is not numeric.</span></p>";
	$error_cnt++;
    }
}

if (empty($loanterm)) {
    $msg .= "<p><span class='errormsg'>Please enter the number of years for the loan term.</span></p>";
    $error_cnt++;
} else {
    if (!is_numeric($loanterm)) {
	$msg .= "<p><span class='errormsg'>Loan term entered, '".$loanterm."' is not numeric.</span></p>";
	$error_cnt++;
    }
}

//Do Calculations

if (!empty($homeprice) && !empty($downpayment) && !empty($interestrate) && !empty($loanterm)) {
    
    $interestrate_forcalc = $interestrate / 100 ;

    $interestrate_forcalc_monthly = $interestrate_forcalc / 12;

    $number_of_months = $loanterm * 12;

    $principal = $homeprice - $downpayment;

    $principal_formatted = number_format($principal);

    $monthly_payment = $principal * $interestrate_forcalc_monthly * ( pow(1+$interestrate_forcalc_monthly, $number_of_months) / (pow(1+$interestrate_forcalc_monthly, $number_of_months)-1));

    $monthly_payment_formatted = number_format($monthly_payment, 2);

    $interest_paid_monthly = $monthly_payment - ($principal / $number_of_months);

    $interest_paid_monthly_formatted = number_format($interest_paid_monthly, 2);

    $principal_paid_monthly = $principal / $number_of_months;

    $principal_paid_monthly_formatted = number_format($principal_paid_monthly, 2);

    $total_cost = $monthly_payment * $number_of_months;

    $total_cost_formatted = number_format($total_cost, 2);

    $total_interest = ($monthly_payment * $number_of_months) - $principal;

    $total_interest_formatted = number_format($total_interest, 2);

    $yearly_total_cost = $total_cost / $loanterm;

    $yearly_total_cost_formatted = number_format($yearly_total_cost, 2);
}
?>
    
    <h1><a href='exercise2.html'>Exercise 2</a></h1>
    
    <?php

    if ($error_cnt > 0) {
	print "<div class='providedInfo'>" . $msg . "</div><!-- .providedInfo -->";
    } else {
	// Return input
	print "<div class='providedInfo'><h2>Provided information</h2>";
	print "<p><span class='fieldLabel infoProv'>Home price: </span>£".$homeprice_formatted."</p>";
	print "<p><span class='fieldLabel infoProv'>Interest rate: </span>".$interestrate."%</p>";
	print "<p><span class='fieldLabel infoProv'>Down payment: </span>£".$downpayment_formatted."</p>";
	print "<p><span class='fieldLabel infoProv'>Loan term: </span>".$loanterm."</p>";
	// Display interim calculations
	print "<div class='interimCalc'><h3>Interim calculations</h3>";
	print "<p><span class='fieldLabel infoProv interCalc'>Number of months: </span>".$number_of_months."<br><span class='additionalInfo'> = Loan term * 12</span></p>";
	print "<p><span class='fieldLabel infoProv interCalc'>Monthly interest rate for calculation: </span>".$interestrate_forcalc_monthly."<br><span class='additionalInfo'> = (Interest rate / 100) / 12</span></p>";
	print "<p><span class='fieldLabel infoProv interCalc'>Principal: </span>£".$principal_formatted."<br><span class='additionalInfo'> = Home price - Down payment</span></p>";
	print "</div><!-- .interimCalc --></div><!-- .providedInfo -->";
	//Display results
	print "<div class='mortgageresults'><h2>Mortgage Calculations</h2>";
	print "<p><span class='fieldLabel mortgageRes'>Monthly Payment:</span>£".$monthly_payment_formatted."</p>";
	print "<p class='additionalInfo'>Monthly payment = Principal * Monthly interest rate * ((1 + Monthly interest rate)<sup>Number of months</sup> / (((1 + Monthly interest rate)<sup>Number of months</sup>) - 1 ))</p>";
	print "<p><span class='fieldLabel mortgageRes'>Monthly principal:</span>£". $principal_paid_monthly_formatted . "</p>";
	print "<p class='additionalInfo'>Monthly principal = Principal / Number of months</p>";
	print "<p><span class='fieldLabel mortgageRes'>Monthly interest:</span>£". $interest_paid_monthly_formatted . "</p>";
	print "<p class='additionalInfo'>Monthly interest = Montly Payment - (Principal / Number of months)</p>";
	print "<p><span class='fieldLabel mortgageRes'>Total cost of mortgage:</span>£". $total_cost_formatted . "</p>";
	print "<p class='additionalInfo'>Total cost of mortgage = Monthly Payment * Number of months</p>";
	print "<p><span class='fieldLabel mortgageRes'>Total compounded interest:</span>£". $total_interest_formatted . "</p>";
	print "<p class='additionalInfo'>Total interest = (Monthly Payment * Number of months) - Principal</p>";
	print "<p><span class='fieldLabel mortgageRes'>Total cost of mortgage per year:</span>£". $yearly_total_cost_formatted . "</p>";
	print "<p class='additionalInfo'>Total cost of mortgage per year = Total cost of mortgage / Loan term</p></div><!-- .mortgageresults -->";
    }

    ?>
    
</body>
</html>
