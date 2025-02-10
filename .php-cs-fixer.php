<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$excludes = [
    'vendor',
    'bootstrap',
    'public',
    'resources',
    'storage',
];

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude($excludes)
    ->name('*.php')
    ->notName('*.blade.php')
    ->notName('_ide_helper.php')
    ->notName('README.md')
    ->notName('*.xml')
    ->notName('*.yml')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12'                 => true,
        '@PHP81Migration'        => true,
        '@PhpCsFixer'            => true,
        'array_indentation'      => true,
        'array_syntax'           => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
        ],
        'blank_line_after_namespace'   => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement'  => [
            'statements' => ['return'],
        ],
        'cast_spaces'                 => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'class_definition' => [
            'single_item_single_line'  => true,
            'single_line'              => true,
            'space_before_parenthesis' => true,
        ],
        'compact_nullable_type_declaration' => true,
        'concat_space'                      => [
            'spacing' => 'one',
        ],
        'constant_case'                => ['case' => 'lower'],
        'declare_equal_normalize'      => true,
        'elseif'                       => true,
        'encoding'                     => true,
        'full_opening_tag'             => true,
        'fully_qualified_strict_types' => true, // added by Shift
        'function_declaration'         => true,
        'type_declaration_spaces'      => true,
        'general_phpdoc_tag_rename'    => true,
        'heredoc_to_nowdoc'            => true,
        'include'                      => true,
        'increment_style'              => ['style' => 'post'],
        'indentation_type'             => true,
        'linebreak_after_opening_tag'  => true,
        'line_ending'                  => true,
        'lowercase_cast'               => true,
        'lowercase_keywords'           => true,
        'lowercase_static_reference'   => true, // added from Symfony
        'method_argument_space'        => [
            'on_multiline' => 'ignore',
        ],
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'native_function_casing' => true,
        'new_with_parentheses'   => [
            'named_class'     => true,
            'anonymous_class' => false,
        ],
        'no_extra_blank_lines'               => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc'        => true,
        'no_closing_tag'                     => true,
        'no_empty_phpdoc'                    => true,
        'no_empty_statement'                 => true,
        'no_leading_import_slash'            => true,
        'no_leading_namespace_whitespace'    => true,
        'no_mixed_echo_print'                => [
            'use' => 'echo',
        ],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast'                          => true,
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_spaces_after_function_name'               => true,
        'no_spaces_around_offset'                     => [
            'positions' => ['inside', 'outside'],
        ],
        'spaces_inside_parentheses'         => true,
        'no_trailing_comma_in_singleline'   => true,
        'no_trailing_whitespace'            => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_unneeded_control_parentheses'   => [
            'statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
        ],
        'no_unused_imports'                   => true,
        'no_useless_else'                     => true,
        'no_useless_return'                   => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line'         => true,
        'normalize_index_brace'               => true,
        'not_operator_with_successor_space'   => true,
        'object_operator_without_whitespace'  => true,
        'ordered_imports'                     => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
        'phpdoc_align'                        => [
            'align' => 'left',
        ],
        'phpdoc_scalar'                                 => true,
        'phpdoc_single_line_var_spacing'                => true,
        'phpdoc_summary'                                => true,
        'phpdoc_to_comment'                             => false,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types'                                  => true,
        'phpdoc_var_without_name'                       => true,
        'return_type_declaration'                       => true,
        'short_scalar_cast'                             => true,
        'simplified_null_return'                        => false, // disabled as "risky"
        'single_blank_line_at_eof'                      => true,
        'single_class_element_per_statement'            => [
            'elements' => ['const', 'property'],
        ],
        'single_import_per_statement' => true,
        'single_line_after_imports'   => true,
        'single_line_comment_style'   => [
            'comment_types' => ['hash'],
        ],
        'single_quote'                      => true,
        'single_trait_insert_per_statement' => true,
        'space_after_semicolon'             => true,
        'standardize_not_equals'            => true,
        'switch_case_semicolon_to_colon'    => true,
        'switch_case_space'                 => true,
        'ternary_operator_spaces'           => true,
        'ternary_to_null_coalescing'        => true,
        'trailing_comma_in_multiline'       => true,
        'trim_array_spaces'                 => true,
        'unary_operator_spaces'             => true,
        'visibility_required'               => true,
        'whitespace_after_comma_in_array'   => true,
        'yoda_style'                        => false,

        'single_space_around_construct'           => true,
        'control_structure_braces'                => true,
        'braces_position'                         => true,
        'control_structure_continuation_position' => true,
        'declare_parentheses'                     => true,
        'statement_indentation'                   => true,
        'no_multiple_statements_per_line'         => true,

        // ignored from @PhpCsFixer
        'multiline_comment_opening_closing' => false,
        'php_unit_method_casing'            => ['case' => 'snake_case'],
        'global_namespace_import'           => false,

        // ignored from @PHP81Migration
        'octal_notation' => false,

        // risky
        'use_arrow_functions'                 => true,
        'modernize_strpos'                    => true,
        'array_push'                          => true,
        'ereg_to_preg'                        => true,
        'set_type_to_cast'                    => true,
        'psr_autoloading'                     => true,
        'modernize_types_casting'             => true,
        'no_php4_constructor'                 => true,
        'self_accessor'                       => true,
        'get_class_to_class_keyword'          => true,
        'php_unit_construct'                  => true,
        'php_unit_namespaced'                 => true,
        'php_unit_test_class_requires_covers' => false,
    ]);
