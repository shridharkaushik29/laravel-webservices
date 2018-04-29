<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Shridhar\Webservices;

use Shridhar\Hooks\Hook;

/**
 *
 * @author shrid
 */
trait Hooks {

    function allowRetrieveMany() {
        $this->addAction("retrieve/many", function($ctrl) {
            $methods = $ctrl->input("methods");
            collect($methods)->each(function($service)use($ctrl) {
                $ctrl->retrieve($service);
            });
        });
    }

    function addAction($action, $callback, $priority = 10) {
        Hook::add_action("service-$action", $callback, $priority, 1);
    }

    function doAction($action) {
        return Hook::do_action($action, $this);
    }

    function hasAction($action) {
        return Hook::has_action($action);
    }

}
