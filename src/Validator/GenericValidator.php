<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GenericValidator
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateEntity($data): ?array
    {
        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            $messages = [];
            /** @var ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }
            return $messages;
        }

        return null;
    }
}
