<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery;

use MakinaCorpus\ElasticSearchQuery\Condition\ExistsCondition;
use MakinaCorpus\ElasticSearchQuery\Condition\FieldCondition;
use MakinaCorpus\ElasticSearchQuery\Condition\MatchCondition;
use MakinaCorpus\ElasticSearchQuery\Condition\RangeCondition;
use MakinaCorpus\ElasticSearchQuery\Condition\TermCondition;
use MakinaCorpus\ElasticSearchQuery\Condition\TermsCondition;
use MakinaCorpus\ElasticSearchQuery\Query\NestedBoolQuery;

/**
 * Clause is an arbitrary collection of conditions.
 */
class ConditionList extends Expression
{
    /**
     * @var Expression[]
     */
    private array $conditions = [];

    /**
     * Get all conditions.
     *
     * @return Expression[]
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * Add arbitrary condition, allow you to extend this API.
     */
    public function addCondition(Expression $condition): void
    {
        foreach ($this->conditions as $existing) {
            if ($condition === $existing) {
                return;
            }
        }
        $this->conditions[] = $condition;
    }

    public function createNestedBool(string $path): NestedBoolQuery
    {
        $condition = new NestedBoolQuery($path);
        $this->addCondition($condition);

        return $condition;
    }

    public function createTerm(string $field, mixed $value): FieldCondition
    {
        if (\is_array($value)) {
            $condition = new TermsCondition($field, $value);
        } else {
            $condition = new TermCondition($field, $value);
        }
        $this->addCondition($condition);

        return $condition;
    }

    /**
     * @return $this
     */
    public function term(string $field, mixed $value): self
    {
        $this->createTerm($field, $value);

        return $this;
    }

    public function createExists(string $field): Condition
    {
        $condition = new ExistsCondition($field);
        $this->addCondition($condition);

        return $condition;
    }

    /**
     * @return $this
     */
    public function exists(string $field): self
    {
        $this->createExists($field);

        return $this;
    }

    public function createMatch(string $field, string $query): MatchCondition
    {
        $condition = new MatchCondition($field, $query);
        $this->addCondition($condition);

        return $condition;
    }

    /**
     * @return $this
     */
    public function match(string $field, string $query): self
    {
        $this->createMatch($field, $query);

        return $this;
    }

    public function createRange(string $field, mixed $from = null, mixed $to = null, bool $inclusive = false): Condition
    {
        $condition = new RangeCondition($field, $from, $to, $inclusive);
        $this->addCondition($condition);

        return $condition;
    }

    /**
     * @return $this
     */
    public function range(string $field, mixed $from = null, mixed $to = null, bool $inclusive = false): self
    {
        $this->createRange($field, $from, $to, $inclusive);

        return $this;
    }

    /**
     * Allow extenders to preprocess or validate field name.
     */
    protected function validateField(string $field): string
    {
        return $field;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        if (!$this->conditions) {
            // {} will be the resulting JSON of \stdClass.
            return [];
        }
        if (1 === \count($this->conditions)) {
            return $this->conditions[0]->build();
        }
        return Expression::buildArray($this->conditions);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return !$this->conditions;
    }
}
