<?php

echo $this->Form->create('Classroom');
echo $this->Form->input(
        'title', array('label' => 'Name of the classroom')
);
//Set the list at the controller
echo $this->Form->input(
        'campuses', array(
    'label' => 'University Association',
    'type' => 'select',
    'empty' => 'none'
));
//Set the list of departments based on university association
//ajax fill based on campus
echo $this->Form->input(
        'departments', array(
    'label' => 'Department',
    'type' => 'select',
    'empty' => 'none'
));
//Set list like 1,2,3,4,5
echo $this->Form->input(
        'year', array(
            'label' => 'Year',
            
            )
);
//
echo $this->Form->input(
        'duration_start_date', array('label' => 'Start')
);
//
echo $this->Form->input(
        'duration_end_date', array('label' => 'End')
);

echo $this->Form->input(
        'is_private', array('label' => 'Private Classroom')
);

echo $this->Form->input(
        'description', array('label' => 'Course Description')
);
//ajax fill based on department
//Set the list at the controller
echo $this->Form->input(
        'degrees', array('label' => 'Degree')
);

echo $this->Form->input(
        'link', array('label' => 'Youtube video link')
);

echo $this->Form->input(
        'minimum_attendance_percentage', array('label' => 'Minimum required attendance')
);

echo $this->Form->end('Create');

