var frmvalidator = new Validator("login_name");
	frmvalidator.addValidation("UserName", "req", "Please enter Your ID");
    frmvalidator.addValidation("PasWord", "req", "Please enter Your Password");
