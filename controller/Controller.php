<?php



abstract class Controller
{
    private static $INDEX_LOCATION = 'Location: ' . './index.php'; // referera till application index const?

    public function goToIndex()
    {
        header(self::$INDEX_LOCATION);
    }
}
