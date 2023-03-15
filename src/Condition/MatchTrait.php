<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

use MakinaCorpus\ElasticSearchQuery\Query\ArbitraryTrait;

trait MatchTrait
{
    use ArbitraryTrait;

    /**
     * @return $this
     */
    public function allowLeadingWildcard(bool $value): self
    {
        $this->arbitrary('allow_leading_wildcard', $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function analyzeWildcard(bool $value): self
    {
        $this->arbitrary('analyze_wildcard', $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function fuzziness(?int $value): self
    {
        $this->arbitrary('fuzziness', null === $value ? 'AUTO' : $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function fuzzyTranspositions(bool $value): self
    {
        $this->arbitrary('fuzzy_transpositions', $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function fuzzyMaxExpansions(int $value): self
    {
        $this->arbitrary('fuzzy_max_expansions', $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function boost(float $value): self
    {
        $this->arbitrary('boost', $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function enablePositionIncrements(bool $value): self
    {
        $this->arbitrary('enable_position_increments', $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function flags(array $value): self
    {
        $this->arbitrary('flags', \implode('|', $value));

        return $this;
    }

    /**
     * @return $this
     */
    public function lenient(bool $value): self
    {
        $this->arbitrary('lenient', $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function lowFreqOperator(string $value): self
    {
        $this->arbitrary('low_freq_operator', $value);

        return $this;
    }

    // ...
}
