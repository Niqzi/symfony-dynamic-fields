<?php

namespace App\Manager\Partial;

use Symfony\Component\Form\FormFactoryInterface;

trait FormTrait
{
    private FormFactoryInterface $formFactory;

    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function createForm($type, $data = null, array $options = [])
    {  
       return $this->formFactory->create($type, $data, $options);
    }
}
