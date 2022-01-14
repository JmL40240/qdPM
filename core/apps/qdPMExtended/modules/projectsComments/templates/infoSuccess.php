<?php echo $c->getDescription() ?>
<div><?php include_component('attachments','attachmentsList',array('bind_type'=>'projectsComments','bind_id'=>$c->getId())) ?></div>
<div><?php include_component('projectsComments','info',array('c'=>$c)) ?></div>