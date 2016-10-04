<?php

namespace luya\tag;

/**
 * TagInterface for all LUYA Tags
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-rc1
 */
interface TagInterface
{
    /**
     * Provide a single example tag which is used as value when clicking on an tag in the administration interface
     * in order to insert the tag at the texteditor location.
     *
     * @return string The example string like `mail[info@luya.io](Mail us!)`.
     */
    public function example();
    
    /**
     * Get the readme informations of the current tag, markdown syntax is allowed.
     *
     * @return string The readme string with allowed markdown syntax.
     */
    public function readme();

    /**
     * Parse the the values of the tag into your output text.
     *
     * Assuming the following tag value `mytag[Hello](John Doe)`, the values are injected to `parse()` as following
     *
     * + **Hello** represents `$value` of the parse method.
     * + **John Doe** represents `$sub` of parse method.
     *
     * The `$sub` variables can also be null and is not required by any tag. Assuming `mytag[Hello]` means that `$sub` is null.
     *
     * The output of `parse()` is what will be replaced withing this tag. Assuming the above example `mytag[Hello](John Doe)` with the
     * parse logic:
     *
     * ```php
     * public function parse($value, $sub)
     * {
     *     return "{$value}, {$sub}";
     * }
     * ```
     *
     * Woud replace and return tag with **Hello, John Doe**.
     *
     * @param string $value The value of the tag enclosed by square bracket `[]`
     * @param string|null $sub The optional value of the tag enclise by round bracket `()`, is not required by tag. If not provided equals `null`.
     * @return string The new generated string of the Tag.
     */
    public function parse($value, $sub);
}
