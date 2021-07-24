<?php


namespace SquareMvc\Foundation;

use Valitron\Validator as ValidationValidator;

class Validator
{
    /**
     * @param array $data
     * @return ValidationValidator
     */
    public static function get(array $data): ValidationValidator
    {
        $validator = new ValidationValidator(
            data: $data,
            lang: 'fr'
        );

        $validator->labels(require ROOT
            . DIRECTORY_SEPARATOR . 'resources'
            . DIRECTORY_SEPARATOR . 'lang'
            . DIRECTORY_SEPARATOR . 'validation.php');

        static::addCustomRules($validator);

        return $validator;
    }

    /**
     * @param ValidationValidator $validator
     */
    protected static function addCustomRules(ValidationValidator $validator): void
    {
        // Custom rules here
    }
}