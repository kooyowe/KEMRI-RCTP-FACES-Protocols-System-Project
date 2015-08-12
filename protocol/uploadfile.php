<?php
	if(isset($_POST['submit'])){   
		$allowedExts = array("pdf", "doc", "docx", "pt");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);

		if ((($_FILES["file"]["type"] == "application/pdf")
		|| ($_FILES["file"]["type"] == "application/x-pdf")
		|| ($_FILES["file"]["type"] == "application/acrobat")
		|| ($_FILES["file"]["type"] == "applications/vnd.pdf")
		|| ($_FILES["file"]["type"] == "text/pdf")
		|| ($_FILES["file"]["type"] == "application/msword")
		|| ($_FILES["file"]["type"] == "application/vnd.ms-word")
		|| ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		|| ($_FILES["file"]["type"] == "text/x-pdf"))
		&& ($_FILES["file"]["size"] < 2000000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES["file"]["error"] > 0) {
			//file error
		  } else {
			if (file_exists("upload/" . $_FILES["file"]["name"])) {
			  //file already exists
			  echo $_FILES["file"]["name"] . " already exists. ";
			} else {
			  move_uploaded_file($_FILES["file"]["tmp_name"],
			  "../images/attachs/" . $_FILES["file"]["name"]);
			  
			  //query
			}
		  }
		} else {
		  //invalid document format
		}
	}
?>