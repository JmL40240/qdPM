<?php foreach($attachments as $a): 

$attachments_id = urlencode(base64_encode($a->getId()));

$file_path = sfConfig::get('sf_upload_dir') . '/attachments/' . $a->getFile();

?>
  <div id="attachedFile<?php echo $a->getId() ?>">
    <table style="width: 100%" class="table">
      <tr>
        <td colspan="2"><?php echo Attachments::getFileIcon($a->getFile())  . ' ' . (is_file($file_path) ? (getimagesize($file_path) ? link_to( substr($a->getFile(),7), 'attachments/view?id=' . $attachments_id, array('target'=>'_blank', 'absolute'=>true)) :Attachments::getLink($a)):substr($a->getFile(),7)) ?></td>
      </tr>                                                                                     
      </tr>
        <?php if($a->getBindType()!='wiki'):?>
        <td style="border-top: 0;"><?php echo  input_tag('attachments_info[' . $a->getId() . ']',$a->getInfo(),array('class'=>'form-control','placeholder'=>__('Description')))?></td>
        <?php endif ?>
        
        <td style="border-top: 0;"><a href="#" onClick="return deleteAttachments(<?php echo $a->getId() ?>,'<?php echo url_for('attachments/delete?id=' . $attachments_id) ?>')"><?php echo __('Delete') ?></a></td>
      </tr> 
      <?php if($a->getBindType()=='wiki') echo '<tr><td colspan="3">[' . url_for('attachments/view?id='.$attachments_id,true). ' ' . substr($a->getFile(),7) . ']</td></tr>' ?>       
    </table>
  </div>
<?php endforeach ?>