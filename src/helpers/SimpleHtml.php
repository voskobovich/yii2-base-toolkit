<?php

namespace voskobovich\base\helpers;

use yii\helpers\Html;

/**
 * Class Html.
 */
class SimpleHtml extends Html
{
    /**
     * @param $name
     *
     * @return string
     */
    public function getIdByName($name): string
    {
        $id = str_replace(['[', ']'], ['_', ''], $name);
        $id = strtolower($id);

        return $id;
    }

    /**
     * @param string $name
     * @param null $selection
     * @param array $items
     * @param array $options
     *
     * @return string
     */
    public static function radioList($name, $selection = null, $items = [], $options = []): string
    {
        $encode = !isset($options['encode']) || $options['encode'];
        $formatter = $options['item'] ?? null;
        $itemOptions = $options['itemOptions'] ?? [];
        $id = !empty($itemOptions['id']) ? $itemOptions['id'] : static::getIdByName($name);
        unset($itemOptions['id']);
        $lines = [];
        $index = 0;
        foreach ($items as $value => $label) {
            $checked = $selection !== null &&
                (false === is_array($selection) && !strcmp($value, $selection)
                    || is_array($selection) && in_array($value, $selection));
            if ($formatter !== null) {
                $lines[] = call_user_func($formatter, $index, $label, $name, $checked, $value);
            } else {
                $lines[] = static::radio($name, $checked, array_merge($itemOptions, [
                    'value' => $value,
                    'label' => $encode ? static::encode($label) : $label,
                    'id' => $id . $index,
                ]));
            }
            ++$index;
        }
        $separator = $options['separator'] ?? "\n";
        if (isset($options['unselect'])) {
            // add a hidden field so that if the list box has no option being selected, it still submits a value
            $hidden = static::hiddenInput($name, $options['unselect']);
        } else {
            $hidden = '';
        }
        $tag = $options['tag'] ?? 'div';
        unset($options['tag'], $options['unselect'], $options['encode'], $options['separator'], $options['item'], $options['itemOptions']);

        return $hidden . static::tag($tag, implode($separator, $lines), $options);
    }

    /**
     * @param string $name
     * @param bool $checked
     * @param array $options
     *
     * @return string
     */
    public static function radio($name, $checked = false, $options = []): string
    {
        $options['checked'] = (bool)$checked;
        $value = array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the radio button is not selected, it still submits a value
            $hidden = static::hiddenInput($name, $options['uncheck']);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }

        if (isset($options['label'])) {
            $label = $options['label'];
            $labelOptions = $options['labelOptions'] ?? [];
            $for = $options['id'] ?? '';
            unset($options['label'], $options['labelOptions']);
            $content = static::input('radio', $name, $value, $options);
            $content .= static::label($label, $for, $labelOptions);

            return $hidden . $content;
        }

        return $hidden . static::input('radio', $name, $value, $options);
    }

    /**
     * @param string $name
     * @param null $selection
     * @param array $items
     * @param array $options
     *
     * @return string
     */
    public static function checkboxList($name, $selection = null, $items = [], $options = []): string
    {
        if (substr($name, -2) !== '[]') {
            $name .= '[]';
        }
        $encode = !isset($options['encode']) || $options['encode'];
        $formatter = $options['item'] ?? null;
        $itemOptions = $options['itemOptions'] ?? [];
        $id = !empty($itemOptions['id']) ? $itemOptions['id'] : static::getIdByName($name);
        unset($itemOptions['id']);
        $lines = [];
        $index = 0;
        foreach ($items as $value => $label) {
            $checked = $selection !== null &&
                (!is_array($selection) && !strcmp($value, $selection)
                    || is_array($selection) && in_array($value, $selection));
            if ($formatter !== null) {
                $lines[] = call_user_func($formatter, $index, $label, $name, $checked, $value);
            } else {
                $lines[] = static::checkbox($name, $checked, array_merge($itemOptions, [
                    'value' => $value,
                    'label' => $encode ? static::encode($label) : $label,
                    'id' => $id . $index,
                ]));
            }
            ++$index;
        }
        if (isset($options['unselect'])) {
            // add a hidden field so that if the list box has no option being selected, it still submits a value
            $name2 = substr($name, -2) === '[]' ? substr($name, 0, -2) : $name;
            $hidden = static::hiddenInput($name2, $options['unselect']);
        } else {
            $hidden = '';
        }
        $separator = $options['separator'] ?? "\n";
        $tag = $options['tag'] ?? 'div';
        unset($options['tag'], $options['unselect'], $options['encode'], $options['separator'], $options['item'], $options['itemOptions']);

        return $hidden . static::tag($tag, implode($separator, $lines), $options);
    }

    /**
     * @param string $name
     * @param bool $checked
     * @param array $options
     *
     * @return string
     */
    public static function checkbox($name, $checked = false, $options = []): string
    {
        $options['checked'] = (bool)$checked;
        $value = array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hidden = static::hiddenInput($name, $options['uncheck']);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }

        if (isset($options['label'])) {
            $label = $options['label'];
            $labelOptions = $options['labelOptions'] ?? [];
            $for = $options['id'] ?? '';
            unset($options['label'], $options['labelOptions']);
            $content = static::input('checkbox', $name, $value, $options);
            $content .= static::label($label, $for, $labelOptions);

            return $hidden . $content;
        }

        return $hidden . static::input('checkbox', $name, $value, $options);
    }
}
