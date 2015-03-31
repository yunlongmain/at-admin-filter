<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-9-12
 * Time: 上午11:37
 */

class test extends Base{
    public function updateStatus(){
        $testData = array(
            array(
                'appid' => "3665690",
                'status' => "1"
            ),
            array(
                'appid' => "3665692",
                'status' => "1"
            ),
        );

        $result = $this->appinfo_model->batch($testData,'update_appinfo');
        var_dump($result);
    }

    public function updateStatus2(){
        $testData = array(
            array(
                'appid' => "3665690",
                'status' => "3"
            ),
            array(
                'appid' => "3665692",
                'status' => "3"
            ),
        );

        $result = $this->appinfo_model->update_appinfo_batch($testData);
        var_dump($result);
    }

    public function insert(){
        $testData = array(
            array(
                'appid' => "5665690",
                'shop_name'=> "123123",
                'url' => "321321",
                'query' => "321321",
                'status' => "3",
                'facilitator_id' => "3",
                'facilitator_name' => "3",
            ),
            array(
                'appid' => "5665691",
                'shop_name'=> "123123",
                'url' => "321",
                'query' => "321",
                'status' => "3",
                'facilitator_id' => "3",
                'facilitator_name' => "3",
            ),
        );

        $result = $this->appinfo_model->insert_appinfo_batch($testData);
        var_dump($result);
    }

    public function set(){
        return $this->appinfo_model->set_appinfo_batch(1);
    }

    public function upload(){
        $result = array(
            'insert_error' => 1,
            'insert_msg' => "成功插入100条"
        );

        $viewData['result'] = var_export($result,true);

        $this->load->view('templates/header');
        $this->parser->parse('data/upload',$viewData);
        $this->load->view('templates/footer');
    }
}