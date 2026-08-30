<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class SMSService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $from;

    public function __construct()
    {
        $this->baseUrl = config('services.sms.base_url', env('SMS_BASE_URL'));
        $this->username = config('services.sms.username', env('SMS_USERNAME'));
        $this->password = config('services.sms.password', env('SMS_PASSWORD'));
        $this->from = config('services.sms.from', env('SMS_FROM'));
    }

    public function sendSMS(string $to, string $message, int $type = 0): bool
    {
        $response = Http::get($this->baseUrl, [
            'username' => $this->username,
            'password' => $this->password,
            'from' => $this->from,
            'to' => $to,
            'msg' => $message,
            'type' => $type,
        ]);

        return $response->ok();
    }
}