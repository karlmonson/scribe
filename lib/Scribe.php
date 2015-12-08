<?php

/**
 * Scribe - The Unofficial Sendy API Wrapper
 * Copyright © 2015 Karl Monson <karl@karlmonson.com>
 *
 * The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

class Scribe {

    protected $instance;
    protected $api_key;
    protected $list_id;

    public function __construct(array $config)
    {
        //error checking
        $instance = @$config['instance'];
        $api_key = @$config['api_key'];
        $list_id = @$config['list_id'];

        if (empty($instance)):
            throw new \Exception("Required config parameter [instance] is not set or empty", 1);
        elseif (empty($api_key)):
            throw new \Exception("Required config parameter [api_key] is not set or empty", 1);
        elseif (empty($list_id)):
            throw new \Exception("Required config parameter [list_id] is not set or empty", 1);
        endif;

        $this->instance = $instance;
        $this->api_key = $api_key;
        $this->list_id = $list_id;
    }

    public function setListId($list_id)
    {
        if (empty($list_id)):
            throw new \Exception("Required parameter [list_id] is not set", 1);
        endif;

        $this->list_id = $list_id;
    }

    public function getListId()
    {
        return $this->list_id;
    }

    public function subscribe(array $values)
    {
        if (empty($values)):
            throw new \Exception("Required parameter [values] is not set", 1);
        endif;

        $return_options = array(
            'list' => $this->list_id,
            'boolean' => 'true'
        );
        $content = array_merge($values, $return_options);
        $postdata = http_build_query($content);
        $opts = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents($this->instance.'/subscribe', false, $context);

        if($result == 1):
            return array('status' => 'success', 'message' => 'Subscribed');
        else:
            return array('status' => 'error', 'message' => $result);
        endif;
    }

    public function unsubscribe($email)
    {
        if (empty($email)):
            throw new \Exception("Required parameter [email] is not set", 1);
        endif;

        $postdata = http_build_query(
            array(
                'email' => $email,
                'list' => $this->list_id,
                'boolean' => 'true'
            )
        );
        $opts = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents($this->instance.'/unsubscribe', false, $context);

        if($result == 1):
            return array('status' => 'success', 'message' => $email . ' unsubscribed');
        else:
            return array('status' => 'error', 'message' => $result);
        endif;
    }

    public function subscriptionStatus($email)
    {
        if (empty($email)):
            throw new \Exception("Required parameter [email] is not set", 1);
        endif;

        $postdata = http_build_query(
            array(
                'api_key' => $this->api_key,
                'email' => $email,
                'list_id' => $this->list_id
            )
        );
        $opts = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents($this->instance.'//api/subscribers/subscription-status.php', false, $context);

        if($result == 'Subscribed' || $result == 'Unsubscribed' || $result == 'Unconfirmed' || $result == 'Bounced' || $result == 'Soft bounced' || $result == 'Complained'):
            return array('status' => 'success', 'message' => $result);
        else:
            return array('status' => 'error', 'message' => $result);
        endif;
    }

    public function activeSubscriberCount()
    {
        $postdata = http_build_query(
            array(
                'api_key' => $this->api_key,
                'list_id' => $this->list_id
            )
        );
        $opts = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents($this->instance.'//api/subscribers/active-subscriber-count.php', false, $context);

        if(is_numeric($result)):
            return array('status' => 'success', 'message' => $result);
        else:
            return array('status' => 'error', 'message' => $result);
        endif;
    }

    public function createCampaign($from_name, $from_email, $reply_to, $subject, $plain_text, $html_text, $list_ids = null, $brand_id = null, $send_campaign = null)
    {
        $postdata = http_build_query(
            array(
                'api_key' => $this->api_key,
                'from_name' => $from_name,
                'from_email' => $from_email,
                'reply_to' => $reply_to,
                'subject' => $subject,
                'plain_text' => $plain_text,
                'html_text' => $html_text,
                'list_ids' => ($list_ids ? $list_ids : $this->list_id),
                'brand_id' => ($brand_id ? $brand_id : ''),
                'send_campaign' => ($send_campaign ? $send_campaign : 0)
            )
        );
        $opts = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents($this->instance.'//api/campaigns/create.php', false, $context);

        if($result == 'Campaign created' || $result == 'Campaign created and now sending'):
            return array('status' => 'success', 'message' => $result);
        else:
            return array('status' => 'error', 'message' => $result);
        endif;
    }

}
