<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrackingUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Dados do email
     */
    public string $trackingCode;
    public string $name;
    public string $currentStatus;
    public string $statusDescription;
    public string $updateTime;
    public array $journey;
    public int $currentStatusIndex;
    public string $currentLocation;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $trackingCode,
        string $name,
        string $currentStatus,
        string $statusDescription,
        string $updateTime,
        array $journey,
        int $currentStatusIndex,
        string $currentLocation
    ) {
        $this->trackingCode = $trackingCode;
        $this->name = $name;
        $this->currentStatus = $currentStatus;
        $this->statusDescription = $statusDescription;
        $this->updateTime = $updateTime;
        $this->journey = $journey;
        $this->currentStatusIndex = $currentStatusIndex;
        $this->currentLocation = $currentLocation;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject("📦 Atualização do seu pedido #{$this->trackingCode}")
                   ->view('emails.tracking_code')
                   ->with([
                       'trackingCode' => $this->trackingCode,
                       'name' => $this->name,
                       'currentStatus' => $this->currentStatus,
                       'statusDescription' => $this->statusDescription,
                       'updateTime' => $this->updateTime,
                       'journey' => $this->journey,
                       'currentStatusIndex' => $this->currentStatusIndex,
                       'currentLocation' => $this->currentLocation
                   ]);
    }
}