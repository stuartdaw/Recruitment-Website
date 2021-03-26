<?php

// Error and exception handler class
// helps convert errors into Exceptions

namespace Core;

class Error
{
    // handle errors and convert into exceptions
    public static function errorHandler($level, $message, $file, $line)
    {
        if(error_reporting() !== 0){
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    // handle thrown exceptions
    public static function exceptionHandler($exception)
    {
        echo "<h1>Fatal Error</h1>";
        echo "<p>Uncaught Exception: '" . get_class($exception) . "'</p>";
        echo "<p>Message: '" . $exception->getMessage() . "'</p>";
        echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
        echo "<p>Thrown in:'" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
    }
}

?>