<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Query;

trait ArbitraryTrait
{
    private array $arbitrary = [];

    /**
     * Add arbitrary property.
     *
     * Almost everything you write in ElasticSearch query is a JSON object
     * until the bottom, which is the user given scalar value.
     *
     * At any moment, on any object, this allows you to add arbitrary
     * data in the query, in case this API does not handle it.
     *
     * @return $this
     */
    public function arbitrary(string $name, mixed $value): self
    {
        // @todo fail if override?
        $this->arbitrary[$name] = $value;

        return $this;
    }

    /**
     * Get arbitrary properties.
     */
    protected function getArbitraryProperties(): array
    {
        return $this->arbitrary;
    }
}
