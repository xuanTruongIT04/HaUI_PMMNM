<?php

namespace App\Http\Jobs;

use App\Http\Mail\VerificationAccountMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VerificationAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    public $verifiUrl;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $verifiUrl)
    {
        $this->email = $email;
        $this->verifiUrl = $verifiUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new VerificationAccountMail($this->email, $this->verifiUrl));
    }
}
