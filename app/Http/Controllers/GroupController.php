<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\ReportEntry;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('groups.create');
    }

    // public function showMember(Group $group, string $name)
    // {
    //     $entries = ReportEntry::where('name', $name)->get();
    //     return view('groups.show-member', compact('entries'));
    // }

    public function addMember(Group $group)
    {
        return view('groups.add-member', compact('group'));
    }

    public function storeMember(Request $request)
    {
        // Validasi input
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'members' => 'required|array',
            'members.*.name' => 'required|string|max:255',
            'members.*.whatsapp' => 'nullable|string|max:20',
        ]);

        // Cari group berdasarkan ID
        $group = Group::find($request->group_id);

        if (!$group) {
            return redirect()->back()->with('error', 'Group tidak ditemukan!');
        }

        // Tambahkan semua member baru ke dalam array members
        $members = $group->member; // Sudah otomatis berupa array
        foreach ($request->members as $newMember) {
            $members[] = [
                'name' => $newMember['name'],
                'whatsapp' => $newMember['whatsapp'],
            ];
        }

        // Update group dengan members baru
        $group->update(['member' => $members]); // Otomatis diubah ke JSON string

        return redirect()->route('groups.show', $group)->with('success', 'Member berhasil ditambahkan!');
    }

    public function editMember(Group $group, string $whatsapp)
    {
        dd($group);
        return view('groups.add-member', compact('group'));
    }

    public function removeMember(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string',
            'whatsapp' => 'nullable|string',
        ]);

        // Ambil member dari group (sudah berupa array berkat accessor)
        $members = $group->member;

        // Filter out the member to be removed
        $members = array_filter($members, function ($member) use ($request) {
            return $member['name'] !== $request->name || $member['whatsapp'] !== $request->whatsapp;
        });

        // Update group dengan members yang tersisa
        $group->update(['member' => array_values($members)]);

        return redirect()->route('groups.show', $group)->with('success', 'Member berhasil dihapus!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_id' => 'nullable|string|max:255',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'whatsapp_id' => $request->whatsapp_id,
        ]);

        return redirect()->route('groups.add-member', $group)->with('success', 'Group created successfully! Now you can add members to this group.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $groups = Group::all();
        return view('groups.edit', compact('group', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'group_id' => 'required|exists:groups,id',
        ]);

        $group = Group::find($request->group_id);

        // Update member in the group
        $members = $group->member ?? [];
        foreach ($members as &$member) {
            if ($member['name'] === $group->name && $member['whatsapp'] === $group->whatsapp) {
                $member['name'] = $request->name;
                $member['whatsapp'] = $request->whatsapp;
                break;
            }
        }

        $group->update(['member' => $members]);

        return redirect()->route('groups.index')->with('success', 'Member updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group = Group::find($group->group_id);

        // Remove member from the group
        $members = $group->member ?? [];
        $members = array_filter($members, function ($member) use ($group) {
            return $member['name'] !== $group->name || $member['whatsapp'] !== $group->whatsapp;
        });

        $group->update(['member' => $members]);

        return redirect()->route('groups.index')->with('success', 'Member deleted successfully!');
    }
}
