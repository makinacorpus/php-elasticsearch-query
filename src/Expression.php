<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery;

abstract class Expression
{
    /**
     * Build all given expressions as an array.
     */
    public static function buildArray(array $expressions): array
    {
        return \array_map(fn (Expression $expression) => $expression->build(), $expressions);
    }

    /**
     * Build all given expression by merging their arrays.
     */
    public static function buildMerge(array $expressions): array
    {
        return \array_merge(self::buildArray($expressions));
    }

    /**
     * Is this expression empty.
     *
     * Empty expression will be skipped from output.
     */
    abstract public function isEmpty(): bool;

    /**
     * Build final JSON object as a PHP array.
     */
    abstract public function build(): array;
}
