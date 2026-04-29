<?php

use Illuminate\Support\Str;


if (!function_exists('generateSlug')) {
    /**
     * Generate slug from text
     * @param string $text - Text to convert to slug
     * @param string $separator - Separator character (default: '-')
     * @param string $language - Language locale (default: 'id' for Indonesian)
     * @return string
     */
    function generateSlug($text, $separator = '-', $language = 'id')
    {
        return Str::slug($text, $separator, $language);
    }
}

if (!function_exists('autoGenerateSlug')) {
    /**
     * Auto-generate slug from name/title if empty
     * @param string $slug - Current slug value
     * @param string $name - Name or title to generate slug from
     * @return string
     */
    function autoGenerateSlug($slug, $name)
    {
        if (empty($slug) && !empty($name)) {
            return generateSlug($name);
        }
        return $slug;
    }
}

if (!function_exists('sanitizeHtml')) {
    /**
     * Sanitize and display HTML content safely
     * Removes potentially dangerous tags and attributes while preserving formatting
     * @param string $html - Raw HTML content to sanitize
     * @param array $allowedTags - Tags to allow (default: common formatting tags)
     * @return string - Sanitized HTML safe for display
     */
    function sanitizeHtml($html, $allowedTags = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 'ol', 'ul', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'a', 'img'])
    {
        if (empty($html)) {
            return '';
        }

        // Build allowed tags string for strip_tags
        $tagString = '<' . implode('><', $allowedTags) . '>';

        // Strip disallowed tags
        $html = strip_tags($html, $tagString);

        // Remove dangerous attributes from allowed tags
        $html = preg_replace('/(on\w+)\s*=\s*["\']?[^"\']*["\']?/i', '', $html);
        $html = preg_replace('/javascript:/i', '', $html);
        $html = preg_replace('/data:/i', '', $html);

        return $html;
    }
}

if (!function_exists('displayHtml')) {
    /**
     * Display HTML content safely in Blade templates
     * Use with {!! displayHtml($content) !!} in Blade files
     * @param string $html - Raw HTML content to display
     * @return \Illuminate\Support\HtmlString - Safe HTML string for output
     */
    function displayHtml($html)
    {
        return new \Illuminate\Support\HtmlString(sanitizeHtml($html));
    }
}
