<?php

/**
 * Validate data based on rules
 */
function validate(array $rules, array $data): array
{
    $errors = [];

    foreach ($rules as $field => $rulesArray) {
        foreach ($rulesArray as $rule) {
            $ruleErrors = applyRule($field, $rule, $data);
            if (!empty($ruleErrors)) {
                $errors[$field] = array_merge($errors[$field] ?? [], $ruleErrors);
            }
        }
    }

    return $errors;
}

/**
 * Apply single rule to field
 */
function applyRule(string $field, string $rule, array $data): array
{
    [$ruleName, $param] = array_pad(explode(':', $rule, 2), 2, null);
    $value = trim($data[$field] ?? '');
    $errors = [];

    switch ($ruleName) {

        case 'required':
            if ($value === '') {
                $errors[] = "The $field field is required.";
            }
            break;

        case 'string':
            if ($value !== '' && !is_string($value)) {
                $errors[] = "The $field must be a string.";
            }
            break;

        case 'email':
            if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "The $field must be a valid email.";
            }
            break;

        case 'min':
            if ($value !== '' && strlen($value) < (int)$param) {
                $errors[] = "The $field must be at least $param characters.";
            }
            break;

        case 'max':
            if ($value !== '' && strlen($value) > (int)$param) {
                $errors[] = "The $field must be at most $param characters.";
            }
            break;

        case 'in':
            if ($value !== '') {
                $options = explode(',', $param);
                if (!in_array($value, $options)) {
                    $errors[] = "The $field must be one of: " . implode(', ', $options);
                }
            }
            break;

        case 'password_confirmation':
            if ($value !== ($data['password'] ?? null)) {
                $errors[] = "Password confirmation does not match.";
            }
            break;

        case 'has_number':
            if ($value !== '' && !preg_match('/\d/', $value)) {
                $errors[] = "The $field must contain at least one number.";
            }
            break;

        case 'has_special':
            if ($value !== '' && !preg_match('/[\W_]/', $value)) {
                $errors[] = "The $field must contain at least one special character.";
            }
            break;

        case 'has_upper':
            if ($value !== '' && !preg_match('/[A-Z]/', $value)) {
                $errors[] = "The $field must contain at least one uppercase letter.";
            }
            break;

        case 'has_lower':
            if ($value !== '' && !preg_match('/[a-z]/', $value)) {
                $errors[] = "The $field must contain at least one lowercase letter.";
            }
            break;

        default:
            $errors[] = "Unknown rule: $ruleName";
    }

    return $errors;
}
