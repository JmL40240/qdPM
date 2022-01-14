<?php

/**
 * UserReports form base class.
 *
 * @method UserReports getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserReportsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'users_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'name'                  => new sfWidgetFormInputText(),
      'display_on_home'       => new sfWidgetFormInputText(),
      'projects_id'           => new sfWidgetFormTextarea(),
      'projects_type_id'      => new sfWidgetFormTextarea(),
      'projects_status_id'    => new sfWidgetFormTextarea(),
      'assigned_to'           => new sfWidgetFormTextarea(),
      'created_by'            => new sfWidgetFormTextarea(),
      'tasks_status_id'       => new sfWidgetFormTextarea(),
      'tasks_type_id'         => new sfWidgetFormTextarea(),
      'tasks_label_id'        => new sfWidgetFormTextarea(),
      'due_date_from'         => new sfWidgetFormDate(),
      'due_date_to'           => new sfWidgetFormDate(),
      'created_from'          => new sfWidgetFormDate(),
      'created_to'            => new sfWidgetFormDate(),
      'closed_from'           => new sfWidgetFormDate(),
      'closed_to'             => new sfWidgetFormDate(),
      'sort_order'            => new sfWidgetFormInputText(),
      'days_before_due_date'  => new sfWidgetFormInputText(),
      'has_related_ticket'    => new sfWidgetFormInputText(),
      'has_estimated_time'    => new sfWidgetFormInputText(),
      'report_reminder'       => new sfWidgetFormInputText(),
      'display_in_menu'       => new sfWidgetFormInputText(),
      'visible_on_home'       => new sfWidgetFormInputText(),
      'overdue_tasks'         => new sfWidgetFormInputText(),
      'projects_groups_id'    => new sfWidgetFormTextarea(),
      'report_type'           => new sfWidgetFormInputText(),
      'extra_fields'          => new sfWidgetFormTextarea(),
      'listing_order'         => new sfWidgetFormInputText(),
      'is_default'            => new sfWidgetFormInputText(),
      'tasks_priority_id'     => new sfWidgetFormTextarea(),
      'projects_priority_id'  => new sfWidgetFormTextarea(),
      'tasks_groups_id'       => new sfWidgetFormTextarea(),
      'versions_id'           => new sfWidgetFormTextarea(),
      'projects_phases_id'    => new sfWidgetFormTextarea(),
      'users_groups_id'       => new sfWidgetFormTextarea(),
      'display_only_assigned' => new sfWidgetFormInputText(),
      'is_mandatory'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'users_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'display_on_home'       => new sfValidatorInteger(array('required' => false)),
      'projects_id'           => new sfValidatorString(array('required' => false)),
      'projects_type_id'      => new sfValidatorString(array('required' => false)),
      'projects_status_id'    => new sfValidatorString(array('required' => false)),
      'assigned_to'           => new sfValidatorString(array('required' => false)),
      'created_by'            => new sfValidatorString(array('required' => false)),
      'tasks_status_id'       => new sfValidatorString(array('required' => false)),
      'tasks_type_id'         => new sfValidatorString(array('required' => false)),
      'tasks_label_id'        => new sfValidatorString(array('required' => false)),
      'due_date_from'         => new sfValidatorDate(array('required' => false)),
      'due_date_to'           => new sfValidatorDate(array('required' => false)),
      'created_from'          => new sfValidatorDate(array('required' => false)),
      'created_to'            => new sfValidatorDate(array('required' => false)),
      'closed_from'           => new sfValidatorDate(array('required' => false)),
      'closed_to'             => new sfValidatorDate(array('required' => false)),
      'sort_order'            => new sfValidatorInteger(array('required' => false)),
      'days_before_due_date'  => new sfValidatorInteger(array('required' => false)),
      'has_related_ticket'    => new sfValidatorInteger(array('required' => false)),
      'has_estimated_time'    => new sfValidatorInteger(array('required' => false)),
      'report_reminder'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'display_in_menu'       => new sfValidatorInteger(array('required' => false)),
      'visible_on_home'       => new sfValidatorInteger(array('required' => false)),
      'overdue_tasks'         => new sfValidatorInteger(array('required' => false)),
      'projects_groups_id'    => new sfValidatorString(array('required' => false)),
      'report_type'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'extra_fields'          => new sfValidatorString(array('required' => false)),
      'listing_order'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'is_default'            => new sfValidatorInteger(array('required' => false)),
      'tasks_priority_id'     => new sfValidatorString(array('required' => false)),
      'projects_priority_id'  => new sfValidatorString(array('required' => false)),
      'tasks_groups_id'       => new sfValidatorString(array('required' => false)),
      'versions_id'           => new sfValidatorString(array('required' => false)),
      'projects_phases_id'    => new sfValidatorString(array('required' => false)),
      'users_groups_id'       => new sfValidatorString(array('required' => false)),
      'display_only_assigned' => new sfValidatorInteger(array('required' => false)),
      'is_mandatory'          => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_reports[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserReports';
  }

}
