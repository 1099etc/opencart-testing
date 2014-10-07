<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

    <table class='content' style='width:100%' cellspacing='10'>
     <?php if($errors) { ?>
       <tr><td colspan='2'><?php echo $errors; ?></td></tr>
     <?php } ?>
     <tr>
        <td><label for='serial'>Serial Number</label></td>
        <td><input type='text' name='serial' id='serial' class='textbox' value='<?php echo $serial; ?>' /></td>
      </tr>
      <tr>
        <td colspan='2'><label for='states'><b>If you use AMS Payroll or Forms Filer Plus, which states will you be filing for?</b><br />Select all that apply by holding the Control Key on your keyboard as you select.</label></td>
      </tr>
      <tr>
        <td colspan='2'>
          <select multiple size='10' name='states[]' id='states'>
          <?php foreach($states[0] as $state) { ?>
            <?php if(in_array($state['code'], $selectedStates)) { ?>
              <option value="<?php echo $state['code']; ?>" selected><?php echo $state['name']; ?></option>
            <?php } else { ?>
              <option value="<?php echo $state['code']; ?>"><?php echo $state['name']; ?></option>
            <?php } ?>
          <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan=2><label for='comments'>Do you have any comments (Not for technical support questions)?</label></td>
      </tr>
      <tr>
        <td colspan=2><textarea name='comments' id='comments' style='width:100%; height:65px;' ><?php echo $comments; ?></textarea></td>
      </tr>
      <tr>
        <td colspan=2>
           <input type="submit" value="Submit" class="button" />
        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $footer; ?>
