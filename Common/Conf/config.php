<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING'		=>    array(
		'__ADMIN__'			=> 	  '/Public/Admin',
		'__HOME__'          =>    '/Public/Home',
		'__PUBLICU__'          => '/Public/Publicu',
		'__TIME__'          =>    date('Y-m-d H:i:s',time())
		),
	//数据库连接配置
	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'fs2',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
	'SHOW_PAGE_TRACE' => true,
	'LOAD_EXT_FILE'   => 'qz_02',

);