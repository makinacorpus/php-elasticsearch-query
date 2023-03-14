<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

use MakinaCorpus\ElasticSearchQuery\Condition;

abstract class FieldCondition extends Condition
{
    private string $field;

    /**
     * @param mixed $value
     *   Value must be JSON serializable.
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * Get field.
     */
    protected function getField(): string
    {
        return $this->field;
    }
}
