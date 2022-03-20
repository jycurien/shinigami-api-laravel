<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CardController extends Controller
{
    const LIMIT_CARDS_TO_DISPLAY = 20;

    public function findByCode($code) {
        if (10 !== strlen($code)) {
            throw new InvalidArgumentException('Invalid card number');
        }
        [$centerCode, $cardCode, $checkSum] = $this->extractCodeParts($code);
        return Card::where('center_code', $centerCode)
                ->where('card_code', $cardCode)
                ->where('check_sum', $checkSum)
                ->firstOrFail();
    }

    public function index()
    {
        return Card::orderBy('id', 'DESC')->take(self::LIMIT_CARDS_TO_DISPLAY)->get();
    }

    /**
     * @param $code
     * @return array
     */
    private function extractCodeParts($code): array
    {
        return [substr($code, 0, 3), substr($code, 3, 6), substr($code, 9)];
    }
}
