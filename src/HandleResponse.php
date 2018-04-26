<?php

namespace Shridhar\Webservices;

use Exception;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 * @author Shridhar Kaushiks
 */
trait HandleResponse {

    function success($message) {
        $this->setData("type", "success");
        $this->setData("message", $message);
    }

    function error($message, $exit = true) {
        if ($exit) {
            if ($message instanceof Exception) {
                throw $message;
            } else {
                throw $this->exception($message);
            }
        } else {
            if ($message instanceof Exception) {
                $this->setData("message", $message->getMessage());
            } else {
                $this->setData("message", $message);
            }
        }
        $this->setData("type", "error");
    }

    function exception($message) {
        return new Exception($message);
    }

    function setData($key, $value) {
        if ($value instanceof Builder) {
            $value = $value->get();
        }
        array_set($this->data, $key, $value);
    }

    function getData($key = false) {
        if (!$key) {
            return collect($this->data);
        } else {
            return array_get($this->data, $key);
        }
    }

}
