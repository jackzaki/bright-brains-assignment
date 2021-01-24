<?php
$system_name    =   $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
$system_title   =   $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $system_name; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    

    <title><?php echo get_phrase('login');?> | <?php echo $system_title;?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
   

    <!-- font -->
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,500,500i,600,700,800,900|Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/plugins-css.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/typography.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/style.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/responsive.css'); ?>" />


    <link rel="stylesheet" href="<?php echo base_url('assets/css/neon-forms.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons/entypo/css/entypo.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">
<style>
.intl-tel-input {
  display: table-cell;
}
.intl-tel-input .selected-flag {
  z-index: 4;
}
.intl-tel-input .country-list {
  z-index: 5;
}
.input-group .intl-tel-input .form-control {
  border-top-left-radius: 4px;
  border-top-right-radius: 0;
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 0;
}
</style>
</head>

<body>
<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
    var baseurl = '<?php echo base_url();?>';
</script>

    <div class="wrapper">

        <!-- <section class="gray-bg height-100vh d-flex align-items-center page-section-ptb " style="background: url(<?php //echo base_url();?>assets/images/full.jpg) no-repeat; background-size: cover;"> -->
        <section class="gray-bg height-100vh d-flex align-items-center page-section-ptb " style="background-color:#aadaff;background-repeat: no-repeat; background-size: cover;background-position: center top;">
        
            <div class="container">
                <div class="row no-gutters justify-content-center">
                    <!-- <div class="col-lg-4 col-md-6 login-fancy-bg bg-overlay-black-10" style="background: url(<?php //echo base_url();?>assets/login/login_bg.jpg);">
                        <div class="login-fancy pos-r">
                            <div class="text-center">
                                <div style="padding: 55px;" class="d-none d-md-block"></div>
                                <img src="<?php //echo base_url().'uploads/logo.png'; ?>" height="25" />
                                <h2 class="text-white mb-20"></h2>
                                <h4 class="text-white mb-20"><?php //echo $system_name;?></h4>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-4 col-md-6 white-bg" style=" border-radius: 25px;">
                        
                        <div class="login-fancy pb-40 clearfix" id = "login_area">
                            <h3 class="mb-30"><?php echo get_phrase('login'); ?></h3>
                            <!-- <form action="<?php echo site_url('login/validate_login'); ?>" method="post"> -->
                            <?php echo form_open(base_url() . 'login/validate_login' , array('class' => 'form-horizontal form-groups-bordered validate'));?>

                                <div class="section-field mb-20">
                                    <label class="mb-10" for="name"><?php echo get_phrase('email'); ?>* </label>
                                    <input id="email" class="web form-control" type="email" placeholder="<?php echo get_phrase('email'); ?>" name="email" required>
                                </div>
                                <div class="section-field mb-20">
                                    <label class="mb-10" for="Password"><?php echo get_phrase('password'); ?>* </label>
                                    <input id="Password" class="Password form-control" type="password" placeholder="<?php echo get_phrase('password'); ?>" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary"><?php echo get_phrase('login'); ?></button>
                            <!-- </form> -->
                            <?php echo form_close();?>

                            <div class="section-field">
                                <div class="remember-checkbox mb-30">
                                    <a href="#" class="float-left" id = "new_forget_password_button" onclick="toggleView(this)"><?php echo get_phrase('Forgot_password'); ?> ?</a>

                                    <a href="#" class="float-right" id = "forgot_password_button" onclick="toggleView(this)"><?php echo get_phrase('create_new_account'); ?> ?</a>
                                
                                </div>
                            </div>
                        </div>

                        <div class="login-fancy pb-10 clearfix" id = "forgot_password_area" style="display: none; padding-top: 10px !important;">
                            <h3 class="mb-10"><?php echo get_phrase('create_new_account'); ?></h3>
                            <?php echo form_open(base_url() . 'login/validate_singup' , array('onsubmit' => 'mySubmit()', 'class' => 'form-horizontal form-groups-bordered validate'));?>

                            <!-- <form class="" action="<?php echo site_url('login/reset_password');?>" method="post"> -->
                                <div class="section-field mb-10">
                                    <label class="mb-10" for="name"><?php echo get_phrase('name'); ?>* </label>
                                    <input id="name" class="web form-control input-sm" type="text" placeholder="<?php echo get_phrase('name'); ?>" name="name" required>
                                </div>
                                <div class="section-field mb-10">
                                    <label class="mb-10" for="name"><?php echo get_phrase('email'); ?>* </label>
                                    <input id="forgot_password_email" class="web form-control input-sm" type="email" placeholder="<?php echo get_phrase('email'); ?>" name="email" required>
                                </div>
                                <div class="section-field mb-10">
                                    <label class="mb-10" for="name"><?php echo get_phrase('password'); ?>* </label>
                                    <input id="password" minlength="8" class="web form-control input-sm" type="password" placeholder="<?php echo get_phrase('password'); ?>" name="password" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary"><?php echo get_phrase('signup'); ?></button>
                            </form>

                            <div class="section-field">
                                <div class="remember-checkbox mb-20">
                                    <a href="#" class="float-right" id = "login_button" onclick="toggleView(this)"><?php echo get_phrase('back_to_login'); ?>?</a>
                                </div>
                            </div>
                        </div>

                        <div class="login-fancy pb-40 clearfix" id = "new_forget_password_area" style="display: none; padding-top: 10px !important;">
                            <h3 class="mb-30"><?php echo get_phrase('login'); ?></h3>
                            <!-- <form action="<?php echo site_url('login/validate_login'); ?>" method="post"> -->
                            <?php echo form_open(base_url() . 'login/forget_password' , array('class' => 'form-horizontal form-groups-bordered validate'));?>

                                <div class="section-field mb-20">
                                    <label class="mb-10" for="name"><?php echo get_phrase('email'); ?>* </label>
                                    <input id="email" class="web form-control" type="email" placeholder="<?php echo get_phrase('email'); ?>" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary"><?php echo get_phrase('send'); ?></button>
                            <!-- </form> -->
                            <?php echo form_close();?>

                            <div class="section-field">
                                <div class="remember-checkbox mb-30">
                                    <a href="#" class="float-right" id = "login_button" onclick="toggleView(this)"><?php echo get_phrase('back_to_login'); ?>?</a>

                                
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
        </section>
    </div>


    <!-- jquery -->
    <script src="<?php echo base_url('assets/login/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/toastr.js'); ?>"></script>
    <script type="text/javascript">
        function toggleView(elem) {
            if (elem.id === 'forgot_password_button') {
                $('#login_area').hide();
                $('#new_forget_password_area').hide();
                $('#forgot_password_area').show();
            }else if (elem.id === 'login_button') {
                $('#login_area').show();
                $('#new_forget_password_area').hide();
                $('#forgot_password_area').hide();
            }
            else if (elem.id === 'new_forget_password_button') {
                $('#login_area').hide();
                $('#new_forget_password_area').show();
                $('#forgot_password_area').hide();
            }
        }

        
    </script>
    <!-- for mobile with country -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
    
    <script type="text/javascript">

        $("#mobile").intlTelInput({
            separateDialCode: true,
            preferredCountries:["in","us"],
            //hiddenInput: "full",
            //onlyCountries: ["in", "us"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
        });
        

  
        // $("#phone").intlTelInput("getSelectedCountryData").dialCode;
        // $("#calling_code").val($("#mobile").intlTelInput("getSelectedCountryData").dialCode);

        // $("form").submit(function() {
        //     var full_number = mobile.getNumber(intlTelInputUtils.numberFormat.E164);
        //     $("input[name='mobile[full]'").val(full_number);
        //     alert(full_number)
        
        // });
        function mySubmit() {
            var telInput = $("#mobile");
            var getCode = telInput.intlTelInput('getSelectedCountryData').dialCode;
            var iso = telInput.intlTelInput('getSelectedCountryData').iso2;
            document.getElementById("country_code").value = getCode;
            document.getElementById("country").value = iso;
        }
    </script>
    
    <!-- SHOW TOASTR NOTIFIVATION -->
    <?php if ($this->session->flashdata('flash_message') != ""):?>

    <script type="text/javascript">
    	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
    </script>

    <?php endif;?>

    <?php if ($this->session->flashdata('error_message') != ""):?>

    <script type="text/javascript">
    	toastr.error('<?php echo $this->session->flashdata("error_message");?>');
    </script>

    <?php endif;?>

    
</body>
</html>
