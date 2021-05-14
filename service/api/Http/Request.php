<?php
/*
|--------------------------------------------------------------------------
| Http Class Request
|--------------------------------------------------------------------------
*/
namespace App\Http; /** ประกาศ namespace เพื่อไว้ใช้งานในไฟล์ index โดยเรียกผ่าน autoload */

class Request {
    public static function input($key = '') {
        /** ดึงข้อมูล */
        $postdata = file_get_contents("php://input");
        /** แปลง json ให้เป็น array ที่ php อ่านได้ */
        $request = json_decode($postdata, true);

        /** ตรวจสอบว่าได้ส่งค่า key มาหรือไม่ ถ้าส่งมาให้เข้าเงื่อนไข */
        if (!empty($key)) {
            /** 
             * ตรวจสอบว่า มี key ที่ระบุไว้หรือไม่ 
             * self::clean() ป้องกันอักขระแปลกปลอม
             */
            return isset($request[$key]) ? self::clean($request[$key]) : null;
        } 

        /** ส่งค่าที่ได้กลับไป */
        return $request;
    }

    public static function query($key = '') {
        /** ตรวจสอบ Query String */
        $request = isset($_GET[$key]) ? self::clean($_GET[$key]) : null;
        return $request;
    }
    
    public static function getUri() {
        /**
         * parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ดึงแค่ path uri เท่านั้น ไม่ดึง query string 
         * urldecode() ทำให้ path ที่ดึงเข้ามาอยู่ในรูปแบบปกติ ไม่เข้ารหัสไว้
         */
        $REQUEST_URI = urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
        $uri = explode('/api', $REQUEST_URI);
        if (count($uri) == 2){
            return $uri[1];
        } else {
            http_response_code(404);
            echo 'Do not use duplicate path names "api".';
            exit();
        }
    }

    public static function getMethod() {
        /**
         * strtoupper() เปลี่ยนตัวอักษรในสตริงเป็นตัวอักษรใหญ่
         */
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    private static function clean($data) {
        /** เช็คว่า $data เป็น array หรือไม่ */
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                /** ลบ array ตำแหน่ง เก่าทิ้งไป */
                unset($data[$key]);

                /** สร้าง array ใหม่โดยใช้ htmlspecialchars ขึ้นมาแทน */
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            /** 
             * เปลี่ยน predefined characters เป็น HTML entities ด้วยฟังก์ชัน htmlspecialchars() 
             * ENT_QUOTES คือ Decodes ทั้ง double and single quotes 
             */
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }
}
