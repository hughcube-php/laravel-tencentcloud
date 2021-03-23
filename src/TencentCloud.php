<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/2/23
 * Time: 10:58
 */

namespace HughCube\Laravel\TencentCloud;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * Class TencentCloud
 * @package HughCube\Laravel\TencentCloud
 * @method static Client client(string $name = null)
 * @method static Client makeClient(array $config)
 */
class TencentCloud extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tencentCloud';
    }
}
