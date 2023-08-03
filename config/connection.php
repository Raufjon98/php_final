<?
function getConnection() 
{
    $var = 'It`s not Directory';
    try {
        $connection = new PDO('mysql:host=localhost; dbname=cloud_storage', 'root', '6260834700109');
        if($connection){
            return $connection;
        }
       
    } catch (PDOException $e) {
        echo   $e->getMessage();
    }
}


