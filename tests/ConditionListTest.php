<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Tests;

use MakinaCorpus\ElasticSearchQuery\ConditionList;
use PHPUnit\Framework\TestCase;

final class ConditionListTest extends TestCase
{
    public function testEmpty(): void
    {
        $query = new ConditionList();

        self::assertSame(
            <<<JSON
            []
            JSON,
            \json_encode($query->build(), JSON_PRETTY_PRINT)
        );
    }

    public function testOne(): void
    {
        $query = new ConditionList('query');
        $query->match('some_field', 'one two three');

        self::assertSame(
            <<<JSON
            {
                "match": {
                    "some_field": "one two three"
                }
            }
            JSON,
            \json_encode($query->build(), JSON_PRETTY_PRINT)
        );
    }

    public function testNestedAlone(): void
    {
        $query = new ConditionList();
        $nested = $query->createNestedBool('child_path');
        $nested->must()->term('some_field', 'some_value');

        self::assertSame(
            <<<JSON
            {
                "nested": {
                    "path": "child_path",
                    "query": {
                        "bool": {
                            "must": {
                                "term": {
                                    "some_field": "some_value"
                                }
                            }
                        }
                    }
                }
            }
            JSON,
            \json_encode($query->build(), JSON_PRETTY_PRINT)
        );
    }

    public function testNestedAloneMultiple(): void
    {
        $query = new ConditionList();
        $nested = $query->createNestedBool('child_path');
        $nested->must()->term('some_field', 'some_value');
        $nested->must()->match('some_other', 'some query');

        self::assertSame(
            <<<JSON
            {
                "nested": {
                    "path": "child_path",
                    "query": {
                        "bool": {
                            "must": [
                                {
                                    "term": {
                                        "some_field": "some_value"
                                    }
                                },
                                {
                                    "match": {
                                        "some_other": "some query"
                                    }
                                }
                            ]
                        }
                    }
                }
            }
            JSON,
            \json_encode($query->build(), JSON_PRETTY_PRINT)
        );
    }

    public function testNestedWithOther(): void
    {
        $query = new ConditionList();
        $query->match('some_field', 'one two three');
        $nested = $query->createNestedBool('child_path');
        $nested->must()->term('some_field', 'some_value');

        self::assertSame(
            <<<JSON
            [
                {
                    "match": {
                        "some_field": "one two three"
                    }
                },
                {
                    "nested": {
                        "path": "child_path",
                        "query": {
                            "bool": {
                                "must": {
                                    "term": {
                                        "some_field": "some_value"
                                    }
                                }
                            }
                        }
                    }
                }
            ]
            JSON,
            \json_encode($query->build(), JSON_PRETTY_PRINT)
        );
    }

    public function testMultiple(): void
    {
        $query = new ConditionList();
        $query->match('some_field', 'one two three');
        $query->term('other_field', 12);

        self::assertSame(
            <<<JSON
            [
                {
                    "match": {
                        "some_field": "one two three"
                    }
                },
                {
                    "term": {
                        "other_field": 12
                    }
                }
            ]
            JSON,
            \json_encode($query->build(), JSON_PRETTY_PRINT)
        );
    }
}
