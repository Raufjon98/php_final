<?
class ErrorHandler
{
    public static function handlerException(Throwable $exception): void
    {
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(), 
            "line" => $exception->getLine()
        ]); 
    } 
}