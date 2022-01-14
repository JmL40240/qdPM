<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo javascript_include_tag('/js/bueditor/bueditor.js'); ?>
<?php echo stylesheet_tag('/js/bueditor/bueditor.css'); ?>

<?php echo __('You can format your text using wiki markup.') . ' <a href="#" onclick="openModalBox(\'' .  url_for('wiki/supportedMarkup', true) . '\')">' . __('Check supported wiki markup') . '</a><br>' . __('Also any HTML tags are allowed'); ?>

<form id="wiki" action="<?php echo url_for('wiki/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table  class="formTable" width="100%">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <?php echo input_hidden_tag('projects_id',$sf_request->getParameter('projects_id')) ?>
          <div class="infoBlock">
            <input type="submit" value="<?php echo __('Save'); ?>"  class="btn btn-primary"/>&nbsp;
            <input type="button" value="<?php echo __('Preview'); ?>"  class="btn btn-default" onClick="do_wiki_preview('<?php echo url_for('wiki/preview')?>')"/>
          </div>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>

      <tr>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <td><br>                    
        </td>
      </tr>
    </tbody>
  </table>
</form>

<script>
editor.path='<?php echo public_path("js/bueditor/") ?>'; 
editor.buttons=getBueditorButtons('<?php echo public_path("js/bueditor/") ?>');

</script>

<div id="wiki_preview"></div>
