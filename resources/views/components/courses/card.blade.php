@foreach($courses as $course)
    @include('components.courses.card', ['course' => $course])
@endforeach
