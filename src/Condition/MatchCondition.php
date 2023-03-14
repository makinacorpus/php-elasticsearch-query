<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

class MatchCondition extends FieldCondition
{
    use MatchTrait;

    private string $query;

    public function __construct(string $field, string $query)
    {
        parent::__construct($field);

        $this->query = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $arbitrary = $this->getArbitraryProperties();

        if ($arbitrary) {
            return [
                'match' => [
                    $this->getField() => [
                        'query' => $this->query,
                    ] + $arbitrary,
                ],
            ];
        }

        return [
            'match' => [
                $this->getField() => $this->query,
            ],
        ];
    }
}
