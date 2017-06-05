


	function validateDelete()
	{
		
		if(confirm("Are you sure you want to delete this record?")){
			
			document.getElementById("deleteid").value = document.getElementById("id").value;
			return true;
		
		}else
			
			return false;
		
	}
	
