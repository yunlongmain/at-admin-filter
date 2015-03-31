<div class="layout_rightmain">
    <div class="inner">
        <div class="pd10x20">
            <div class="page-title mb20"><i class="i_icon"></i>{title}</div>
            <div class="panel">
                <div class="panel-header">
                    <!--                    <div>-->
                    <!--                        时间范围：<input type="text" class="input Wdate" id="bdate" name="bdate" onClick="WdatePicker()">&nbsp;到&nbsp;<input-->
                    <!--                            type="text" class="input Wdate" id="edate" name="edate" onClick="WdatePicker()">-->
                    <!--                        &nbsp;&nbsp;-->
                    <!--                    </div>-->

                    <div class="mt10">
                        基本查询：<select name="select" id="select_condition" class="select">
                            <option value="app_id">应用ID</option>
                            <option value="shop_name">应用名称</option>
                            <option value="query">申请词</option>
                            <option value="facilitator_name">服务商名称</option>
                        </select>
                        <span class="ml20">关键词：</span><input type="text" class="input" id="input_keyword">
                        <!--                        <span class="ml20">服务商：</span><select name="select" id="select_facilitator" class="select">-->
                        <!--                            <option selected="selected"></option>-->
                        <!--                            --><?php //foreach ($facilitator_list as $item) { ?>
                        <!--                                <option value="--><? //= $item['facilitator_id'] ?><!--">-->
                        <? //= $item['facilitator_name'] ?><!--</option>-->
                        <!--                            --><?php //} ?>
                        <!--                        </select>-->
                        <a class="btn btn-primary" id="btn_search"><i class="icon16 icon16-zoom"></i> 查询</a>
                    </div>
                </div>

                <div class="panel-main pd10">
                    <table class="table table-striped" style="table-layout:fixed;word-wrap:break-word">
                        <thead>
                        <tr>
                            <th style="width: 25px">选取</th>
                            <th style="width: 50px">应用ID</th>
                            <th style="width: 60px">应用名称</th>
                            <th style="width: 60px">申请词</th>
                            <th style="width: 150px">应用URL</th>
                            <th style="width: 30px">状态</th>
                            <th style="width: 55px">提交时间</th>
                            <th style="width: 60px">最后操作时间</th>
                            <th style="width: 50px">最后操作人</th>
                            <th style="width: 80px">操作</th>
                        </tr>
                        </thead>
                        <tbody id="table_content">
                        <?php foreach ($shop_list as $item) { ?>
                            <tr>
                                <td><input class="input-checkbox check" type="checkbox" name="<?= $item['appid'] ?>"
                                           data-appname="<?= $item['shop_name'] ?>"/>
                                </td>
                                <td><?= $item['appid'] ?></td>
                                <td><?= $item['shop_name'] ?></td>
                                <td><a href="<?= base_url('shop/rate/' . $item['appid']) ?>"><?= $item['query'] ?></a>
                                </td>
                                <td><?= $item['url'] ?></td>
                                <td><?= Appinfo_model::$STATUS[$item['status']] ?></td>
                                <td><?= $item['ctime'] ?></td>
                                <td><?= $item['utime'] ?></td>
                                <td><?= $item['handler_name'] ?></td>
                                <td class="i-operate">
                                    <?php if ($item['status'] != Appinfo_model::STATUS_PASSED) { ?>
                                        <a class="i-pass" data-appid="<?= $item['appid'] ?>"
                                           data-appname="<?= $item['shop_name'] ?>" title="通过">通过</a>
                                    <?php } ?>
                                    <?php if ($item['status'] != Appinfo_model::STATUS_UNPASS) { ?>
                                        <a class="i-unpass" data-appid="<?= $item['appid'] ?>"
                                           data-appname="<?= $item['shop_name'] ?>" title="不通过">不通过</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div style="margin-top: 10px">
                        <a class="btn btn-primary" id="btn_choose_all">全选</a>
                        <?php if ($status != Appinfo_model::STATUS_PASSED) { ?>
                            <a class="btn btn-primary" id="btn_pass" style="margin-left: 100px">选中的通过,未选中的不通过</a>
                        <?php } else { ?>
                            <a class="btn btn-primary" id="btn_output_choose" style="margin-left: 100px">导出所选</a>
                            <a class="btn btn-primary" id="btn_output_all">导出所有</a>
                        <?php } ?>
                    </div>
                    <div class="list-page pd10">
                        <div class="i-total">共有相关信息 <b><?= $totle_row ?></b> 条</div>
                        <div class="i-pager">
                            <?php
                            if ($isPagination) {
                                echo $this->pagination->create_links();
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>

    /* 获取url参数  */
    $.extend({
        getUrlVars: function () {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash);
            }
            return vars;
        },
        getUrlVar: function (name) {
            return $.getUrlVars()[name];
        }
    });

    $(function () {
        var params = $.getUrlVars();
        var input_keyword, select_condition;
        if (params[0].length > 1) {
            select_condition = params[0][0];
            input_keyword = decodeURI(params[0][1]);
            $('#input_keyword').val(input_keyword);
            $('#select_condition').val(select_condition);
        }
    });

    function _refresh_page(getUrl) {
        var searchKeyword = $('#input_keyword').val();
        var selectCondition = $('#select_condition').val();
        var params = "";
        if (searchKeyword != '') {
            params = '?' + selectCondition + '=' + searchKeyword;
        }
        window.location.href = getUrl + params;

//        $.get(
//            getUrl + params,
//            function (result) {
//                var html = $.parseHTML(result);
//                $('#table_content').replaceWith($('#table_content', html)[0]);
//                $('.list-page').replaceWith($('.list-page', html)[0]);
//                console.log($('#table_content',html)[0]);
//            }
//        );

    }

    $('#btn_search').click(function () {
        var getUrl = '<?= base_url('shop') ?>';
        _refresh_page(getUrl);
    });


    $('.i-pager a').bind('click', function (event) {
        event.preventDefault();
        _refresh_page($(this).attr('href'));
    });

    $('.i-pass').bind('click', function (event) {
        event.preventDefault();
        if (confirm("审核通过轻应用'" + $(this).attr('data-appname') + "'，请确定？")) {
            var postData = new Array();
            postData.push({
                'appid': $(this).attr('data-appid'),
                'status': '<?= Appinfo_model::STATUS_PASSED?>'
            });
            _update(postData);
        }
    });

    $('.i-unpass').bind('click', function (event) {
        event.preventDefault();
        if (confirm("审核不通过轻应用'" + $(this).attr('data-appname') + "'，请确定？")) {
            var postData = new Array();
            postData.push({
                'appid': $(this).attr('data-appid'),
                'status': '<?= Appinfo_model::STATUS_UNPASS?>'
            });
            _update(postData);
        }
    });

    function _update(data) {
        if (data != undefined) {
            var postdata = new Object();
            postdata.operate_data = data;
            $.ajax({
                url: '<?= base_url('shop/update') ?>',
                type: 'POST',
                data: postdata,
                dateType: 'json',
                timeout: 10000,
                error: function () {
                    console.log('更改状态失败');
                },
                success: function (result) {
                    var resultCode = JSON.parse(result).result;
                    if (resultCode > 0) {
                        console.log('更改状态成功');
                        var getUrl = '<?= base_url('shop/index/').'/'.$status.'/0' ?>';
                        _refresh_page(getUrl);
                    } else {
                        console.log('更改状态失败');
                    }
                }
            });
        }
    }

    $('#btn_pass').click(function () {
        var array_checkbox = $('input.input-checkbox');
        var postData = new Array();
        var alertString = '';
        for (var i = 0; i < array_checkbox.length; i++) {
            if (array_checkbox[i].checked) {
                postData.push({
                    'appid': array_checkbox[i].name,
                    'status': '<?= Appinfo_model::STATUS_PASSED?>'
                });
                alertString += " ‘" + array_checkbox[i].getAttribute('data-appname') + "’ ";
            } else {
                postData.push({
                    'appid': array_checkbox[i].name,
                    'status': '<?= Appinfo_model::STATUS_UNPASS?>'
                });
            }
        }
        if (postData.length > 0) {

            if (confirm("确定要通过所选的轻应用吗？\r" + alertString)) {
                _update(postData);
            }
        } else {
            alert('未选取条目！');
        }
        console.log(postData);
    });

    var choose_all = false;
    $('#btn_choose_all').click(function () {
        var array_checkbox = $('input.input-checkbox');
        if (choose_all) {
            choose_all = false;
            for (var i = 0; i < array_checkbox.length; i++) {
                array_checkbox[i].checked = false;
            }
            this.innerHTML = '全选';
        } else {
            choose_all = true;
            for (var i = 0; i < array_checkbox.length; i++) {
                array_checkbox[i].checked = true;
            }
            this.innerHTML = '取消全选';
        }
    });

    $('#btn_output_choose').click(function () {
        var array_checkbox = $('input.input-checkbox');
        var postData = new Array();
        for (var i = 0; i < array_checkbox.length; i++) {
            if (array_checkbox[i].checked) {
                postData.push(array_checkbox[i].name);
            }
        }
        if (postData.length > 0) {
            _output(postData);
        } else {
            alert('未选取条目！');
        }
    });

    $('#btn_output_all').click(function () {
        _output();
    });

    function _output(data) {
        if (data != undefined) {
            var postdata = new Object();
            postdata.operate_data = data;
            window.open('<?= base_url('shop/output') ?>' + '?operate_data= ' + JSON.stringify(postdata));
        } else {
            window.open('<?= base_url('shop/output') ?>');
        }
    }
</script>
