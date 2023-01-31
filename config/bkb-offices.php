<?php

return [
    "routes_enabled" => false,
    "routes_middleware" => ["auth"],
    "views_enabled" => false,
    "table_prefix" => "bkboffices_",
    "migrations_enabled" => true,
    "database_connection" => config("database.default")
];
