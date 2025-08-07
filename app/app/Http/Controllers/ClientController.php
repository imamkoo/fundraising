<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $fundraisings = Fundraising::with('category', 'fundraiser')->where('is_active', 1)->orderByDesc('id')->get();

        return view('client.views.index', compact('categories', 'fundraisings'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();

        $fundraisings = Fundraising::with('category', 'fundraiser')->where('is_active', 1)->orderByDesc('id')->get();

        return view('client.views.category', compact('category', 'fundraisings'));
    }

    public function details(Fundraising $fundraising)
    {
        $goalReached = $fundraising->totalReachedAmount() >= $fundraising->target_amount;

        return view('client.views.details', compact('fundraising', 'goalReached'));
    }

    public function donation(Fundraising $fundraising)
    {
        return view('client.views.donation', compact('fundraising'));
    }

    public function checkout(Fundraising $fundraising, $totalAmountDonation)
    {
        return view('client.views.checkout', compact('fundraising', 'totalAmountDonation'));
    }

    public function store(StoreDonationRequest $request, Fundraising $fundraising, $totalAmountDonation)
    {
        DB::transaction(function () use ($request, $fundraising, $totalAmountDonation) {
            $validated = $request->validated();

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proof', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['fundraising_id'] = $fundraising->id;
            $validated['total_amount'] = $totalAmountDonation;
            $validated['is_paid'] = false;

            $donatur = Donatur::create($validated);
        });
        return redirect()->route('client.details', $fundraising->slug);
    }
}
