<?php

declare(strict_types=1);

namespace League\Tactician\Validator;

use League\Tactician\Exception\Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidCommandException extends \Exception implements Exception
{
    /**
     * @var object
     */
    private $command;

    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public static function onCommand($command, ConstraintViolationListInterface $violations) : InvalidCommandException
    {
        $exception = new static(\sprintf(
            'Validation failed for %s with %d violation(s).',
            \get_class($command),
            $violations->count()
        ));

        $exception->command = $command;
        $exception->violations = $violations;

        return $exception;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getViolations() : ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
