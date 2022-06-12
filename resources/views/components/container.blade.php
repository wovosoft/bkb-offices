<div class="container" {{$attributes->merge(["class"=>\Illuminate\Support\Arr::toCssClasses(["container-fluid"=>$fluid])])}}>
    {{$slot}}
</div>
