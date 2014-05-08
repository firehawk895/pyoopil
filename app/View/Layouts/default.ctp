<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!--<link href="../style.css" rel="stylesheet">-->
    <?php echo $this->Html->css('/style.css'); ?>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/css/toastr.min.css" rel="stylesheet"/>

</head>
<!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="../css/ie8.css" />
<![endif]-->
<!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
</head>
<body class="bg-color">
    <!-- Header -->
    <header>
        <?php
        $flashMessage = $this->Session->flash();
        if ($flashMessage !== false) {
            echo $this->element('pyoopil_flash', array(
                'message' => $flashMessage
            ));
        }
        ?>
        <section class="clearfix header">
            <!-- Logo-->
            <div class="logo"><a href="">
                    <?php echo $this->Html->image('/images/logo.png', array('class' => 'f-left')); ?>
                </a>
            </div>
            <!-- search div -->
            <!-- Top Notification -->
        </section>
    </header>
    <div class="container calen">
        <!-- Left Navigation -->
        <nav class="navigation-main">
            <ul class="primary">
                <li class="pdiscover active">
                    <a href="" class="lst-a classrooms"><span class="icon"></span>
                        <span class="label">Classrooms</span></a>
                    <!--Classroom sub nav-->
                </li>
                <li class="pdiscover">
                    <a href="" class="lst-a flname">
                        <span class="icon">
                            <?php echo $this->Html->image('/images/chat1.jpg'); ?>
                        </span>
                        <span class="label"><?php echo AuthComponent::user('username') ?></span></a>
                </li>
                <li>
                    <a href="" class="logout">
                        <?php echo $this->Html->image('/images/logout.png'); ?>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Right side Content  -->
        <section class="rightwrapper">
            <!-- Right Sub Navigation -->
            <section class="pagesubnav">
                <div class="clearfix">
                    <?php
                    echo $this->fetch('pagesubnav');
                    ?>
                </div>
            </section>
            <!-- Right Content -->
            <section class="pagecontent clearfix">
                <!-- content -->
                <?php
                echo $this->fetch('content');
                ?>
            </section>
        </section>
    </div>

    <?php
    echo $this->Html->script('jquery-1.8.2.min');
    echo $this->Html->script('jquery-ui-1.10.3.custom');
    echo $this->Html->script('plugin');
    echo $this->Html->script('core');
    ?>
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>--> 
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
</body>
</html>