<?php
/*
|--------------------------------------------------------------------------
| ไฟล์เริ่มต้นการทำงานทั้งหมดของ Route Api
|--------------------------------------------------------------------------
*/
use App\Http\Request;
use App\Http\Router;
use App\Database\DB;

/** เชื่อมต่อฐานข้อมูล */
// DB::getInstance();

/** ประกาศค่าเริ่มต้นของ Router */
$router = new Router(Request::getUri(), Request::getMethod());

/** เรียกใช้งาน Route ตามที่กำหนด */
$router->get('/', function() {
    require_once 'welcome.php';
});

/** ลงทะเบียน Router */
require_once 'Home.php';
require_once 'Test.php';

/** เรียกใช้งาน Method run เพื่อรันคำสั่งของ Route ทั้งหมด */
$router->run();
