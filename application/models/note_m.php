<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('UC_NOTE_REPEAT', 5);
define('UC_NOTE_TIMEOUT', 15);
define('UC_NOTE_GC', 10000);

define('API_RETURN_FAILED', '-1');

class Note_m extends CI_Model
{
	var $apps;
	var $operations = array();
	var $notetype = 'HTTP';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cache_m');
		$this->apps = $this->cache_m->getdata('apps');
		$this->load->model('misc_m');
		$this->operations = array(
				'test'=>array('', 'action=test'),
				'deleteuser'=>array('', 'action=deleteuser'),
				'renameuser'=>array('', 'action=renameuser'),
				'deletefriend'=>array('', 'action=deletefriend'),
				'gettag'=>array('', 'action=gettag', 'tag', 'updatedata'),
				'getcreditsettings'=>array('', 'action=getcreditsettings'),
				'getcredit'=>array('', 'action=getcredit'),
				'updatecreditsettings'=>array('', 'action=updatecreditsettings'),
				'updateclient'=>array('', 'action=updateclient'),
				'updatepw'=>array('', 'action=updatepw'),
				'updatebadwords'=>array('', 'action=updatebadwords'),
				'updatehosts'=>array('', 'action=updatehosts'),
				'updateapps'=>array('', 'action=updateapps'),
				'updatecredit'=>array('', 'action=updatecredit'),
		);
	}

	function get_total_num($all = TRUE) {
		if($all)
		{
			$data = $this->db->count_all_results('notelist');
		}
		else
		{
			$data = $this->db->where('closed', 0)->get('notelist')->num_rows();
		}
		
		return $data;
	}

	function get_list($page, $ppp, $totalnum, $all = TRUE) {
		$start = page_get_start($page, $ppp, $totalnum);
		if($all)
		{
			$data = $this->db->order_by('dateline DESC')->get('notelist', $ppp, $start)->result_array();
		}
		else
		{
			$data = $this->db->where('closed', 0)->order_by('dateline DESC')->get('notelist', $ppp, $start)->result_array();
		}
		foreach((array)$data as $k => $v) {
			$data[$k]['postdata2'] = addslashes(str_replace('"', '', $data[$k]['postdata']));
			$data[$k]['getdata2'] = addslashes(str_replace('"', '', $v['getdata']));
			$data[$k]['dateline'] = $v['dateline'] ? $data[$k]['dateline'] : '';
		}
		return $data;
	}

	function delete_note($ids) {
		
		return $this->db->where_in('noteid', $ids)->delete('notelist');
	}

	function add($operation, $getdata='', $postdata='', $appids=array(), $pri = 0) {
		$set = $varsets = array();
		foreach((array)$this->apps as $appid => $app) {
			$appid = $app['appid'];
			if($appid == intval($appid)) {
				if($appids && !in_array($appid, $appids)) {
					$set['app'.$appid] = 1;
				} else {
					$varsets[] = array('name'=>'noteexists'.$appid, 'value'=>1);
				}
			}
		}
		
		$getdata = addslashes($getdata);
		$postdata = addslashes($postdata);
		$set['getdata'] = $getdata;
		$set['operation'] = $operation;
		$set['pri'] = $pri;
		$set['postdata'] = $postdata;
		$insert_id = $this->db->insert('notelist', $set);
		if($insert_id){
			$this->db->replace('vars', array('name'=>'noteexists', 'value'=>1));
			if($varsets){
				foreach($varsets as $varset)
				{
					$this->db->replace('vars', $varset);
				}
			}
		}
		return $insert_id;
	}

	function send() {
		register_shutdown_function(array($this, '_send'));
	}

	function _send() {


		$note = $this->_get_note();
		if(empty($note)) {
			$this->db->replace('vars', array('name'=>'noteexists', 'value'=>0));
			return NULL;
		}

		$closenote = TRUE;
		foreach((array)$this->apps as $appid => $app) {
			$appnotes = $note['app'.$appid];
			if($app['recvnote'] && $appnotes != 1 && $appnotes > -UC_NOTE_REPEAT) {
// 				$this->sendone($appid, 0, $note);
				$closenote = FALSE;
				break;
			}
		}
		if($closenote) {
			$this->db->update('notelist', array('closed'=>'1'), array('noteid'=>$note['noteid']));
		}

		$this->_gc();
	}

	function sendone($appid, $noteid = 0, $note = '') {
// 		$this->load->library('xml');
		$return = FALSE;
		$app = $this->apps[$appid];
		if($noteid) {
			$note = $this->_get_note_by_id($noteid);
		}
		
		$apifilename = isset($app['apifilename']) && $app['apifilename'] ? $app['apifilename'] : 'uc.php';
		if(isset($app['extra']['apppath']) && $app['extra']['apppath'] && @include $app['extra']['apppath'].'./api/'.$apifilename) {
			$uc_note = new uc_note();
			$method = $note['operation'];
			if(is_string($method) && !empty($method)) {
				parse_str($note['getdata'], $note['getdata']);				
				if(get_magic_quotes_gpc()) {
					$note['getdata'] = $this->base->dstripslashes($note['getdata']);
				}
				$note['postdata'] = xml_unserialize($note['postdata']);
				$response = $uc_note->$method($note['getdata'], $note['postdata']);
			}
			unset($uc_note);
		} else {
			$url = $this->get_url_code($note['operation'], $note['getdata'], $appid);
			$note['postdata'] = str_replace(array("\n", "\r"), '', $note['postdata']);
			$response = trim($this->misc_m->dfopen2($url, 0, $note['postdata'], '', 1, $app['ip'], UC_NOTE_TIMEOUT, TRUE));
		}

		$returnsucceed = $response != '' && ($response == 1 || is_array(xml_unserialize($response)));

		$closed = $this->_close_note($note, $this->apps, $returnsucceed, $appid) ? 1 : 0;//

		if($returnsucceed) {
			if($this->operations[$note['operation']][2]) {
				$this->base->load($this->operations[$note['operation']][2]);
				$func = $this->operations[$note['operation']][3];
				$_ENV[$this->operations[$note['operation']][2]]->$func($appid, $response);
			}
			$this->db->set('totalnum', 'totalnum+1', FALSE)->set('succeednum', 'succeednum+1', FALSE)->update('notelist', array('app'.$appid=>'1', 'dateline'=>time(), 'closed'=>$closed), array('noteid'=>$note[noteid]));
			$return = TRUE;
		} else {
			$this->db->set('totalnum', 'totalnum+1', FALSE)->set('app'.$appid, 'app'.$appid.'-1', FALSE)->update('notelist', array('dateline'=>time(), 'closed'=>$closed), array('noteid'=>$note[noteid]));
			$return = FALSE;
		}
		return $return;
	}

	function _get_note() {
		$data = $this->db->where('closed', 0)->order_by('pri DESC, noteid ASC')->get('notelist', 1)->first_row('array');
		return $data;
	}

	function _gc() {
		rand(0, UC_NOTE_GC) == 0 && $this->db->delete('notelist', array('closed'=>'1'));
	}

	function _close_note($note, $apps, $returnsucceed, $appid) {
		$note['app'.$appid] = $returnsucceed ? 1 : $note['app'.$appid] - 1;
		$appcount = count($apps);
		foreach($apps as $key => $app) {
			$appstatus = $note['app'.$app['appid']];
			if(!$app['recvnote'] || $appstatus == 1 || $appstatus <= -UC_NOTE_REPEAT) {
				$appcount--;
			}
		}
		if($appcount < 1) {
			return TRUE;
			//$closedsqladd = ",closed='1'";
		}
	}

	function _get_note_by_id($noteid) {
		$data = $this->db->where('noteid', $noteid)->get('notelist')->first_row();
		return $data;
	}

	function get_url_code($operation, $getdata, $appid) {
		$app = $this->apps[$appid];
		$authkey = $app['authkey'];
		$url = $app['url'];
		$apifilename = isset($app['apifilename']) && $app['apifilename'] ? $app['apifilename'] : 'uc.php';
		$action = $this->operations[$operation][1];
		$code = urlencode(authcode("$action&".($getdata ? "$getdata&" : '')."time=".time(), 'ENCODE', $authkey));
		
		return $url."/api/$apifilename?code=$code";
	}

}