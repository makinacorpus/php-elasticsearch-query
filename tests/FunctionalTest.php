<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Tests;

use PHPUnit\Framework\TestCase;
use MakinaCorpus\ElasticSearchQuery\RootBoolQuery;

final class FunctionalTest extends TestCase
{
    public function testSomeRealUseCase(): void
    {
        $query = new RootBoolQuery();
        $query->must()->term('statut', 20);
        $nested = $query->must()->createNestedBool('statut_histo');
        $nested->must()->term('statut_histo.statut', 23);
        $query->size(100);
        $query->from(0);
        $query->trackTotalHits();
        $query->sort('pushed_at');
        $query->sort('created_at');

        self::assertSame(
            <<<JSON
            {
                "query": {
                    "bool": {
                        "must": [
                            {
                                "term": {
                                    "statut": 20
                                }
                            },
                            {
                                "nested": {
                                    "path": "statut_histo",
                                    "query": {
                                        "bool": {
                                            "must": {
                                                "term": {
                                                    "statut_histo.statut": 23
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        ]
                    }
                },
                "from": 0,
                "size": 100,
                "track_total_hits": true,
                "sort": {
                    "pushed_at": {
                        "order": "asc"
                    },
                    "created_at": {
                        "order": "asc"
                    }
                }
            }
            JSON,
            \json_encode($query->build(), JSON_PRETTY_PRINT)
        );
    }
}
