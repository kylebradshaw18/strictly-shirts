<?php
    
    //$globalFunctionsConn = new mysqli("localhost","strictlyShirts","strictlyShirts","strictly_shirts");
    
    function openDBConnection(){
        $temp = new mysqli("localhost","strictlyShirts","strictlyShirts","strictly_shirts");
        return $temp;
    }
    
    
    //Function that gets the persons first name
    function getPersonsName($personId){
        $results = $globalFunctionsConn->query("SELECT `firstName` FROM `people` WHERE `personId` = ".$personId . " LIMIT 1");
        return $results->fetch_assoc()['firstName'];
    }
    
    //Function that gets the persons total from the cart
    function getCartSum($personId){
        $sum = 0;
        $sql = "SELECT `cart`.`quantity`, `inventory`.`price` FROM `cart` INNER JOIN `inventory` ON `cart`.`inventoryId` = `inventory`.`inventoryId` WHERE `personId` = ".$personId;
        $globalFunctionsConn = openDBConnection();
        $results = $globalFunctionsConn->query($sql);
        
        if($results ->num_rows > 0){
            while($row = $results->fetch_assoc()) { 
                $sum += ($row['price'] *  $row['quantity']);
            }
    	} 
        
        return $sum;
    }
    
    
    /**
     * This function creates the HTML for a closable bootstrap alert
     * Takes in the message and type of alert by default it sets it to danger
     * 
     * TYPES OF alerts
     * 
     * success = Green
     * info = Blue
     * warning = Yellow
     * danger = red
     */
    function addAlert($message, $type = "danger"){
        if(strlen(trim($message)) > 0){
            return "<div class=\"alert  alert-". trim(strtolower($type)) ."\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>". $message ."</div>";
        }
    }
    
    /**
     * This function masks a card number so only the last 4 digits are visible
     */
    function maskCard($cardNumber){
        $lengthCardNumber = strlen($cardNumber);
        $lengthCardNumberMask = $lengthCardNumber - 4;
        $lastDigits = substr($cardNumber, $lengthCardNumberMask);
        $newCardNumber = "";
        for($index = 0; $index < $lengthCardNumberMask; $index++){
            $newCardNumber .= "*";
        }
        $newCardNumber .= $lastDigits;
        return $newCardNumber;
    }
    
?>