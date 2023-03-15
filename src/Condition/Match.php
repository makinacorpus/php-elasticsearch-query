<?php

declare (strict_types=1);

namespace MakinaCorpus\ElasticSearchQuery\Condition;

interface Match
{
    const FLAG_ALL = 'ALL';
    const FLAG_AND = 'AND';
    const FLAG_NOT = 'NOT';
    const FLAG_OR = 'OR';

    const LOW_FREQ_OR = 'or';
    const LOW_FREQ_AND = 'and';
}
