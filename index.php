<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    .error {color: #FF0000;}
    </style>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="AFoDIB Café Michel">
	<meta name="author" content="Simon DA SILVA">
	<title>AFoDIB Café Michel</title>
</head>
<body>

    <?php
        $nameErr = $emailErr = $referenceErr = $priceErr = "";
        $name = $email = $reference = $price = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["name"])) {
            $nameErr = "Name is required";
          } else {
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
              $nameErr = "Only letters and white space allowed";
            }
          }
          
          if (empty($_POST["email"])) {
            $emailErr = "Email is required";
          } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $emailErr = "Invalid email format";
            }
          }
            
          if (empty($_POST["reference"])) {
            $referenceErr = "Reference is required";
          } else {
            $reference = test_input($_POST["reference"]);
            if (!preg_match("/^[0-9]{0,15}$/",$reference)) {
              $referenceErr = "Invalid reference, digits only";
            }
          }
          
          if (empty($_POST["price"])) {
            $priceErr = "Price is required";
          } else {
            $price = test_input($_POST["price"]);
            if (!preg_match("/^[0-9.]{0,15}$/",$price)) {
              $priceErr = "Invalid price, digits separated by one dot only";
            }
          }
        }

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }
    ?>

    <h2>AFoDIB Café Michel</h2>
 <iframe src="https://simondasilva.fr/afodib-cafe/tarif-CM-2018.pdf" width="1280" height="1280" align="middle"></iframe>
    <a href="https://simondasilva.fr/afodib-cafe/tarif-CM-2018.pdf">Download references and prices</a>
    <br><br>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
      Full name: <input type="text" name="name" value="<?php echo $name;?>">
      <span class="error"><?php echo $nameErr;?></span>
      <br><br>
      E-mail: <input type="text" name="email" value="<?php echo $email;?>">
      <span class="error"><?php echo $emailErr;?></span>
      <br><br>
      Reference: <input type="text" name="reference" value="<?php echo $reference;?>">
      <span class="error"><?php echo $referenceErr;?></span>
      <br><br>
      Price: <input type="text" name="price" value="<?php echo $price;?>">
      <span class="error"><?php echo $priceErr;?></span>
      <br><br>
      <input type="submit" name="submit" value="Submit">  
    </form>

</body>
</html>

