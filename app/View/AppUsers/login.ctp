<?php
$this->extend('/Pages/home');

$script = <<<JS
    $("#dialog").dialog("open");
    $('.ui-widget-overlay').addClass('custom-overlay');
JS;

//$this->start('login');
//echo $this->Form->create($model, array(
//    'action' => 'login',
//    'id' => 'LoginForm'));
//echo $this->Form->input('email', array(
//    'label' => __d('users', 'Email')));
//echo $this->Form->input('password', array(
//    'label' => __d('users', 'Password')));
//
//echo '<p>' . $this->Form->input('remember_me', array('type' => 'checkbox', 'label' => __d('users', 'Remember Me'))) . '</p>';
//echo '<p>' . $this->Html->link(__d('users', 'I forgot my password'), array('action' => 'reset_password')) . '</p>';
//
//echo $this->Form->hidden('User.return_to', array(
//    'value' => $return_to));
//echo $this->Form->end(__d('users', 'Submit'));
//$this->end();
?>
<!--Login dialog-->
<!--<div id="dialog" class="signup">
    <div class="pop-wind clearfix">
        <a class="close-link" href="javascript:void(0);"><span class="icon-cross"></span></a>
        <div class="signup-content">
            <p class="signup-heading">Pyoopil Login</p>
            <form action="" method="post">
                <table class="signup-form">
                    <tr>
                        <td>
                            <p class="sign-txt">Username</p>
                            <div class="sign-txtbx">
                                <input type="text" name="" required placeholder="">
                            </div>
                        </td>
                        <td>
                            <p class="sign-txt">Password</p>
                            <div class="sign-txtbx">
                                <input type="password" name="" required placeholder="">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="login-check">
                                <input type="checkbox" name="checkbox2" id="checkbox2" class="css-checkbox" />
                                <label for="checkbox2" class="css-label">Stay signed in</label>
                            </div>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="for-pass">Forgot password</a>
                        </td>
                    </tr>
                </table>
                <div class="form-btn clearfix">
                    <div class="submit-btn">
                        <input type="submit" class="sub-btn" value="Login">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>-->

<!-- mix and match -->
<?php $this->start('login'); ?>
<!--Login dialog-->
<div id="dialog" class="signup">
    <div class="pop-wind clearfix">
        <a class="close-link" href="javascript:void(0);"><span class="icon-cross"></span></a>
        <div class="signup-content">
            <p class="signup-heading">Pyoopil Login </p>
                <table class="signup-form">
                    <?php
                    echo $this->Form->create($model, array(
                        'action' => 'login',
                        'id' => 'LoginForm'));
                    ?>
                    <tr>
                        <td>
                            <p class="sign-txt">Email</p>
                            <div class="sign-txtbx">
                                <?php
                                echo $this->Form->input('email', array(
                                    'label' => false,
                                    'div' => false
                                ));
                                ?>
                                <!--<input type="text" name="" required placeholder="">-->
                            </div>
                        </td>
                        <td>
                            <p class="sign-txt">Password</p>
                            <div class="sign-txtbx">
                                <?php
                                echo $this->Form->input('password', array(
                                    'label' => false,
                                    'div' => false
                                ));
                                ?>
                                <!--<input type="password" name="" required placeholder="">-->
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="login-check">
                                <?php echo $this->Form->input('remember_me', array('type' => 'checkbox', 'label' => false, 'div' => false, 'id' => 'checkbox2', 'class' => 'css-checkbox')); ?>
                                <!--<input type="checkbox" name="checkbox2" id="checkbox2" class="css-checkbox" />-->
                                <label for="checkbox2" class="css-label">Stay signed in</label>
                            </div>
                        </td>
                        <td>
                            <?php
                            echo $this->Html->link('Forgot password', array(
                                'controller' => 'app_users',
                                'action' => 'reset_password',
                                    ), array(
                                'class' => 'for-pass'
                            ));
                            ?>
                            <!--<a href="javascript:void(0)" class="for-pass">Forgot password</a>-->
                        </td>
                    </tr>
                </table>
                <div class="form-btn clearfix">
                    <div class="submit-btn">
                        <?php
                        echo $this->Form->hidden('User.return_to', array(
                            'value' => $return_to));
                        echo $this->Form->submit('Login' , array(
                            'div' => false,
                            'class' => 'sub-btn'
                        ));
                        echo $this->Form->end();
                        ?>
                        <!--<input type="submit" class="sub-btn" value="Login">-->
                    </div>
                </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
<?php
$this->Js->buffer($script);
