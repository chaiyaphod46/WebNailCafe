

<script type="text/javascript">
    function openSmallWindow(url) {
        // เปิดหน้าต่างใหม่ที่มีขนาด 790x600 และล็อกขนาดไม่ให้ขยายได้
        window.open(url, 'newwindow', 'width=790,height=600,resizable=no');
    }
</script>
@foreach($naildesign as $naildesigns)
<div class="col">
    <div class="card shadow-sm">
        <img src="naildesingimage/{{$naildesigns->image}}" width="100%" height="225" class="bd-placeholder-img card-img-top">
        <div class="card-body">
            <p class="card-text">{{$naildesigns->nailname}}</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">

                    <button type="button" onclick="openSmallWindow('/nailvto/?id={{$naildesigns->nail_design_id}}')"  class="btn btn-sm btn-outline-secondary me-2">Virtual try-on</button>
                    {{-- <button type="button" onclick="openSmallWindow('http://localhost:3000/?id={{$naildesigns->nail_design_id}}')"  class="btn btn-sm btn-outline-secondary me-2">Virtual try-on</button> --}}

                    <form action="{{ route('reserv') }}" method="GET">
                        @csrf
                        <input type="hidden" name="nail_design_id" value="{{ $naildesigns->nail_design_id }}">
                        <input type="hidden" name="nail_image" value="{{ $naildesigns->image }}">
                        <input type="hidden" name="nail_name" value="{{ $naildesigns->nailname }}">
                        <input type="hidden" name="nail_price" value="{{ $naildesigns->design_price }}">
                        <input type="hidden" name="nail_time" value="{{ $naildesigns->design_time }}">

                        <button type="submit" class="btn btn-sm btn-dark" style="width: 120px;">จอง</button>
                    </form>
                </div>
                <div class="d-flex align-items-center">
    <button type="button" class="like-button" data-nail-design-id="{{ $naildesigns->nail_design_id }}" style="border: none; background: none; padding: 0; display: flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
        </svg>
    </button>
    <span class="like-count ms-1" style="font-size: 12px;">{{ $naildesigns->likes_count }}</span>
</div>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    fetch('{{ url("liked-designs") }}')
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('.like-button').forEach(button => {
                const nailDesignId = button.getAttribute('data-nail-design-id');
                if (data.likedDesigns.includes(parseInt(nailDesignId))) {
                    const svg = button.querySelector('svg');
                    svg.classList.add('liked');
                    svg.setAttribute('fill', 'red');
                }

                button.addEventListener('click', () => {
                    fetch('{{ url("toggle-like") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nail_design_id: nailDesignId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const svg = button.querySelector('svg');
                            svg.classList.toggle('liked');
                            if (svg.classList.contains('liked')) {
                                svg.setAttribute('fill', 'red');
                            } else {
                                svg.setAttribute('fill', 'currentColor');
                            }
                        }
                    });
                });
            });
        });
});
</script>


<!-- -------------------------------------------------------------------- -->




