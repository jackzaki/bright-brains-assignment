<div class="sidebar-menu">
    <header class="logo-env" style="" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>" style="color: white;font-weight: bolder;margin-bottom: 10%; font-size: 18px;"> 
                <img src="<?php echo base_url(); ?>uploads/logo.png"  style="max-height:60px;"/> CI DEMO
            </a>
        </div>

        <!-- logo collapse icon -->
        <!-- <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div> -->

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>	
    <ul id="main-menu" style="font-weight: bold;" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>superadmin/dashboard">
                <i class="entypo-gauge"></i>
                <span style="color: white;font-weight: bold;"><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
        
        <!-- users -->
        <li class="<?php if ($page_name == 'users') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>superadmin/users">
                <i class="entypo-users"></i>
                <span style="color: white;font-weight: bold;"><?php echo get_phrase('users'); ?></span>
            </a>
        </li>

        <!-- Product -->
        <li class="<?php if ($page_name == 'products') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>superadmin/products">
                <i class="entypo-download"></i>
                <span style="color: white;font-weight: bold;"><?php echo get_phrase('products'); ?></span>
            </a>
        </li>

        <!-- profile -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>superadmin/manage_profile">
                <i class="flaticon-lock"></i>
                <span style="color: white;font-weight: bold;"><?php echo get_phrase('edit_profile'); ?></span>
            </a>
        </li>

        <!-- Logout -->
        <li >
            <a href="<?php echo base_url(); ?>superadmin/logout">
                <i class="flaticon-paper-plane-1"></i>
                <span style="color: white;font-weight: bold;"><?php echo get_phrase('logout'); ?></span>
            </a>
        </li>

       

        <!-- SETTINGS -->
<!--        <li class="--><?php
//        if ($page_name == 'system_settings' || $page_name == 'profession_category_type' )
//                        echo 'opened active';
//        ?><!-- ">-->
<!--            <a href="#">-->
<!--                <i class="entypo-lifebuoy"></i>-->
<!--                <span style="color: white;font-weight: bold;">--><?php //echo get_phrase('settings'); ?><!--</span>-->
<!--            </a>-->
<!--            <ul>-->
<!--                <li class="--><?php //if ($page_name == 'system_settings') echo 'active'; ?><!-- ">-->
<!--                    <a href="--><?php //echo base_url(); ?><!--superadmin/system_settings">-->
<!--                        <span><i class="entypo-dot"></i> --><?php //echo get_phrase('general_settings'); ?><!--</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="--><?php //if ($page_name == 'profession_category_type') echo 'active'; ?><!-- ">-->
<!--                    <a href="--><?php //echo base_url(); ?><!--superadmin/profession_category_type">-->
<!--                        <span style="color: white;font-weight: bold;"><i class="entypo-dot"></i> --><?php //echo get_phrase('profession_category_type'); ?><!--</span>-->
<!--                    </a>-->
<!--                </li>-->
                <!-- <li class="<?php //if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php //echo base_url(); ?>superadmin/manage_language">
                        <span><i class="entypo-dot"></i> <?php //echo get_phrase('language_settings'); ?></span>
                    </a>
                </li> -->
<!--            </ul>-->
<!--        </li>-->

        <!-- ACCOUNT -->
        <!-- <li class="<?php //if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php //echo base_url(); ?>superadmin/manage_profile">
                <i class="entypo-lock"></i>
                <span style="color: white;font-weight: bold;"><?php //echo get_phrase('account'); ?></span>
            </a>
        </li> -->

    </ul>

</div>