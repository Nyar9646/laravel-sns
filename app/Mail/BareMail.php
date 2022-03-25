<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BareMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // 使用法：メール件名・本文等のテンプレート blade を追加した上で自分自身を返す。↓default
        // return $this->view('view.name');

        // 当app では、テンプレートを通知クラスを作成して設定するので、空を返す
        return $this;
    }
}
