<?php


/**
 * Class ExceptionHandle
 */
class ExceptionHandle extends Exception
{
    /**
     * @throws Exception
     */
    public function handle(string $message)
    {
        throw new Exception(
            PHP_EOL . 'Message: ' . $message . PHP_EOL .
            'File: ' . $this->getFile() . PHP_EOL .
            'Line: ' . $this->getLine() . PHP_EOL
        );
    }
}