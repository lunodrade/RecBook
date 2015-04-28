<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10">
    <link rel="stylesheet" type="text/css" href="components/css/main.css" />
</head>
<body>

    <table class="pgui-grid grid" style="width: auto">
        <thead>
            <tr class="header"><th ><?php echo $this->_tpl_vars['Viewer']->GetCaption(); ?>
</th></tr>
        </thead>
        <tr class="even">
            <td class="even" style="padding: 10px; text-align: left">
                <p align="justify"><?php echo $this->_tpl_vars['Viewer']->GetValue($this->_tpl_vars['Renderer']); ?>
</p>
            </td>
        </tr>
    </table>
    <div style="margin: 8px; text-align: right;">
        <a href="#" class="btn btn-primary" onClick="window.close(); return false;"><?php echo $this->_tpl_vars['Captions']->GetMessageString('CloseWindow'); ?>
</a>
    </div>



</body>
</html>