<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use App\Admin\Forms\Buynote;
use Encore\Admin\Widgets\Tab;

class SettingsController extends Controller
{
    public function index(Content $content)
    {
        $forms = [
            'buynote' => Buynote::class,
        ];

        return $content
            ->title('平台设置')
            ->body(Tab::forms($forms));
    }
}
