<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery;

use MakinaCorpus\ElasticSearchQuery\Query\RootQueryTrait;

class RootBoolQuery extends BoolQuery
{
    use RootQueryTrait;

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        if ($this->isEmpty()) {
            $query = [
                'match_all' => new \stdClass(),
            ];
        } else {
            $query = parent::build();
        }

        return ['query' => $query] + $this->buildRootProperties() + $this->getArbitraryProperties();
    }
}
