<?php

namespace lib;
/**
 * 配置文件重写
 */
class FilesReplace 
{	
	/**
	 * 过滤
	 * @return [type] [description]
	 */
	public static function strip_whitespace($content) {
		$stripStr   = '';
    		//分析php源码
		$tokens     = token_get_all($content);
		$last_space = false;
		for ($i = 0, $j = count($tokens); $i < $j; $i++) {
			if (is_string($tokens[$i])) {
				$last_space = false;
				$stripStr  .= $tokens[$i];
			} else {
				switch ($tokens[$i][0]) {
                //过滤各种PHP注释
					case T_COMMENT:
					case T_DOC_COMMENT:
					break;
                //过滤空格
					case T_WHITESPACE:
					if (!$last_space) {
						$stripStr  .= ' ';
						$last_space = true;
					}
					break;
					case T_START_HEREDOC:
					$stripStr .= "<<<THINK\n";
					break;
					case T_END_HEREDOC:
					$stripStr .= "THINK;\n";
					for($k = $i+1; $k < $j; $k++) {
						if(is_string($tokens[$k]) && $tokens[$k] == ';') {
							$i = $k;
							break;
						} else if($tokens[$k][0] == T_CLOSE_TAG) {
							break;
						}
					}
					break;
					default:
					$last_space = false;
					$stripStr  .= $tokens[$i][1];
				}
			}
		}
		return $stripStr;
	}
	/**
	 * [写入文档]
	 * @param [type] $name  [description]
	 * @param string $value [description]
	 * @param [type] $path  [description]
	 */
	public static function writeInConf ($name, $value='', $path=DATA_PATH) {
		static $_cache  = array();
		$filename       = $path . $name . '.php';
		if ('' !== $value) {
			if (is_null($value)) {
            // 删除缓存
				return false !== strpos($name,'*')?array_map("unlink", glob($filename)):unlink($filename);
			} else {
            // 缓存数据
				$dir            =   dirname($filename);
            // 目录不存在则创建
				if (!is_dir($dir))
					mkdir($dir,0755,true);
				$_cache[$name]  =   $value;
				return file_put_contents($filename, self::strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
			}
		}
		if (isset($_cache[$name]))
			return $_cache[$name];
    // 获取缓存数据
		if (is_file($filename)) {
			$value          =   include $filename;
			$_cache[$name]  =   $value;
		} else {
			$value          =   false;
		}
		return $value;
	}
}