<?php

namespace Smsapp\Http\Controllers;

use View;
use Smsapp\Group;
use Smsapp\Lib\ISanitize;
use Illuminate\Http\Request;
use Smsapp\Http\Controllers\Controller;
use Smsapp\Repositories\GroupRepository;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * The Group repository instance.
     *
     * @var GroupRepository
     */
    protected $groups;

    /**
     * Create a new controller instance.
     *
     * @param  GroupRepository $groups
     * @return void
     */
    public function __construct(GroupRepository $groups)
    {
        $this->middleware('auth');
        $this->groups = $groups;
    }

    /**
     * Display a listing of groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //get group repository with groups
        $groups = $this->groups->withGroups($request->user());
        return view('groups.group', compact('groups'));
    }

    /**
     * Display group affiliations
     *
     * @param Request $request
     */
    public function affiliations(Request $request)
    {
        //get group repository with affiliations
        $affiliations = $this->groups->forAffiliations($request->user());
        return view('groups.affiliations-list', compact('affiliations'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|min:3|max:255|unique:groups',
        ]);
    }

    /**
     * Store a newly created group.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get the form data
        $name = $request->name;

        //Sanitize data
        $mrClean = new ISanitize();
        $name = $mrClean->sanitize($name);

        //Setup data for Validation
        $data = array('name' => $name,);

        //these keywords are used in SmsController. Prevent them from being used
        //for group names
        $notAction = strtolower($name);
        if ($notAction === 'join' || $notAction === 'leave' ||
        $notAction === 'create' || $notAction === 'delete') {
            $errors = ['name' => 'This name is not allowed.'];
            return back()->withErrors($errors);
        }

        //Validate data
        $this->validator($data)->validate();

        $group = $request->user()->groups()->create([
            'name' => $name,
            'slug' => str_slug($name),
        ]);

        return redirect()->route('group.new', [
            'group' => $group->slug,
        ]);
    }

    /**
     * Show a group with it's users.
     *
     * @param  \Smsapp\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        //authorize viewing groups
        $this->authorize('crud', $group);

        //set session backUrl for editing users.
        $backUrl = $request->fullUrl();
        $request->session()->put('backUrl', $backUrl);
        $request->session()->save();

        //get the group repository with users
        $groups = $this->groups->withUsers($group);
        $result = '';

        $content = View::make('groups.group-list-body', compact('groups', 'result'));
        return response($content)
        //Set headers so updates to users will always be displayed
        //even when the back button is used.
        ->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

    /**
     * Destroy the given group.
     *
     * @param  Request $request
     * @param  Group $group
     * @return Response
     */
    public function destroy(Request $request, Group $group)
    {
        $this->authorize('crud', $group);
        $group->delete();
        return redirect('dashboard');
    }
}
