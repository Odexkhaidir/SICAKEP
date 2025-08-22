<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Member;
use App\Models\Satker;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'admin-provinsi') {
            $satker = Satker::all();
        } else {
            $satker = Satker::where('id', auth()->user()->satker_id)->get();
        }        
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];
        $satker_id = auth()->user()->satker_id;
        $this_year = date('Y');
        return view('team.index', [
            "satkers" => $satker,
            "teams" => Team::where('satker_id', $satker_id)->where('year', $this_year)->get(),
            "this_year" => $this_year,
            "this_satker" => $satker_id,
            "years" => $years,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role == 'admin-provinsi') {
            $satker = Satker::all();
            $user = User::all();
        } else {
            $satker = Satker::where('id', auth()->user()->satker_id)->get();
            $user = User::where('satker_id', auth()->user()->satker_id)->get();
        }

        return view('team.create', [
            "satkers" => $satker,
            "users" => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'year' => ['required'],
            'satker_id' => ['required'],
            'leader_id' => ['required'],
        ]);

        $team = Team::create([
            'name' => $request->name,
            'year' => $request->year,
            'satker_id' => $request->satker_id,
            'leader_id' => $request->leader_id
        ]);

        // dd($team);

        if (!isNull($request->members)) {
            $members = [];
            foreach ($request->members as $member) {
                array_push($members, ['team_id' => $team->id, 'user_id' => $member]);
            }

            Member::insert($members);
        }

        return redirect('/team')->with('notification', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return view('team.show', [
            'team' => $team
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        if (auth()->user()->role == 'admin-provinsi') {
            $satker = Satker::all();
            $user = User::all();
        } else {
            $satker = Satker::where('id', auth()->user()->satker_id)->get();
            $user = User::where('satker_id', auth()->user()->satker_id)->get();
        }
        $members = [];

        foreach ($team->members as $member) {
            array_push($members, $member->id);
        }
        return view('team.edit', [
            'team' => $team,
            'satkers' => $satker,
            'members' => $members,
            'users' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'year' => ['required'],
            'satker_id' => ['required'],
            'leader_id' => ['required'],
        ]);

        $team = Team::where('id', $team->id)->update([
            'name' => $request->name,
            'year' => $request->year,
            'satker_id' => $request->satker_id,
            'leader_id' => $request->leader_id
        ]);

        // dd($team);
        if ($team->members) {
            $members_exist = [];

            foreach ($team->members as $member) {
                array_push($members_exist, $member->id);
            }

            $members_input = [];

            foreach ($request->members as $member) {
                array_push($members, ['team_id' => $team->id, 'user_id' => $member]);
            }

            if ($members_input != $members_exist) {
                Members::where('team_id', $team->id)->delete();
                Member::insert($members_input);
            }
        }

        return redirect('/team')->with('notification', 'Data berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        Team::where('id', $team->id)->delete();
        Member::where('team_id', $team->id)->delete();
        return redirect('/team')->with('notification', 'Data berhasil dihapus!');
    }

    /**
     * Show filtered list resource from storage.
     */
    public function filter(Request $request)
    {

        $filter = (array) json_decode($request->filter);
        $notification = [];
        // dd($filter);
        $teams = Team::where('year', $filter['year'])->where('satker_id', $filter['satker'])->get();

        if(count($teams) > 0){
            array_push($notification, [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data berhasil diunduh'
            ]);

        } else {
            array_push($notification, [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Data tidak ditemukan'
            ]);
        }
        return response()->json(['data' => $teams, 'messages' => $notification]);
    }
}
