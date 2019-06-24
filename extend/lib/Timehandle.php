<?php 

namespace lib;

	/**
	 * 时间处理
	 */
	class TimeHandle
	{	
		/**
		 * 历史记录时间处理
		 * @param  [type] $time [description]
		 * @return [type]       [description]
		 */
		public static function timeConversion ($time) {
			$time = intval($time);
			switch ($time) {
				case 0:
				case 1:
				$time = time()-(24*3600);
				break;
				case 2:
				$time = time()-(24*3600*7);
				break;
				case 3:
				$time = time()-(24*3600*30);
				break;
			}
			return $time;
		}
	}