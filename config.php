<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
const DB_HOST = 'localhost';
const DB_NAME = 'meraj_school';
const DB_USER = 'YOUR_DATABASE_USER';
const DB_PASS = 'YOUR_DATABASE_PASSWORD';
const SCHOOL_NAME = "Me'Raj International School Maiduguri";
const SCHOOL_MOTTO = 'Educational Excellence';
const SCHOOL_ADDRESS = 'No. 18 Circular Road, GRA, Maiduguri, Borno State, Nigeria';
const SCHOOL_PHONE_1 = '08026798386';
const SCHOOL_PHONE_2 = '08038978383';
const SCHOOL_WHATSAPP = '2348026798386';
function db(): PDO { static $pdo=null; if($pdo instanceof PDO)return $pdo; $pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]); return $pdo; }
function e(?string $v):string{return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function csrf_token():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function verify_csrf():void{if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Security token expired.');}}
function require_admin():void{if(empty($_SESSION['admin_id'])){header('Location: login.php');exit;}}
