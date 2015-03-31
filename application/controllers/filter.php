<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-9-10
 * Time: 下午2:58
 */

class Filter extends CI_Controller {
    public static $URLS;
    const CURL_NUM = 100;
    const FLAG_STR = "不能访问";
    const FLAG_STR2 = "http://qudao.weixinjia.net/image/mobile/wsite/logo.jpg";

    public function __construct()
    {
        parent::__construct();

        set_time_limit(3600);
        ini_set("memory_limit", "2048M");
    }

    public function getConf() {
        echo 'max_execution_time = ' . ini_get('max_execution_time') ."<br>";
        echo 'memory_limit = ' . ini_get('memory_limit') ."<br>";
        echo 'upload_max_filesize = ' . ini_get('upload_max_filesize')."<br>";
        echo 'post_max_size = ' . ini_get('post_max_size')."<br>";
        die();
    }

    protected  $attribute = array(
        'B' => 'user_id',
        'C' => 'lightapp_name',
        'D' => 'app_desc',
        'E' => 'app_icon',
        'F' => 'user_mobile',
        'G' => 'user_email',
        'H' => 'url',
        'I' => 'query',
        'J' => 'unknown',
    );

    protected $defaultAttributeValue = array(
        'visit_status' => 0,
    );

    public function index()
    {
        $data['submitUrl'] = base_url('/filter/upload');
        $data['error_tip'] = $this->session->flashdata('import_data_error_tip');

        $this->load->view('templates/header', $data);
        $this->parser->parse('data/import', $data);
        $this->load->view('templates/footer');
        error_log("select data file!");
    }

    public function upload()
    {
        error_log("finish upload!");
        $error = '';
        if($_FILES['appInfoFile']['type'] !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            $error = '类型错误';
        }

        if(empty($_FILES['appInfoFile']['name'])){
            $error = '未选择文件';
        }
        $os = $this->input->post('os');
//        var_dump($os);
//        var_dump($_FILES);
//        die();

        $this->session->set_flashdata('import_data_error_tip',$error);
        if(!empty($error)){
            redirect(base_url('filter/index'));
        }

        $this->load->library('PHPExcel');
        $input_file = $_FILES['appInfoFile']['tmp_name'];//APPPATH."data/data.xlsx";

        $objPHPExcel = PHPExcel_IOFactory::load($input_file);
        error_log("finish load data file!");

        $currentSheet = $objPHPExcel->getSheet(0);
        $row_num = $currentSheet->getHighestRow();
        log_message('info','excel 加载完！');
        $sheetData = array();
        //去掉表头
        for($i = 5; $i <= $row_num; $i++) {
            $tempRow = [];
            foreach($this->attribute as $k => $v) {

                $address = $k . $i;
                $tempRow[$v] = $currentSheet->getCell($address)->getFormattedValue();
            }
            $tempRow += $this->defaultAttributeValue;
            $sheetData[] = $tempRow;

            if(($i % 1000) == 0) {
                log_message('info','dong '.$i.' '.$k);
                error_log('dong '.$i.' '.$k);
            }
        }

        error_log("finish parse cell data");

        $checkedData = $this->_checkUrl($sheetData);
//        var_dump($checkedData);
        error_log("finish check data");

        if($os == "mac") {
            $this->_download($checkedData,';',"\n",'"',true);
        } else{
            $this->_download($checkedData);//,';',"\n",'"',true);
        }

    }

    private function _checkUrl($data) {
        $data = array_add_key($data,'url');

        $urls = [];
        foreach($data as $v) {
            $urls[] = $v['url'];
        }

        try{
            $visitStatus = $this->_rolling_curl($urls,0);
        }catch (Exception $e) {
            die( 'Message: ' .$e->getMessage());
        }


        foreach($data as $k => $v) {
            $data[$k]['visit_status'] = $visitStatus[$k];
        }

//        var_dump($data);
//        die();
        return $data;
    }

    private function _rolling_curl($urls,$delay) {
        $queue = curl_multi_init();
        $map = array();

        for($i = 0;$i< self::CURL_NUM;$i++){
            if(empty($urls)) {
                break;
            }

            $url = array_pop($urls);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOSIGNAL, true);

            curl_multi_add_handle($queue, $ch);
            $map[(string) $ch] = $url;

            log_message('info','curl url add1 '.$url);
        }

        $responses = array();
        do {
            while (($code = curl_multi_exec($queue, $active)) == CURLM_CALL_MULTI_PERFORM) ;

            if ($code != CURLM_OK) { break; }

// a request was just completed -- find out which one
            while ($done = curl_multi_info_read($queue)) {

// get the info and content returned on the request
                $curlResultContent = curl_multi_getcontent($done['handle']);
                $statusResult = $this->_checkResult($curlResultContent);
                usleep(100);
                log_message('info','url:'.$map[$done['handle'].''].'    '.'内容：'.$curlResultContent);
                $responses[$map[(string) $done['handle']]] = $statusResult;

// remove the curl handle that just completed
                curl_multi_remove_handle($queue, $done['handle']);
                curl_close($done['handle']);

                $url = array_pop($urls);
                if($url) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_NOSIGNAL, true);
                    curl_multi_add_handle($queue, $ch);
                    $map[(string) $ch] = $url;
                    log_message('info','curl url add2 '.$url.'。 '.'未处理：'.count($urls));
                    error_log('curl url add2 '.$url.'。 '.'未处理：'.count($urls));
                }
            }

// Block for data in / output; error handling is done by curl_multi_exec
            if ($active > 0) {
                curl_multi_select($queue, 0.5);
            }

        } while ($active);

        curl_multi_close($queue);
        return $responses;
    }

    private function _download($sheetData,$delim = ",", $newline = "\n", $enclosure = '"',$toGBK = false){
        $this->load->helper('file');
        $this->load->helper('download');

        $out = '';
        foreach ($sheetData as $row)
        {
            foreach ($row as $k => $item)
            {
                if($toGBK) {
                    try{
                        $item = iconv('UTF-8', 'GB2312//IGNORE', $item);
                    } catch(Exception $e) {

                    }
                }

                $out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure.$delim;
            }
            $out = rtrim($out);
            $out .= $newline;
        }

        $Date = date("YmdHis");
        $Filename = $Date.".csv";
        force_download($Filename, $out);

    }

    private function _checkResult($checkStr) {

        if(strpos($checkStr,self::FLAG_STR)) {
            $result = "不能访问";
        } else if(strpos($checkStr,self::FLAG_STR2)) {
            $result = "模板";
        } else {
            $result = "通过检查";
        }

        return $result;
    }

}