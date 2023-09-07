<?php

namespace Core\Form;

use Core\Form\FormError;

class FormResult
{
    //on crée un tableau pour stocker les erreurs
    private array $form_errors = [];

    //constructeur avec un paramètre par default
    public function __construct(private string $success_message = '')
    {
    }

    public function getSuccessMessage(): string
    {
        return $this->success_message;
    }

    public function getErrors(): array
    {
        return $this->form_errors;
    }

    public function hasError(): bool
    {
        return !empty($this->form_errors);
    }

    public function addError(FormError $error)
    {
        $this->form_errors[] = $error;
    }
}
