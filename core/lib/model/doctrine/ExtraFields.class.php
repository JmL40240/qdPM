<?php

/**
 * ExtraFields
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ExtraFields extends BaseExtraFields
{
  public static function getTypesChoices()
  {
    $l = array();
    $l['text'] = t::__('Input Field');
    $l['number'] = t::__('Input Numeric Field');
    $l['url']  = t::__('Input URL Field');    
    $l['formula'] = t::__('Formula');    
    $l['file'] = t::__('File');
    $l['textarea'] = t::__('Textarea');
    $l['textarea_wysiwyg'] = t::__('Textarea with WYSIWYG editor');
    $l['date_dropdown'] = t::__('Date');
    $l['date'] = t::__('Date with calendar picker');    
    $l['date_time'] = t::__('Date with calendar and time picker');
    $l['date_range'] = t::__('Date range with calendar picker');            
    $l['pull_down']  = t::__('Pull Down List');
    $l['checkbox']  = t::__('Checkbox List');
    $l['radiobox']  = t::__('Radiobox List');
    

    return $l;
  }
  
  public static function getTypeNameByKey($k)
  {
    $t = ExtraFields::getTypesChoices();
    
    if(isset($t[$k]))
    {
      return $t[$k]; 
    }
    else
    {
      return '';
    }
  }

  public static function getFieldsByType($type)
  {
    $q = Doctrine_Core::getTable('ExtraFields')->createQuery();
    $q->addWhere('bind_type=?',$type);
    $q->orderBy('sort_order,name');

    $l = array();
    foreach($q->execute() as $v)
    {
      $l[$v->getId()]=$v->getName();
    }
    
    return $l;
  }
  
  public static function getJsListPerGroup($t)
  {
    switch($t)
    {  
      case 'UsersGroups':
        $groups = Doctrine_Core::getTable($t)
          ->createQuery('a')
          ->addWhere('group_type is null or length(group_type)=0')
          ->orderBy('name')
          ->execute();
        break;
      default:
        $groups = Doctrine_Core::getTable($t)
          ->createQuery('a')
          ->orderBy('sort_order, name')
          ->execute();
        break;
    }
    $html = '
      <script>
        var extra_fields_per_group = new Array();';
        
    foreach($groups as $v)
    {
      if(strlen($v->getExtraFields()))
      {
        $html .= '
          extra_fields_per_group[' . $v->getId() . ']="' . addslashes($v->getExtraFields()) . '";';
      }
    }
    
    $html .= '
      </script>';
    
    return $html;
  }
  
}