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
    

    <title>Forget password | <?php echo $system_title;?></title>
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

</head>

<body>
<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
    var baseurl = '<?php echo base_url();?>';
</script>

    <div class="wrapper">

        <!-- <section class="gray-bg height-100vh d-flex align-items-center page-section-ptb " style="background: url(<?php //echo base_url();?>assets/images/full.jpg) no-repeat; background-size: cover;"> -->
        <!-- <section class="gray-bg height-100vh d-flex align-items-center page-section-ptb " style="background-image: url(<?php //echo base_url();?>assets/images/full.jpg);background-repeat: no-repeat; background-size: cover;background-position: center top;"> -->

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
                            <h3 class="mb-30">Update new Password</h3>
                            <?php echo form_open(base_url() . 'login/update_new_password' , array('class' => 'form-horizontal form-groups-bordered validate'));?>

                                <div class="section-field mb-20">
                                    <label class="mb-10" for="new_Password"><?php echo get_phrase('password'); ?>* </label>
                                    <input id="new_Password" minlength="8" class="Password form-control" type="password" placeholder="New password" name="new_password" required>
                                </div>
                                <div class="section-field mb-20">
                                    <label class="mb-10" for="confirm_new_Password">Confirm New Password * </label>
                                    <input id="confirm_new_Password" minlength="8" class="Password form-control" type="password" placeholder="Confirm New Password" name="confirm_new_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary"><?php echo get_phrase('update'); ?></button>
                                <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>" >
                            <!-- </form> -->
                            <?php echo form_close();?>

                        </div>

                        
                    </div>

                </div>
            </div>
        </section>
    </div>


    <!-- jquery -->
    <script src="<?php echo base_url('assets/login/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/toastr.js'); ?>"></script>
    
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
