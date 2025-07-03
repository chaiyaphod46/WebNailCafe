
<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">ชื่อ</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="phon" class="form-label">เบอร์โทร</label>
        <input type="text" class="form-control" id="phon" name="phon" value="{{ old('phon', $user->phon) }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">อีเมล</label>
        <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
    </div>

    <button type="submit" class="btn btn-primary">บันทึก</button>
</form>


