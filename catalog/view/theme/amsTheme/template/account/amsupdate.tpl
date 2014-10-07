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

    <?php 

      if(isset($serial)) {
        $serial = $serial;
      }
      else { $serial = ''; }
      
      if(isset($this->request->get['serial'])) {
        $serial = $this->request->get['serial'];
      }
      if(isset($this->request->post['serial'])) {
        $serial = $this->request->post['serial'];
      }
      if(isset($this->request->get['serialSearch'])) {
        $serial = $this->request->get['serialSearch'];
      }
      if(isset($this->request->post['serialSearch'])) {
        $serial = $this->request->post['serialSearch'];
      }


    ?>

<form action='index.php'>
  <input type='hidden' name='route' value='account/amsupdate/submit' />
      <label for='searchSerial'>Enter Your 8 Character Serial Number : </label><input type='text' maxlength='8' name='serialSearch' id='serialSearch' size='8' class='uppercase' value='<?php echo $serial; ?>' /><input type='submit' value='Go!' />
</form>
<br /><br />
    <?php if(!empty($files)) {?>
      <?php foreach($files as $file) { ?>

<!--        <div>
          <table style='width:100%; text-align:left;'>
            <tr><td style='width:15%;text-align: left;'><nobr><a href='index.php?route=account/amsupdate/download&serial=<?php echo $file["serialcode"]; ?>&download_id=<?php echo $file["download_id"]; ?>'>Download Now</a></nobr></td></tr>
            <tr><td style='text-align: left;'>File       </td><td style='text-align: left;'><?php echo $file['mask']; ?></td></tr>
            <tr><td style='text-align: left;'>Date Added </td><td style='text-align: left;'><?php echo $file['date_added']; ?></td></tr>
            <tr><td style='text-align: left;'>Notes      </td><td style='text-align: left;'><?php echo $file['notes']; ?></td></tr>
          </table>
        </div>
-->
        <table class='fileTable'>
          <tr>
            <td class='fileTableHeadRow'>
              <div class='fileName'><nobr><a href='index.php?route=account/amsupdate/download&serial=<?php echo $file["serialcode"]; ?>&download_id=<?php echo $file["download_id"]; ?>'><?php echo $file['name']; ?></a></nobr></div>
              <div class='releaseNotes'><a class='inline' href='#hidden-<?php echo $file["download_id"]; ?>' title='<?php echo $file["name"] . " - " . $file["version"]; ?>' >Click here to view release notes.</a></div>
              <div class='dlLink'><nobr><a href='index.php?route=account/amsupdate/download&serial=<?php echo $file["serialcode"]; ?>&download_id=<?php echo $file["download_id"]; ?>'>Download Now</a></nobr></div>
            </td>
          </tr>
        </table>

        <div style='display: none;'>
          <div id='hidden-<?php echo $file["download_id"]; ?>' style='padding: 10px; background:#FFF;'>
            <?php echo htmlspecialchars_decode($file['notes']); ?>
          </div>
        </div>

      <?php } ?>
    <?php } ?>


  </div>

  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 
