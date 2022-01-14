<?php

require('core/lib/PhpSpreadsheet-master/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * tools actions.
 *
 * @package    sf_sandbox
 * @subpackage tools
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class toolsActions extends sfActions
{

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeTrashEmpty(sfWebRequest $request)
    {
        app::EmptyTrash();

        $this->redirect('tools/trash');
    }

    public function executeTrashRestore(sfWebRequest $request)
    {
        if ($request->hasParameter('selected_items'))
        {
            foreach (explode(',', $request->getParameter('selected_items')) as $item)
            {
                $item = explode('_', $item);

                $o = Doctrine_Core::getTable($item[0])->createQuery()->addWhere('id=?', $item[1])->fetchOne();
                $o->setInTrash(null);
                $o->setInTrashDate(null);
                $o->save();
            }

            $this->getUser()->setFlash('userNotices', t::__('Items restored'));
            $this->redirect('tools/trash');
        }
    }

    public function executeTrash(sfWebRequest $request)
    {
        app::setPageTitle('Trash', $this->getResponse());

        $this->trash = array();

        foreach (array('Projects', 'Tasks', 'Tickets', 'Discussions') as $t)
        {
            foreach (Doctrine_Core::getTable($t)->createQuery()->addWhere('in_trash=?', 1)->fetchArray() as $item)
            {
                if (isset($this->trash[$item['in_trash_date']]))
                {
                    while (isset($this->trash[$item['in_trash_date']]))
                    {
                        $item['in_trash_date']++;
                    }
                }
                $this->trash[$item['in_trash_date']] = array('id' => $item['id'], 'name' => $item['name'], 'description' => app::truncate_text(strip_tags($item['description']), 150), 'type' => $t, 'date' => $item['in_trash_date']);
            }
        }

        foreach (array('ProjectsComments', 'TasksComments', 'TicketsComments', 'DiscussionsComments') as $t)
        {
            foreach (Doctrine_Core::getTable($t)->createQuery('t')->leftJoin('t.' . (str_replace('Comments', '', $t)) . ' tt')->addWhere('t.in_trash=?', 1)->fetchArray() as $item)
            {
                if (isset($this->trash[$item['in_trash_date']]))
                {
                    while (isset($this->trash[$item['in_trash_date']]))
                    {
                        $item['in_trash_date']++;
                    }
                }
                $this->trash[$item['in_trash_date']] = array('id' => $item['id'], 'name' => $item[str_replace('Comments', '', $t)]['name'], 'description' => app::truncate_text(strip_tags($item['description']), 150), 'type' => $t, 'date' => $item['in_trash_date']);
            }
        }

        krsort($this->trash);
    }

    public function executeDoBackup(sfWebRequest $request)
    {
        app::backup();

        $this->getUser()->setFlash('userNotices', t::__('Database saved.'));

        $this->redirect('tools/backup');
    }

    private function fp_read_str($fp)
    {
        $string = '';
        $this->file_cache = ltrim($this->file_cache);
        $pos = strpos($this->file_cache, "\n", 0);
        if ($pos < 1)
        {
            while (!$string && ($str = fread($fp, 4096)))
            {
                $pos = strpos($str, "\n", 0);
                if ($pos === false)
                {
                    $this->file_cache .= $str;
                }
                else
                {
                    $string = $this->file_cache . substr($str, 0, $pos);
                    $this->file_cache = substr($str, $pos + 1);
                }
            }

            if (!$str)
            {
                if ($this->file_cache)
                {
                    $string = $this->file_cache;
                    $this->file_cache = '';

                    return trim($string);
                }

                return false;
            }
        }
        else
        {
            $string = substr($this->file_cache, 0, $pos);
            $this->file_cache = substr($this->file_cache, $pos + 1);
        }

        return trim($string);
    }

    public function executeDoRestore(sfWebRequest $request)
    {
        if (strlen($restore_file = $request->getParameter('restore_file')) > 0)
        {
            if (is_file($restore_file_path = sfConfig::get('sf_web_dir') . '/backups/' . $restore_file))
            {
                set_time_limit(0);

                $connection = Doctrine_Manager::connection();

                $fp = fopen($restore_file_path, 'r');

                $this->file_cache = $sql = $table = $insert = '';
                $query_len = 0;
                $execute = 0;

                while (($str = $this->fp_read_str($fp)) !== false)
                {
                    if (empty($str) || preg_match("/^(#|--)/", $str))
                    {
                        continue;
                    }

                    $query_len += strlen($str);

                    //echo $str  . '<hr>';

                    if (!$insert && preg_match("/INSERT IGNORE INTO ([^`]*?) VALUES([^`]*?)/i", $str, $m))
                    {
                        if ($table != $m[1])
                        {
                            $table = $m[1];
                        }

                        $insert = $m[0] . ' ';

                        $sql .= '';
                    }
                    else
                    {
                        $sql .= $str;
                    }

                    if (!$insert && preg_match("/CREATE TABLE IF NOT EXISTS `([^`]*?)`/i", $str, $m) && $table != $m[1])
                    {
                        $table = $m[1];
                        $insert = '';
                    }

                    if ($sql)
                    {
                        if (preg_match("/;$/", $str))
                        {
                            $sql = rtrim($insert . $sql, ";");

                            $insert = '';
                            $execute = 1;
                        }

                        if ($query_len >= 65536 && preg_match("/,$/", $str))
                        {
                            $sql = rtrim($insert . $sql, ",");
                            $execute = 1;
                        }

                        if ($execute)
                        {
                            $statement = $connection->execute($sql);
                            //$statement->execute();
                            //echo '<nobr>' . htmlspecialchars($sql) . '</nobr><hr>';

                            $sql = '';
                            $query_len = 0;
                            $execute = 0;
                        }
                    }
                }
            }
        }

        $this->getUser()->setFlash('userNotices', t::__('Database restored.'));

        $this->redirect('tools/backup');
    }

    public function executeBackup(sfWebRequest $request)
    {
        if (strlen($delete_file = $request->getParameter('delete_file')) > 0)
        {
            if (unlink(sfConfig::get('sf_web_dir') . '/backups/' . $delete_file))
            {
                $this->getUser()->setFlash('userNotices', t::__('Success: Backup removed.'));
            }
            else
            {
                $this->getUser()->setFlash('userNotices', t::__('Error: Backup not removed.'));
            }

            $this->redirect('tools/backup');
        }

        if (strlen($download_file = $request->getParameter('download_file')) > 0)
        {
            if (is_file($file_path = sfConfig::get('sf_web_dir') . '/backups/' . $download_file))
            {
                header("Expires: Mon, 26 Nov 1962 00:00:00 GMT");
                header("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-Type: Application/octet-stream");
                header("Content-disposition: attachment; filename=" . str_replace(' ', '_', $download_file));

                readfile($file_path);
            }
            else
            {
                echo 'File "' . $download_file . '" not found';
            }

            exit();
        }

        $dir = dir(sfConfig::get('sf_web_dir') . '/backups/');
        $this->backups = array();
        while ($file = $dir->read())
        {
            if (!is_dir(sfConfig::get('sf_web_dir') . '/backups/' . $file) && in_array(substr($file, -3), array('zip', 'sql', '.gz')))
            {

                if ($ft = filemtime(sfConfig::get('sf_web_dir') . '/backups/' . $file))
                {
                    $this->backups[$ft] = $file;
                }
                else
                {
                    $this->backups[] = $file;
                }
            }
        }

        if (isset($this->backups[0]))
        {
            rsort($this->backups);
        }
        else
        {
            krsort($this->backups);
        }

        app::setPageTitle('Backups', $this->getResponse());
    }

    public function executeXlsTasksImport(sfWebRequest $request)
    {
        app::setPageTitle('Import Spreadsheet', $this->getResponse());

        if ($request->isMethod(sfRequest::PUT))
        {
            if ($request->hasParameter('import_file'))
            {
                if (is_file($import_spreadsheet_file = sfConfig::get('sf_upload_dir') . '/' . $request->getParameter('import_file')))
                {
                    $import_fields = $this->getUser()->getAttribute('import_fields');

                    //$data = new Spreadsheet_Excel_Reader($import_spreadsheet_file);

                    $worksheet = array();

                    $objPHPExcel =  IOFactory::load($import_spreadsheet_file);

                    $objWorksheet = $objPHPExcel->getActiveSheet();

                    $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
                    $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

                    $projects_id = $request->getParameter('projects_id');

                    $import_first_row = false;
                    if ($request->getParameter('import_first_row') == 1)
                    {
                        $import_first_row = true;
                    }

                    $level = 0;
                    $parents = array();
                    $sort_order = 0;


                    for ($row = 1; $row <= $highestRow; ++$row)
                    {
                        $is_empty_row = true;
                        $worksheet_cols = array();

                        for ($col = 1; $col <= $highestColumnIndex; ++$col)
                        {
                            $value = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
                            $worksheet_cols[$col] = $value;

                            if (strlen($value) > 0)
                                $is_empty_row = false;
                        }

                        if (!$is_empty_row)
                        {
                            $worksheet[] = $worksheet_cols;
                        }
                    }

                    //echo '<pre>';
                    //print_r($worksheet);
                    //echo '</pre>';
                    //exit();
                    //for($i=$first_row;$i<=$highestRow;$i++)
                    foreach ($worksheet as $row => $data)
                    {
                        if (!$import_first_row and $row == 0)
                            continue;

                        $t = new Tasks();
                        $t->setCreatedBy($this->getUser()->getAttribute('id'))
                                ->setCreatedAt(date('Y-m-d H:i:s'))
                                ->setProjectsId($request->getParameter('projects_id'))
                                ->setSortOrder($sort_order);

                        $extra_fields = array();

                        //for($j=0;$j<$highestColumnIndex;$j++)
                        foreach ($data as $j => $v)
                        {
                            if (isset($import_fields[$j]))
                            {
                                //$v = $data->val($i,$j);
                                //$v = trim($objWorksheet->getCellByColumnAndRow($j, $i)->getValue());

                                if (strlen(trim($v)) == 0)
                                    continue;

                                switch ($import_fields[$j])
                                {
                                    case 'OutlineLevel':
                                        $level = $v;

                                        if ($level > 1 and isset($parents[$level - 1]))
                                        {
                                            $t->setParentId($parents[$level - 1]);
                                        }
                                        break;
                                    case 'TasksGroups':
                                        if ($id = app::getProjectCfgItemIdByName($v, 'TasksGroups', $projects_id))
                                        {
                                            $t->setTasksGroupsId($id);
                                        }
                                        else
                                        {
                                            $cfg = new TasksGroups();
                                            $cfg->setName($v);
                                            $cfg->setProjectsId($projects_id);

                                            $cfg->save();

                                            $t->setTasksGroupsId($cfg->getId());
                                        }
                                        break;
                                    case 'Versions':
                                        if ($id = app::getProjectCfgItemIdByName($v, 'Versions', $projects_id))
                                        {
                                            $t->setVersionsId($id);
                                        }
                                        else
                                        {
                                            $cfg = new Versions();
                                            $cfg->setName($v);
                                            $cfg->setProjectsId($projects_id);

                                            $cfg->save();

                                            $t->setVersionsId($cfg->getId());
                                        }
                                        break;
                                    case 'ProjectsPhases':
                                        if ($id = app::getProjectCfgItemIdByName($v, 'ProjectsPhases', $projects_id))
                                        {
                                            $t->setProjectsPhasesId($id);
                                        }
                                        else
                                        {
                                            $cfg = new ProjectsPhases();
                                            $cfg->setName($v);
                                            $cfg->setProjectsId($projects_id);

                                            $cfg->save();

                                            $t->setProjectsPhasesId($cfg->getId());
                                        }
                                        break;
                                    case 'TasksPriority':
                                        if ($id = app::getCfgItemIdByName($v, 'TasksPriority'))
                                        {
                                            $t->setTasksPriorityId($id);
                                        }
                                        else
                                        {
                                            $cfg = new TasksPriority();
                                            $cfg->setName($v);
                                            $cfg->save();

                                            $t->setTasksPriorityId($cfg->getId());
                                        }
                                        break;
                                    case 'TasksLabels':
                                        if ($id = app::getCfgItemIdByName($v, 'TasksLabels'))
                                        {
                                            $t->setTasksLabelId($id);
                                        }
                                        else
                                        {
                                            $cfg = new TasksLabels();
                                            $cfg->setName($v);
                                            $cfg->save();

                                            $t->setTasksLabelId($cfg->getId());
                                        }
                                        break;
                                    case 'name':
                                        $t->setName($v);
                                        break;
                                    case 'description':
                                        $t->setDescription($v);
                                        break;
                                    case 'TasksStatus':
                                        if ($id = app::getCfgItemIdByName($v, 'TasksStatus'))
                                        {
                                            $t->setTasksStatusId($id);
                                        }
                                        else
                                        {
                                            $cfg = new TasksStatus();
                                            $cfg->setName($v);
                                            $cfg->save();

                                            $t->setTasksStatusId($cfg->getId());
                                        }
                                        break;
                                    case 'TasksTypes':
                                        if ($id = app::getCfgItemIdByName($v, 'TasksTypes'))
                                        {
                                            $t->setTasksTypeId($id);
                                        }
                                        else
                                        {
                                            $cfg = new TasksTypes();
                                            $cfg->setName($v);
                                            $cfg->save();

                                            $t->setTasksTypeId($cfg->getId());
                                        }
                                        break;
                                        break;
                                    case 'assigned_to':
                                        $assigned_to = array();
                                        foreach (explode(',', $v) as $n)
                                        {
                                            if ($user = Doctrine_Core::getTable('Users')->createQuery()->addWhere('name=?', trim($n))->fetchOne())
                                            {
                                                $assigned_to[] = $user->getId();
                                            }
                                        }

                                        $t->setAssignedTo(implode(',', $assigned_to));
                                        break;
                                    case 'estimated_time':
                                        $t->setEstimatedTime($v);
                                        break;
                                    case 'start_date':
                                        $t->setStartDate(date('Y-m-d', strtotime($v)));
                                        break;
                                    case 'due_date':
                                        $t->setDueDate(date('Y-m-d', strtotime($v)));
                                        break;
                                    case 'progress':
                                        $t->setProgress($v);
                                        break;
                                }


                                if (strstr($import_fields[$j], 'extra_field_'))
                                {
                                    $extra_fields[str_replace('extra_field_', '', $import_fields[$j])] = $v;
                                }
                            }
                        }

                        $t->save();

                        $parents[$level] = $t->getId();
                        $sort_order++;

                        foreach ($extra_fields as $id => $v)
                        {
                            $f = new ExtraFieldsList;
                            $f->setBindId($t->getId());
                            $f->setExtraFieldsId($id);
                            $f->setValue($v);
                            $f->save();
                        }
                    }

                    $this->getUser()->setFlash('userNotices', t::__('Spreadsheet imported'));
                    $this->redirect('tasks/index?projects_id=' . $request->getParameter('projects_id'));
                }
            }
            elseif (($projects_id = $request->getParameter('projects_id')) > 0)
            {
                $f = $request->getFiles();

                if ($f['import_file'] and (substr($f['import_file']['name'],-3)=='xls' or substr($f['import_file']['name'],-4)=='xlsx'))
                {
                    $this->getUser()->setAttribute('import_fields', array());

                    move_uploaded_file($f['import_file']['tmp_name'], sfConfig::get('sf_upload_dir') . '/' . $f['import_file']['name']);

                    $this->import_file = $f['import_file']['name'];

                    if (is_file($import_spreadsheet_file = sfConfig::get('sf_upload_dir') . '/' . $this->import_file))
                    {

                        //$this->data = new Spreadsheet_Excel_Reader($import_spreadsheet_file);

                        $worksheet = array();

                        $objPHPExcel =  IOFactory::load($import_spreadsheet_file);

                        $objWorksheet = $objPHPExcel->getActiveSheet();

                        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
                        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

                        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

                        for ($row = 1; $row <= $highestRow; ++$row)
                        {
                            $is_empty_row = true;
                            $worksheet_cols = array();

                            for ($col = 1; $col <= $highestColumnIndex; ++$col)
                            {
                                $value = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
                                $worksheet_cols[$col] = $value;

                                if (strlen($value) > 0)
                                    $is_empty_row = false;
                            }

                            if (!$is_empty_row)
                            {
                                $worksheet[] = $worksheet_cols;
                            }
                        }

                        $this->data = $worksheet;


                        $this->setTemplate('xlsTasksImportBind');
                    }
                    else
                    {
                        $this->getUser()->setFlash('userNotices', array('type' => 'error', 'text' => t::__('There is an error with uploading file. Please try again with less file size.')));
                        $this->redirect('tools/xlsTasksImport');
                    }
                }
            }
        }
    }

    public function executeXlsTasksImportBindField(sfWebRequest $request)
    {
        $this->columns = array('OutlineLevel' => t::__('Outline Level'),
            'TasksGroups' => t::__('Group'),
            'Versions' => t::__('Version'),
            'ProjectsPhases' => t::__('Phase'),
            'TasksPriority' => t::__('Priority'),
            'TasksLabels' => t::__('Label'),
            'name' => t::__('Name'),
            'description' => t::__('Description'),
            'TasksStatus' => t::__('Status'),
            'TasksTypes' => t::__('Type'),
            'assigned_to' => t::__('Assigned To'),
            'estimated_time' => t::__('Est. Time'),
            'start_date' => t::__('Start Date'),
            'due_date' => t::__('Due Date'),
            'progress' => t::__('Progress'),
        );

        $extra_fields = ExtraFieldsList::getFieldsByType('tasks', $this->getUser(), false, array('all' => true));

        foreach ($extra_fields as $v)
        {
            $this->columns['extra_field_' . $v['id']] = $v['name'];
        }

        $import_fields = $this->getUser()->getAttribute('import_fields');

        foreach ($import_fields as $k => $v)
        {
            unset($this->columns[$v]);
        }


        if ($request->hasParameter('field_id'))
        {
            if ($request->getParameter('field_id') != '0')
            {
                $import_fields = $this->getUser()->getAttribute('import_fields');
                $import_fields[$request->getParameter('col')] = $request->getParameter('field_id');
                $this->getUser()->setAttribute('import_fields', $import_fields);
                echo $this->columns[$request->getParameter('field_id')];
            }
            else
            {
                $import_fields = $this->getUser()->getAttribute('import_fields');
                if (isset($import_fields[$request->getParameter('col')]))
                {
                    unset($import_fields[$request->getParameter('col')]);
                }
                $this->getUser()->setAttribute('import_fields', $import_fields);

                echo '-';
            }

            exit();
        }
    }

    public function executeMsProjectImport(sfWebRequest $request)
    {
        app::setPageTitle('Import Tasks', $this->getResponse());

        if ($request->isMethod(sfRequest::PUT))
        {
            if (($projects_id = $request->getParameter('projects_id')) > 0)
            {
                $f = $request->getFiles();

                if ($f['import_file'])
                {
                    move_uploaded_file($f['import_file']['tmp_name'], sfConfig::get('sf_upload_dir') . '/' . $f['import_file']['name']);

                    @$xml = simplexml_load_file(sfConfig::get('sf_upload_dir') . '/' . $f['import_file']['name']) or die('Error: Failed to parse xml file!');

                    //echo '<pre>';
                    //print_r($xml->Tasks->Task);

                    $status_id = app::getDefaultValueByTable('TasksStatus');
                    $priority_id = app::getDefaultValueByTable('TasksPriority');
                    $types_id = app::getDefaultValueByTable('TasksTypes');
                    $labels_id = app::getDefaultValueByTable('TasksLabels');

                    $level = 0;
                    $parents = array();
                    $sort_order = 0;

                    foreach ($xml->Tasks->Task as $v)
                    {
                        //print_r($v);

                        if (strlen($v->Name) == 0)
                            continue;

                        //getting resource Id
                        $assigned_to = array();
                        $assigned_to_names = array();
                        $resource_ids = array();
                        foreach ($xml->Assignments->Assignment as $a)
                        {

                            if ((int) $a->TaskUID == (int) $v->UID)
                            {
                                if ((int) $a->ResourceUID > 0)
                                {
                                    $resource_ids[] = $a->ResourceUID;
                                }
                            }
                        }

                        foreach ($resource_ids as $rid)
                        {
                            foreach ($xml->Resources->Resource as $r)
                            {
                                if ((int) $r->UID == $rid)
                                {
                                    $assigned_to_names[] = (string) $r->Name;
                                }
                            }
                        }

                        foreach ($assigned_to_names as $n)
                        {
                            if ($user = Doctrine_Core::getTable('Users')->createQuery()->addWhere('name=?', $n)->fetchOne())
                            {
                                $assigned_to[] = $user->getId();
                            }
                        }



                        //print_r($assigned_to);          

                        $level = (int) $v->OutlineLevel;

                        $t = new Tasks();
                        $t->setName($v->Name);
                        $t->setAssignedTo(implode(',', $assigned_to));

                        if ($level > 1)
                        {
                            $t->setParentId($parents[$level - 1]);
                        }

                        if ($status_id)
                            $t->setTasksStatusId($status_id);
                        if ($priority_id)
                            $t->setTasksPriorityId($priority_id);
                        if ($types_id)
                            $t->setTasksTypeId($types_id);
                        if ($labels_id)
                            $t->setTasksLabelId($labels_id);

                        $t->setStartDate(substr($v->Start, 0, 10));
                        $t->setDueDate(substr($v->Finish, 0, 10));
                        $t->setProgress($v->PercentComplete);
                        $t->setEstimatedTime(str_replace(array('PT', 'H0M0S'), '', $v->Work));
                        $t->setProjectsId($projects_id);
                        $t->setSortOrder($sort_order);
                        $t->setCreatedBy($this->getUser()->getAttribute('id'));
                        $t->save();

                        $parents[$level] = $t->getId();
                        $sort_order++;
                    }

                    @unlink(sfConfig::get('sf_upload_dir') . '/' . $f['import_file']['name']);

                    //exit(); 

                    $this->getUser()->setFlash('userNotices', t::__('Tasks Imported'));
                    $this->redirect('tasks/index?projects_id=' . $projects_id);
                }
            }
        }
    }

}
