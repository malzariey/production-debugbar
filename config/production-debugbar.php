<?php

// config for malzariey/ProductionDebugbar
return [
    "password" => env("PRODUCTION_DEBUGBAR_PASSWORD", "MyPassword"),
    "get_parameter" => env("PRODUCTION_DEBUGBAR_GET_PARAMETER", 'pd_debug'),

];
