<?php
/**
 * Created by PhpStorm.
 * User: yuanyetao
 * Date: 14-9-10
 * Time: 下午2:22
 */

class Facilitator extends Base{
    public function index($startIndex = 0){

        $isPagination = true;

        $facilitator_id = $this->input->get('id');
        if(!empty($facilitator_id)){
            $this->db->where('facilitator_id',$facilitator_id);
            $isPagination = false;
        }

        $facilitator_name = $this->input->get('name');
        if(!empty($facilitator_name)) {
            $this->db->like('facilitator_name',$facilitator_name);
            $isPagination = false;
        }

        $perPage = $isPagination? config_item('per_page'):10000;

        $this->db->group_by('facilitator_id');
        $this->db->select('facilitator_id,facilitator_name,count(1) as resource_num,ctime,utime');
        $data['list'] = $this->db->get(Appinfo_model::$tableName,$perPage,$startIndex)->result_array();
        $data['totle_row'] = count($data['list']);


        if($isPagination) {
            $this->load->library('pagination');

            $sqlQuery='select count(1) as totleCount from (select 1 from '. Appinfo_model::$tableName .' group by facilitator_id) as temp';
            $countArr = $this->db->query($sqlQuery)->row_array();

            $data['totle_row'] = $config['total_rows'] = $countArr['totleCount'];
            $config['base_url'] = base_url('/facilitator/index/');
            $config['per_page'] = $perPage;

            $this->pagination->initialize($config);
        }
        $data['isPagination'] = $isPagination;

        $this->load->view('templates/header',$data);
        $this->parser->parse('facilitator/list',$data);
        $this->load->view('templates/footer');
    }


}