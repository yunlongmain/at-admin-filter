
<div class="layout_rightmain">
    <div class="inner">
        <div class="pd10x20">
            <div class="page-title mb20"><i class="i_icon"></i>服务商列表</div>
            <div class="panel">
                <div class="panel-header">
<!--                    <div>-->
<!--                        时间范围：<input type="text" class="input Wdate" id="bdate" name="bdate" onClick="WdatePicker()">&nbsp;到&nbsp;<input-->
<!--                            type="text" class="input Wdate" id="edate" name="edate" onClick="WdatePicker()">-->
<!--                        &nbsp;&nbsp;<span class="ml20">关键词：</span><input type="text" class="input">-->
<!--                    </div>-->
<!---->
<!--                    <div class="mt10">-->
<!--                        <input type="radio" name="RadioGroup1" class="radio radio-first">按流量筛选：-->
<!--                        流量类型：<select name="select" id="select" class="select">-->
<!--                            <option>All</option>-->
<!--                            <option>中间页：卡片导流</option>-->
<!--                        </select>-->
<!--                        直接来源：<select name="select" id="select" class="select">-->
<!--                            <option>--</option>-->
<!--                            <option>百度搜索结果页</option>-->
<!--                        </select>-->
<!--                        <input type="radio" name="RadioGroup1" class="radio">按卡片筛选：-->
<!--                        <select name="select" id="select" class="select">-->
<!--                            <option>全部卡片</option>-->
<!--                        </select>-->
<!--                    </div>-->
                    <div class="mt10">
                        基本查询：<select name="select" id="select_condition" class="select">
                            <option value="id">渠道商UID</option>
                            <option value="name">渠道商名称</option>
                        </select>
                        <span class="ml20">关键词：</span><input type="text" class="input" id="input_query">
                        &nbsp;&nbsp;<a class="btn btn-primary" id="btn_search"><i class="icon16 icon16-zoom"></i> 查询</a>
                    </div>
                </div>

                <div class="panel-main pd10">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="120">渠道商UID</th>
                            <th width="300">渠道商名称</th>
                            <th width="90">资源数量</th>
                            <th width="90">提交时间</th>
                            <th width="90">最后操作时间</th>
                            <th width="90" style="padding-left:15px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $item) {?>
                        <tr>
                            <td><?= $item['facilitator_id'] ?></td>
                            <td><?= $item['facilitator_name'] ?></td>
                            <td><?= $item['resource_num'] ?></td>
                            <td><?= $item['ctime'] ?></td</td>
                            <td><?= $item['utime'] ?></td</td>
                            <td class="i-operate">
                                <a href="<?= base_url('shop?facilitator_name='.$item['facilitator_name']) ?>" title="审核">审核</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="list-page pd10">
                        <div class="i-total">共有相关信息 <b><?=$totle_row?></b> 条</div>
                        <?php
                            if($isPagination) {
                                echo $this->pagination->create_links();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn_search').click(function(){
        if($('#input_query').val()!==''){
            window.location.href="<?= base_url('facilitator')?>"+"?"+$('#select_condition').val()+"="+$('#input_query').val();
        }
    });
    $('.i-operate a').on('click',function(event){
        event.preventDefault();
        window.location.href= $(this).attr('href');
        $.cookie('current_page_order', 2 , {expires: 10, path: "/"});
        $.cookie('current_page_parent', 0 , {expires: 10, path: "/"});
    });
</script>
