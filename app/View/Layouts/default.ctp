<!DOCTYPE html>
<html>
<head>
    <title>Pyoopil</title>
    <?php echo $this->Session->flash(); ?>
</head>
<body>
    <!-- fetch the content -->
    <?php
        echo $this->fetch('content');
    ?>
</body>
</html>