<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/2/23
 * Time: 11:21
 */

namespace HughCube\Laravel\TencentCloud;


use Illuminate\Support\Arr;

class Manager
{
    /**
     * The TencentCloud server configurations.
     *
     * @var array
     */
    protected $config;

    /**
     * The clients.
     *
     * @var Client[]
     */
    protected $clients = [];

    /**
     * Manager constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get a client by name.
     *
     * @param string|null $name
     *
     * @return Client
     */
    public function client($name = null)
    {
        $name = null == $name ? $this->getDefaultClient() : $name;

        if (isset($this->clients[$name])) {
            return $this->clients[$name];
        }

        return $this->clients[$name] = $this->resolve($name);
    }

    /**
     * Resolve the given client by name.
     *
     * @param string|null $name
     *
     * @return Client
     *
     */
    protected function resolve($name = null)
    {
        return $this->makeClient($this->configuration($name));
    }

    /**
     * Make the TencentCloud client instance.
     *
     * @param string $name
     * @return Client
     */
    public function makeClient(array $config)
    {
        return new Client($config);
    }

    /**
     * Get the default client name.
     *
     * @return string
     */
    public function getDefaultClient()
    {
        return Arr::get($this->config, 'default', 'default');
    }

    /**
     * Get the configuration for a client.
     *
     * @param string $name
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function configuration($name)
    {
        $name = $name ?: $this->getDefaultClient();
        $clients = Arr::get($this->config, 'clients');

        if (is_null($config = Arr::get($clients, $name))) {
            throw new \InvalidArgumentException("TencentCloud client [{$name}] not configured.");
        }

        return $config;
    }
}
