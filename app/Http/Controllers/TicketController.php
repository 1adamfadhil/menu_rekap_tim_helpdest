<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketComment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $tickets = Ticket::with(['user', 'agent', 'category'])
                ->latest()
                ->get();
        } elseif ($user->role === 'agent') {
            $tickets = Ticket::with(['user', 'agent', 'category'])
                ->where('agent_id', $user->id)
                ->latest()
                ->get();
        } else {
            $tickets = Ticket::with(['user', 'agent', 'category'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        // Cari ticket berdasarkan ID
        // Jika tidak ditemukan, Laravel otomatis memberikan 404
        $ticket = Ticket::with([
            'user',
            'agent',
            'category',
            'comments.user'
        ])->findOrFail($id);

        $user = Auth::user();

        Gate::authorize('view', $ticket);

        // Ambil semua user yang memiliki role agent
        $agents = User::where('role', 'agent')->get();

        return view('tickets.show', compact('ticket', 'agents'));
    }

    public function create()
    {
        // Ambil semua kategori untuk pilihan di form
        $categories = Category::all();

        // Ambil user dengan role user sebagai pembuat Ticket
        $users = User::where('role', 'user')->get();

        return view('tickets.create', compact('categories', 'users'));
    }
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        if (Auth::user()->role === 'admin') {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $data['user_id'] = $request->user_id;
        } else {
            $data['user_id'] = Auth::id();
        }

        // Buat nomor ticket secara sederhana
        $data['ticket_number'] = 'TKT-' . now()->format('YmdHis');

        // Status awal ticket
        $data['status'] = 'open';

        // Simpan ticket ke database
        Ticket::create($data);

        // Kembali ke halaman daftar ticket
        return redirect('/tickets');
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'agent' && $ticket->user_id === $user->id) {
            abort(403);
        }

        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        $categories = Category::all();
        $users = User::where('role', 'user')->get();

        return view('tickets.edit', compact('ticket', 'categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Cari ticket yang ingin diubah
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'agent' && $ticket->user_id === $user->id) {
            abort(403);
        }

        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        // Validasi data dari form
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        if (Auth::user()->role === 'admin') {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $data['user_id'] = $request->user_id;
        }
    }
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'agent' && $ticket->user_id === $user->id) {
            abort(403);
        }

        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        $ticket->delete();

        return redirect('/tickets');
    }

    public function storeComment(Request $request, $id)
    {
        // cari tiket yang akan diberi komentar
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'agent' && $ticket->user_id === $user->id) {
            abort(403);
        }

        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        // Validasi isi Komentar
        $data = $request->validate([
            'comment' => 'required|string'
        ]);

        // Simpan komentar ke database
        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'comment' => $data['comment'],
        ]);

        // Kembali ke halaman detail ticket
        return redirect('/tickets/' . $ticket->id);
    }

    public function updateStatus(Request $request, $id)
    {
        // Cari Ticket yang ingin diubah
        $ticket = Ticket::findOrFail($id);

        // Validasi status yang dikirim dari form
        $data = $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        // Update status ticket
        $ticket->update([
            'status' => $data['status'],
        ]);

        // Kembali ke halaman detail ticket
        return redirect('/tickets/' . $ticket->id);
    }
    public function assignAgent(Request $request, $id)
    {
        // Cari ticket berdasarkan ID
        $ticket = Ticket::findOrFail($id);

        // Validasi agent yang dipilih
        $data = $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        // Simpan agent ke ticket
        $ticket->update([
            'agent_id' => $data['agent_id'],
        ]);

        // Kembali ke halaman detail ticket
        return redirect('/tickets/' . $ticket->id);
    }
}
