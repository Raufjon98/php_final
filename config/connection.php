<?
function getConnection() 
{
    $var = 'Test github changes';
    try {
        $connection = new PDO('mysql:host=localhost; dbname=cloud_storage', 'root', '6260834700109');
        if($connection){
            return $connection;
        }
       
    } catch (PDOException $e) {
        echo   $e->getMessage();
    }
}


