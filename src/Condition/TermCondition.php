<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

class TermCondition extends FieldCondition
{
    private mixed $value;

    public function __construct(string $field, mixed $value)
    {
        parent::__construct($field);

        if (!\is_int($value) && !\is_float($value) && !\is_string($value) && !\is_bool($value)) {
            if (\is_object($value) && $value instanceof \Stringable) {
                $value = (string) $value;
            } else {
                throw new \InvalidArgumentException('"term" query only supports bool, int, float and string values.');
            }
        }
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $arbitrary = $this->getArbitraryProperties();

        if ($arbitrary) {
            return [
                'term' => [
                    $this->getField() => [
                        'value' => $this->value,
                    ] + $arbitrary,
                ],
            ];
        }

        return [
            'term' => [
                $this->getField() => $this->value,
            ],
        ];
    }
}
