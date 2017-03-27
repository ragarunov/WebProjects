    //********************************************************************************//
    //* Name :  Ronen Agarunov 							                             *//
    //* zenit login : int222_161b01                                                  *//
    //********************************************************************************//
    //********************************************************************************//
    //*   Do not modify any statements in detailPaymentCalculation function          *//
    //********************************************************************************//

function detailPaymentCalculation(mortAmount,mortDownPayment,mortRate,mortAmortization) {

    //********************************************************************************//
    //*   This function calculates the monthly payment based on the following:       *//
    //*                                                                              *//
    //*               M = P [ i(1 + i)n ] / [ (1 +  i)n - 1]                         *//
    //*                                                                              *//
    //*   Note: This function also updates the payment amount on the form            *//
    //********************************************************************************//
     var paymentError = "";
     var v = mortAmount * 1;
     var d = mortDownPayment * 1;
     var i = mortRate * 1;
     var y = mortAmortization * 1;
     var a = v - d;
         i = i/100/12;
         n = y * 12;
     var f = Math.pow((1+i),n);

     var p = (a * ((i*f)/(f-1))).toFixed(2);

     if (p=="NaN" || p=="Infinity") {
         document.forms[0].payment.value = "";
     }
     else {
           document.forms[0].payment.value = p;
     }

} // End of detailPaymentCalculation function


function calculatePayment() {   

    //********************************************************************************//
    //*   You will need to call the functions that validate the following:           *//
    //********************************************************************************//
    //*        (1)              (2)              (3)             (4)                 *//
    //********************************************************************************//
    //*   Property value  -  Down payment  -  Interest rate -  Amortization          *//
    //********************************************************************************//
    //*   If there are no errors, then call                                          *//
    //*                                                                              *//
    //*      detailPaymentCalculation(...., ......, ......, ......);                 *//
    //*                                                                              *//
    //*   and make sure to pass the four values in the order shown above.            *//
    //*                                                                              *//
    //********************************************************************************//
    //*   If there are errors, present the client the following message in the       *//
    //*   reserved area on the form:                                                 *//
    //*                                                                              *//
    //*   Please complete the form first and then click on Calculate Monthly Payment *//
    //*                                                                              *//
    //********************************************************************************//
	
	var errMessages = " ";	//initialising errors to none
	errMessages = propValue(errMessages);
	errMessages = downPaym(errMessages);
	errMessages = rate(errMessages);
	errMessages = amorti(errMessages);
	
	var propVal = document.mortgage.propValue.value;
	var downPay = document.mortgage.downPay.value;
	var intrate =  document.mortgage.intRate.value;
	var amor = document.mortgage.amortization.value;
	
	if (errMessages !== " ") {
		
		errMsg = "<p><b>- Please complete the form first and then click on Calculate Monthly Payment</b></p><br />";
		document.getElementById('errors').innerHTML = errMsg;
		
	}
	
	else {
	
		clearErrors();
		detailPaymentCalculation(propVal, downPay, intrate, amor);
		 
	}
		

} // End of calculatePayment function



function formValidation() {

    //***************************************************************************************//
    //*                                                                                     *//
    //* This function calls the different functions to validate all required fields         *//
    //*                                                                                     *//
    //* Once you have called and validated all field, determine if any error(s)             *//
    //*  have been encountered                                                              *//
    //*                                                                                     *//
    //* If any of the required fields are in error:                                         *//
    //*                                                                                     *//
    //*    present the client with a list of all the errors in reserved area                *//
    //*         on the form and                                                             *//
    //*          don't submit the form to the CGI program in order to allow the             *//
    //*          client to correct the fields in error                                      *//
    //*                                                                                     *//
    //*    Error messages should be meaningful and reflect the exact error condition.       *//
    //*                                                                                     *//
    //*    Make sure to return false                                                        *//
    //*                                                                                     *//
    //* Otherwise (if there are no errors)                                                  *//
    //*                                                                                     *//
    //*    Recalculate the monthly payment by calling                                       *//
    //*      detailPaymentCalculation(mortAmount,mortDownPayment,mortRate,mortAmortization) *//
    //*                                                                                     *//
    //*    Change the 1st. character in the field called client to upper case               *//
    //*                                                                                     *//
    //*    Change the initial value in the field called jsActive from N to Y                *//
    //*                                                                                     *//
    //*    Make sure to return true in order for the form to be submitted to the CGI        *//
    //*                                                                                     *//
    //***************************************************************************************//

	var errMessages = " "; //initialising
	errMessages = userId(errMessages);
	errMessages = client(errMessages);
	errMessages = propValue(errMessages);
	errMessages = downPaym(errMessages);
	errMessages = income(errMessages);
	errMessages = propDetails(errMessages);
	errMessages = propLocation(errMessages);
	errMessages = mortYear(errMessages);
	errMessages = mortMonth(errMessages);
	errMessages = rate(errMessages);
	errMessages = amorti(errMessages);

	
	if (errMessages !== " ") {
		
		showErrors(errMessages);
		return false;
		
	}
	
	else {
	
		clearErrors();
		var Upcase = document.mortgage.client.value;
		document.mortgage.client.value = Upcase.substr(0,1).toUpperCase()+Upcase.substr(1);
		document.mortgage.jsActive.value = "Y";
		return true;
	
	}
		
}

function userId(errMessages) {
	
	var value = document.mortgage.userId.value;
	value = value.trim();
	var length = value.length;
	var sumL = 0;
	var sumR = 0;
	
	if (length === 0) {
		
		errMessages += "- <u>Client ID:</u> must be filled<br />";
		
	}
	
	else {
		
		if (length !== 10) {
			
			errMessages += "- <u>Client ID:</u> must be 10 characters<br />";
			
		}
		
		if (value.charAt(4) !== "-") {
			
			errMessages += "- <u>Client ID:</u> character 5# must be a hyphen (-)<br />";
			
		}
		
		var valid = 0;
		
		if (isNaN(value.substring(0, 4))) {
			
			errMessages += "- <u>Client ID:</u> characters 1 to 4 must be numeric digits<br />";
			valid++;
			
		}
		
		if (isNaN(value.substring(5, 10))) {
			
			errMessages += "- <u>Client ID:</u> characters 6 to 10 must be numeric digits<br />";
			valid++;
			
		}
		
		if (valid === 0) {
		
			for (var i=0; i < 4; i++) {
			
				sumL += eval(value.charAt(i));
			
			}
			
			for (var j=5; j < 10; j++) {
			
				sumR += eval(value.charAt(j));
			
			}
			
			if (sumL === 0 || sumR === 0) {
			
				errMessages += "- <u>Client ID:</u> sum of the numbers to the left of the hyphen (-) and the sum to the right of the hyphen must be greater than zero<br />";
			
			}
			
			if (sumR !== (sumL*2+2)) {
			
				errMessages += "- <u>Client ID:</u> sum of the numbers to the right of the hyphen (-) must be (double plus 2) the sum of the numbers to the left of the hyphen<br />";
			
			}
			
		}
	}
	
	return errMessages;
	
}

function client(errMessages) {
	
	var value = document.mortgage.client.value;
	value = value.trim();
	var length = value.length;
	
	var valCap = value.toUpperCase();
	
	if (length === 0) {
		
		errMessages += "- <u>Client Name:</u> must be filled<br />";
		
	}
	
	else {
		
		var fine = 0;
		var fine2 = 0;
		var fine3 = 0;
		
		for (var i = 64; i <= 90; i++) {
			
			if (valCap.charCodeAt(0) == i) {
				
				fine++;
			
			}
			
			if (valCap.charCodeAt(1) == i) {
				
				fine2++;	
				
			}
			
			if (valCap.charCodeAt(2) == i) {
				
				fine3++;
				
			}
			
		}
		
		if (value.charCodeAt(1) == 39) {  // Checks apostrophe at the second character
			
			fine2++;
			
		}
		
		if (fine === 0 || fine2 === 0 || fine3 === 0) {
			
			errMessages += "- <u>Client Name:</u> must have at least 3 alphabetic characters (a-z) (A-Z) at the beginning of the field<br />";
			
		}
		
		if (valCap.substring(0,1) === "'" || valCap.substring(length-1) === "'") {
			
			errMessages += "- <u>Client Name:</u> an apostrophe (') at the beginning or at the end of the name is not valid<br />";
		
		}

	}

	return errMessages;
	
}

function income(errMessages) {
	
	var value = document.mortgage.income.selectedIndex;
	
	if (value === -1) {
		
		errMessages += "- <u>Income Range:</u> must select one of the income options<br />";
		
	}
	
	else if (document.mortgage.income.options[value].value == "") {
		
		errMessages += "- <u>Income Range:</u> must select one of the income options<br />";
		
	}
	
	return errMessages;

}

function propDetails(errMessages) {
	
	var value = document.mortgage.propDetails.length;
	var x = 0;
	
	for (var i=0; i < value; i++) {
		
		if (document.mortgage.propDetails[i].checked == true) {
			
			x++;
			
		}
		
	}
	
	if (x == 0) {
		
		errMessages += "- <u>Property Type:</u> Must pick one<br />";
		
	}
	
	return errMessages;
	
}

function propLocation(errMessages) {
	
	var value = document.mortgage.propLocation.selectedIndex;

	if (value === -1) {
		
		errMessages += "- <u>Location:</u> must select one of the location options<br />";
		
	}
	
	else if (document.mortgage.propLocation.options[value].value == "") {
		
		errMessages += "- <u>Location:</u> must select one of the location options<br />";
		
	}
	
	return errMessages;
	
}

function mortYear(errMessages) {
	
	var value = document.mortgage.mortYear.value;
	var length = value.length;
	var myDate = new Date();
	var year = myDate.getFullYear();
	
	if (length === 0) {
		
		errMessages += "- <u>Year:</u> must be filled<br />";
		
	}
	
	else {
		
		if (isNaN(value)) {
			
			errMessages += "- <u>Year:</u> must be a numeric field<br />";
			
		}
		
		if (year == value || eval(year+1) == value) {
			
			errMessages += "";
			
		}
		
		else {
			
			errMessages += "- <u>Year:</u> must be equal to the current year or 1 year greater than current year<br />";
		
		}
	
	}
	
	return errMessages;
	
}

function mortMonth(errMessages) {
	
	var value = document.mortgage.mortMonth.value;
	var length = value.length;
	var myDate = new Date();
	var month = myDate.getMonth();
	
	if (length === 0) {
		
		errMessages += "- <u>Month:</u> must be filled<br />";
		
	}
	
	else {
		
		if (isNaN(value)) {
			
			errMessages += "- <u>Month:</u> must be a numeric field<br />";
			
		}
		
		else if (value > 12 || value < 1) {
			
			errMessages += "- <u>Month:</u> must be between 1 to 12 (included)<br />";
		
		}
		
		if (eval(month+1) == value || eval(month+2) == value) {
			
			errMessages += "";
			
		}
		
		else {			// been tricky
			
			errMessages += "- <u>Month:</u> must be equal to the current month or 1 month greater than current month<br />";
			
		}
		
	}
	
	return errMessages;
	
}


function propValue(errMessages) {
	
	var value = document.mortgage.propValue.value;
	var downPay = document.mortgage.downPay.value;
	
	if (value === "") {
		
		errMessages += "- <u>Property Value:</u> must be filled<br />";
		
	}
	
	else {

		if (isNaN(value) == true || value.substr(0,1) == " ") {
		
			errMessages += "- <u>Property Value:</u> must be a numeric field<br />";

		}
		
		if (value < 65000) {
			
			errMessages += "- <u>Property Value:</u> must be higher than 65,000<br />";
		}
		
		if (value < (downPay + 65000)) {
		
			errMessages += "- <u>Property Value:</u> must be at least 65,000 dollars more than the down payment<br />";
		
		}
	
	}
	
	return errMessages;

}

function downPaym(errMessages) {
	
	var value = document.mortgage.downPay.value;
	var PropVal = document.mortgage.propValue.value;
	
	if (value === "") {
		
		errMessages += "- <u>Down Payment:</u> must be filled<br />";
		
	}
	
	else {
	
		if (isNaN(value) || value.substr(0,1) == " ") {
		
			errMessages += "- <u>Down Payment:</u> must be a numeric field<br />";
		
		}
	
		if (value < (PropVal * 0.2)) {
		
			errMessages += "- <u>Down Payment:</u> must be at least 20% of the value of the property<br />";
		
		}
		
	}

	return errMessages;
	
}

function rate(errMessages) {
	
	var value = document.mortgage.intRate.value;
	
	if (value === "") {
		
		errMessages += "- <u>Interest Rate:</u> must be filled<br />";
		
	}
	
	else {
		
		if (isNaN(value) || value.substr(0,1) == " ") {
		
			errMessages += "- <u>Interest Rate:</u> must be numeric<br />";
		
		}
	
		if (value < 3 || value > 16) {
		
			errMessages += "- <u>Interest Rate:</u> must be between 3.000 to 16.000 (included)<br />";
		
		}
	
	}
	
	return errMessages;
	
}

function amorti(errMessages) {
	
	var value = document.mortgage.amortization.value;
	
	if (value === "") {
		
		errMessages += "- <u>Amortisation:</u> must be filled<br />";
		
	}
	
	else {
	
		if (isNaN(value) || value.substr(0,1) == " ") {
		
			errMessages += "- <u>Amortisation:</u> must be numeric<br />";
		
		}
	
		if (value < 5 || value > 20) {
		
			errMessages += "- <u>Amortisation:</u> must be between 5 to 20 (included)<br />";
		}
		
	}
	
	return errMessages;
	
}


function showErrors(messages) {
	
	messages = "<p>" + messages + "</p>";
	document.getElementById('errors').innerHTML = messages;

}

function clearErrors() {
	
	document.getElementById('errors').innerHTML = " ";

}