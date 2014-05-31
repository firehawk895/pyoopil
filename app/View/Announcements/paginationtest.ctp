<table border="1">
    <?php foreach ($data as $tile): ?>
        <tr>
            <td><?php echo $tile['Announcement']['id']; ?> </td>
            <td><?php echo $tile['Announcement']['subject']; ?> </td>
            <td><?php echo $tile['Announcement']['user_id']; ?> </td>
            <td><?php echo $tile['Announcement']['classroom_id']; ?> </td>
            <td><?php echo $tile['Announcement']['file_path']; ?> </td>
            <td><?php echo $tile['Announcement']['created']; ?> </td>
            <td><?php echo $tile['AppUser']['fname']; ?> </td>
            <td><?php echo $tile['AppUser']['lname']; ?> </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>    
<?php echo $this->Paginator->counter(); ?>
<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?>    