<?php

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        '-psr0',
        'ordered_use',
        'unused_use',
        'remove_lines_between_uses',
        'remove_leading_slash_use',
        'phpdoc_no_empty_return',
        'phpdoc_params',
        'phpdoc_to_comment',
        'phpdoc_order',
        'short_array_syntax',
        'single_array_no_trailing_comma',
        'multiline_array_trailing_comma',
        'concat_without_spaces',
        'single_quote',
        'ternary_spaces',
        'operators_spaces',
        'new_with_braces',
    ])
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in(__DIR__.'/app')
            ->in(__DIR__.'/tests')
    );
