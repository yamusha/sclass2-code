<?php
/*
|--------------------------------------------------------------------------
| Routes Class Router
| Class หลักที่ใช้สำหรับตรวจสอบ Pattern URL, Http Method
|--------------------------------------------------------------------------
*/
namespace App\Http; /** ประกาศ namespace เพื่อไว้ใช้งานในไฟล์ index โดยเรียกผ่าน autoload */
class Router {
    /** ประกาศ Property ค่าเริ่มต้น */
    private $router = [];
    private $uri;
    private $method;
    private $matchRouter = [];

    /** __construct ค่าเริ่มต้น */
    public function __construct(string $uri, string $method) {
        $this->uri = $uri;
        $this->method = $method;
    }

    /** HTTP Method get */
    public function get($pattern = null, $callback = null) {
        $this->addRoute("GET", $pattern, $callback);
    }

    /** HTTP Method post */
    public function post($pattern = null, $callback = null) {
        $this->addRoute("POST", $pattern, $callback);
    }

    /** HTTP Method put */
    public function put($pattern = null, $callback = null) {
        $this->addRoute("PUT", $pattern, $callback);
    }

    /** HTTP Method delete */
    public function delete($pattern = null, $callback = null) {
        $this->addRoute("DELETE", $pattern, $callback);
    }

    /** Method addRoute สำหรับสร้าง Route API ที่กำหนดเอาไว้ */
    public function addRoute($method, $pattern, $callback) {
       array_push($this->router, ['method' => $method, 'pattern' => $pattern, 'callback' => $callback]);
    }

    /**
     *  run application
     */
    public function run() {
        /* ตรวจสอบว่าได้สร้าง route api ขึ้นมาหรือยัง*/
        if (!is_array($this->router) || empty($this->router)) {
            echo 'NON-Object Route Set';
            exit();
        }

        /* เช็ค Method ที่เหมือนกัน */
        $this->getMatchRoutersByRequestMethod();

        /* เช็ค Pattern Uri จากค่า Method ที่เหมือนกัน */
        $this->getMatchRoutersByPattern($this->matchRouter);

        /* ตรวจสอบว่า matchRouter เป็นค่าว่างหรือไม่ */
        if (!empty($this->matchRouter)) {
            if (is_callable($this->matchRouter['callback'])) {
                /* เรียกใช้งาน function ได้เลย */
                call_user_func($this->matchRouter['callback']);
            } else {
                /* แยก callback ออกจากกัน "controller@method" */
                $parts = explode('@', $this->matchRouter['callback']);
                if(count($parts) > 1){
                    /**
                     * กำหนดค่าให้กับตัวแปรตามตำแหน่ง 
                     * $controller index[0] 
                     * $method index[1] 
                     */
                    $controller = $parts[0];
                    $method = $parts[1];
                    try {
                        /**
                         * ตรวจสอบว่าสามารถเรียกใช้งาน method ภายใน class นี้ได้หรือไม่
                         * is_callable([$controller, $method]) 
                         */
                        $myclass = new $controller();
                        if (is_callable(array($myclass, $method))) {
                            call_user_func(array($myclass, $method));
                        } else {
                            $this->sendNotFound('ไม่สามารถเรียกใช้งาน Class และ Method ได้');
                        }
                    } catch (\Throwable $th) {
                        $this->sendNotFound('ไม่สามารถเรียกใช้งาน Controller ได้');
                    }
                } else {
                    $this->sendNotFound('ไม่สามารถเรียกใช้งาน Callback ได้');
                }
            }
        } else {
            $this->sendNotFound('ไม่สามารถเข้าถึงข้อมูล Router ได้');
        }
    }

    /** เช็ค Method ที่เหมือนกัน */
    private function getMatchRoutersByRequestMethod() {
        foreach ($this->router as $value) {
            if ($this->method == $value['method']){
                array_push($this->matchRouter, $value);
            }
        }
    }

    /** เช็ค Pattern Uri จากค่า Method ที่เหมือนกัน */
    private function getMatchRoutersByPattern($pattern) {
        $this->matchRouter = []; // ล้างค่า matchRouter ให้เป็น array ว่าง
        foreach ($pattern as $value) {
            if ( $this->uri == $value['pattern'] ){
                $this->matchRouter = $value;
            }
        }
    }

    /** sendNotFound */
    private function sendNotFound($message) {
        http_response_code(400);
        echo json_encode([ 'message' => $message ]);
        exit();
    }

}
