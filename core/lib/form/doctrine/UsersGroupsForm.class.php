<?php

/**
 * UsersGroups form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UsersGroupsForm extends BaseUsersGroupsForm
{
  public function configure()
  {  
    $basic_access_choices = array(''       => t::__('None'),
                          'full_access'    => t::__('Full Access'),
                          'manage_own_lnly'=> t::__('Manage Own Only'),
                          'view_only'      => t::__('View Only'),
                          'view_own_only'  => t::__('View Own Only'),
                          'custom'         => t::__('Custom Access'),                          
                          );
                                                                                             
    $default_choices = array(''              => t::__('None'),
                             'view_only'     => t::__('View Only'),                                   
                             'full_access'   => t::__('Full Access'),
                             ); 
                             
    $custome_access_choices = array('view_own_only' => t::__('View Own Only'),
                                    'create'        => t::__('Create'),                                   
                                    'edit'          => t::__('Edit'),
                                    'delete'        => t::__('Delete'),
                                   );
                                   
    $comments_access_choices = array(''               => t::__('None'),
                                    'full_access'     => t::__('Full Access'),                                    
                                    'manage_own_lnly' => t::__('Manage Own Only'),
                                    'insert_only'     => t::__('Insert and View Only'),
                                    'view_only'       => t::__('View Only'),                                                                                                                                                                
                                    );
                                                          
                                   
    $project_access_choices = $basic_access_choices;
    $project_custome_access_choices = $custome_access_choices;
     
    unset($project_access_choices['']);
        
    if($this->getOption('group_type')=='project_role')
    {      
      unset($project_access_choices['manage_own_lnly']);
      unset($project_access_choices['view_own_only']);
      
      unset($project_custome_access_choices['view_own_only']);
      unset($project_custome_access_choices['create']);
    }     
         
    unset($this->widgetSchema['extra_fields']);                       
    unset($this->validatorSchema['extra_fields']);
                                                                                                                                         
    $this->widgetSchema['allow_manage_projects'] = new sfWidgetFormChoice(array('choices' => $project_access_choices),array('onChange'=>'check_users_groups_items_access()','class'=>'form-control input-medium'));
    $this->widgetSchema['allow_manage_tasks'] =  new sfWidgetFormChoice(array('choices' => $basic_access_choices),array('onChange'=>'check_users_groups_items_access()','class'=>'form-control input-medium'));
    $this->widgetSchema['allow_manage_tickets'] =  new sfWidgetFormChoice(array('choices' => $basic_access_choices),array('onChange'=>'check_users_groups_items_access()','class'=>'form-control input-medium'));
    $this->widgetSchema['allow_manage_discussions'] =  new sfWidgetFormChoice(array('choices' => $basic_access_choices),array('onChange'=>'check_users_groups_items_access()','class'=>'form-control input-medium'));    
    $this->widgetSchema['allow_manage_users'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->widgetSchema['allow_manage_configuration'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));    
    $this->widgetSchema['allow_manage_public_scheduler'] = new sfWidgetFormChoice(array('choices' => $default_choices));
    $this->widgetSchema['allow_manage_personal_scheduler'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->widgetSchema['allow_manage_patterns'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->widgetSchema['allow_manage_contacts'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    
    $this->widgetSchema['allow_manage_public_wiki'] = new sfWidgetFormChoice(array('choices' => $default_choices));
    $this->widgetSchema['allow_manage_projects_wiki'] = new sfWidgetFormChoice(array('choices' => $default_choices));
    
    $this->widgetSchema['projects_custom_access'] = new sfWidgetFormChoice(array('choices' => $project_custome_access_choices, 'multiple'=>true, 'expanded'=>true));
    $this->widgetSchema['tasks_custom_access'] = new sfWidgetFormChoice(array('choices' => $custome_access_choices, 'multiple'=>true, 'expanded'=>true));
    $this->widgetSchema['tickets_custom_access'] = new sfWidgetFormChoice(array('choices' => $custome_access_choices, 'multiple'=>true, 'expanded'=>true));
    $this->widgetSchema['discussions_custom_access'] = new sfWidgetFormChoice(array('choices' => $custome_access_choices, 'multiple'=>true, 'expanded'=>true));
  
  
    $this->widgetSchema['default_value'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('default_value', 0);
    
    $this->widgetSchema['ldap_default'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));
    $this->setDefault('ldap_default', 0);
    
    $this->widgetSchema['projects_comments_access'] = new sfWidgetFormChoice(array('choices' => $comments_access_choices),array('class'=>'form-control input-medium'));    
    $this->widgetSchema['tasks_comments_access'] = new sfWidgetFormChoice(array('choices' => $comments_access_choices),array('class'=>'form-control input-medium'));    
    $this->widgetSchema['tickets_comments_access'] = new sfWidgetFormChoice(array('choices' => $comments_access_choices),array('class'=>'form-control input-medium'));    
    $this->widgetSchema['discussions_comments_access'] = new sfWidgetFormChoice(array('choices' => $comments_access_choices),array('class'=>'form-control input-medium'));
         
    $this->widgetSchema['group_type'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['name']->setAttribute('class','form-control input-medium required');
    
    $this->widgetSchema->setLabels(array('allow_manage_projects'  => 'Projects',
                                         'allow_manage_tasks'  => 'Tasks',
                                         'allow_manage_tickets'  => 'Tickets',
                                         'allow_manage_discussions'  => 'Discussions',
                                         'projects_comments_access'=>'Comments',
                                         'tasks_comments_access'=>'Comments',
                                         'tickets_comments_access'=>'Comments',
                                         'discussions_comments_access'=>'Comments',
                                         'projects_custom_access'=>'Custom Access',
                                         'tasks_custom_access'=>'Custom Access',
                                         'tickets_custom_access'=>'Custom Access',
                                         'discussions_custom_access'=>'Custom Access',
                                         'allow_manage_configuration'  => 'Configuration',
                                         'allow_manage_users'  => 'Users',
                                         'allow_manage_patterns'  => 'Patterns',
                                         'allow_manage_contacts'  => 'Contacts',
                                         'allow_manage_public_wiki' => 'Public Wiki',
                                         'allow_manage_projects_wiki' => 'Projects Wiki',                                         
                                         'allow_manage_public_scheduler' => 'Public Scheduler',
                                         'allow_manage_personal_scheduler' => 'Personal Scheduler',                                         
                                         'ldap_default'=>'LDAP Default?',
                                         'default_value'=>'Default?',
                                         ));
  }
}
