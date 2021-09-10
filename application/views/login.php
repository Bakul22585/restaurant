<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restaurant | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url() ?>public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>public/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url() ?>public/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>public/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= base_url() ?>"><b>Restaurant Admin</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php
            $attributes = array('class' => 'login-form', 'id' => 'login-form');
            echo form_open('login/validate', $attributes);
            ?>
            <?php
            echo form_error('password');
            echo form_error('username');
            if ($this->session->flashdata('msg_class') == "success") {
            ?>
                <div class="alert alert-success alert-message">
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            <?php
            } else if ($this->session->flashdata('msg_class') == "failure") {
            ?>
                <div class="alert alert-danger alert-message">
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            <?php
            }
            ?>
            <div class="form-group has-feedback">
                <?php
                $username = set_value('username', NULL);
                echo form_input(array('name' => 'username', 'class' => 'form-control', 'placeholder' => 'Username', 'autocomplete' => 'off', 'required' => 'required'), $username);
                ?>
                <!-- <input type="email" class="form-control" placeholder="Email"> -->
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php
                $password = set_value('password', NULL);
                echo form_password(array('id' => 'password', 'name' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'autocomplete' => 'off', 'required' => 'required'), $password);
                ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <?php echo form_checkbox(array('name' => 'remember', 'value' => '1')); ?> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?php echo form_submit(array('id' => 'signin_submit', 'value' => 'Sign In', 'class' => 'btn btn-primary btn-block btn-flat')); ?>
                </div>
                <!-- /.col -->
            </div>
            <?php echo form_close(); ?>
            <!-- /.social-auth-links -->
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?= base_url() ?>public/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url() ?>public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url() ?>public/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
</body>

</html>