@if(isset($webProperties))
    @foreach($webProperties as $property)
        <div class="well well-sm web-property">
            <a href="{{ route('ga.property', [$property->getAccountId(), $property->getId()]) }}">{{ $property->getName() }}</a>
        </div>
    @endforeach
@endif

