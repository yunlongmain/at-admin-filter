<div class="layout_rightmain">

    <div class="pd10x20">
        <div class="page-title mb20"><i class="i_icon"></i> 表单</div>
        <div class="panel">
            <form class="form" id="form_update" action="{submitUrl}" method="post">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tbody>
                    <tr>
                        <td width="20%" align="right">用户名：</td>
                        <td width="80%" align="left">
                            <?php if(!$username) {?>
                            <input type="text" id="username_input" name="username" id="textfield" value='{username}'class="input">
                            <?php } else {?>
                                <input type="text" id="username_input" name="username" id="textfield" value='{username}' readonly="readonly" class="input">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">角色：</td>
                        <td align="left"><select name="role" id="role_select" class="select">
                                <option value="2">审核员</option>
                                <option value="5">管理员</option>
<!--                                <option value="8">超级管理员</option>-->
                            </select></td>
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                        <td align="left">
                            <a class="btn btn-primary btn-large" id="btn_update">提交</a></td>
                    </tr>
                    <input type="hidden" name="isnew" value={isnew} />
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

    function initSelect(){
        var curRole = {role};
        var objSelect = $("#role_select")[0];
        for (var i = 0; i < objSelect.options.length; i++) {
            if (objSelect.options[i].value == curRole) {
                objSelect.options[i].selected = true;
                break;
            }
        }
    }

    initSelect();

</script>

