<?php

namespace Smsapp\Http\Controllers;

use Smsapp\Group;
use Illuminate\Http\Request;

class GroupSearchController extends Controller
{
    /**
     * Display a listing of the groups.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, Group $group)
    {
        //get the results
        $groups = $group->search($request->search)->get();

        //what was searched for?
        $for = $request->search;
        
        return view('search.search-results', compact('groups', 'for'));
    }
}
