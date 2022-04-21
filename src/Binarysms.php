<?php

namespace Binarycaster\Binarysms;

use Binarycaster\Binarysms\Http\Response;

class Binarysms extends ApiClient
{
    public $config;
    protected $msisdnPrefix = '880';
    protected $msisdns = [];
    protected $text;
    protected $senderId;
    protected $callbackUrl;
    protected $schedules = [];

    public function __construct(Config $config)
    {
        parent::__construct();

        $this->config = $config;
        $this->senderId = $this->config->get('default-sender-id');
        $this->setHeaders([
            'App-Key' => $this->config->get('app-key'),
            'App-Secret' => $this->config->get('app-secret'),
        ]);
    }

    public function setSenderId($value)
    {
        $this->senderId = $value;

        return $this;
    }

    public function setMsisdnPrefix($prefix)
    {
        $this->msisdnPrefix = $prefix;

        return $this;
    }

    public function setCallbackUrl($url)
    {
        $this->callbackUrl = $url;

        return $this;
    }

    public function scheduledAt($dateTime)
    {
        if (is_array($dateTime)) {
            $this->schedules = array_merge($this->schedules, $dateTime);
        } else {
            $this->schedules[] = $dateTime;
        }

        return $this;
    }

    public function to($msisdn)
    {
        if (is_array($msisdn)) {
            $this->msisdns = array_merge($this->msisdns, array_map(function ($item) {
                return sprintf("{$this->msisdnPrefix}%s", substr($item, -10));
            }, $msisdn));
        } else {
            $this->msisdns[] = $this->addMsisdnPrefix($msisdn);
        }

        return $this;
    }

    public function text($body)
    {
        $this->text = trim($body);

        return $this;
    }

    public function send()
    {
        $response =  $this->post('v1/sms/send', [
            'to' => $this->msisdns,
            'text' => $this->text,
            'sender_id' => $this->senderId,
            'callback_url' => $this->callbackUrl,
            'schedules' => $this->schedules,
        ]);

        return new Response($response);
    }

    public function getStatus(string $taskId)
    {
        $response = $this->get('v1/sms/status', ['task_id' => $taskId]);

        return new Response($response);
    }

    private function addMsisdnPrefix($msisdn): string
    {
        return sprintf("{$this->msisdnPrefix}%s", substr($msisdn, -10));
    }
}
