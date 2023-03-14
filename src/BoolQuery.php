<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery;

class BoolQuery extends Expression
{
    const OP_FILTER = "filter";
    const OP_MUST = "must";
    const OP_MUST_NOT = "must_not";
    const OP_SHOULD = "should";
    const OP_SHOULD_NOT = "should_not";

    /**
     * @var ConditionList[]
     */
    private array $conditions = [];

    public function filter(): ConditionList
    {
        return $this->getConditionList(self::OP_FILTER);
    }

    public function should(): ConditionList
    {
        return $this->getConditionList(self::OP_SHOULD);
    }

    public function shouldNot(): ConditionList
    {
        return $this->getConditionList(self::OP_SHOULD_NOT);
    }

    public function must(): ConditionList
    {
        return $this->getConditionList(self::OP_MUST);
    }

    public function mustNot(): ConditionList
    {
        return $this->getConditionList(self::OP_MUST_NOT);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        foreach ($this->conditions as $query) {
            if (!$query->isEmpty()) {
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $body = [];
        foreach ($this->conditions as $type => $list) {
            if (!$list->isEmpty()) {
                $body[$type] = $list->build();
            }
        }
        if ($body) {
            return ['bool' => $body];
        }
        return \stdClass();
    }

    /**
     * Get nested query.
     */
    private function getConditionList(string $type)
    {
        return $this->conditions[$type] ?? ($this->conditions[$type] = new ConditionList());
    }
}
