<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Query;

trait RootQueryTrait
{
    use ArbitraryTrait;

    private array $sorts = [];
    private ?bool $trackTotalHits;
    private ?int $from = null;
    private ?int $size = null;

    /**
     * @return $this
     */
    public function trackTotalHits(?bool $value = true): self
    {
        $this->trackTotalHits = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function from(?int $value): self
    {
        $this->from = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function size(?int $value): self
    {
        $this->size = $value;

        return $this;
    }

    public function createSort(string $field, string $order = Sort::ORDER_ASC): Sort
    {
        return $this->sorts[$field] = new Sort($order);
    }

    /**
     * @return $this
     */
    public function sort(string $field, string $order = Sort::ORDER_ASC): self
    {
        $this->createSort($field, $order);

        return $this;
    }

    protected function buildRootProperties(): array
    {
        $ret = [];
        if (null !== $this->from) {
            $ret['from'] = $this->from;
        }
        if (null !== $this->size) {
            $ret['size'] = $this->size;
        }
        if (null !== $this->trackTotalHits) {
            $ret['track_total_hits'] = $this->trackTotalHits;
        }
        if ($this->sorts) {
            foreach ($this->sorts as $field => $sort) {
                $ret['sort'][$field] = $sort->build();
            }
        }

        return $ret;
    }
}
