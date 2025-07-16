@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: @json(session('success')),
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: @json(session('error')),
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        });
</script>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi nhập liệu',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        });
</script>
@endif