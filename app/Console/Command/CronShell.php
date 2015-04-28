<?php
class CronShell extends AppShell {
	public function array_splice_assoc(&$input, $offset, $length = 0, $replacement = array()) {
		$replacement = (array) $replacement;
		$key_indices = array_flip(array_keys($input));
		if (isset($input[$offset]) && is_string($offset)) {
			$offset = $key_indices[$offset] + 1;
		}
		if (isset($input[$length]) && is_string($length)) {
			$length = $key_indices[$length] - $offset;
		}
		$input = array_slice($input, 0, $offset, TRUE)
		+ $replacement
		+ array_slice($input, $offset + $length, NULL, TRUE);
		return $input;
	}
}