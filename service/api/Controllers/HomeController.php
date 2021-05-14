<?php 
use App\Http\Response; /** เรียกใช้งาน Class Response */
class HomeController { 
    /**
     * ดึงข้อมูลทั้งหมด
     */
    public function index() { 
        $response = array([
                "link" => "https://appzstory.dev",
                "name" => "AppzStory Studio",
            ],[
                "link" => "https://facebook.com/WebAppzStory",
                "name" => "Facebook Page",
            ],[
                "link" => "https://youtube.com/appzstorystudio",
                "name" => "Youtube",
        ]);
        return Response::success($response, 'success');
    }
}