<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Pyoopil</title>
    <!-- styles -->
    <?php
    echo $this->Html->css('reset.css');
    echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css');
    echo $this->Html->css('layout.css');
    echo $this->Html->css('styles.css');
    echo $this->Html->css('jquery-ui-latest.css');
    echo $this->Html->css('tooltipster.css');
    echo $this->Html->css('font-awesome.min.css');
    echo $this->Html->css('plugins.css');
    echo $this->Html->css('jquery.bxslider.css');
    echo $this->Html->css('chosen.css');
    echo $this->Html->css('jquery.tagit.css');
    echo $this->Html->css('prettyPhoto.css');
    echo $this->Html->css('fullcalendar.css');
    echo $this->Html->css('toggle-switch.css');
    ?>
    <link rel="shortcut icon" href="images/favicon.ico">
    <!--[if lt IE 9]>
            <link rel="stylesheet" type="text/css" href="css/ie8.css" />
    <![endif]-->
    <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
        <![endif]-->
    <?php // echo $this->Session->flash(); ?>
</head>
<body class="bg-color">
    <!-- Header -->
    <header>
        <section class="clearfix header">
            <!-- Logo-->
            <div class="logo"><a href="javascript:void(0)">
                    <!--<img src="images/logo.png" class="f-left" alt="logo">-->
                    <?php
                    echo $this->Html->image('/images/logo.png', array(
                        'alt' => 'logo',
                        'class' => 'f-left'
                    ));
                    ?>
                </a>
            </div>
            <div class="search">
                <div class="uni-search clearfix">
                    <a href="javascript:void(0)" class="search-bx"></a>
                    <input type="text" placeholder="Search.." class="uni-searchinput">
                </div>
                <!-- Top Notification -->
                <div class="right-slide">
                    <div class="toprightsection tabpages">
                        <ul>
                            <li><a href="#tab1" class="calenderdescrip tab">
                                    <div class="top-icon cal"></div>
                                    <span class="noti-num">5</span></a>
                            </li>
                            <li><a href="#tab2" class="msgdescrip tab">
                                    <div class="top-icon chat"></div>
                                    <span class="noti-num">5</span></a>
                            </li>
                            <li><a href="#tab3" class="tab">
                                    <div class="top-icon noti"></div>
                                    <span class="noti-num">11</span></a>
                            </li>
                            <li><a href="#tab4" class="tab">
                                    <div class="top-icon msg"></div>
                                    <span class="noti-num">4</span></a>
                            </li>
                            <li class="dock-bk lastli"><a href="#" class="active tab">
                                    <!--<img src="images/arrow_back.png" class="mt5" alt="">-->
                                    <?php
                                    echo $this->Html->image('/images/arrow_back.png', array(
                                        'class' => 'mt5'
                                    ));
                                    ?>
                                </a>
                            </li>
                        </ul>

                        <!-- Notification Right Window -->
                        <div class="notification_details">
                            <div id="tab1">
                                <p>Calender Panel</p>
                            </div>
                            <div id="tab2">
                                <p>Chat Panel</p>
                            </div>
                            <div id="tab3">
                                <p>Notification Panel</p>
                            </div>
                            <div id="tab4">
                                <p>Message Panel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </header>
    <div class="container calen">
        <!-- Left Navigation -->
        <nav class="navigation-main">
            <ul class="primary">
                <li class="pdiscover hassub active">
                    <a href="javascript:void(0);" class="lst-a classrooms"><span class="icon"></span>
                        <span class="label">Classrooms</span></a>
                    <div class="sub">
                        <!--Classroom sub nav-->
                        <ul class="menu-coll">
                            <li class="sub-menu pre-contact">
                                <a href="<?php echo Router::url(array('controller' => 'classrooms' , 'action' => 'index'))?>">
                                    <p class="submenu-heading">All<br />
                                        Classrooms</p>
                                </a>
                                <!--Classroom Vertical Scroller-->
                            </li>
                            <!-- fetch left-nav-classrooms -->
                            <?php echo $this->element('classrooms/classrooms-left-nav'); ?>
                        </ul>
                    </div>
                </li>
                <li class="pdiscover">
                    <a href="#" class="lst-a flname"><span class="icon">
                            <!--<img src="images/chat1.jpg" alt="fname" />-->
                            <?php
                            echo $this->Html->image('/images/chat1.jpg', array(
                                'alt' => 'profile pic'
                            ));
                            ?>
                        </span>
                        <span class="label">
                            <?php
                            $name = AuthComponent::user('fname') . " " . AuthComponent::user('lname');
                            echo String::truncate($name, '18');
                            ?>
                        </span></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="logout">
                        <!--<img src="images/logout.png" alt="">-->
                        <?php
                            echo $this->Html->image('/images/logout.png', array(
                                'alt' => 'profile pic'
                            ));
                        ?>
                    </a>
                    <ul class="logout-lst">
                        <li class="lastli"><a href="<?php echo Router::url(array('controller' => 'app_users', 'action' => 'logout')); ?>">Logout</a>
                        </li>
                    </ul>

                </li>        </ul>
        </nav>
        <!-- Right side Content  -->
        <section class="rightwrapper">
            <!-- Right Sub Navigation -->
            <section class="pagesubnav">
                <!-- fetch the subnav + ajax load -->
                <?php
                echo $this->fetch('pagesubnav');
                ?>
            </section>
            <!-- Right Content -->
            <section class="pagecontent clearfix">
                <!-- fetch the content -->
                    <?php
                    echo $this->fetch('content');
                    ?>
            </section>
        </section>
    </div>
    <?php
    //core library
//    echo $this->Html->script('jquery-1.8.2.min.js');
    echo $this->Html->script('https://code.jquery.com/jquery-1.11.1.js');
    echo $this->Html->script('jquery-ui-1.10.3.custom.js');

    //Buffer from cakephp
    echo $this->Js->writeBuffer();

    //plugins that should have never been there
    echo $this->Html->script('jquery.autosize.min.js');
//    echo $this->Html->script('charts.js');
    echo $this->Html->script('jquery.passstrength.js');
    echo $this->Html->script('jquery.bxslider.min.js');
    echo $this->Html->script('jquery.slimscroll.min.js');
    echo $this->Html->script('tooltip.min.js');
    echo $this->Html->script('jquery.prettyPhoto.js');
    echo $this->Html->script('chosen.jquery.min.js');
    echo $this->Html->script('jquery.ddslick.min.js');
    echo $this->Html->script('tag-it.min.js');
//    echo $this->Html->script('tiny.editor.packed.js');
    echo $this->Html->script('fullcalendar.min.js');
    echo $this->Html->script('jquery.mousewheel.min.js');
    echo $this->Html->script('vertical.slider.standard.js');
//    echo $this->Html->script('toastr.js');
    echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js');
    echo $this->Html->script('core.js');
    echo $this->Html->script('ck/ckeditor');

    //plugins for pyoopil front end use
    echo $this->Html->script('http://malsup.github.io/jquery.form.js');
    ?>
    <?php // echo $this->element('sql_dump'); ?>
</body>
</html>