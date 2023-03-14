<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery;

use MakinaCorpus\ElasticSearchQuery\Query\ArbitraryTrait;

abstract class Condition extends Expression
{
    use ArbitraryTrait;

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return false;
    }
}
