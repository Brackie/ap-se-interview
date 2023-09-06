<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all subscription plans
        $plans = SubscriptionPlan::all();

        return response()->json(array(
            "success" => 1,
            "message" => "Plans Found",
            "data" => $plans
        ), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            "plan_id" => "required"
        ]);

        $user = auth()->user();
        $plan = SubscriptionPlan::find($request->input("plan_id"));

        $user_plan = new UserSubscriptionPlan();
        $user_plan->user_id = $user->id;
        $user_plan->subscription_plan_id = $user->id;
        $user_plan->start_date = Carbon::now();
        $user_plan->end_date = Carbon::parse($user_plan->start_date )->addDays($plan->validity);
        $user_plan->save();

        return response()->json(array(
            "success" => 1,
            "message" => "You are subscribed!",
            "data" => $plan
        ), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
