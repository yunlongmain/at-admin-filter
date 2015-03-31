<div class="layout_rightmain">
    <div class="inner">
        <div class="pd10x20">
            <div class="page-title mb20"><i class="i_icon"></i>个人信息</div>
            <div class="panel">
                <div class="panel-header">
                    信息详情 <div class="succ_report">{tip}</div>
                </div>

                <div class="panel-main pd10">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="60">用户名</th>
                            <th width="90">角色</th>
                            <th width="90">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{username}</td>
                            <td>{rolename}</td>
                            <td class="i-operate">
                                <a href="<?= base_url('account/updateSelfPw') ?>" title="修改">修改密码</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

