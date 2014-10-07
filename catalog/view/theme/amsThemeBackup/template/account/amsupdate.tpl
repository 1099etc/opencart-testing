<?php echo $header; ?>

<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>

  <h1><?php echo $heading_title; ?></h1>

  <div class="content">

    <?php if($errors != '') { ?>
      <div id='errors'>
        <ul>
          <?php echo $errors; ?>
        </ul>
      </div>
    <?php } ?>

<form action='index.php'>
  <input type='hidden' name='route' value='account/amsupdate/submit' />
      <label for='searchSerial'>Enter Your Serial Number : </label><input type='text' maxlength='8' name='serialSearch' id='serialSearch' size='8' value='' /><input type='submit' value='Go!' />
</form>

    <?php if(!empty($files)) {?>
      <?php foreach($files as $file) { ?>
        <div>
          <table style='width:100%; text-align:left;'>
            <tr><td style='width:15%;text-align: left;'><nobr><a href='index.php?route=account/amsupdate/download&serial=<?php echo $file["serialcode"]; ?>&download_id=<?php echo $file["download_id"]; ?>'>Download Now</a></nobr></td></tr>
            <tr><td style='text-align: left;'>File       </td><td style='text-align: left;'><?php echo $file['mask']; ?></td></tr>
            <tr><td style='text-align: left;'>Date Added </td><td style='text-align: left;'><?php echo $file['date_added']; ?></td></tr>
            <tr><td style='text-align: left;'>Notes      </td><td style='text-align: left;'><?php echo $file['notes']; ?></td></tr>
          </table>
        </div>
      <?php } ?>
    <?php } ?>


  </div>

  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 
