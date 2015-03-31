<div class="layout_rightmain">
    <div class="pd10x20">
        <div class="page-title mb20"><i class="i_icon"></i>登录</div>
        <div class="panel">
            <form class="form" id="form_login" action={submitUrl} method="post">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tbody>
                    <div class="error_report"><?php echo validation_errors(); ?>{error_tip}</div>
                    <tr>
                        <td width="20%" align="right">用户名：</td>
                        <td width="80%" align="left"><input type="text" name="name" id="textfield" class="input" />
                    </tr>
                    <tr>
                        <td align="right">密码：</td>
                        <td align="left"><input type="password" name="password" id="textfield2" class="input" onkeydown="enterIn(event)" />
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                        <td align="left">
                            <a class="btn btn-primary btn-large" id="btn_login">提交</a>
                    </tr>
                    <input type="hidden" name="act" value="signin" />
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    $('#btn_login').click(function(){
       $('#form_login').submit();
    });

    function enterIn(evt){
        var evt=evt?evt:(window.event?window.event:null);//兼容IE和FF
        if (evt.keyCode==13){
            $('#form_login').submit();
        }
    }

</script>

