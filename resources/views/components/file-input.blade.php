<!-- HTML -->
<input {!! $attributes->merge([
    'class' =>
        'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full',
]) !!} type="file" multiple accept="image/*" onchange="previewImages(event)" />

<div id="preview-container"></div>

<script>
    function previewImages(event) {
        const files = event.target.files;

        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = ''; // Clear previous previews

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function (e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.classList.add('preview-image');

                previewContainer.appendChild(imgElement);
            };

            reader.readAsDataURL(file);
        }
    }
</script>

<style>
    /* Optional styling for the preview images */
    .preview-image {
        max-width: 200px;
        max-height: 200px;
        margin: 5px;
    }
</style>

