<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\Setting;

use Illuminate\Http\Request;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Payment\Models\Plan;
use LeadBrowser\Payment\Models\Saas;
use LeadBrowser\Payment\Repositories\PlanRepository;
use Illuminate\Support\Facades\Event;

class PlanController extends Controller
{   
    protected $stripe;

    /**
     * Role repository instance.
     *
     * @var \LeadBrowser\User\Repositories\PlanRepository
     */
    protected $planRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\User\Repositories\PlanRepository  $planRepository
     * @return void
     */
    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Setting\PlanDataGrid::class)->toJson();
        }

        return view('admin::settings.plans.index');
    }

    public function create()
    {
        return view('admin::settings.plans.create');
    }

    public function store(Request $request)
    {   
        $data = $request->except('_token');

        $data['slug'] = strtolower($data['name']);
        $price = $data['price'] *100; 

        //create stripe product
        $stripeProduct = $this->stripe->products->create([
            'name' => $data['name'],
        ]);

        //Stripe Plan Creation
        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $price,
            'currency' => 'usd',
            'interval' =>'month', //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);

        $data['stripe_plan'] = $stripePlanCreation->id;

        $plan = $this->planRepository->create($data);

        Event::dispatch('settings.plan.create.after', $plan);

        session()->flash('success', trans('admin::app.settings.plans.create-success'));

        return redirect()->route('settings.plans.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->planRepository->findOrFail($id);

        $acl = app('acl');

        return view('admin::settings.plans.edit', compact('role', 'acl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'name'            => 'required',
            'permission_type' => 'required',
        ]);

        Event::dispatch('settings.role.update.before', $id);

        $roleData = request()->all();

        if ($roleData['permission_type'] == 'custom') {
            if (! isset($roleData['permissions'])) {
                $roleData['permissions'] = [];
            }
        }

        $role = $this->planRepository->update($roleData, $id);

        Event::dispatch('settings.role.update.after', $role);

        session()->flash('success', trans('admin::app.settings.plans.update-success'));

        return redirect()->route('settings.plans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [
            'responseCode' => 400,
        ];

        $role = $this->planRepository->findOrFail($id);

        if ($role->admins && $role->admins->count() >= 1) {
            $response['message'] = trans('admin::app.settings.plans.being-used');

            session()->flash('warning', $response['message']);
        } else if ($this->planRepository->count() == 1) {
            $response['message'] = trans('admin::app.settings.plans.last-delete-error');

            session()->flash('warning', $response['message']);
        } else {
            try {
                Event::dispatch('settings.role.delete.before', $id);

                if (auth()->guard('user')->user()->role_id == $id) {
                    $response['message'] = trans('admin::app.settings.plans.current-role-delete-error');
                } else {
                    $this->planRepository->delete($id);

                    Event::dispatch('settings.role.delete.after', $id);

                    $message = trans('admin::app.settings.plans.delete-success');

                    $response = [
                        'responseCode' => 200,
                        'message'      => $message,
                    ];

                    session()->flash('success', $message);
                }
            } catch (\Exception $exception) {
                $message = $exception->getMessage();

                $response['message'] = $message;

                session()->flash('warning', $message);
            }
        }

        return response()->json($response, $response['responseCode']);
    }
}