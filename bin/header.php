<?php

const ROOT_DIR =  __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR; 

const PIPEFY_API_URI = 'https://api.pipefy.com/graphql';

const PIPEFY_DIR = ROOT_DIR           . ".pipefy" . DIRECTORY_SEPARATOR;
const PIPEFY_GRAPHQL_DIR = PIPEFY_DIR . "graphql" . DIRECTORY_SEPARATOR;
const PIPEFY_CACHE_DIR = PIPEFY_DIR   . ".cache"  . DIRECTORY_SEPARATOR;


const  PIPEFY_CONFIG_PATH = PIPEFY_DIR . ".config";
const  PIPEFY_CONFIG_PARAMS = ["APIKEY"=>null];

require  ROOT_DIR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";



