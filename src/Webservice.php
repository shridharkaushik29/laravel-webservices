<?php

namespace Shridhar\Webservices;

/**
 *
 * @author Shridhar Kaushik
 */
trait Webservice {

    use HandleRequest;
    use Input;
    use HandleResponse;
    use Hooks;

    protected $data, $services_path;

    static function routeAction($name) {
        return __CLASS__ . "@$name";
    }

}
