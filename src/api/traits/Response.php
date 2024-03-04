<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * API response model
 * @property array $result [ 
 *                          'code' => '0', // 0 if no errors. Or an int number for the error type
 *                          'message' => 'Error or success message'
 *                          ]. 
 * @property array $data  Mixed array with data returned by the API services. Could be empty.
 *
 * @property array $notification [
 *                          'type' => 'alert', // alert, info, extra
 *                          'text' => 'Notification text'
 *                          ].
 */

class Response extends Model
{
    public $result;
    public $data;
    public $notification;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Result is mandatory in any response
            [['result'], 'required'],
        ];
    }

}
