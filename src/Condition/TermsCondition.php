<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

class TermsCondition extends FieldCondition
{
    private array $values;

    public function __construct(string $field, array $values)
    {
        parent::__construct($field);

        foreach ($values as $index => $value) {
            if (!\is_int($value) && !\is_float($value) && !\is_string($value) && !\is_bool($value)) {
                if (\is_object($value) && $value instanceof \Stringable) {
                    $values[$index] = (string) $value;
                } else {
                    throw new \InvalidArgumentException('"terms" query only supports bool, int, float and string values.');
                }
            }
        }
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        // arbitrary values?

        return [
            'terms' => [
                $this->getField() => \array_values($this->values)
            ],
        ];
    }
}
