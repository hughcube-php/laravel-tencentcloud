<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/2/23
 * Time: 11:20
 */

namespace HughCube\Laravel\TencentCloud;

use Illuminate\Support\Arr;
use TencentCloud\Common\AbstractClient;
use TencentCloud\Common\Credential;

class Client extends Credential
{
    /**
     * The clients.
     *
     * @var AbstractClient[]
     */
    protected $clients = [];

    /**
     * @var null
     */
    protected $region = null;

    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct(
            $config["secretId"],
            $config["secretKey"],
            (isset($config["token"]) ? $config["token"] : null)
        );
        $this->region = Arr::get($config, "region");
    }

    /**
     * 创建对应的Client
     *
     * @param string $class
     * @param null $region
     * @param null $profile
     * @return AbstractClient
     *
     * @see \TencentCloud\Cvm\V20170312\CvmClient;
     */
    public function service($class, $region = null, $profile = null)
    {
        $region = null == $region ? $this->region : $region;

        if (null !== $profile) {
            return new $class($region, $profile);
        }

        if (empty($this->clients[$class][$region])) {
            $this->clients[$class][$region] = new $class($region, $profile);
        }

        return $this->clients[$class][$region];
    }
}
