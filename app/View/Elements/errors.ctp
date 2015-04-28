<?php 
$html = '';
foreach ((array)$errors as $validationError) {
	if(is_array($validationError)){
		foreach ($validationError as $error){
			$html .= '<li><p class="text-danger">'.$error.'</p></li>';//$this->Html->tag('li', $error);
		}
	}else{
		$html .= '<li><p class="text-danger">'.$validationError.'</p></li>';//$this->Html->tag('li', $validationError,array('class' => 'text-danger'));
	}
}
echo $this->Html->tag('ul', $html,array('class' => 'list-unstyled'));
?>
