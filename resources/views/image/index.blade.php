@extends('layouts.app')
@section('content')

        <div class="container">
            <div class="row">
                @foreach($images as $image)
                <div class="col-2 m-3">
                        <img alt="delete" height="20"
                             onclick='sendFileName("{{$image->name}}", "{{route('photos.delete')}}")'
                             src="{{ asset('/icons/delete.png') }}">
                        <img alt="img" src="{{ asset('/images/' . $image->name) }}"><br>
                    @if($image->profile_pic == 0)
                        <a href="" style="border: #6cb2eb 1px solid"
                           onclick='sendFileName("{{$image->name}}","{{route('photos.setProfile')}}")'>
                            Set as Profile photo</a>
                    @endif
                    </div>
                @endforeach

            </div>
            </div>

    <script>
      function sendFileName(imgName, url) {
        $.ajax({
          // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: url,
          type: 'GET',
          contentType: 'application/json; charset=utf-8',
          data: {filename: imgName},
          success: function(response) {
            alert(response.message);
            location.reload();
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(
                'AJAX error: ' + textStatus + ' : ' + errorThrown,
            );
          },
        });
      }

    </script>

@endsection
