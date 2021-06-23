<?php
/**
* System Error Prompt
*
* @category   GUI
* @version    1.0.0
* @since      Available since Release 1.0
*/

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Not Found</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @media screen and (max-width:500px) {
      body { font-size: .6em; } 
    }
    a{
      text-decoration: none;
    }
    button{
      background-color: #f44336;
    }
  </style>
</head>

<body style="text-align: center;">

  <h1 style="font-family: Georgia, serif; color: #4a4a4a; margin-top: 4em; line-height: 1.5;">
    It seems that file you have requested in not available.
  </h1>
  
  <h2 style="  font-family: Verdana, sans-serif; color: #7d7d7d; font-weight: 300;">
    Error # ERR_FILE_NOT_FOUND_404
  </h2>

  <button><a href="http://localhost:8080/project/public/">Go Back</a></button>
  
</body>

</html>