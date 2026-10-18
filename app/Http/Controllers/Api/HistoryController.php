<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $member = $request->user()->member;

        if (! $member) {
            return TransactionResource::collection(collect());
        }

        $transactions = $member->transactions()->with("book")->latest()->paginate(10);
        return TransactionResource::collection($transactions);
    }
}
