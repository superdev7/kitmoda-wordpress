<?php



class KSM_Inbox extends KSM_Message {
	
	
	static $users = array();
	
	public function __construct($msg) {
		
		parent::__construct($msg);
		
		$this->replies = parent::get("parent_id = '{$this->uuid}' AND member_id='{$this->to_id}'");
		//$this->from = User::getUser(array('f' => 'member_id', 'v' => $this->from_id));
		
		
	}
        
        
        
	
	
	
	static function getMessages($to_id, $page=1) {
		
		$db = DB_MySQL::getInstance();
		
		
		
		
		//echo $to_id;
		//$q = "SELECT COUNT(id) FROM messages WHERE (member_id='{$to_id}' AND to_id='{$to_id}' AND `deleted` = 0 AND parent_id=0) || (is_conversation = 1 && member_id='{$to_id}' && `deleted`=0)";
		
		$data = array();
		$result = array('total_results'=> 0);
		$limit = 20;
		
		
		$total_results_sql = "SELECT COUNT(id) as total_results FROM messages WHERE (member_id='{$to_id}' AND to_id='{$to_id}' AND parent_id=0) || (is_conversation = 1 && member_id='{$to_id}' && parent_id=0)";
		$total_results_res = $db->select($total_results_sql);
		$total_results = $total_results_res[0]['total_results'];
		
		
		$page = (!is_numeric($page) || $page < 1) ? 1 : $page;
		
		$limit_start = ($limit*$page)-$limit;
		$limit_end = $limit;
		$sql_limit = " LIMIT {$limit_start} , {$limit_end}";
		
				
		if($total_results > 0) {
			$result['total_results'] = $total_results;
					
			$q = "SELECT * FROM messages WHERE (member_id='{$to_id}' AND to_id='{$to_id}' AND parent_id=0) || (is_conversation = 1 && member_id='{$to_id}' && parent_id=0) ORDER BY last_activity DESC {$sql_limit}";
			
			//echo $q;
			//$filter = array('limit'=>20, 'page'=>1);
			$messages = $db->select($q, $filter);
			$result['total'] = count($messages);	
			foreach($messages as $msg) {
				$msg = self::prepare($msg);
				$replies = Message::get("parent_id = '{$msg['uuid']}' AND member_id='{$to_id}'");
				$msg_replies = array();
				foreach($replies as $rep) {
					$msg_replies[] = new Message(self::prepare($rep));
				}
				$msg['replies'] = $msg_replies;
				$data[] = new Message($msg);
			}
			
			
			
			$result['paging'] = array('page'=> $page, 'total_pages'=> ceil($total_results / $limit ));
			
			$result['paging']['prev'] = ($page > 1) ? $page-1 : '';
			$result['paging']['next'] = ($page < $result['paging']['total_pages']) ? $page+1 : '';
		}
		
		
		
		
		
		
		$result['data'] = $data;
		return $result;
		
		
		
	}
	
	
	
	static function prepare($msg) {
		
			if(!in_array($msg['from_id'], array_keys(self::$users))) {
				self::$users[$msg['from_id']] = User::getUser(array('f'=>'member_id', 'v'=> $msg['from_id']));
				self::$users[$msg['from_id']]->thumb = User::getDefaultImage2($msg['from_id'], true, 'image_thumb');
			}
			if(!in_array($msg['to_id'], array_keys(self::$users))) {
				self::$users[$msg['to_id']] = User::getUser(array('f'=>'member_id', 'v'=> $msg['to_id']));
				self::$users[$msg['to_id']]->thumb = User::getDefaultImage2($msg['to_id'], true, 'image_thumb');
			}
			$msg['to'] = self::$users[$msg['to_id']];
			$msg['from'] = self::$users[$msg['from_id']];
			
			return $msg;
		
	}
	
	
	
	
}





?>