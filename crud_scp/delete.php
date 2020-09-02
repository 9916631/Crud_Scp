<?php
    include 'config/connection.php';

    if(array_key_exists('id',$_REQUEST)) $id = (int) $_REQUEST['id'];
    if(!is_int($id)) http_response_code(400); // no id supplied - bad request response
    try{
        $query = "DELETE FROM subject WHERE id = ?";

        $statement = $conn->prepare($query);

        if($statement->execute([$id]))
        {            
            http_response_code(200); // return ok            
        } 
        else
        {
            http_response_code(500); // return internal server error (however id may be invalid)           
        }
    } 
    catch(PDOException $exception)
    {
        http_response_code(500); // return internal server error
    }
?>