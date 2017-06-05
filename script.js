

function validateForm()
{
	    var firstName = trim(document.getElementById('firstname').value);
        var lastName = trim(document.getElementById('lastname').value);
        var phoneNum = trim(document.getElementById('phoneNum').value);
		var email = trim(document.getElementById('email').value);
		

        if (firstName == "")
		{
            alert("Please provide your first name");
			return false;
        } else if (lastName == "")
		{
            alert("Please provide your last name");
			return false;
        } else if (phoneNum.length < 7) 
		{
            alert("Please provide a valid phone number");
			return false;
        }else if (email == "")
		{
			alert("Please provide your email");
			return false;
		}
    };


	function trim(str)
	{
		return str.replace(/^\s+|\s+$/g, '');
	}


	
