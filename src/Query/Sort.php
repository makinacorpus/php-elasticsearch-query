<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Query;

use MakinaCorpus\ElasticSearchQuery\Expression;

class Sort extends Expression
{
    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    use ArbitraryTrait;

    private string $order = self::ORDER_ASC;

    public function __construct(string $order = self::ORDER_ASC)
    {
        $this->order = $order;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        return ['order' => $this->order === self::ORDER_DESC ? 'desc' : 'asc'] + $this->getArbitraryProperties();
    }
}
