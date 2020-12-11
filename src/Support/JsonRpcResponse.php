<?php

namespace Tochka\JsonRpc\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class JsonRpcResponse implements Jsonable, Arrayable
{
    public $jsonrpc = '2.0';
    public $error = null;
    public $result = null;
    public $id = null;

    public static function result($result, string $id = null): self
    {
        $instance = new self();
        $instance->result = $result;
        $instance->id = $id;

        return $instance;
    }

    public static function error($error, string $id = null): self
    {
        $instance = new self();
        $instance->error = $error;
        $instance->id = $id;

        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = [];
        $result['jsonrpc'] = $this->jsonrpc;
        if ($this->id !== null) {
            $result['id'] = $this->id;
        }

        if ($this->error !== null) {
            if ($this->error instanceof Arrayable) {
                $result['error'] = $this->error->toArray();
            } elseif ($this->error instanceof \JsonSerializable) {
                $result['error'] = $this->error->jsonSerialize();
            } else {
                $result['error'] = $this->error;
            }
        } elseif ($this->result instanceof Arrayable) {
            $result['result'] = $this->result->toArray();
        } elseif ($this->result instanceof \JsonSerializable) {
            $result['result'] = $this->result->jsonSerialize();
        } else {
            $result['result'] = $this->result;
        }

        return $result;
    }
}
