<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    /**
     * Create a new PaymentController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('front.stripe.index', [
            'intent' => auth()->user()->createSetupIntent()
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $paymentMethod = $request->input('payment-method');
        $plan = Plan::where('stripe_name', $request->plan)->first();

        $user->newSubscription($plan->stripe_name, $plan->stripe_product_id)->create($paymentMethod);

        return redirect()->route('premium.index')->with('status', __('Thank you for your subscription'));
    }
}
