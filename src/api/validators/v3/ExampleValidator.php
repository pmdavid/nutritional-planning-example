<?php


namespace api\validators\v3;
use common\helpers\XssSecurity;
use Exception;
use Rakit\Validation\Validator;


/**
 * Example of Validator OnboardingValidator
 *
 * @property integer $athlete_id
 */


class ExampleValidator
{
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator; // External lib
    }

    public function validateUserData($data): bool
    {
        $validation = $this->validator->validate($data, [
            'firstname' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validation->fails()) {
            throw new Exception('Error validación de campos');
        }

        return true;
    }

    public function validateCaloriesData($data): bool
    {
        $validation = $this->validator->validate($data, [
            'birth_date' => 'required|date',
            'gender' => 'required|alpha',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'muscle' => 'required|numeric',
            'fat' => 'required|numeric',
            'pregnancy' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            throw new Exception('Error validación de campos');
        }

        return true;
    }

    public function validateNoteData(array $data): array
    {
        $data['note'] = XssSecurity::cleanKeepingAccents($data['note']);

        $validation = $this->validator->validate($data, [
            'note' => ["max:200"]
        ]);

        if ($validation->fails()) {
            throw new Exception('Error validación de campos: Nota');
        }

        return $data;
    }
}
