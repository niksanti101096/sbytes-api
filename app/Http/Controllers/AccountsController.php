<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Accounts::all();
        return response()->json(array('status' => 200, 'accounts' => $accounts));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirstName' => 'required',
            'LastName' => 'required',
            'email' => 'required|unique:accounts,email',
            'Address' => 'required',
            'ContactNumber' => 'required',
            'BirthDate' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            Accounts::create(
                [
                    'FirstName' => $request->FirstName,
                    'LastName' => $request->LastName,
                    'email' => $request->email,
                    'Address' => $request->Address,
                    'ContactNumber' => $request->ContactNumber,
                    'BirthDate' => $request->BirthDate,
                    'password' => Hash::make($request->password),
                    'Gender' => "",
                    'AccessType' => "User"
                ]
            );

            return response()
                ->json([
                    'Message' => 'Successfully created a new account!'
                ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()
                ->json([
                    "Message" => $e->getMessage()
                ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Accounts $accounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accounts $account)
    {
        return response()
            ->json(
                [
                    "account" => $account
                ]
            );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accounts $account)
    {

        $validator = Validator::make($request->all(), [
            "FirstName" => "required",
            "LastName" => "required",
            "Address" => "required",
            "ContactNumber" => "required",
            "BirthDate" => "required|date_format:Y-m-d",
            "Gender" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["Errors" => $validator->errors()]);
        }

        try {
            $account->fill($request->all())->update();
            $account->save();

            return response()
                ->json(
                    [
                        "Message" => "Successfully updated your account!"
                    ]
                );

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()
                ->json(
                    [
                        "Message" => "Error updating your account!"
                    ]
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accounts $account)
    {
        try {
            $account->delete();
            return response()
                ->json(
                    [
                        "Message" => "Account deleted successfully"
                    ]
                );
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                "Message" => "There's an error deleting your account!"
            ]);
        }
    }

    /**
     * This will authenticate the user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["Errors" => $validator->errors()]);
        }

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->AccessType == 'Admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return response()->json([
                        "Message" => "Successfully logged in!.",
                        "User" => $user
                    ]);
                }
                
                
            } else {
                return response()->json([
                    "Message" => "Please login to continue!"
                ]);
            }
            
        } else {
            return response()->json([
                "Message" => "The provided credentials do not match our records!!"
            ]);
        }

    }

    // public function mainDashboard()
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         if ($user->AccessType == 'Admin') {
    //             return redirect()->route('admin.dashboard');
    //         } else {
    //             return response()->json([
    //                 "Message" => "Successfully logged in!."
    //             ]);
    //         }
            
            
    //     } else {
    //         return response()->json([
    //             "Message" => "Please login to continue!"
    //         ]);
    //     }
    // }

    public function adminDashboard()
    {
        return response()->json([
            "Message" => "here!."
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            "Message" => "Successfully logged out!"
        ]);
    }


    /**
     * This will return the data of the account to be editted in access type
     */

    public function accessTypeEdit(Accounts $accounts)
    {
        return response()
            ->json(
                [
                    "Account" => $accounts
                ]
            );
    }

    /**
     * This will update the access type of the account
     */

    public function accessTypeUpdate(Request $request, Accounts $accounts)
    {
        $request
            ->validate(
                [
                    "AccessType" => "required"
                ]
            );

        try {
            $accounts->fill($request->post())->update();
            $accounts->save();

            return response()
                ->json([
                    "Message" => "Account access type updated successfully!"
                ]);

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()
                ->json(
                    [
                        "Message" => "Error updating access type!"
                    ]
                );
        }

    }

    public function accountValidation(Request $request)
    {
       
        try {
            $user = Auth::user();
            if (Auth::check()) {
            
                return response()->json([
                    "Status" => 200,
                    "User" => $user
                ]);
                
                
            } else {
                return response()->json([
                    "Status" => 401,
                    "Message" => "Please login to continue!",
                    "User" => $user
                ]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                "Status" => 401,
                "Message" => $e->getMessage(),
                "User" => $user
            ]);
        }
    }


}