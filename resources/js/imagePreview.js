document.getElementById('imageInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.querySelector('#imagePreview img');
            img.src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});