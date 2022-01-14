<?php

/**
 * attachments actions.
 *
 * @package    sf_sandbox
 * @subpackage attachments
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class attachmentsActions extends sfActions
{
  public function executeUpload(sfWebRequest $request)
  {            
    $file = $request->getFiles();
    $filename = mt_rand(111111,999999)  . '-' . $file['Filedata']['name'];
    if(move_uploaded_file($file['Filedata']['tmp_name'], sfConfig::get('sf_upload_dir') . '/attachments/'  . $filename))
    {                
      $a = new Attachments();
      $a->setFile($filename);    
      $a->setBindType($request->getParameter('bind_type'));            
      $a->setBindId($request->getParameter('bind_id'));
      $a->setDateAdded(time());
      $a->setUsersId($this->getUser()->getAttribute('id'));
      $a->save();    
    }
                
    exit();
  }
  
  public function executePreview(sfWebRequest $request)
  {
     $q = Doctrine_Core::getTable('Attachments')
                  ->createQuery()                  
                  ->addWhere('bind_type=?',$request->getParameter('bind_type'))
                  ->orderBy('id');
                  
    if($request->getParameter('bind_id')>0)
     {
       $q->addWhere("bind_id='" . $request->getParameter('bind_id') . "' or (bind_id=0 and users_id='" . $this->getUser()->getAttribute('id') . "')");
     }
     else
     {
       $q->addWhere("bind_id=0 and users_id='" . $this->getUser()->getAttribute('id') . "'");
     }              
                                                          
    $this->attachments = $q->execute();        
  }
  
  public function executeSaveInfo(sfWebRequest $request)
  {
    if($request->hasParameter('attachments_info'))
    {   
      foreach($request->getParameter('attachments_info') as $id=>$v)
      {    
        if($a = Doctrine_Core::getTable('Attachments')->find($id))
        {            
          $a->setInfo($v);          
          $a->save();
        }      
      }
    } 
      
    exit();
  }
  
  public function executeDownload(sfWebRequest $request)
  {
    $attachments_id =  base64_decode($request->getParameter('id'));
    
    $this->forward404Unless($attachments = Doctrine_Core::getTable('Attachments')->find($attachments_id), sprintf('Attachments does not exist.'));
    
    $file_path = sfConfig::get('sf_upload_dir') . '/attachments/' . $attachments->getFile();
                    
    if(is_file($file_path))
    {
      header("Expires: Mon, 26 Nov 1962 00:00:00 GMT");
      header("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
      header("Cache-Control: no-cache, must-revalidate");
      header("Pragma: no-cache");
      header("Content-Type: Application/octet-stream");
      header("Content-disposition: attachment; filename=" . substr(str_replace(array(' ',','),'_',$attachments->getFile()),7));
  
      readfile($file_path);
    }
    else
    {
      echo 'File "' . $attachments->getFile() . '" not found';
    }
  
    exit();
  }
  
  public function executeView(sfWebRequest $request)
  {
    $attachments_id =  base64_decode($request->getParameter('id'));
    
    $this->forward404Unless($attachments = Doctrine_Core::getTable('Attachments')->find($attachments_id), sprintf('Attachments does not exist.'));
    
    $file_path = sfConfig::get('sf_upload_dir') . '/attachments/' . $attachments->getFile();
    
    if(!is_file($file_path))
    {
      echo 'File "' . $attachments->getFile() . '" not found';
    }
    
    if($size = getimagesize($file_path))
    {
      $filename = substr(str_replace(array(' ',','),'_',$attachments->getFile()),7);
      
      header('Content-Disposition: filename="' . $filename . '"');                          
      header("Content-type: {$size['mime']}");                  
      ob_clean();
      flush();
          
      readfile($file_path);
    }
    else
    {
       $this->redirect('attachments/download?id=' . urlencode(base64_encode($attachments->getId())));
    }
  
    exit();
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $attachments_id =  base64_decode($request->getParameter('id'));
    
    if($a = Doctrine_Core::getTable('Attachments')->find($attachments_id))
    {
      if(is_file($file_path = sfConfig::get('sf_upload_dir') . '/attachments/' . $a->getFile()))
      {
        unlink($file_path);
      }
      
      $a->delete();
    }
    
    exit();
  }
}
