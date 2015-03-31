
<div class="layout_rightmain">
    <div class="inner">
        <div class="pd10x20">
            <div class="page-title mb20"><i class="i_icon"></i>审核人员列表(只显示比自己权限低的用户)</div>
            <div class="panel">
                <div class="panel-header">
<!--                    <div class="mt10">-->
<!--                        基本查询：<select name="select" id="select" class="select">-->
<!--                            <option>渠道商UID</option>-->
<!--                            <option>渠道商名称</option>-->
<!--                        </select>-->
<!--                        <span class="ml20">关键词：</span><input type="text" class="input">-->
<!--                        &nbsp;&nbsp;-->
                        <a href="<?= base_url('account/edit') ?>" class="btn btn-primary">添加审核人员</a>
                        <div class="succ_report">{tip}</div>
<!--                    </div>-->
                </div>

                <div class="panel-main pd10">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="120">用户名</th>
                            <th width="120">角色</th>
                            <th width="90">创建时间</th>
                            <th width="90" style="padding-left:15px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($user_list as $item) {?>
                        <tr>
                            <td><?= $item['username'] ?></td>
                            <td><?= $item['role'] ?></td>
                            <td><?= $item['ctime'] ?></td</td>
                            <td class="i-operate">
                                <?= $item['handle'] ?>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
<!--                    <div class="list-page pd10">-->
<!--                        --><?php
//                            if($isPagination) {
//                                echo $this->pagination->create_links();
//                            }
//                        ?>
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
