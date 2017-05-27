<?php
//获取上传图片的地址
function seaweedAssign() {
	$url = 'http://192.168.126.245:9333/dir/assign';
	//初始化
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	//释放curl句柄
	curl_close($ch);
	//打印获得的数据
	//{"fid":"2,01f0c2c004","url":"192.168.126.245:9080","publicUrl":"192.168.126.245:9080","count":1}
	return json_decode($output, 1);
}


//上传附件
function uploadAttach()
{
	$ret = array();
	$ret['errorcode'] = 0;
	$ret['errormsg'] = '';
	if(!$_FILES || false == isset($_FILES["upFile"]))
	{
		$ret['errorcode'] = 1;
		$ret['errormsg'] = "ERROR:upFile is not set";
		return $ret;
	}

	$file = $_FILES["upFile"];
	if (false == isset($file['tmp_name']) || false == is_file($file['tmp_name']))
	{
		$ret['errorcode'] = 2;
		$ret['errormsg'] = "tmp_name is not file";
		return $ret;
	}
	if (0 == filesize($file['tmp_name']))
	{
		$ret['errorcode'] = 3;
		$ret['errormsg'] = "tmp_name filesize is 0";
		return $ret;
	}

	$curlFile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
	$fileSuffix = getSuffix($curlFile->getPostFilename());

	$ret['file'] = $file;
	$ret['fileId'] = uploadToFastdfs($curlFile, $fileSuffix);
	return $ret;
}

//获取后缀
function getSuffix($fileName)
{
	preg_match('/\.(\w+)?$/', $fileName, $matchs);
	return isset($matchs[1])?$matchs[1]:'';
}

//上传文件到seaweedfs
function uploadToFastdfs(CurlFile $file, $fileSuffix)
{
	$jsonData = seaweedAssign();
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://'.$jsonData['publicUrl'].'/'.$jsonData['fid']);
	curl_setopt($ch, CURLOPT_POST,true);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1); //连接超时
	curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'file' => $file,
	]);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,$file);
	$data=curl_exec ($ch);
	$info=curl_getinfo($ch);
	curl_close($ch);
	print_r($data);
	print_r($info);
//array ( [url] => http://172.18.0.3:8080/4,0a234491a4 [content_type] => [http_code] => 0 [header_size] => 0 [request_size] => 0 [filetime] => -1 [ssl_verify_result] => 0 [redirect_count] => 0 [total_time] => 1 [namelookup_time] => 0 [connect_time] => 0 [pretransfer_time] => 0 [size_upload] => 0 [size_download] => 0 [speed_download] => 0 [speed_upload] => 0 [download_content_length] => -1 [upload_content_length] => -1 [starttransfer_time] => 0 [redirect_time] => 0 [redirect_url] => [primary_ip] => [certinfo] => Array ( ) [primary_port] => 0 [local_ip] => [local_port] => 0 ) Array ( [errorcode] => 0 [errormsg] => [file] => Array ( [name] => 1.png [type] => image/png [tmp_name] => D:\AppData\Local\Temp\phpF8CC.tmp [error] => 0 [size] => 11273 ) [fileId] => )
	//return $fileId;
}

function start()
{
	$ret = uploadAttach();
	print_r($ret);
}
start();
?>

