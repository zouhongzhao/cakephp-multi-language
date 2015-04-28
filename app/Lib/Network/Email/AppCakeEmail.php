<?php
App::uses('CakeEmail', 'Network/Email');

class AppCakeEmail extends CakeEmail {
	protected $_from = array(ADMIN_EMAIL =>ADMIN_NAME);
	public function subject($subject = null) {
		if ($subject === null) {
			return $this->_subject;
		}
		$this->_subject =  __(EMAIL_TITLE_PREFIX) . $this->_encode((string)$subject);
		return $this;
	}
	public function send($content = null) {
		if (empty($this->_from)) {
			throw new SocketException(__d('cake_dev', 'From is not specified.'));
		}
		if (empty($this->_to) && empty($this->_cc) && empty($this->_bcc)) {
			throw new SocketException(__d('cake_dev', 'You need to specify at least one destination for to, cc or bcc.'));
		}

		if (is_array($content)) {
			$content = implode("\n", $content) . "\n";
		}

		$this->_textMessage = $this->_htmlMessage = '';
		$this->_createBoundary();
		$this->_message = $this->_render($this->_wrap($content));

		$contents = $this->transportClass()->send($this);
		if (!empty($this->_config['log'])) {
			$level = LOG_DEBUG;
			if ($this->_config['log'] !== true) {
				$level = $this->_config['log'];
			}
			$to = $cc = $bcc = '';
			if (!empty($this->_to)) {
				$to = PHP_EOL . 'To:' . implode(',', $this->_to);
			}
			if (!empty($this->_cc)) {
				$cc = PHP_EOL . 'Cc:' . implode(',', $this->_cc);
			}
			if (!empty($this->_bcc)) {
				$bcc = PHP_EOL . 'Bcc:' . implode(',', $this->_bcc);
			}
			if (!empty($this->_subject)) {
				$subject = PHP_EOL . 'Subject:' . $this->_subject;
			}
			CakeLog::write($level, $to . $cc . $bcc . $subject . PHP_EOL . $contents['headers'] . PHP_EOL . $contents['message']);
		}
		return $contents;
	}
}