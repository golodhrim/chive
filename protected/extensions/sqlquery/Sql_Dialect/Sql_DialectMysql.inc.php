<?php

$dialect = array(
    'column_attribs' => array (
		'auto_increment', 'bdb', 'berkeleydb', 'binary', 'default', 'innobase', 'innodb', 
		'isam', 'mrg_myisam', 'myisam', 'national', 'precision', 'unsigned', 'varying', 'zerofill'
	),
	'column_types' => array(
		'bigint', 'bit', 'blob', 'bool', 'char', 'character', 'date', 'datetime', 'dec', 'decimal', 
		'double', 'enum', 'float', 'float4', 'float8', 'int', 'int1', 'int2', 'int3', 'int4', 'int8', 
		'integer', 'long', 'longblob', 'longtext', 'mediumblob', 'mediumint', 'mediumtext', 'middleint', 
		'nchar', 'numeric', 'real', 'set', 'smallint', 'text', 'time', 'timestamp', 'tinyblob', 
		'tinyint', 'tinytext', 'varbinary', 'varchar', 'year'	
	),
	'selected_keyword' => array(
		"", // on flipping a zero becomes to false, due to php comparing error
		"high_priority",
		"straight_join",
		"sql_small_result",
		"sql_big_result",
		"sql_buffer_result",
		"sql_calc_found_rows_cache",
		"sql_no_cache",
		"sql_cache"
		),
	'commands' => array(
	    'alter',
		'create',
		'create_table',
		'drop',
		'select',
		'delete',
		'insert',
		'update',
		'part',
		'replace'
	),	
	'operators' => array(
	    '=',
		'<>',
		'<',
		'<=',
		'>',
		'>=',
		'like',
		'clike',
		'slike',
		'not',
		'is',
		'in',
		'between',
		'and',
		'or'
	),
	'types' => array(
	    'character',
		'char',
		'varchar',
		'nchar',
		'bit',
		'numeric',
		'decimal',
		'dec',
		'integer',
		'int',
		'smallint',
		'float',
		'real',
		'double',
		'date',
		'datetime',
		'time',
		'timestamp',
		'interval',
		'bool',
		'boolean',
		'set',
		'enum',
		'text'
	),
	'conjunctions' => array(
	    'by',
		'as',
		'on',
		'into',
		'from',
		'where',
		'with'
	),
	'controlFlowFunctions' => array(
		'if',
		'elseif',
		'then',
		'case',
		'when'
	),
	'functions' =>  array(
		'abs', 'acos', 'adddate', 'aes_encrypt', 'aes_decrypt', 'ascii', 'asin', 'atan', 
		'atan2', 'avg', 'benchmark', 'bin', 'bit_and', 'bit_count', 'bit_length', 'bit_or', 
		'cast', 'ceil', 'ceiling', 'char_length', 'character_length', 'coalesce', 'concat', 
		'concat_ws', 'connection_id', 'conv', 'convert', 'cos', 'cot', 'count', 'curdate', 
		'current_date', 'current_time', 'current_timestamp', 'current_user', 'curtime', 'database', 
		'date_add', 'date_format', 'date_sub', 'dayname', 'dayofmonth', 'dayofweek', 'dayofyear', 
		'decode', 'degrees', 'des_encrypt', 'des_decrypt', 'elt', 'encode', 'encrypt', 'exp', 
		'export_set', 'extract', 'field', 'find_in_set', 'floor', 'format', 'found_rows', 
		'from_days', 'from_unixtime', 'get_lock', 'greatest', 'group_unique_users', 'hex', 
		'ifnull', 'inet_aton', 'inet_ntoa', 'instr', 'interval', 'is_free_lock', 'isnull', 
		'last_insert_id', 'lcase', 'least', 'left', 'length', 'ln', 'load_file', 'locate', 'log', 
		'log2', 'log10', 'lower', 'lpad', 'ltrim', 'make_set', 'master_pos_wait', 'max', 'md5', 
		'mid', 'min', 'mod', 'monthname', 'now', 'nullif', 'oct', 'octet_length', 'ord', 'password', 
		'period_add', 'period_diff', 'pi', 'position', 'pow', 'power', 'quarter', 'quote', 'radians', 
		'rand', 'release_lock', 'repeat', 'reverse', 'right', 'round', 'rpad', 'rtrim', 'sec_to_time', 
		'session_user', 'sha', 'sha1', 'sign', 'sin', 'soundex', 'space', 'sqrt', 'std', 'stddev', 
		'strcmp', 'subdate', 'substring', 'substring_index', 'sum', 'sysdate', 'system_user', 'tan', 
		'time_format', 'time_to_sec', 'to_days', 'trim', 'ucase', 'unique_users', 'unix_timestamp', 
		'upper', 'user', 'version', 'week', 'weekday', 'yearweek','pi'	
	),
	'reserved' => array(
	    'absolute',
	    'abs',
	    'acos',
	    'atan',
	    'atan2',
		'action',
		'add',
		'all',
		'allocate',
		'and',
		'any',
		'are',
		'asc',
		'ascending',
		'assertion',
		'at',
		'pi',
		'avg',
		'authorization',
		'begin',
		'bit_length',
		'bit_count',
		'bit_or',
		'bit_and',
		'both',
		'cascade',
		'cascaded',
		'case',
		'cast',
		'catalog',
		'char_length',
		'character_length',
		'check',
		'ceil',
		'ceiling',
		'close',
		'coalesce',
		'collate',
		'collation',
		'column',
		'commit',
		'connect',
		'concat',
		'concat_ws',
		'connection',
		'constraint',
		'constraints',
		'continue',
		'convert',
		'corresponding',
		'cos',
		'cot',
		'count',
		'cross',
		'current',
		'current_date',
		'current_time',
		'current_timestamp',
		'current_user',
		'cursor',
		'crc32',
		'day',
		'deallocate',
		'declare',
		'default',
		'deferrable',
		'deferred',
		'degrees',
		'desc',
		'descending',
		'describe',
		'descriptor',
		'diagnostics',
		'disconnect',
		'distinct',
		'domain',
		'else',
		'end',
		'end-exec',
		'escape',
		'except',
		'exception',
		'exec',
		'execute',
		'exists',
		'external',
		'extract',
		'exp',
		'false',
		'fetch',
		'first',
		'floor',
		'for',
		'foreign',
		'found',
		'full',
		'fulltext',
		'format',
		'get',
		'global',
		'go',
		'goto',
		'grant',
		'group',
		'having',
		'hour',
		'identity',
		'if',
		'immediate',
		'indicator',
		'initially',
		'inner',
		'input',
		'insensitive',
		'intersect',
		'isolation',
		'join',
		'key',
		'language',
		'last',
		'leading',
		'left',
		'level',
		'limit',
		'local',
		'lower',
		'log',
		'log2',
		'log10',
		'ln',
		'max',
		'min',
		'match',
		'minute',
		'module',
		'month',
		'names',
		'national',
		'natural',
		'next',
		'no',
		'null',
		'nullif',
		'octet_length',
		'of',
		'only',
		'open',
		'option',
		'or',
		'order',
		'outer',
		'output',
		'overlaps',
		'pad',
		'pi',
		'partial',
		'position',
		'precision',
		'prepare',
		'preserve',
		'primary',
		'prior',
		'privileges',
		'procedure',
		'public',
		'pow',
		'power',
		'radians',
		'rand',
		'read',
		'references',
		'relative',
		'restrict',
		'revoke',
		'right',
		'rollback',
		'rows',
		'round',
		'schema',
		'scroll',
		'second',
		'section',
		'session',
		'session_user',
		'size',
		'sign',
		'sin',
		'sqrt',
		'some',
		'space',
		'spatial',
		'sum',
		'sql',
		'sqlcode',
		'sqlerror',
		'sqlstate',
		'substring',
		'system_user',
		'table',
		'index',
		'temporary',
		'then',
		'tan',
		'timezone_hour',
		'timezone_minute',
		'to',
		'trailing',
		'transaction',
		'translate',
		'translation',
		'trim',
		'true',
		'truncate',
		'union',
		'unique',
		'unknown',
		'upper',
		'usage',
		'user',
		'using',
		'value',
		'values',
		'varying',
		'view',
		'when',
		'whenever',
		'work',
		'write',
		'year',
		'zone',
		'eoc',
		'auto_increment',
		'ascii',
		'bin',
		'bit_length',
		'char_length',
		'character_length',
		'lcase',
		'length',
		'lower',
		'ltrim',
		'oct',
		'octet_length',
		'ord',
		'quote',
		'reverse',
		'rtrim',
		'soundex',
		'space',
		'ucase',
		'unhex',
		'upper',
		'find_in_set',
		'format',
		'instr',
		'left',
		'locate',
		'repeat',
		'right',
		'substr',
		'substring',
		'make_set',
		'elt'
	),
	'synonyms' => array(
	    'delayed' => 'delayed',
		'decimal' => 'numeric',
		'dec' => 'numeric',
		'numeric' => 'numeric',
		'float' => 'float',
		'real' => 'real',
		'double' => 'real',
		'ignore' => 'ignore',
		'int' => 'int',
		'integer' => 'int',
		'interval' => 'interval',
		'smallint' => 'smallint',
		'timestamp' => 'timestamp',
		'bool' => 'bool',
		'boolean' => 'bool',
		'set' => 'set',
		'enum' => 'enum',
		'modify' => 'modify',
		'change' => 'change',
		'rename' => 'rename',
		'text' => 'text',
		'char' => 'char',
		'character' => 'char',
		'varchar' => 'varchar',
		'ascending' => 'asc',
		'asc' => 'asc',
		'descending' => 'desc',
		'desc' => 'desc',
		'date' => 'date',
		'time' => 'time',
		'primary' => 'primary_key',
		'foreign'  =>  'foreign_key',
		'datetime' => 'datetime'
	)
);

