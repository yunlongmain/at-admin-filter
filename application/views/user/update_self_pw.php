<div class="layout_rightmain">

    <div class="pd10x20">
        <div class="page-title mb20"><i class="i_icon"></i>修改密码</div>
        <div class="panel">
            <form class="form" id="form_update" action="{actionUrl}" method="post">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tbody>
<!--                    <tr>-->
<!--                        <td width="20%" align="right">用户名：</td>-->
<!--                        <td width="80%" align="left"><input type="text" name="name" id="textfield" class="input">-->
<!--                            <span><i class="icon16 icon16-errorbg"></i>已存在</span></td>-->
<!--                    </tr>-->
                    <tr>
                        <td align="right">密码：</td>
                        <td align="left"><input type="password" name="password" id="textfield2" class="input">
<!--                            <span><i class="icon16 icon16-errorbg"></i> 您输入的信息错误</span></td>-->
                    </tr>
                    <tr>
                        <td align="right">确认密码：</td>
                        <td align="left"><input type="password" name="re_password" id="textfield2" class="input">
<!--                            <span><i class="icon16 icon16-errorbg"></i> 确认密码错误</span></td>-->
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                        <td align="left">
                            <a class="btn btn-primary btn-large" id="btn_update">更新</a></td>
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                        <td><div class="error_report"><?php echo validation_errors(); ?>{error_tip}</div></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    $('#btn_update').click(function(){
        $('#form_update').submit();
    });
</script>
