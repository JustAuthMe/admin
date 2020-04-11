<?php

/**
 * Created by PhpStorm.
 * User: peter_000
 * Date: 05/07/2016
 * Time: 12:09
 */

namespace PitouFW\Core;

use PDO;

interface Resourceable {
    public function __construct();
    public static function getDbInstance(): PDO;
    public static function getTableName(): string;
}