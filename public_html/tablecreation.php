<?php
    require("/home/eriojasn/inc/tablecreationpage.php");
    
    $test = new TableCreationPage();
    
    $status = $test->CreateAndConfigureTable();
    
    $test->Display($status);
?>