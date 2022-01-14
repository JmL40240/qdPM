<h3 class="page-title"><?php echo __($heading) ?></h3>
<p>
<?php echo __('By default all Extra Fields are visible.') ?><br>
<?php echo __('Select Extra Fields which will be visible only for specific group') ?><br>
<?php echo __('Use option (Don\'t use Extra Fields) to hide Extra Fields for specific group') ?>
</p>

<form action="<?php echo url_for('extraFields/extraFieldsByGroup?t=' . $sf_request->getParameter('t')) ?>" method="post">
<div class="table-scrollable">
<table class="table table-striped table-bordered table-hover" >
<?php
  $html = '
    <tr>
      <td></td>
  ';
  foreach($groups as $g)
  {
    $html .= '<td>' . $g->getName() . '</td>';
  }
  $html .= '</tr>';
  
  echo $html;
  
  foreach($extra_fields as $ef)
  {
    $html = '
      <tr>
        <td>' . $ef->getName() . '</td>';
        
    foreach($groups as $g)
    {
      $checked='';
      if(in_array($ef->getId(),explode(',',$g->getExtraFields())))
      {
        $checked='checked="checked"';
      }
      
      $disabled='';
      if($g->getExtraFields()=='set_off_extra_fields')
      {
        $disabled='disabled';
      }
      
      $html .= '<td><input ' . $disabled . ' class="extra_field_' . $g->getId() . '" type="checkbox" value="' . $ef->getId() . '" id="extra_field_' . $g->getId() . '_' . $ef->getId() . '" name="extra_field[' . $g->getId(). '][]" ' . $checked . '></td>';
    }
        
    $html .= '</tr>';
            
    echo $html;
  }
  
  $html = '
      <tr>
        <td>' . __('Don\'t use Extra Fields') . '</td>';
        
    foreach($groups as $g)
    {
      $checked='';
      if($g->getExtraFields()=='set_off_extra_fields')
      {
        $checked='checked="checked"';
      }
      
      $html .= '
          <td>
            <input value="set_off_extra_fields" type="checkbox" id="set_off_extra_fields_' . $g->getId() . '" name="set_off_extra_fields[' . $g->getId(). ']" ' . $checked . ' onClick="set_off_extra_fields(' . $g->getId() . ')">            
          </td>';
    }
        
  $html .= '</tr>';
  
  echo $html;
  
  
?>
</table>
</div>
<br>
  <input type="submit" value="<?php echo __('Save')?>" class="btn btn-primary">
</form>

<script>
  function set_off_extra_fields(gId)
  {
    if($('#set_off_extra_fields_'+gId).attr('checked'))
    {
      $( ".extra_field_"+gId).each(function() {       
          set_checkbox_checked($(this).attr('id'),false)  
        });
    }
    else
    {
      $( ".extra_field_"+gId).each(function() {  
      
      });
    }
  }
</script>