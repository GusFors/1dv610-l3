<?php



abstract class Controller
{
    private static $INDEX_LOCATION = 'Location: ' . './index.php';

    public function goToIndex()
    {
        header(self::$INDEX_LOCATION);
    }
}
