<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Query;

use MakinaCorpus\ElasticSearchQuery\BoolQuery;

class NestedBoolQuery extends BoolQuery
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        return [
            'nested' => [
                'path' => $this->path,
                'query' => parent::build(),
            ],
        ];
    }
}
