<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 18.11.2015
 * Time: 16:40
 */

namespace CodeMine\CommandQuery;


interface CommandQueryInterface extends \JsonSerializable
{
    /**
     * @return string
     */
    public static function name();
}