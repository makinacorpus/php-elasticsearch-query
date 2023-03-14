<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

class RangeCondition extends FieldCondition
{
    private mixed $from = null;
    private mixed $fromInclusive = false;
    private mixed $to = null;
    private mixed $toInclusive = false;

    public function __construct(string $field, mixed $from = null, mixed $to = null, bool $inclusive = false)
    {
        parent::__construct($field);

        $this->from = $from;
        $this->fromInclusive = $inclusive;
        $this->to = $to;
        $this->toInclusive = $inclusive;
    }

    /**
     * @return $this
     */
    public function lessThan(mixed $to): self
    {
        $this->to = $to;
        $this->toInclusive = false;
    }

    /**
     * @return $this
     */
    public function lessOrEqualThan(mixed $to): self
    {
        $this->to = $to;
        $this->toInclusive = true;
    }

    /**
     * @return $this
     */
    public function greaterThan(mixed $from): self
    {
        $this->from = $from;
        $this->fromInclusive = false;
    }

    /**
     * @return $this
     */
    public function greaterOrEqualThan(mixed $from): self
    {
        $this->from = $from;
        $this->fromInclusive = true;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $opLess = $this->toInclusive ? 'lte' : 'lt';
        $opGreater = $this->fromInclusive ? 'gte' : 'gt';

        if ($this->from && $this->to) {
            if ($this->from < $this->to) {
                $range = [$opGreater => $this->from, $opLess => $this->to];
            } else {
                $range = [$opGreater => $this->to, $opLess => $this->from];
            }
        } else if ($this->from) {
            $range = [$opGreater => $this->from];
        } else if ($this->to) {
            $range = [$opLess => $this->to];
        } else {
            throw new \InvalidArgumentException('"range" query must have a from or a to value.');
        }

        return [
            'range' => [
                $this->getField() => $range + $this->getArbitraryProperties(),
            ],
        ];
    }
}
