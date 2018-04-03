<?php
namespace Kanboard\Plugin\DemoData\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\UserModel;

/**
 * DemoData plugin controller
 */
class DemoData extends BaseController {

private function doImport($data, $table) 
{ 
$count=0;
if ($table === 'users')
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

return "$count $table ";
}
	
private function RandomText ()
{
$blurb = array('Tripanodon', 'Bamboula', "tartuffe", 'Dingo', 'Bison Futé', 'Gros malin', "The quick brown fox jumps over the lazy dog."	);
return array_rand(array_flip($blurb), 1); 
}
	
private function RandomColor ()
{
$blurb = array('blue', 'yellow', "grey", 'orange', 'cyan', 'green', "pink", 'lime'	);
return array_rand(array_flip($blurb), 1); 
}

private function RandomString($chrList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $chrRandomLength = 10)
{ 
$blurb = array('Customisation', 'Transition', "Expectation", 'Investigation', 'Cogitation', 'Regresion', "Degustation",
'Delegation', 	'Manipulation', 'Transmission', 'Evaluation', 'Situation', 'Revolution', 'Imagination', 'Position', 'Ambition');
return array_rand(array_flip($blurb), 1); 
}

private function MakeNewTask ()
{ 
return array ('title' => $this->RandomString (), 
'description' => $this->RandomText(), 
'date_creation' => time() - (7 * 86400* rand (-3, -10)), # 5 weeks ago
'date_modification' => time() - (7 * 86400* rand (+3, +20)), # 5 weeks ago
'color_id' => $this->RandomColor(), 
'project_id' => 1, 
'column_id' => rand (1, 4),
'score' => rand(1, 10),
'owner_id' => rand(1, 10),
'date_due' => time() + (5 * 7 * 86400), # 5 weeks from now
'is_active' => 1,
'creator_id' => rand(1, 10),
'date_started' => time() + (86400 * rand (-3, +3)), 
'time_spent' => rand(0, 100),
'time_estimated' => rand(100, 1000),
'swimlane_id' => 1,
'priority' => rand(0, 3),
);
}

public function import() 
{
if ($this->request->isPost()) 
	{
	$msg = 'Created ';
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

	$msg .= $this->doImport(array(array('name' => 'Winning Team')), "groups");

	$ghu = array();
	for ($i=1; $i<11; $i++)
	array_push ($ghu, array('group_id' => 1, 'user_id' => $i));
	$this->doImport($ghu, "group_has_users");

	$tasks = array();
	for ($i=0; $i<20; $i++)
	array_push ($tasks, $this->MakeNewTask ());


	$msg .= $this->doImport($tasks, "tasks");

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
