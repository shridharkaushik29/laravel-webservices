<?php

namespace Shridhar\Webservices;

use Illuminate\Validation\Validator;

/**
 *
 * @author Shridhar Kaushik
 */
trait HandleRequest {

    function perform($action) {
        $controller_name = class_basename(__CLASS__);
        if (is_array($action)) {
            foreach ($action as $p) {
                $this->perform($p);
            }
        } else {
            $path = $this->getPath($action);
            if (file_exists($path)) {
                try {
                    include($path);
                } catch (Exception $exc) {
                    $this->error($exc, false);
                }
                return $this->getData();
            } else {
                abort(404);
            }
        }
    }

    public function create($path) {
        return $this->perform("create/$path");
    }

    public function retrieve($path) {
        return $this->perform("retrieve/$path");
    }

    public function update($path) {
        return $this->perform("update/$path");
    }

    public function delete($path) {
        return $this->perform("delete/$path");
    }

    function validate_request($res, $messages = []) {
        if ($res instanceof Validator) {
            $validator = $res;
        } elseif (is_array($res)) {
            $validator = validator(request()->all(), $res, $messages);
        } else {
            throw $this->exception("Invalid Validator");
        }
        if ($validator->fails()) {
            throw $this->exception($validator->errors()->first());
        }
    }

    function getPath($action) {
        $path = preg_replace("/\/$/", "", $action);
        $base_path = $this->services_path ?: app_path("Http/Controllers/" . class_basename(__CLASS__));
        $p = "$base_path/$path.php";
        return $p;
    }

}
