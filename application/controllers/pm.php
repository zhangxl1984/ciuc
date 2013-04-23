<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->check_priv();
		if(!$this->user['isfounder'] && !$this->user['allowadminpm']) {
			$this->message('no_permission_for_this_module');
		}
		$this->load->model('pm_m');
		
	}
	
	function ls() {
		$folder = 'inbox';
		$filter = 'announcepm';
		$status = 0;
		if(submitcheck()) {
			$delnum = $_ENV['pm']->deletepm($this->user['uid'], $_POST['delete']);
			$status = 1;
			$this->writelog('pm_delete', "delete=".implode(',', $_POST['delete']));
		}
		$pmnum = $this->db->where(array('msgtoid'=>'0', 'folder'=>'inbox'))->get('pms')->num_rows();
		$pmlist = $this->pm_m->get_pm_list($this->user['uid'], $pmnum, $folder, $filter, $_GET['page']);
		$multipage = page($pmnum, 10, $_GET['page'], 'admin.php?m=pm&a=ls');
		$extra = 'extra='.rawurlencode($_GET['extra']);
		$a = getgpc('a');
		$data['a'] = $a;
		$data['status'] = $status;
		$data['pmlist'] = $pmlist;
		$data['extra'] = $extra;
		$data['multipage'] = $multipage;

		$this->load->view('pm', $data);
	}

	function view() {
		$pmid = @is_numeric($_GET['pmid']) ? $_GET['pmid'] : 0;
		$pms = $_ENV['pm']->get_pm_by_pmid($this->user['uid'], $pmid);

		if($pms[0]) {
			$pms = $pms[0];
			require_once UC_ROOT.'lib/uccode.class.php';
			$this->uccode = new uccode();
			$this->uccode->lang = &$this->lang;
			$pms['message'] = $this->uccode->complie($pms['message']);
			$pms['dateline'] = $this->date($pms['dateline']);
		}

		$extra = 'extra='.rawurlencode($_GET['extra']);
		$a = getgpc('a');
		$data['a'] = $a;
		$data['pms'] = $pms;
		$data['extra'] = $extra;

		$this->load->view('pm', $data);
	}

	function send() {
		$status = 0;
		if($this->submitcheck()) {
			$lastpmid = $_ENV['pm']->sendpm($_POST['subject'], $_POST['message'], $this->user['isfounder'] ? '' : $this->user, 0);
			$status = 1;
			$this->writelog('pm_send', "subject=".htmlspecialchars($_POST['subject']));
		}
		$data['status'] = $status;
		$this->load->view('pm_send', $data);
	}

	function clear() {
		$delnum = 0;
		if($this->submitcheck()) {
			$cleardays = intval(getgpc('cleardays', 'P'));
			$unread = getgpc('unread') ? 1 : 0;
			$usernames = trim(getgpc('usernames', 'P'));
			$sqladd = '';
			if($cleardays > 0) {
				$sqladd .= ' AND dateline < '.($this->time - $cleardays * 86400);
			}
			if($unread) {
				$sqladd .= " AND new='0'";
			}
			if($usernames) {
				$uids = 0;
				$usernames = "'".implode("', '", explode(',', $usernames))."'";
				$query = $this->db->query("SELECT uid FROM ".UC_DBTABLEPRE."members WHERE username IN ($usernames)");
				while($res = $this->db->fetch_array($query)) {
					$uids .= ','.$res['uid'];
				}
				if($uids) {
					$sqladd .= " AND (msgfromid IN ($uids) OR msgtoid IN ($uids))";
				}
			}
			
			if($sqladd) {
				$this->db->query("DELETE FROM ".UC_DBTABLEPRE."pms WHERE 1 $sqladd", 'UNBUFFERED');
				$delnum = $this->db->affected_rows();
				$status = 1;
				$this->writelog('pm_clear', "cleardays=$cleardays&unread=$unread");
			}
		}

		$pmnum = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."pms");
		$data['pmnum'] = $pmnum;
		$data['delnum'] = $delnum;
		$data['status'] = $status;
		$this->load->view('pm_clear', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */