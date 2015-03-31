<div class="layout_rightmain">
    <div class="inner">
        <div class="pd10x20">
            <div class="page-title mb20"><i class="i_icon"></i><?= $list[0]['shop_name'] ?></div>
            <div class="panel">
                <div class="panel-header">
                    <iframe src="http://www.baidu.com/s?wd=<?= $list[0]['query'] ?>" frameborder="0" width="100%"
                            height="300px"></iframe>
                </div>

                <div class="panel-main pd10">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 120px">服务商</th>
                            <th style="width: 120px">应用名称</th>
                            <th style="width: 120px">关键词</th>
                            <th style="width: 120px">应用URL</th>
                            <th style="width: 60px">状态</th>
                            <th style="width: 90px" style="padding-left:15px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?= $list[0]['facilitator_name'] ?></td>
                            <td><?= $list[0]['shop_name'] ?></td>
                            <td><?= $list[0]['query'] ?></td>
                            <td><?= $list[0]['url'] ?></td>
                            <td><?= Appinfo_model::$STATUS[$list[0]['status']] ?></td>
                            <td class="i-operate">
                                <?php if ($list[0]['status'] != Appinfo_model::STATUS_PASSED) { ?>
                                    <a class="i-pass" data-appid="<?= $list[0]['appid'] ?>"
                                       data-appname="<?= $list[0]['shop_name'] ?>" title="通过">通过</a>
                                <?php } ?>
                                <?php if ($list[0]['status'] != Appinfo_model::STATUS_UNPASS) { ?>
                                    <a class="i-unpass" data-appid="<?= $list[0]['appid'] ?>"
                                       data-appname="<?= $list[0]['shop_name'] ?>" title="不通过">不通过</a>
                                <?php } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">返回</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

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
                        location.href = '<?= $_SERVER['HTTP_REFERER'] ?>';
                    } else {
                        alert('更改状态失败');
                        console.log('更改状态失败');
                    }
                }
            });
        }
    }
</script>
