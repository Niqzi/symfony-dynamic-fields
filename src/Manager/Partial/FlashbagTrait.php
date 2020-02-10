<?php

namespace App\Manager\Partial;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

trait FlashbagTrait
{
    private ?FlashBagInterface $flashbag = null;

    private ?TranslatorInterface $translator = null;

    public function setFlashbag(FlashBagInterface $flashbag): void
    {
        $this->flashbag = $flashbag;
    }

    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    protected function addFlash(string $type, string $message, array $parameters = [], string $domain = 'flashbag'): void
    {
        if (null !== $this->translator) {
            $message = $this->translator->trans($message, $parameters, $domain);
        }

        $this->flashbag->set($type, $message);
    }
}
