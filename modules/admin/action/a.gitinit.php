<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$result=array();

$git_version = shell_exec('git --version');

if ($git_version) {

  $command1	= 'git init';
  $command2	= 'git remote add origin https://github.com/kimsQ/rb.git';
  shell_exec($command1);
  shell_exec($command2);
  setrawcookie('system_update_result', rawurlencode('업데이트 준비가 되었습니다.'));
  $result['error'] = false;

} else {
  $result['error'] = true;
  $result['msg'] = 'git 설치가 필요합니다. 호스팅 업체 또는 서버관리자에게 문의해주세요.';
}

echo json_encode($result);
exit;

?>
