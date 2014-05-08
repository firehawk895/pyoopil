<?php

echo $this->Form->create('Library' , array('type' => 'file'));
echo $this->Form->input('id');
echo $this->Form->input('Topic.0.name');
//or (without list for new topic)
//echo $this->Form->input('Topic.0.name');
echo $this->Form->input('Pyoopilfile.0.path' , array('type' => 'file'));
echo $this->Form->input('Pyoopilfile.1.path' , array('type' => 'file'));
echo $this->Form->input('Pyoopilfile.2.path' , array('type' => 'file'));
echo $this->Form->input('Link.0.linktext');
echo $this->Form->input('Link.1.linktext');
echo $this->Form->input('Link.2.linktext');
echo $this->Form->end('Upload');