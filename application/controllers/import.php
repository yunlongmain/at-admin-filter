<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-9-10
 * Time: 下午2:58
 */

class Import extends Base {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('account_model');
        if($this->session->userdata('role') < Account_model::ROLE_ADMIN) {
            redirect(base_url('/home/noAuth'));
        }

        set_time_limit(3600);
        ini_set("memory_limit", "1024M");

//        echo 'max_execution_time = ' . ini_get('max_execution_time') ."<br>";
//        echo 'memory_limit = ' . ini_get('memory_limit') ."<br>";
//        echo 'upload_max_filesize = ' . ini_get('upload_max_filesize')."<br>";
//        echo 'post_max_size = ' . ini_get('post_max_size')."<br>";
//        die();
    }

    protected  $attribute = array(
        'C' => 'appid',
        'D' => 'shop_name',
        'E' => 'url',
        'F' => 'query',
        'A' => 'facilitator_id',
        'B' => 'facilitator_name',
    );

    protected $defaultAttributeValue = array(
        'status' => 0,
    );

    public function index()
    {
        $data['submitUrl'] = base_url('/import/upload');
        $data['error_tip'] = $this->session->flashdata('import_data_error_tip');

        $this->load->view('templates/header', $data);
        $this->parser->parse('data/import', $data);
        $this->load->view('templates/footer');
    }

    public function upload()
    {
        $error = '';
        if($_FILES['appInfoFile']['type'] !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            $error = '类型错误';
        }

        if(empty($_FILES['appInfoFile']['name'])){
            $error = '未选择文件';
        }
//        var_dump($_FILES);
//        die();

        $this->session->set_flashdata('import_data_error_tip',$error);
        if(!empty($error)){
            redirect(base_url('import/index'));
        }

        $this->load->library('PHPExcel');
        $input_file = $_FILES['appInfoFile']['tmp_name'];//APPPATH."data/data.xlsx";

        $objPHPExcel = PHPExcel_IOFactory::load($input_file);

        $currentSheet = $objPHPExcel->getSheet(0);
        $row_num = $currentSheet->getHighestRow();

        $sheetData = array();
        //去掉表头
        for($i = 2; $i <= $row_num; $i++) {
            $tempRow = [];
            foreach($this->attribute as $k => $v) {

                $address = $k . $i;
                $tempRow[$v] = $currentSheet->getCell($address)->getFormattedValue();
            }
            $tempRow += $this->defaultAttributeValue;
            $sheetData[] = $tempRow;

            if(($i % 1000) == 0) {
                log_message('info','dong '.$i.' '.$k);
            }
        }

        $viewData = $this->appinfo_model->set_appinfo_batch($sheetData);

        $this->load->view('templates/header');
        $this->parser->parse('data/upload',$viewData);
        $this->load->view('templates/footer');
    }
}