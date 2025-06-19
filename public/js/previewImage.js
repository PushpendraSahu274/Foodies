function previewImage(previewImageId, inputImageId){
     $(document).ready(function() {
            const previewProductImage = document.getElementById(previewImageId);
            const inputImage = document.getElementById(inputImageId);
            inputImage.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewProductImage.src = event.target.result;
                        previewProductImage.classList.remove('d-none');
                        previewProductImage.classList.add('d-block');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
}