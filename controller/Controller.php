<?php

//TODO add common functionality/members between controllers and namespaces

abstract class Controller
{
    private static $INDEX_LOCATION = 'Location: ./' . self::INDEX_PAGE . '.php';
    const REGISTER_PAGE = 'register';
    const INDEX_PAGE = 'index';

    public function goToIndex()
    {
        header(self::$INDEX_LOCATION);
    }
}
