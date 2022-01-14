<?php

/**
 * login actions.
 *
 * @package    sf_sandbox
 * @subpackage login
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class loginActions extends sfActions
{
  public function executeKeepSession()
  {
    exit();
  }
  
  public function executeLogoff()
  {
    $this->getResponse()->setCookie('stay_logged','',time() - 3600,'/');    
    $this->getResponse()->setCookie('remember_pass','',time() - 3600,'/');
  
    $this->getUser()->setAuthenticated(false);
    $this->getUser()->getAttributeHolder()->clear();
    $this->getUser()->clearCredentials();
                            
    $this->redirect('login/index');
  }
  
  public function doUserLogin($user, $request)
  {
    $this->getUser()->setAttribute('id', $user->getId());    
    $this->getUser()->setAttribute('users_group_id', $user->getUsersGroupId());    
    $this->getUser()->setAttribute('user', $user);
    
    $this->getUser()->setAuthenticated(true);
    
    Attachments::clearTmpUploadedFiles($this->getUser());
    
    $this->getUser()->setCulture($user->getCulture());
    
    if(strlen($user->getSkin())>0)
    {
      $this->getResponse()->setCookie('skin', $user->getSkin(), time()+31536000,'','');
    }
    
    $ug = $user->getUsersGroups();
    
    if(strlen($ug->getAllowManageReports())>0)
    {            
      foreach(explode(',',$ug->getAllowManageReports()) as $v)
      {
        $this->getUser()->addCredentials('reports_access_' . $v);
      }                        
    }
    
    if(strlen($ug->getAllowManagePublicWiki())>0){ $this->getUser()->addCredentials('public_wiki_access_' . $ug->getAllowManagePublicWiki()); }    
    if(strlen($ug->getAllowManageProjectsWiki())>0){$this->getUser()->addCredentials('projects_wiki_access_' . $ug->getAllowManageProjectsWiki());}
    
    if(strlen($ug->getAllowManagePublicScheduler())>0){$this->getUser()->addCredential('public_scheduler_access_' . $ug->getAllowManagePublicScheduler());}    
    if($ug->getAllowManagePersonalScheduler()==1){$this->getUser()->addCredential('allow_manage_personal_scheduler');}
        
    if($ug->getAllowManagePatterns()==1){$this->getUser()->addCredential('allow_manage_patterns');}    
    if($ug->getAllowManageContacts()==1){$this->getUser()->addCredential('allow_manage_contacts');}    
    if($ug->getAllowManageUsers()==1){$this->getUser()->addCredential('allow_manage_users');}    
    if($ug->getAllowManageConfiguration()==1){$this->getUser()->addCredential('allow_manage_configuration');}
                                                                                                  
    if(strlen($request->getParameter('http_referer'))>0)
    {
      $this->redirect($request->getParameter('http_referer'));
    }
    elseif(strlen($user->getDefaultHomePage())>0)
    {     
      switch(true)
      {
        case $user->getDefaultHomePage()=='projects': 
            $this->redirect('projects/index');
          break;
        case $user->getDefaultHomePage()=='tasks' and Users::hasAccess('view','tasks',$this->getUser()): 
            $this->redirect('tasks/index');
          break;
        case $user->getDefaultHomePage()=='tickets' and Users::hasAccess('view','tickets',$this->getUser()): 
            $this->redirect('tickets/index');
          break;
        case $user->getDefaultHomePage()=='discussions' and Users::hasAccess('view','discussions',$this->getUser()): 
            $this->redirect('discussions/index');
          break;
        case $user->getDefaultHomePage()=='public_scheduler' and ($this->getUser()->hasCredential('public_scheduler_access_full_access') or $this->getUser()->hasCredential('public_scheduler_access_view_only')): 
            $this->redirect('scheduler/index');
          break;
        case $user->getDefaultHomePage()=='scheduler' and $this->getUser()->hasCredential('allow_manage_personal_scheduler'): 
            $this->redirect('scheduler/personal');
          break;
        default:
          $this->redirect('dashboard/index');
         break;          
      }            
    }
    else
    {
      $this->redirect('dashboard/index');
    }                
  }
  
  public function executeRestorePassword(sfWebRequest $request)
  {
    $this->form = new RestorePasswordForm();
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {                
        $user = Doctrine_Core::getTable('Users')->createQuery()->addWhere('email=?',$this->form['email']->getValue())->addWhere('active=1')->fetchOne();
        if($user)
        {
          $newRandomPassword = Users::getRandomPassword();

          $user->setPassword(md5($newRandomPassword));
          $user->save();                    
                                                      
          $body = t::__('You are receiving this notification because you have requested a new password be sent for your account on') . ' ' . sfConfig::get('app_app_name') . '<br><br>' . t::__('Password') . ': ' . $newRandomPassword;          
                              
          $from = array(sfConfig::get('app_administrator_email')=>sfConfig::get('app_app_name'));
          $to = array($user->getEmail()=>$user->getName());
          $subject = t::__('New Password on') . ' ' . sfConfig::get('app_app_name');
          
          Users::sendEmail($from, $to, $subject, $body, $this->getUser());
                              
          $this->getUser()->setFlash('userNotices', t::__('A new password has been sent to your e-mail address'));

          $this->redirect('login/index');
        }
        else
        {
          $this->getUser()->setFlash('userNotices', array('text'=>t::__('No match for Email and/or Password'),'type'=>'error'));
          $this->redirect('login/index');
        }
      }
    }
    
    app::setPageTitle('Restore Password',$this->getResponse());
    
    $this->setLayout('loginLayout');
  }
  
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {      
    
    //check license key       
    $domain_name = $_SERVER['HTTP_HOST'];
    $domain_name = str_replace('www.','',$domain_name);
    $product_key = '';
    for($i = 0; $i<strlen($domain_name); $i++)
    {
      $product_key .= ord($domain_name[$i])*(strlen($domain_name)+ord($domain_name[0]));
    } 
                                               
    $key_file_path = sfConfig::get('sf_app_config_dir') . base64_decode('L3Byb2R1Y3Rfa2V5LnR4dA=='); 
                                         
    if(!is_file($key_file_path))
    { 
      die('Error: product key not found.');      
    }
    else
    {
      $key = file($key_file_path);
      /*if(trim($key[0])!=$product_key)
      {                        
        die('Error: product key is not correct for domain <b>' . $domain_name . '</b>');                       
      }*/
    }                
                             
  
    $this->form = new LoginForm();
    
    if ($request->isMethod('post'))
    {          
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {         
        $hasher = new PasswordHash(11, false);
        $password = $this->form['password']->getValue();
                                                 
        if($this->form['email']->getValue()==sfConfig::get('app_administrator_email') && $hasher->CheckPassword($password, sfConfig::get('app_administrator_password')))
        {
          $this->getUser()->setAttribute('id', 0);
          $this->getUser()->setAttribute('users_group_id', 0);
          $this->getUser()->setAuthenticated(true);
          $this->getUser()->addCredentials('allow_manage_users', 'allow_manage_configuration');          
          $this->redirect('users/index');
        }
        else
        {
          $user = Doctrine_Core::getTable('Users')
                ->createQuery('u')->leftJoin('u.UsersGroups')
                ->addWhere('active=?',1)
                ->addWhere('email=?',$this->form['email']->getValue())
                ->fetchOne();
                //->addWhere('password=?',md5($this->form['password']->getValue()));
                  
           $error = false;                     
                              
          if($user)
          {
             if(strlen($user->getPassword())==32 )
             {                                             
               if($user->getPassword()!=md5($password))
               {
                $error = true;
               }               
             }
             elseif(!$hasher->CheckPassword($password, $user->getPassword()))
             {
               $error = true;
             }
          }
          else
          {
            $error = true;
          }     
                  
          if(!$error)          
          {
            if($request->getParameter('remember_me')==1)
            {
              $this->getResponse()->setCookie('remember_me', 1, time()+60*60*24*100,'/');
              $this->getResponse()->setCookie('stay_logged', 1, time()+60*60*24*100,'/');
              $this->getResponse()->setCookie('remember_user',  base64_encode($this->form['email']->getValue()), time()+60*60*24*100,'/');
              $this->getResponse()->setCookie('remember_pass', base64_encode(md5($this->form['password']->getValue())), time()+60*60*24*100,'/');          
            }
            else
            {
              $this->getResponse()->setCookie('remember_me','',time() - 3600,'/');
              $this->getResponse()->setCookie('stay_logged','',time() - 3600,'/');
              $this->getResponse()->setCookie('remember_user','',time() - 3600,'/');
              $this->getResponse()->setCookie('remember_pass','',time() - 3600,'/'); 
            } 
        
            $this->doUserLogin($user,$request);          
          }
          else
          {
            $this->getUser()->setFlash('userNotices', array('text'=>t::__('No match for Email and/or Password'),'type'=>'error'));
            $this->redirect('login/index');
          }
        }
      }
    }
    elseif($request->getCookie('stay_logged')==1 and $request->getCookie('remember_me')==1)
    {      
      $q = Doctrine_Core::getTable('Users')
            ->createQuery('u')->leftJoin('u.UsersGroups')
            ->addWhere('active=?',1)
            ->addWhere('email=?',base64_decode($request->getCookie('remember_user')))
            ->addWhere('password=?',base64_decode($request->getCookie('remember_pass')));
              
      if($user = $q->fetchOne())
      {      
      
        if(isset($_SERVER['REQUEST_URI']))
        {
          if(!stristr($_SERVER['REQUEST_URI'],'/login') and !stristr($_SERVER['REQUEST_URI'],'/create') and !stristr($_SERVER['REQUEST_URI'],'/edit') and !stristr($_SERVER['REQUEST_URI'],'/update') and !stristr($_SERVER['REQUEST_URI'],'/new'))
          {
            if(isset($_SERVER['HTTPS']))
            {
              $http_referer = ($_SERVER['HTTPS']=='on' ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            }
            else
            {
              $http_referer = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            }
            
            $request->setParameter('http_referer',$http_referer);
          }
        }      
        $this->doUserLogin($user,$request);          
      }
    }        

    app::setPageTitle('Login',$this->getResponse());
    
    $this->setLayout('loginLayout');
  }  
  
  public function executeLdap(sfWebRequest $request)
  {
    $this->form = new LdapLoginForm();
    
    if ($request->isMethod('post'))
    { 
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
      
         $ldap = new ldapLogin();
         $user_attr = $ldap->doLdapLogin($this->form['user']->getValue(), $this->form['password']->getValue());
          
          if($user_attr['status']==true)
          {  
            $userName = $this->form['user']->getValue();                    
            $userEmail = $this->form['user']->getValue() . '@localhost.com';
            
            if(strlen($user_attr['email'])>0)
            {
              $userEmail = $user_attr['email']; 
            }
            
            if(strlen($user_attr['name'])>0)
            {
              $userName = $user_attr['name']; 
            }
            

            $q = Doctrine_Core::getTable('Users')->createQuery()->addWhere('email=?',$userEmail);
            
            if(!$user = $q->fetchOne())
            {
              $user = new Users();
              $user->setUsersGroupId(UsersGroups::getLdapDafaultGroupId());
              $user->setName($userName);
              $user->setEmail($userEmail);
              $user->setPassword(md5($this->form['password']->getValue()));
              $user->setActive(1);
              $user->setCulture(sfConfig::get('sf_default_culture'));            
              $user->save();          
            }
            else
            {
              if($user->getActive()!=1)
              {
                $this->getUser()->setFlash('userNotices', I18NText::__('Your account is not active'));
                $this->redirect('login/ldap');
              }
            }
                      
             $this->doUserLogin($user,$request);                         
          }
          else
          {
            
            $this->getUser()->setFlash('userNotices', t::__($user_attr['msg']));
            $this->redirect('login/ldap');
          }
   
      }
    }
    
    app::setPageTitle('LDAP Login',$this->getResponse());
    
    $this->setLayout('loginLayout');
          
  }
}
