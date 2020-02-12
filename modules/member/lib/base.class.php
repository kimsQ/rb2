<?php
// Rb DB 객체화
Class comment_DB{

    public $changeQue;

    public function query($sql){
   	   global $DB_CONNECT;
  	   $change_result=$this->changeQue=db_query($sql,$DB_CONNECT);
       return $change_result;
    }

    public function fetch_assoc($result){
  	   $change_result=$this->changeQue=db_fetch_assoc($result);
       return $change_result;
    }

    public function fetch_array($result){
  	   $change_result=$this->changeQue=db_fetch_array($result);
       return $change_result;
    }

    public function num_rows($result){
  	   $change_result=$this->changeQue=db_num_rows($result);
       return $change_result;
    }

    // 문자열  escape
    public function real_escape_string($string){
      global $DB_CONNECT;
    	return mysqli_real_escape_string($DB_CONNECT,$string);
    }

}

// 모듈 기본환경 설정
class Member_base {
	public $module;

    public function __construct() {
    	global $g,$table;

		$this->module = 'member';
	}

    // 테이블명 추출
	public function table($lastname){
		global $table;
	    return $table[$this->module.$lastname];
	}

    // mobile 여부 값 추출
	public function is_mobile(){
		global $g;

		if($g['mobile']&&$_SESSION['pcmode']!='Y') return true;
        else return false;
	}

    // device 정보 추출
	public function getUserAgent(){
		$device = '';
		$result = array();

		if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
			$device = "ipad";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
			$device = "iphone";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
			$device = "blackberry";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
			$device = "android";
		}

		if( $device ) {
			return $device;
		} return false; {
			return false;
		}
	}

	public function getAssoc($query){
	    $rows=array();
	    $result=$this->db->query($query);
	  	while ($row=$this->db->fetch_assoc($result)) $rows[]=$row;

		return $rows;
	}

	public function getArray($query){
	    $rows=array();
	    $result=$this->db->query($query);
	  	while ($row=$this->db->fetch_array($result)) $rows[]=$row;

		return $rows;
	}

	public function getRows($query){
	    $result=$this->db->query($query);
	  	$rows=$this->db->num_rows($result);
		return $rows;
	}

	// uid 기준 row 데이타 추출
	public function getUidData($table,$uid){
        $query= sprintf("SELECT * FROM `%s` WHERE `uid` = %s",$table,$this->db->real_escape_string($uid));
        $rows = $this->getArray($query);

        return $rows[0];
    }

      // 숫자 변경 함수
    public function formatWithSuffix($input)
    {
        $suffixes = array('', 'K', 'M', 'G', 'T');
        $suffixIndex = 0;

        while(abs($input) >= 1000 && $suffixIndex < sizeof($suffixes))
        {
            $suffixIndex++;
            $input /= 1000;
        }

        return (
            $input > 0
                // precision of 3 decimal places
                ? floor($input * 1000) / 1000
                : ceil($input * 1000) / 1000
            )
            . $suffixes[$suffixIndex];
    }

    // 사용자 입력내용 중 해시태그 분리 함수
    public function gethashtags($text)
    {
       //Match the hashtags
        preg_match_all('/(^|[^0-9a-zA-Z가-힣_])#([0-9a-zA-Z가-힣]+)/i', $text, $matchedHashtags);
        $hashtag = '';
        // For each hashtag, strip all characters but alpha numeric
        if(!empty($matchedHashtags[0])) {
            foreach($matchedHashtags[0] as $match) {
               $hashtag .= preg_replace("/[^0-9a-zA-Z가-힣]+/i", "", $match).',';
             }
        }
        //to remove last comma in a string
        return rtrim($hashtag, ',');
    }

    // 해시태그 분리하여 링크 추가 함수
    public function addLink_hashtag($message)
    {
        global $g;

        $parsedMessage = preg_replace(array('/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[0-9a-zA-Z가-힣.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/', '/(^|[^0-9a-zA-Z가-힣_])@([0-9a-zA-Z가-힣_]+)/i', '/(^|[^0-9a-zA-Z가-힣_])#([0-9a-zA-Z가-힣_]+)/i'), array('<a href="$1" target="_blank">$1</a>', '$1<a href="">@$2</a>', '$1<a class="hash-alink" href="'.$g['s'].'/?m=sns&mod=search&tag=$2">#$2</a>'), $message);
        return $parsedMessage;
    }

}

?>
