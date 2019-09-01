<?php

namespace Shridhar\Webservices;

/**
 *
 * @author Shridhar Kaushik
 */
trait Webservice {

    use HandleRequest;
    use HandleInput;
    use HandleResponse;

    static function routeAction($name) {
        return __CLASS__ . "@$name";
    }

}
