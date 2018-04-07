<?php
namespace Kanboard\Plugin\DemoData\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\UserModel;

/**
 * Calendar Controller
 *
 * @package  Kanboard\Plugin\DemoData
 * @author   Bruno Deshayes
 */
class DemoData extends BaseController {

	private function doImport($data, $table) 
	{ 
	$count=0;
	if (($table === 'users') /*or ($table === 'projects')*/)
			$retval = $this->db->execute("delete from $table where id > 1");
	else
			$retval = $this->db->execute("delete from $table");
		
	foreach ($data as $myuser)
		{
		$sql = "insert into $table (";
		$i=0;
		foreach (array_keys($myuser) as $mykey)
			{
			if ($i != 0)
				$sql .= ', ';
			$sql .= "'$mykey'";
			$i++;
			}
		$sql .= ") values (";
		$i=0;
		foreach (array_values($myuser) as $myvalue)
			{
			if ($i != 0)
				$sql .= ', ';
			
			if (is_numeric($myvalue))
				$sql .= $myvalue;
			else
				$sql .= "'$myvalue'";
			$i++;
			}
		$sql .= ");";
		
		$this->db->startTransaction();
		$retval = $this->db->execute($sql);
		$this->db->closeTransaction();
		if ($retval == true)
			$count++;
		}

	return "<br />$count $table ";
	}
		
	private function RandomText ()
	{
	$blurb = array(
	'Tripanodon', 
	'Bamboula', 
	"tartuffe", 
	'Dingo', 
	'Bison Futé', 
	'Gros malin', 
	"The quick brown fox jumps over the lazy dog."	
	);
	return array_rand(array_flip($blurb), 1); 
	}
		
	private function RandomColor ()
	{
	$blurb = array(
	'blue', 
	'yellow', 
	"grey", 
	'orange', 
	'cyan', 
	'green', 
	"pink", 
	'lime'	
	);
	return array_rand(array_flip($blurb), 1); 
	}

	private function RandomString()
	{ 
	$blurb = array(
	'Ambition',
	'Cogitation', 
	'Compilation', 	
	'Customisation', 
	'Degustation',
	'Delegation', 
	'Evaluation', 
	'Expectation', 
	'Imagination', 
	'Investigation', 
	'Machination', 
	'Manipulation', 
	'Regression', 
	'Revolution', 
	'Situation', 
	'Transition', 
	'Transmission', 
	);
	return array_rand(array_flip($blurb), 1); 
	}

	private function MakeNewTask ()
	{ 
	return array (
	'color_id' => $this->RandomColor(), 
	'column_id' => rand (1, 4),
	'creator_id' => rand(1, 10),
	'date_creation' => time() - (7 * 86400* rand (-3, -10)), # 5 weeks ago
	'date_due' => time() + (5 * 7 * 86400), # 5 weeks from now
	'date_modification' => time() - (7 * 86400* rand (+3, +20)), # 5 weeks ago
	'date_started' => time() + (7 * 86400 * rand (-3, +3)), 
	'description' => $this->RandomText(), 
	'is_active' => 1,
	'owner_id' => rand(1, 10),
	'priority' => rand(0, 3),
	'project_id' => 1, 
	'score' => rand(1, 10),
	'swimlane_id' => 1,
	'time_estimated' => rand(100, 1000),
	'time_spent' => rand(0, 100),
	'title' => $this->RandomString (), 
	);
	}

	private function MakebtTask ($name)
	{ 
	return array (
	'color_id' => $this->RandomColor(), 
	'column_id' => 4 + rand (1, 4),
	'creator_id' => rand(1, 10),
	'date_creation' => time() - (7 * 86400* rand (-3, -10)), # 5 weeks ago
	'date_due' => time() + (5 * 7 * 86400), # 5 weeks from now
	'date_modification' => time() - (7 * 86400* rand (+3, +20)), # 5 weeks ago
	'date_started' => time() + (7 * 86400 * rand (-3, +3)), 
	'description' => $this->RandomText(), 
	'is_active' => 1,
	'owner_id' => rand(1, 10),
	'priority' => rand(0, 3),
	'project_id' => 2, 
	'score' => rand(1, 10),
	'swimlane_id' => 2,
	'time_estimated' => rand(100, 1000),
	'time_spent' => rand(0, 100),
	'title' => $name, 
	);
	}

	public function import() 
	{
	if ($this->request->isPost()) 
		{
		$msg = '<br />Created<br />';
		$users = array(
		array ('username' => 'SMitchell', 'password' => 'SMitchell', 'is_admin' => 0, 'name' => 'Sylvia Mitchell', 'email' => 'Sylvia.Mitchell@kanboard.org'),
		array ('username' => 'JBloggs',   'password' => 'JBloggs',   'is_admin' => 0, 'name' => 'Joe Bloggs',      'email' => 'Joe.Bloggs@kanboard.org'),
		array ('username' => 'MSmith',    'password' => 'MSmith',    'is_admin' => 0, 'name' => 'Michael Smith',   'email' => 'Michael.Smith@kanboard.org'),
		array ('username' => 'BArtois',   'password' => 'BArtois',   'is_admin' => 0, 'name' => 'Bella Artois',    'email' => 'Bella.Artois@kanboard.org'),
		array ('username' => 'DCohen',    'password' => 'DCohen',    'is_admin' => 0, 'name' => 'David Cohen',     'email' => 'David.Cohen@kanboard.org'),
		array ('username' => 'MFabala',   'password' => 'MFabala',   'is_admin' => 0, 'name' => 'Miriam Fabala',   'email' => 'Miriam.Fabala@kanboard.org'),
		array ('username' => 'PEnchilada', 'password' => 'PEnchilada', 'is_admin' => 0, 'name' => 'Pedro Enchilada', 'email' => 'Pedro.Enchilada@kanboard.org'),
		array ('username' => 'KReinhart', 'password' => 'KReinhart', 'is_admin' => 0, 'name' => 'Karl Reinhart', 'email' => 'Karl.Reinhart@kanboard.org'),
		array ('username' => 'DCarlson', 'password' => 'DCarlson', 'is_admin' => 0, 'name' => 'Debra Carlson', 'email' => 'Debra.Carlson@kanboard.org'),
		);
		$msg .= $this->doImport($users, "users");

		$msg .= $this->doImport(array(array('name' => 'Winning Team'), array('name' => 'Losing Team')), "groups");

		$ghu = array();
		for ($i=1; $i<11; $i++)
		array_push ($ghu, array('group_id' => rand(1, 2), 'user_id' => $i));
		/*$msg .= */$this->doImport($ghu, "group_has_users");

		$projects = array();
		array_push ($projects, array('name' => 'Software design', 'is_public' => 1, 'is_active' => 1, 'default_swimlane' => 'Default swimlane', 'show_default_swimlane' => 1, 'owner_id' => 1,'priority_default'=>0,'priority_start'=>0,'priority_end'=>3));
		array_push ($projects, array('name' => 'House Building',  'is_public' => 1, 'is_active' => 1, 'default_swimlane' => 'Default swimlane', 'show_default_swimlane' => 1, 'owner_id' => 1,'priority_default'=>0,'priority_start'=>0,'priority_end'=>3));
		$msg .= $this->doImport($projects, "projects");
		
		$phu = array();
		for ($i=1; $i<11; $i++)
			{
			array_push ($phu, array('project_id' => 1, 'user_id' => $i, 'is_owner' => ($i == 1 ? 1 : 0),'role' => ($i == 1 ? 'project-manager' : 'project-member')));
			array_push ($phu, array('project_id' => 2, 'user_id' => $i, 'is_owner' => ($i == 1 ? 1 : 0),'role' => ($i == 1 ? 'project-manager' : 'project-member')));
			}
		/*$msg .= */$this->doImport($phu, "project_has_users");

		$swim = array();
		array_push ($swim, array('name' => 'Default swimlane','position'=>1,'is_active'=>1,'project_id'=>1));
		array_push ($swim, array('name' => 'Default swimlane','position'=>1,'is_active'=>1,'project_id'=>2));
		/*$msg .= */$this->doImport($swim, "swimlanes");

		$columns = array();
		array_push ($columns, array('title' => 'Backlog', 'position' => 1, 'project_id' => 1));
		array_push ($columns, array('title' => 'Ready', 'position' => 2, 'project_id' => 1));
		array_push ($columns, array('title' => 'Work in progress', 'position' => 3, 'project_id' => 1));
		array_push ($columns, array('title' => 'Done', 'position' => 4, 'project_id' => 1));
		array_push ($columns, array('title' => 'Backlog', 'position' => 1, 'project_id' => 2));
		array_push ($columns, array('title' => 'Ready', 'position' => 2, 'project_id' => 2));
		array_push ($columns, array('title' => 'Work in progress', 'position' => 3, 'project_id' => 2));
		array_push ($columns, array('title' => 'Done', 'position' => 4, 'project_id' => 2));		
		/*$msg .= */$this->doImport($columns, "columns");

		$phg = array
		(
		array('group_id' => 1, 'project_id' => 1, 'role' => 'project-member'),
		array('group_id' => 2, 'project_id' => 1, 'role' => 'project-member'),
		array('group_id' => 1, 'project_id' => 2, 'role' => 'project-member'),
		array('group_id' => 2, 'project_id' => 2, 'role' => 'project-member'),
		);
		/*$msg .= */$this->doImport($phg, "project_has_groups");

		$tasks = array();
		for ($i=0; $i<20; $i++)
		array_push ($tasks, $this->MakeNewTask ());

$buildingTask = array(
"Sign off architect plans",
"Get local council approval",
"Get Finance",
"Excavate foundations",
"Perform pest control",
"Lay down foundations",
"Do formwork",
"Pour concrete slab",
"Erect load bearing walls",
"Choose appliances",
"Choose wall paints",
"Choose carpet and tiles",
"Do plumbing",
"Do electrical",
"Wire telephone and internet",
"Deliver bricks",
"Deliver doors and windows",
"Deliver appliances",
"Guard construction site 24/7",
"Render internal walls",
"Assemble roof trusses",
"Erect roof",
"Do landscaping",
"Install letterbox",
"Pour concrete driveway",
"Connect water, electricity and sewage",
"Paint ceilings and walls",
"Lay down carpet and tiles",
"Install appliances",
"Inspection and keys handover",
);

		foreach ($buildingTask as $bt)
			array_push ($tasks, $this->MakebtTask ($bt));

		$msg .= $this->doImport($tasks, "tasks");

		$links = array();
		for ($i=1; $i<6; $i++)
			{
			array_push ($links, array('link_id' => 7, 'task_id' => $i, 'opposite_task_id' => $i+1));
			array_push ($links, array('link_id' => 6, 'task_id' => $i+1, 'opposite_task_id' => $i));
			}
		/*$msg .= */$this->doImport($links, "task_has_links");
			
		$this->response->html($this->helper->layout->config('demodata:demodata/done', array(
			'title' => t('Settings').' &gt; '.t('Generate Demo Data'),
			'reply' => $msg
		)));
		}
	else
		$this->response->html($this->helper->layout->config('demodata:demodata/import', array(
			'title' => t('Settings').' &gt; '.t('Generate Demo Data'),
			'max_size' => ini_get('upload_max_filesize')
		)));
		}
}
