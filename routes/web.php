<?php

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/', function (Request $request) {
    $exams = Exam::with('classroom')->orderBy('tarikh')->orderBy('id')->get();

    $examId = $request->integer('exam') ?: $exams->first()?->id;

    $exam = $examId
        ? Exam::with(['classroom', 'sections.questions'])->find($examId)
        : null;

    $students = $exam
        ? $exam->classroom
            ->students()
            ->with(['marks', 'classroom'])
            ->orderBy('no_pelajar')
            ->get()
        : collect();

    return view('home', compact('exams', 'exam', 'students'));
})->middleware('auth')->name('home');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $remember = $request->boolean('remember');

    if (! Auth::attempt($credentials, $remember)) {
        throw ValidationException::withMessages([
            'username' => 'Nama pengguna atau kata laluan tidak sah.',
        ]);
    }

    $request->session()->regenerate();

    return redirect()->intended(route('home'));
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
