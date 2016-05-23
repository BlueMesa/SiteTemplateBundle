<?php

/*
 * Copyright 2013 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Bluemesa\Bundle\SiteTemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controller for displaying general messages
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class MessagesController extends Controller
{

    /**
     * Display MSIE information
     *
     * @Template
     *
     * @return array
     */
    public function msieAction(Request $request)
    {
        $msie_version = 10;
        $user_agent = $request->headers->get('User-Agent');
        $is_msie = strpos($user_agent, 'MSIE') !== false;
        if ($is_msie) {
            $matches = array();
            preg_match('/MSIE (.*?)\./', $user_agent, $matches);
            $msie_version = array_key_exists(1, $matches) ? $matches[1] : 0;
            if ($msie_version < 8) {
                $session = $request->getSession();
                $display = $session->get('msie_info_displayed') == null ? true : false;
                $compat = strpos($user_agent, 'Trident') !== false;
                $session->set('msie_info_displayed',true);
            } else {
                $display = false;
                $compat = false;
            }
        } else {
            $display = false;
            $compat = false;
        }

        return array('display' => $display, 'version' => $msie_version, 'compat' => $compat);
    }
}
