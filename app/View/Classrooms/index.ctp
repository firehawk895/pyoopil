<?php
$this->start('pagesubnav');
echo $this->element('classrooms/classroom-subnav');
$this->end();
?>
<div class="library-wrapper">
    <ul class="tile-lst" id="class-tile-list">
        <div class="tinyscrollbar">
            <div class="viewport">
                <div class="overview">
                    <li class="code-class">
            <div class="newjoinbox">
                <a class="newjoin">Join New Classroom</a>
                <div class="accessclass">
                    <?php
//                echo $this->Form->create('Classroom', array(
//                        'action' => 'joinWithCode',
//                        'id' => 'join-with-code'
//                ));
                    echo $this->Form->create(null, array(
                        'url' => array(
                            'controller' => 'classrooms',
                            'action' => 'joinWithCode'
                        ),
                        'id' => 'join-with-code'
                    ));
                    echo $this->Form->input('access_code', array(
                        'div' => false,
                        'label' => false,
                        'type' => 'text',
                        'class' => 'access',
//                    'name' => 'search',
                        'placeholder' => 'Enter Access Code',
//                    'label' => 'false'
                    ));
               echo $this->Form->submit('Join Classroom', array(
                   'div' => false,
                   'class' => 'sub-btn',
                   'value' => 'Join',
               ));
                    echo $this->Form->end();
                    ?>
                    <!--<input type="text" class="access" name="search" placeholder="Enter Access Code" id="join-with-code-submit">-->
                    <!-- <a href="#" class="sub-btn" id="join-with-code-submit">Join Classroom</a> -->
                </div>
            </div>
        </li
>                    <div id="classrooms">
                    
                    </div>
                </div>
                <div class="scrollbar">
                    <div class="track">
                        <div class="thumb">
                            <div class="end">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">

            var App = window.App || {};
                App.classrooms = App.classrooms || {};

                App.classrooms.data = <?php echo $data ?>;

        </script>   
    </ul>
</div>