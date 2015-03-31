<?php
/**
 * Created by PhpStorm.
 * User: yuanyetao
 * Date: 14-9-10
 * Time: 下午2:22
 */

class Shop extends Base{

    private function _dealDataCondition(&$isPagination){
        $app_id = $this->input->get('app_id');
        if(!empty($app_id)){
            $this->db->where('appid',$app_id);
            $isPagination = false;
        }

        $shop_name = $this->input->get('shop_name');
        if(!empty($shop_name)){
            $this->db->like('shop_name',$shop_name);
            $isPagination = false;
        }

        $query = $this->input->get('query');
        if(!empty($query)){
            $this->db->like('query',$query);
            $isPagination = false;
        }

    }

    private function _pagination(&$data,$perPage,$status){

        $this->load->library('pagination');

        $this->_setFilterCondition($status);
        $data['totle_row'] = $config['total_rows'] = $this->db->count_all_results(Appinfo_model::$tableName);
        $config['base_url'] = base_url('/shop/index/'.$status);
        $config['per_page'] = $perPage;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
    }

    private function _setFilterCondition($status) {
        if($status >=0 && $status <= 2) {
            $this->db->where('status',$status);
        }

        $facilitator_id = $this->input->get('facilitator_id');
        if(intval($facilitator_id) > 0) {
            $this->db->where('facilitator_id',$facilitator_id);
        }

        $facilitator_name = $this->input->get('facilitator_name');
        if(!empty($facilitator_name)) {
            $this->db->like('facilitator_name',$facilitator_name);
        }
    }

    public function index($status = -1,$startIndex = 0){
        $isPagination = true;

        $this->_dealDataCondition($isPagination);
        $perPage = $isPagination? config_item('per_page'):10000;

        $this->_setFilterCondition($status);
        $data['shop_list'] = $this->db->get(Appinfo_model::$tableName,$perPage,$startIndex)->result_array();
        $data['totle_row'] = count($data['shop_list']);
        $data['title'] = Appinfo_model::$STATUS[$status]." 商户列表";

//        $this->db->group_by('facilitator_id');
//        $dataList = $this->db->get(Appinfo_model::$tableName)->result_array();
        $dataList = $data['shop_list'];

        foreach($dataList as &$v) {
            $v['passUrl'] = $passUrl = base_url('/shop/pass/2/'.$v['appid']);
            $v['passMsg'] = $passMsg = "确认要通过 应用名称： ".$v['shop_name']." 吗?";
            $v['unpassUrl'] = $unpassUrl = base_url('/account/pass/1/'.$v['appid']);
            $v['unpassMsg'] = $unpassMsg = "确认要不通过 应用名称： ".$v['shop_name']." 吗?";
        }
        $data['shop_list'] = $dataList;
        $data['status'] = $status;

        if($isPagination) {
            $this->_pagination($data,$perPage,$status);
        }
        $data['isPagination'] = $isPagination;

        $this->load->view('templates/header', $data);
        $this->parser->parse('shop/raw_list',$data);
        $this->load->view('templates/footer');
    }

    public function rate($appid){

        $data['list'] = $this->db->get_where(Appinfo_model::$tableName,array('appid'=>$appid))->result_array();

        $this->load->view('templates/header', $data);
        $this->parser->parse('shop/rate_page');
        $this->load->view('templates/footer');
    }

    public function update(){
        $operate_data = $this->input->post('operate_data');
        if(!empty($operate_data)){
            $result = $this->appinfo_model->update_appinfo_batch($operate_data);
            $arrResult = array ('result'=>$result);
            echo json_encode($arrResult);
        }
    }

    public function output(){

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');

        $operate_data = $this->input->get('operate_data');
        $operate_data = json_decode($operate_data,true);

        if(count($operate_data)>0){
            $this->db->where_in('appid',$operate_data['operate_data']);
        }else{
            $this->db->where('status',Appinfo_model::STATUS_PASSED);
        }

        $query = $this->db->get(Appinfo_model::$tableName);
        $statusTrunValue = array(
            'key' => 'status',
            'value' => Appinfo_model::$STATUS,
        );
        $data = $this->dbutil->csv_from_result($query,';',"\n",'"',true,$statusTrunValue);

        $Date = date("YmdHis");
        $Filename = $Date.".csv";
        force_download($Filename, $data);

    }
}