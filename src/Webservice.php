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

    protected $data, $scopes, $page, $limit, $offset, $services_path;

    static function routeAction($name) {
        return __CLASS__ . "@$name";
    }

}
