<?php
function json_encode_custom($a = false, $forceObject = false) {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';

    if (is_scalar($a)) {
        if (is_float($a)) {
            // Always use "." for floats.
            return floatval(str_replace(",", ".", strval($a)));
        }

        if (is_string($a)) {
            static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
            return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
        } else {
            return $a;
        }
    }
    if (!$forceObject) {
        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
            if (key($a) !== $i) {
                $isList = false;
                break;
            }
        }
    } else {
        $isList = false;
    }
    $result = array();
    if ($isList) {
        foreach ($a as $v) $result[] = json_encode_custom($v);
        return '[' . join(',', $result) . ']';
    } else {
        foreach ($a as $k => $v) $result[] = json_encode_custom($k, $forceObject).':'.json_encode_custom($v, $forceObject);
        return '{' . join(',', $result) . '}';
    }
}