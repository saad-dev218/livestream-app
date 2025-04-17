@push('scripts')
    <!-- jQuery (required for Select2) -->
    <script>
        $(document).ready(function() {


            // Image preview
            $('#thumbnail').on('change', function(e) {
                const input = this;
                const preview = $('#thumbnail-preview');
                const image = $('#thumbnail-image');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        image.attr('src', e.target.result);
                        preview.show();
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.hide();
                }
            });
        });
    </script>
@endpush
