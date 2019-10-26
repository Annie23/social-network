@extends('layouts.app')

@section('content')
    <div class="container">
            <h1>Image Upload</h1>

            <form action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" id="file-input" name="file[]" multiple/>
                <input type="submit" class="btn btn-outline-primary" name='submitImage' value="Upload Image"/>
            </form>
            <br/>

            <div id="preview"></div>

        </div>

   <script>
    function previewImages() {

    var preview = document.querySelector('#preview');

    if (this.files) {
    [].forEach.call(this.files, readAndPreview);
    }

    function readAndPreview(file) {

    // Make sure `file.name` matches our extensions criteria
    if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
    return alert(file.name + ' is not an image');
    } // else...

    var reader = new FileReader();

    reader.addEventListener('load', function() {
    var spanImage = document.createElement('span');
    spanImage.setAttribute('id', 'span-image');
    preview.appendChild(spanImage);

    var deleteIcon = new Image();

    deleteIcon.height = 20;
    deleteIcon.title = 'delete';
    deleteIcon.src = '../icons/delete.png';
    deleteIcon.setAttribute('class', 'remove-image');
    deleteIcon.onclick = function() {
    this.parentElement.remove();
    };
    spanImage.appendChild(deleteIcon);

    var image = new Image();
    image.height = 100;
    image.title = file.name;
    image.src = this.result;
    image.setAttribute('class', 'uploaded-image');
    image.onmouseover = function() {
    var x = document.getElementsByClassName('remove-image');
    x.style.display = 'block';
    };

    image.onmouseout = function() {
    var x = document.getElementsByClassName('remove-image');
    x.style.display = 'none';
    };

    spanImage.appendChild(image);
    }, false);

    reader.readAsDataURL(file);

    }
    }

    document.querySelector('#file-input').
    addEventListener('change', previewImages, false);
</script>
@endsection
