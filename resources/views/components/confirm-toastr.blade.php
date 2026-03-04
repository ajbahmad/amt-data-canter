@if(session('success'))
    <script>
        Swal.fire({
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 5000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
    </script>
@endif

<script>
    function editData(id, url) {
        Swal.fire({
            title: 'Edit Data',
            html: 'Apakah Anda yakin ingin mengedit data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

    function deleteData(id, deleteUrl) {
        Swal.fire({
            title: 'Hapus Data',
            html: 'Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it with DELETE method
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                form.innerHTML = `
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        })
    }
</script>