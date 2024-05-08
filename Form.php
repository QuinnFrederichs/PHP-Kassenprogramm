<html lang="de">   
<head>
<link href="lager.css" rel="stylesheet">  
<title>Kassenprogram</title>
</head>
<body>
<div  class="container-sm"  style="margin-buttom: 20px;">
    <form method="post" action=""> 

        <!--Input PZN-->
        <label class="form-label" > Geben Sie den PZN ein: </label>
        <input  class="form-control" type="text" name="PZN" id="PZN" value="<?php echo $PZN; ?>"/>

        <!--Input PZN-->
        <label class="form-label"> Geben Sie den IK ein: </label>
        <input  class="form-control" type="text" name="IK" id="IK" value="<?php echo $IK; ?>"/> <!--103411401-->
        <!--submit button-->
        <input type="submit" style="margin-top: 6px;" class="btn btn-primary mb-3"\>  
        </form>
        </div> 

        <?php
            echo $out;
            echo $out2;
            echo $out3;
            
        ?>
</body>
</html>
