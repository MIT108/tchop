<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        return view('pages/client/index')
            ->with('customers', $customers);
    }

    public function viewCustomer($id){

        $customer = Customer::find($id);
        if($customer){
            return view('pages/client/view')
                ->with('customer', $customer);
        }else{
            return redirect()->route('client-management');
        }

    }


    public function create(Request $request)
    {
        $fields = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required|string',
            'cPassword' => 'required|string',
        ]);

        if ($fields['password'] == $fields['cPassword']) {

            if ($this->checkEmail($fields['email'])) {
                $hashed = Hash::make($fields['password']);
                if (Hash::needsRehash($hashed)) {
                    $hashed = Hash::make($fields['password']);
                }

                $fields['password'] = $hashed;

                try {
                    Customer::create($fields);

                    return redirect()->back()->with('success', 'Customer registration successful');
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', $th->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'This email address is already registered');
            }
        } else {
            return redirect()->back()->with('error', 'Password does not match');
        }
    }

    public function suspendCustomer($id)
    {
        try {
            //code...
            $customer = Customer::find($id);
            if ($customer) {
                $customer->status = 'suspend';
                $customer->save();
                return redirect()->back()->with('success', 'Customer suspended successful');
            } else {
                return redirect()->back()->with('error', 'this customer does not exist');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function activateCustomer($id)
    {
        try {
            //code...
            $customer = Customer::find($id);
            if ($customer) {
                $customer->status = 'active';
                $customer->save();
                return redirect()->back()->with('success', 'Customer activated successful');
            } else {
                return redirect()->back()->with('error', 'this customer does not exist');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function deleteCustomer($id)
    {
        try {
            //code...
            Customer::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Customer activated successful');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function checkEmail($email)
    {
        if (Customer::where('email', $email)->count() == 0) {
            return true;
        } else {
            return false;
        }
    }
}
