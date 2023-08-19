<?php

namespace App\Traits;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait TranslatorTrait
{
	protected TranslatorInterface $translator;

	#[Required]
	public function setTranslator(TranslatorInterface $translator): void
	{
		$this->translator = $translator;
	}
}