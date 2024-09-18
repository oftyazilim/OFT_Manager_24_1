{{-- resources/views/message.blade.php --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="testAlert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="document.getElementById('testAlert').style.display='none'"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="testAlert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="document.getElementById('testAlert').style.display='none'"></button>
    </div>
@endif

