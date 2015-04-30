
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>管理中心登陆 V1.0</title>
	<script src="<?php echo base_url();?>/js/jquery.js"></script>
	<script src="<?php echo base_url();?>/js/jquery.validate.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/login/login.css" />
<script>
$(function() {
	$("#codeImg").bind(
		"click",
		function() {
			$(this).attr("src", '<?php echo site_url("auth/code");?>?r=' + Math.random());
		}
	);

	var v = $("#loginForm").validate(
		{
			errorClass: "error",
			rules: {
				login_name:{required:true,maxlength:15,minlength:2},
				password:{required:true,maxlength:15,minlength:2},
				randcode:{required:true,rangelength:[4,4]}
			},
			messages: {
				login_name:{required:"请输入用户名", maxlength:"请输入2-15个字符", minlength:"请输入2-15个字符"},
				password:{required:"请输入密码", maxlength:"请输入2-15个字符", minlength:"请输入2-15个字符"},
				randcode:{required:"请输入验证码", rangelength:"请输入4位验证码"}
			}
		}
	);

	$("#loginForm").bind(
		"submit",
		function() {
			if ($("#login_name").val() == "") {
				alert("请输入用户名");
				return false;
			}

			if ($("#password").val() == "") {
				alert("请输入密码");
				return false;
			}

			if ($("#randcode").val() == "") {
				alert("请输入验证码");
				return false;
			}

			return true;
		}
	);
});
</script>

<title>用户登录</title>
</head>

<body onload="document.loginForm.login_name.focus();">


<center>
	<div class="error">
		<?php echo validation_errors(); ?>
		<?php if(!empty($err_code_msg))echo $err_code_msg; ?>
	</div>
</center>

<table height="100%" cellspacing="0" cellpadding="0" width="100%" bgcolor="#002779" border="0">
  <tbody>
  <tr>
    <td align="middle">
      	<table cellspacing="0" cellpadding="0" width="468" border="0">
	        <tbody>
	        <tr>
	          <td><img height="23" src="<?php echo base_url();?>/css/login/login_1.jpg" width="468"></td>
	        </tr>
	        <tr>
	          <td><img height="147" src="<?php echo base_url();?>/css/login/login_2.jpg" width="468"></td>
	        </tr>
	        </tbody>
      	</table>
      	<table cellspacing="0" cellpadding="0" width="468" bgcolor="#ffffff" border="0">
        <tbody><tr>
          <td width="16"><img height="120" src="<?php echo base_url();?>/css/login/login_3.jpg" width="16"></td>
          <td align="middle">
          <?php echo form_open('auth/login', 'id="loginForm"'); ?>
            <table cellspacing="0" cellpadding="0" width="230" border="0">
              <tbody>
              <tr height="0">
                <td width="5"></td>
                <td width="56"></td>
                <td></td></tr>
              <tr height="28">
                <td></td>
                <td>
                  <?php echo form_label('用户名:','login_name');?></td>
                <td>
    			       <?php echo form_input('login_name',set_value('login_name'),'id="login_name" maxlength="30" size="24" class="required"');?>
                </td>
              </tr>
              <tr height="25">
                <td>&nbsp; </td>
                <td>
                <?php echo form_label('密&nbsp;&nbsp;&nbsp;码:','password');?>
                </td>
                <td>
                <?php echo form_password('password','','id="password" size="24" maxlength="30"');?>
                </td>
              </tr>
               <tr height="23">
                <td>&nbsp; </td>
                <td>
                <?php echo form_label('验证码:','randcode');?>
                </td>
                <td>
                <?php echo form_input('randcode','','id="randcode" maxlength="4" size="13"');;?>&nbsp;<img id="codeImg"  src='<?php echo site_url("auth/code");?>' title="点击刷新" />
                </td>
              </tr>

               
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                	
                	<?php echo form_submit('submit','登录'); ?>
                </td>
                </tr>
                
                </tbody>
                </table>
				<?php echo form_close(); ?>
                </td>
          <td width="16">
          <img height="122" src="<?php echo base_url();?>/css/login/login_4.jpg" width="16">
          </td>
          </tr>
          </tbody>
          </table>
          
      <table cellspacing="0" cellpadding="0" width="468" border="0">
        <tbody><tr>
          <td><img height="16" src="<?php echo base_url();?>/css/login/login_5.jpg" width="468"></td></tr></tbody></table>
     </td>
    </tr>

  </tbody>
  </table>
</body>
</html>