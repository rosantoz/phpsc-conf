<?php

namespace PHPSC\Conference\EmailTemplate;

class Registration extends \Swift_Message
{
	public function __construct($placeholders = array())
	{
		$html = '<p>Olá {{user_name}},</p><p>Recebemos sua inscrição para o {{event_name}} que ocorre entre {{date_start}} e {{date_end}}. A inscrição só é válida após a confirmação da instituição financeira.</p><p>Atenciosamente,<br />Coordenação PHPSC.</p>';
		
		foreach ($placeholders as $key => $value) {
			$html = str_replace("{{{$key}}}", $value, $html);
		}

		parent::__construct($placeholders['event_name'] . ': Inscrição recebida', $html, 'text/html', 'UTF-8');
	}
}