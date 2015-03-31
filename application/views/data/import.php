
<div class="layout_rightmain">

    <div class="pd10x20">
        <div class="page-title mb20"><i class="i_icon"></i>数据导入</div>
        <div class="panel">
            <div class="form">
                <div class="error_report">{error_tip}</div>
                <form id="data_imput_form" action="{submitUrl}" method="post" enctype="multipart/form-data">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody>
                        <tr>
                            <td width="20%" align="right">选择数据文件：</td>
                            <td width="80%" align="left"><input type="file" id="appInfoFile" name="appInfoFile" class="input">
                                <span><i class="icon16 icon16-alertbg"></i><?= $error_tip?></span></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right">操作系统：</td>
                            <td width="80%" align="left">Win<input type="radio" name="os" value="win" checked="checked">Mac<input type="radio" name="os" value="mac">
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td align="left">
                                 <!--todo 需要更改样式-->
                                <a class="btn btn-primary btn-large" id="btn_submit" disabled="disabled">提交</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn_submit').click(function () {
        $('#data_imput_form').submit();
    });
</script>
