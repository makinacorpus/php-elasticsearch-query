# ElasticSearch 7.x / OpenSearch query builder

This is very small query builder for ElasticSearch and OpenSearch, mostly
opiniated around building *bool* queries.

A simple example:

```php
// Create a query.
$query = new RootBoolQuery();

// Add some filters.
$query->must()->term('statut', 20);

// Create a nested bool query, for nested objects.
$nested = $query->must()->createNestedBool('statut_histo');
$nested->must()->term('statut_histo.statut', 23);

// Set some query options.
$query->size(100);
$query->from(0);
$query->trackTotalHits();

// Add some sorts.
$query->sort('pushed_at');
$query->sort('created_at');

\json_encode($query->build(), JSON_PRETTY_PRINT);
```

Which will generated the follwoing JSON:

```json
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
```

More documentation may come later.
