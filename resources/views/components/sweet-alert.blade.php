<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    Livewire.on('swal:success', ({ title, text }) => {
        Swal.fire({
            icon: 'success',
            title,
            text,
        });
    });

    Livewire.on('swal:error', ({ title, text }) => {
        Swal.fire({
            icon: 'error',
            title,
            text,
        });
    });

    Livewire.on('swal:warning', ({ title, text }) => {
        Swal.fire({
            icon: 'warning',
            title,
            text,
        });
    });
</script>
