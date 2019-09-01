<?php

namespace Shridhar\Webservices;

use Exception;

/**
 *
 * @author Shridhar Kaushik
 */
trait HandleRequest {

    protected $services_path;

    /**
     * @param $action
     * @return mixed
     */
    function perform($action) {
        if (is_array($action)) {
            foreach ($action as $p) {
                $this->perform($p);
            }
        } else {
            $path = $this->getActionPath($action);
            if (file_exists($path)) {
                try {
                    include($path);
                } catch (Exception $exc) {
                    $this->setData("exception", $exc);
                    $this->error($exc->getMessage(), false);
                }
                return $this->getData();
            } else {
                abort(404);
            }
        }
    }

    /**
     * @param $path
     * @return mixed
     */
    public function create($path) {
        return $this->perform("create/$path");
    }

    /**
     * @param $path
     * @return mixed
     */
    public function retrieve($path) {
        return $this->perform("retrieve/$path");
    }

    /**
     * @param $path
     * @return mixed
     */
    public function update($path) {
        return $this->perform("update/$path");
    }

    /**
     * @param $path
     * @return mixed
     */
    public function delete($path) {
        return $this->perform("delete/$path");
    }

    /**
     * @param $validator
     * @param array $messages
     */
    function validate_request($validator, $messages = []) {
        if (is_array($validator)) {
            $validator = validator(request()->all(), $validator, $messages);
        }

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
        }
    }

    /**
     * @param $action
     * @return string
     */
    function getActionPath($action) {
        $path = preg_replace("/\/$/", "", $action);
        $base_path = $this->services_path ?: app_path("Http/Controllers/" . class_basename(__CLASS__));
        $p = "$base_path/$path.php";
        return $p;
    }

}
