<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Menampilkan daftar semua siswa
    public function index()
    {
        // with('classRoom') = Eager Loading
        // Tanpa ini, setiap kali menampilkan $student->classRoom->class_name di view,
        // Laravel akan query database berulang kali (N+1 problem).
        // Dengan with(), Laravel cukup query sekali untuk ambil semua data kelas terkait.
        $students = Student::with('classRoom')
            ->latest()
            ->paginate(20);

        return view('admin.students.index', compact('students'));
    }

    // Menampilkan form tambah siswa
    public function create()
    {
        // Ambil semua kelas untuk ditampilkan sebagai pilihan dropdown di form
        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.students.create', compact('classes'));
    }

    // Memproses data dari form tambah siswa
    public function store(Request $request)
    {
        $validated = $request->validate([
            // unique:students,nis = NIS tidak boleh sama dengan NIS siswa lain yang sudah ada
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis'],
            'full_name' => ['required', 'string', 'max:150'],
            // exists:classes,id = class_id yang dikirim harus benar-benar ada di tabel classes
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        Student::create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // Menampilkan form edit siswa tertentu
    public function edit(Student $student)
    {
        $classes = ClassRoom::orderBy('class_name')->get();

        return view('admin.students.edit', compact('student', 'classes'));
    }

    // Memproses data dari form edit siswa
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            // unique:students,nis,{id} = NIS boleh sama dengan NIS milik siswa ini sendiri,
            // tapi tetap tidak boleh sama dengan NIS siswa LAIN
            'nis' => ['required', 'string', 'max:50', 'unique:students,nis,' . $student->id],
            'full_name' => ['required', 'string', 'max:150'],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    // Menghapus data siswa
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}