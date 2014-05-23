<label>Course Type</label>
<div class="radio-btn">
    <?php
    $options = array('0' => 'Public', '1' => 'Private');
    $attributes = array('legend' => false);

    echo $this->Form->radio('is_private', $options, $attributes);
    ?>
</div>
<label>Course Type</label>
<div class="radio-btn">
    <input id="Public" type="radio" name="course" value="Public">
    <label for="Public" class="radio-lbl">Public</label>
    <input id="Private" type="radio" name="course" value="Private">
    <label for="Private" class="radio-lbl">Private</label>
</div>

<label>Course Type</label>
<div class="radio-btn">
    <input type="hidden" name="data[is_private]" id="is_private_" value=""/>
    <input type="radio" name="data[is_private]" id="is_private0" value="0" />
    <label for="is_private0">Public</label>
    <input type="radio" name="data[is_private]" id="is_private1" value="1" />
    <label for="is_private1">Private</label>
</div>
<label>Course Type</label>
<div class="radio-btn">
    <input id="Public" type="radio" name="course" value="Public">
    <label for="Public" class="radio-lbl">Public</label>
    <input id="Private" type="radio" name="course" value="Private">
    <label for="Private" class="radio-lbl">Private</label>
</div>