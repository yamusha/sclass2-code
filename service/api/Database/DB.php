<?php
/*
|--------------------------------------------------------------------------
| Database Class DB
|--------------------------------------------------------------------------
*/

namespace App\Database;

/** ประกาศ namespace เพื่อไว้ใช้งานในไฟล์ index โดยเรียกผ่าน autoload */

use PDO;
use PDOException;

class DB
{
    private static $connect;
    /** กำหนด Property $connect */
    private static $instance = null;
    /** กำหนด Property $instance มีค่าเริ่มต้นเป็น null */
    private static $response = true;
    /** กำหนด Property $response มีค่าเริ่มต้นเป็น true */

    private function __construct()
    {
        self::$connect = null;
        /** กำหนดค่าเริ่มต้นเป็น null, เวลาเข้าถึงข้อมูล static ต้องใช้ self:: ในการเข้าถึง */
        try {
            /**
             * สร้าง instance PDO ค่า $_ENV ได้มาจากไฟล์ .env 
             */
            self::$connect = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . '; 
                                    dbname=' . $_ENV['DB_DATABASE'] . '; 
                                    charset=utf8',
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );
            self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$connect;
        } catch (PDOException $e) {
            echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
            exit();
        }
    }

    public static function getInstance()
    {
        /** method สำหรับเช็คว่าค่าการเชื่อมต่อดาต้าเบสนั้น เกิดขึ้นหรือยัง ตามแบบ Singleton Pattern ที่ต้องการ */
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public static function query($query = null, $params = array())
    {
        if (self::$connect instanceof PDO) {
            try {
                /** คำสั่ง Query SQL */
                $statement = self::$connect->prepare($query);
                /** ประมวณผลคำสั่ง */
                $statement->execute($params);
                $command = strtoupper(explode(' ', $query)[0]);

                /** ถ้าคำสั่ง SQL เป็น SELECT จะ return ข้อมูลแบบ Associative ออกไป */
                if ($command === 'SELECT') {
                    self::$response = $statement->fetchAll(PDO::FETCH_ASSOC);
                }

                /** ถ้าคำสั่ง SQL เป็น DELETE จะ return ข้อมูลจำนวน rows ที่ทำสำเสร็จออกไป */
                if ($command === 'DELETE') {
                    self::$response = $statement->rowCount();
                }

                return self::$response;
            } catch (\Throwable $e) {
                http_response_code(500);
                echo "การประมวลผลข้อมูลล้มเหลว: " . $e->getMessage();
                exit();
            }
        } else {
            http_response_code(500);
            echo "โปรดเปิดการเชื่อมต่อฐานข้อมูล: getInstance()";
            exit();
        }
    }
}
