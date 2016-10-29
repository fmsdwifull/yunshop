<?php
class UpdaAction extends UserAction{
	public function index(){		
		if($this->_get('token')!=session('token')){$this->error('非法操作');}
		$token      = session('token');
        $id         = $this->_get('id');
		$upinfo = file_get_contents('http://tp.31cms.com/upinfo.php');
		$post_url   = "http://tp.31cms.com/filesync.php";
		$mask =15;
		$post = array ("dir" => 1);
			$ch = curl_init($post_url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			if (!$result) die("连接错误");
			$post_url = curl_getinfo ($ch ,CURLINFO_EFFECTIVE_URL);
			curl_close($ch);
			$rdata = json_decode($result, true);
			if ($rdata == '') die("远程服务器数据错误");
				//$ldata = listFile($_SERVER['DOCUMENT_ROOT']);
			$ldata = $this->listFile(".");
		//search 
		$needdata;
		foreach ($rdata as $data) {
		$exist="e0";
		$type="t0";
		$perms="p0";
		$md5="m0";
		$ret = $this->search_file($data, $ldata, $tmp);
		$ret = $ret & $mask;
		if ($ret&1) $exist="e1";
		if ($ret&2) $type="t1";
		//if ($ret&4) $perms="1";
		if ($ret&8) $md5="m1";
		if ($ret) {
		    $data['ext'] = $ret;
			$needdata[] = $data;
		}
		}
		$this->assign('url',$post_url);
		$this->assign('upinfo',$upinfo);
		$this->assign('needdata',$needdata);
        $this->display();
		}
		
	public function sharesync(){
			$data = $_POST;
			$filename = str_replace('/', DIRECTORY_SEPARATOR , $data['name']);
			if ($data['type'] == "d") { //目录
 				if (!file_exists($filename)) {
					$success = @mkdir($filename, $data['perms']);
					if (!$success) {
						echo "创建文件夹{$data['name']}失败\n";
					}
 				}
			}
			else { //从远程获取文件
				$post = array (
					"get_file" => $data['name'] //文件名
				);
				if (file_exists($filename)) { //如果文件已存在,那么先删除
					unlink($filename);
				}
				$fp = @fopen($filename, 'w');
				if (!$fp) {
					echo "打开文件{$data['name']}失败\n";
				}
				else {
					$ch = curl_init($data['url']);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					curl_setopt($ch, CURLOPT_FILE, $fp);
					$success = curl_exec($ch);
					curl_close($ch);
					fclose($fp);
					if (!$success) {
						echo "文件{$data['name']}同步失败\n";
					}
				}
			}
		echo $data['status'];
	}
private function listFile($dir)
{
	$fileArray = array();
	$cFileNameArray = array();
	$ds = DIRECTORY_SEPARATOR; //获取系统文件分隔符
	$nls = array(
	'.\uploads',
	'.\aspnet_client',
	'.\Common',
	'.\Conf',
	'.\font',
	'.\install',
	'.\Lang',
	'.\Lib',
	'.\tpl\static\artDialog',
	'.\tpl\static\bxslider-4',
	'.\tpl\static\kindeditor',
	'.\tpl\User\default\Upda_index.html',
	'.\31cms\Lib\Action\User\UpdaAction.class.php',
	'.\filesync.php',
	'.\upinfo.php',
	);
	if($handle = opendir($dir)) //打开目录
	{
		while(($file = readdir($handle)) !== false)
		{
			if ($file[0] == ".") continue;
			$dirname = str_replace(DIRECTORY_SEPARATOR, '/',  $dir); //统一文件分割符为"/",
			if(!in_array($dir.$ds.$file,$nls)){
			if(is_dir($dir.$ds.$file))
			{
				$fileArray[] = array(
					"name" => $dirname."/".$file,
					"type" => "d",
					"perms" => substr(sprintf('%o',fileperms($dir.$ds.$file)), -4),
					"md5" =>""
				);
				$cFileNameArray = $this->listFile($dir.$ds.$file);
				for($i=0;$i<count($cFileNameArray);$i++)
				{
					$fileArray[] = $cFileNameArray[$i];
				}
				
			}
			else
			{
				$fileArray[] = @array(
					"name" => $dirname."/".$file,
					"type" => "f",
					"perms" => substr(sprintf('%o',fileperms($dir.$ds.$file)), -4),
					"md5" =>md5_file($dir.$ds.$file)
				);
			}
			}
		}
	}
	return $fileArray;
}

private function search_file(array $file , array $files , array &$result)
{
	$ret = 0;
	foreach ($files as $f) {
		if ($file['name'] == $f['name']) {
			if ($file['type'] != $f['type']) {//类型不一致
				$ret = $ret | 2;
			}
/* 			if ($file['perms'] != $f['perms']) {//权限不一致
				$ret = $ret | 4;
			} */
			if ($file['md5'] != $f['md5']){//MD5不一致
				$ret = $ret | 8;
			}
			$result = $f;
			return $ret;
		}
	}
	return 1; //未找到
} 




}
?>