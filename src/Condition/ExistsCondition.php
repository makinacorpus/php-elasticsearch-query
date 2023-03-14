<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

class ExistsCondition extends FieldCondition
{
    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        return [
            'exists' => [
                'field' => $this->getField(),
            ] + $this->getArbitraryProperties(),
        ];
    }
}
