<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Course;
use App\Models\User;

class CustomerController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    public function index(Request $request): View
    {
        $courseOptions = Course::orderBy('type')->orderBy('name')->get()->pluck('fullName', 'abbreviation')->toArray();
        $courseOptions = array_merge([null => 'Any course'], $courseOptions);

        $filterByCourse = $request->query('course');
        $filterByName = $request->query('name');
        $CustomersQuery = Customer::query();
        if ($filterByCourse !== null) {
            $CustomersQuery->where('course', $filterByCourse);
        }
        // Next 3 lines are required when sorting by name:
        // ->join is necessary so that we have access to the users.name - to be able to order by "users.name"
        // ->select avoids bringing to many fields (that may conflict with each other)
        $CustomersQuery
            ->join('users', 'users.id', '=', 'Customers.user_id')
            ->select( 'Customers.*')
            ->orderBy('users.name');

        // Since we are joining Customers and users, we can simplify the code to search by name
        if ($filterByName !== null) {
            $CustomersQuery
                ->where('users.type', 'S')
                ->where('users.name', 'like', "%$filterByName%");
        }
        // Next line were used to filter by name, when there were no join clauses
        // if ($filterByName !== null) {
        //     $usersIds = User::where('type', 'S')
        //         ->where('name', 'like', "%$filterByName%")
        //         ->pluck('id')
        //         ->toArray();
        //     $CustomersIds = Customer::whereIntegerInRaw('user_id', $usersIds)
        //         ->pluck('id')
        //         ->toArray();
        //     $CustomersQuery->whereIntegerInRaw('Customers.id', $CustomersIds);
        // }

        $Customers = $CustomersQuery
            ->with('user', 'courseRef', 'disciplines')
            ->paginate(20)
            ->withQueryString();

        return view(
            'Customers.index',
            compact('Customers', 'courseOptions', 'filterByCourse', 'filterByName')
        );
    }

    public function myCustomers(Request $request) : View
    {
        $idDisciplines = $request->user()?->teacher?->disciplines?->pluck('id')?->toArray();
        if (empty($idDisciplines)) {
            return view('Customers.my')->with('Customers', new Collection);
        }
        $CustomersQuery = Customer::join('users', 'users.id', '=', 'Customers.user_id')
            ->select('Customers.*')
            ->orderBy('users.name');
        $Customers = $CustomersQuery
            ->join('Customers_disciplines', 'Customers_disciplines.Customers_id', '=', 'Customers.id')
            ->whereIntegerInRaw('Customers_disciplines.discipline_id', $idDisciplines)
            ->with('user', 'courseRef', 'disciplines')
            ->get();
        return view('Customers.my',compact('Customers'));
    }

    public function show(Customer $Customer): View
    {
        return view('Customers.show')->with('Customer', $Customer);
    }

    public function create(): View
    {
        $newCustomer = new Customer();
        // Next 2 lines ensure that the expression $newCustomer->user->name is valid
        $newUser = new User();
        $newUser->type= 'S';
        $newCustomer->user = $newUser;
        $newCustomer->course = 'EI';
        return view('Customers.create')
            ->with('Customer', $newCustomer);
    }

    public function store(CustomerFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $newCustomer = DB::transaction(function () use ($validatedData, $request) {
            $newUser = new User();
            $newUser->type = 'S';
            $newUser->name = $validatedData['name'];
            $newUser->email = $validatedData['email'];
            // Customer is never an administrator
            $newUser->admin = 0;
            $newUser->gender = $validatedData['gender'];
            // Initial password is always 123
            $newUser->password = bcrypt('123');
            $newUser->save();
            $newCustomer = new Customer();
            $newCustomer->user_id = $newUser->id;
            $newCustomer->course = $validatedData['course'];
            $newCustomer->number = $validatedData['number'];
            $newCustomer->save();
            if ($request->hasFile('photo_file')) {
                $path = $request->photo_file->store('public/photos');
                $newUser->photo_url = basename($path);
                $newUser->save();
            }
            return $newCustomer;
        });
        $newCustomer->user->sendEmailVerificationNotification();
        $url = route('Customers.show', ['Customer' => $newCustomer]);
        $htmlMessage = "Customer <a href='$url'><u>{$newCustomer->user->name}</u></a> has been created successfully!";
        return redirect()->route('Customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Customer $Customer): View
    {
        return view('Customers.edit')
            ->with('Customer', $Customer);
    }

    public function update(CustomerFormRequest $request, Customer $Customer): RedirectResponse
    {
        $validatedData = $request->validated();
        $Customer = DB::transaction(function () use ($validatedData, $Customer, $request) {
            $Customer->course = $validatedData['course'];
            $Customer->number = $validatedData['number'];
            $Customer->save();
            $Customer->user->type = 'S';
            $Customer->user->name = $validatedData['name'];
            $Customer->user->email = $validatedData['email'];
            // Customer is never an administrator
            $Customer->user->admin = 0;
            $Customer->user->gender = $validatedData['gender'];
            $Customer->user->save();
            if ($request->hasFile('photo_file')) {
                // Delete previous file (if any)
                if (
                    $Customer->user->photo_url &&
                    Storage::fileExists('public/photos/' . $Customer->user->photo_url)
                ) {
                    Storage::delete('public/photos/' . $Customer->user->photo_url);
                }
                $path = $request->photo_file->store('public/photos');
                $Customer->user->photo_url = basename($path);
                $Customer->user->save();
            }
            return $Customer;
        });
        $url = route('Customers.show', ['Customer' => $Customer]);
        $htmlMessage = "Customer <a href='$url'><u>{$Customer->user->name}</u></a> has been updated successfully!";
        if ($request->user()->can('viewAny', Customer::class)) {
            return redirect()->route('Customers.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Customer $Customer): RedirectResponse
    {
        try {
            $url = route('Customers.show', ['Customer' => $Customer]);

            $totalCustomersDisciplines = $Customer->disciplines()->count();

            if ($totalCustomersDisciplines == 0) {
                DB::transaction(function () use ($Customer) {
                    $fileToDelete = $Customer->user->photo_url;
                    $Customer->delete();
                    $Customer->user->delete();
                    if ($fileToDelete) {
                        if (Storage::fileExists('public/photos/' . $fileToDelete)) {
                            Storage::delete('public/photos/' . $fileToDelete);
                        }
                    }
                });
                $alertType = 'success';
                $alertMsg = "Customer {$Customer->user->name} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $gender = $Customer->user->gender == 'M' ? 'he' : 'she';
                $justification = match (true) {
                    $totalCustomersDisciplines <= 0 => "",
                    $totalCustomersDisciplines == 1 => "$gender is enrolled in 1 discipline",
                    $totalCustomersDisciplines > 1 => "$gender is enrolled in $totalCustomersDisciplines disciplines",
                };
                $alertMsg = "Customer <a href='$url'><u>{$Customer->user->name}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Customer
                            <a href='$url'><u>{$Customer->user->name}</u></a>
                            because there was an error with the operation!";
        }
        return redirect()->route('Customers.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPhoto(Customer $Customer): RedirectResponse
    {
        if ($Customer->user->photo_url) {
            if (Storage::fileExists('public/photos/' . $Customer->user->photo_url)) {
                Storage::delete('public/photos/' . $Customer->user->photo_url);
            }
            $Customer->user->photo_url = null;
            $Customer->user->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of Customer {$Customer->user->name} has been deleted.");
        }
        return redirect()->back();
    }

}
