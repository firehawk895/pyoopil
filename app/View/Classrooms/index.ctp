<?php
$this->start('pagesubnav');
echo $this->element('classrooms/classroom-subnav');
$this->end();
?>
<div class="library-wrapper">
    <ul class="tile-lst" id="class-tile-list">
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
//                echo $this->Form->submit('Join Classroom', array(
//                    'div' => false,
//                    'class' => 'sub-btn',
//                    'value' => 'Join Classroom',
//                ));
                    echo $this->Form->end();
                    $script = <<<JS
                            var data = $data;
JS;
                    ?>
                    <!--<input type="text" class="access" name="search" placeholder="Enter Access Code" id="join-with-code-submit">-->
                    <a href="#" class="sub-btn" id="join-with-code-submit">Join Classroom</a>
                </div>
            </div>
        </li>
        <?php debug($data); ?>
        <?php
        $this->Js->buffer($script);
        ?>
    </ul>
</div>